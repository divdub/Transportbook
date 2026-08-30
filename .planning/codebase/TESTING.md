# Testing Patterns

**Analysis Date:** 2026-08-30

Testing exists **only in the React Native app**. The PHP backend (`transport backend/`) has **no test framework, no PHPUnit, no unit/integration tests** — its only `test.php` / `testing3.php` files are ad-hoc debugging scripts, not automated tests.

---

## React Native App Tests

### Test Framework

**Runner:**
- **Jest** `^29.6.3`, preset `@react-native/jest-preset`.
- Config: `jest.config.js` (`preset: '@react-native/jest-preset'`, `setupFiles: ['./jest.setup.js']`, `transformIgnorePatterns` for `react-native`/`@react-navigation`/`reanimated`/`worklets`/`safe-area-context`/`screens`).

**Assertion Library:**
- Jest built-in `expect` (`@types/jest` present).

**Render / Component Testing:**
- **`react-test-renderer`** `19.2.3` (`@types/react-test-renderer` present).
- No React Native Testing Library, no `@testing-library/react-native` dependency. Smoke render tests use `react-test-renderer` directly.

**Run Commands:**
```bash
npm test            # Run all tests (script: "jest")
npx jest            # Run all tests
npx jest <name>     # Run a single test file (e.g. npx jest TripsList)
npx jest --watch    # Watch mode
npx jest --coverage # Coverage (output dir /coverage is gitignored)
```

### Test File Organization

**Location:**
- All tests live in the root `__tests__/` directory (NOT co-located with source). No `.test.js`/`.spec.js` exists anywhere under `src/`.

**Naming:**
- `PascalCase.test.js` (plus one legacy `App.test.tsx`), named after the feature/screen under test.

**Files present:**
- `__tests__/App.test.tsx`
- `__tests__/AuthScreen.test.js`
- `__tests__/BusinessSetup.test.js`
- `__tests__/TripsList.test.js`
- `__tests__/AddTrip.test.js`
- `__tests__/TripDetails.test.js`

### Test Structure

**Suite Organization:**
Tests are grouped into large `describe` blocks per feature-module (e.g. `describe('Trips Module - Phase 2 & 3 (Add Trip & Add More Details)', ...)` in `AddTrip.test.js`). Each `describe` contains multiple `it(...)` cases. Use `test(...)` for the top-level render smoke test (`App.test.tsx`) and `it(...)` inside feature `describe`s.

**Render smoke-test pattern (most common):**
```javascript
let tree;
ReactTestRenderer.act(() => {
  tree = ReactTestRenderer.create(
    <Wrapper>
      <ScreenUnderTest />
    </Wrapper>,
  );
});
expect(tree).toBeDefined();
```
See `__tests__/AddTrip.test.js`, `__tests__/TripsList.test.js`, `__tests__/TripDetails.test.js`.

**Wrapper pattern (for components needing providers):**
```javascript
const queryClient = new QueryClient();

function Wrapper({children}) {
  return (
    <QueryClientProvider client={queryClient}>
      <NavigationContainer>{children}</NavigationContainer>
    </QueryClientProvider>
  );
}
```
Used in `__tests__/TripsList.test.js`, `AddTrip.test.js`, `TripDetails.test.js`. Screens that don't need providers (e.g. `AuthScreen.test.js`, `BusinessSetup.test.js`) render directly.

**Assertion pattern:**
- Most assertions are minimal smoke checks: `expect(tree).toBeDefined()`.
- A few meaningful assertions exist: schema validation (`expect(result.success).toBe(true)`) and mock-data behavior (`expect(Array.isArray(trips)).toBe(true)`, `expect(trips[0]).toHaveProperty('partyName')`).

### Mocking

**Global mocks (setup file):**
`jest.setup.js` mocks native/animated/third-party render deps that fail under Jest:
- `react-native-gesture-handler` → plain `View` stand-ins.
- `@gorhom/bottom-sheet` → `forwardRef` `View` with `expand`/`close`/`snapToIndex` jest fns.
- `react-native-vector-icons/MaterialCommunityIcons` → string `'Icon'`.
- `react-native-worklets` → `src/mock` (fallback `{}`).
- `react-native-reanimated` → mocked `View`, `Easing`, `FadeIn/FadeOut`, `useAnimatedStyle`, `useSharedValue`, `withTiming/Spring/Delay`.

**Per-file mocks (feature hooks):**
Tests mock feature hooks with `jest.mock('<path>', () => ({ hookName: () => ({...}) }))`, returning canned data:
```javascript
jest.mock('../src/features/trips/hooks/useTripsQuery', () => ({
  useTripsQuery: () => ({
    data: [{id: 'TRIP-1001', partyName: 'Sainy Logistics', ...}],
    isLoading: false,
    isError: false,
    refetch: jest.fn(),
    isRefetching: false,
  }),
}));
```
Mutation hooks are mocked with `mutateAsync: jest.fn().mockResolvedValue({})`, `isPending: false`.

**Navigation mocking (when needed):**
`TripDetails.test.js` mocks `@react-navigation/native` using `jest.requireActual` spread plus overridden `useNavigation` (`navigate`/`goBack`/`replace` jest fns) and `useRoute` (`params`).

**What to Mock:**
- Feature data hooks (`useTripsQuery`, `useTripDetailsQuery`, `usePartiesQuery`) — return fixed fixtures.
- Mutation hooks (`useAddTripMutation`, `useUpdateTripStatusMutation`, `useAddAdvanceMutation`, `useAddDriverBalanceMutation`, `useSendMobileOtp`, `useVerifyMobileOtp`).
- Native/animated third-party deps (globally in `jest.setup.js`).

**What NOT to Mock (tested directly):**
- Zod schemas — validated directly against fixtures (e.g. `addTripSchema.safeParse(...)` in `__tests__/AddTrip.test.js`).
- Mock data modules — `mockFetchTrips`/`mockCreateTrip` are unit-tested directly in `__tests__/TripsList.test.js`.

### Fixtures and Factories

**Test Data:**
- Fixtures are inlined as object literals inside each test file's `jest.mock` factory (mock trip objects with `id`, `partyName`, `truckNumber`, `freightAmount`, etc.).
- Mock data source-of-truth lives in feature modules: `src/features/trips/trips.mock.js` (in-memory `mockTrips` array with factories like `mockCreateTrip`).

**Location:**
- No shared `__fixtures__` directory. Fixtures are duplicated across `__tests__/*.test.js` files.

### Coverage

**Requirements:** None enforced — no `coverageThreshold` in `jest.config.js`; the `coverageDirectory` defaults to `/coverage` (gitignored).
- View: `npx jest --coverage`.

### Test Types

**Unit Tests:**
- Render smoke tests for screens/sheets/components via `react-test-renderer`.
- Schema validation tests (zod `safeParse`).
- Mock-data/function behavior tests (`mockFetchTrips`, `mockCreateTrip`).

**Integration Tests:**
- Not established as a distinct layer. Tests that mount full screens through providers (`QueryClientProvider` + `NavigationContainer`) are the closest approximation.

**E2E Tests:**
- Not used. No Detox/Appium setup.

### Common Patterns

**Async rendering (must wrap act):**
```javascript
it('fetches mock trips correctly', async () => {
  const trips = await mockFetchTrips();
  expect(Array.isArray(trips)).toBe(true);
});
```

**Callback-prop sheet testing:**
Sheets receive `onSave`/`onClose`/`onConfirm` jest.fn() props to assert wiring:
```javascript
it('renders AddAdvanceSheet and triggers save', () => {
  const onSave = jest.fn();
  const onClose = jest.fn();
  let tree;
  ReactTestRenderer.act(() => {
    tree = ReactTestRenderer.create(
      <AddAdvanceSheet visible={true} onSave={onSave} onClose={onClose} />,
    );
  });
  expect(tree).toBeDefined();
});
```
See `__tests__/AddTrip.test.js`, `__tests__/TripDetails.test.js`.

---

## PHP Backend — Testing Status

- **No automated tests exist** for `transport backend/`.
- No `phpunit.xml`, no `tests/` directory, no PHPUnit in `composer.json`/`composer.lock`.
- `transport backend/test.php` and `transport backend/testing3.php` are standalone debugging scripts, not tests.
- Database-dependent procedural code (raw `mysqli`, string-interpolated SQL, global `$connection`) is not structured for testability. If testing is added here, it would require introducing a framework (e.g. PHPUnit) plus refactoring DB access toward dependency injection / a testable connection abstraction (see `lib/dboperation.php`, `lib/getval.php`).

---

*Testing analysis: 2026-08-30*
