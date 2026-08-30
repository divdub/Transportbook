# Coding Conventions

**Analysis Date:** 2026-08-30

This repo contains TWO sub-projects with distinct conventions:
1. **React Native app** (root: `App.js`, `src/`, `package.json`) — modern JS/React with build tooling.
2. **PHP backend** (`transport backend/`) — legacy procedural PHP business system.

Conventions below are split by project because they differ substantially.

---

## React Native App Conventions

### Language / Type Usage
- **All application source is plain JavaScript (`.js`)**. No `.ts`/`.tsx` files exist under `src/` despite a `tsconfig.json` that extends `@react-native/typescript-config`. The only `.tsx` file is `__tests__/App.test.tsx`.
- Do not introduce TypeScript into the `src/` tree without establishing the toolchain; match the existing `.js` source convention.

### Naming Patterns

**Files:**
- **Screens:** `PascalCase` ending in `Screen.js` — e.g. `src/features/auth/screens/AuthScreen.js`, `src/features/trips/screens/AddTripScreen.js`.
- **Presentational components:** `PascalCase.js` — e.g. `src/components/common/AppText.js`, `src/components/ui/StatusBadge.js`.
- **Sheets/bottom-sheets:** `PascalCase` ending in `Sheet.js` — e.g. `src/features/trips/sheets/AddAdvanceSheet.js`.
- **Hooks:** `useXxx.js` (camelCase with `use` prefix) — e.g. `src/features/trips/hooks/useTripsQuery.js`.
- **API modules (per feature):** `kebab`-free lowercase: `trips.api.js`, `parties.api.js`, `auth.api.js`.
- **Mock modules (per feature):** `<feature>.mock.js` — e.g. `src/features/trips/trips.mock.js`.
- **Validation modules (per feature):** `<feature>Validation.js` — e.g. `src/features/trips/tripsValidation.js`, `src/features/auth/authValidation.js`.
- **Constants (per feature):** camelCase file — e.g. `src/features/dashboard/constants/businessModules.js`, `src/features/parties/constants/indianStates.js`.
- **Theme files:** lowercase `colors.js`, `spacing.js`, `typography.js`, etc. under `src/theme/`.

**Functions:**
- Hooks and helper functions use `function name()` declarations — e.g. `export function useTripsQuery()`, `export function AppText({...})`.
- Arrow functions used for inline callbacks and exported mock/API callbacks — e.g. `export const mockCreateTrip = async tripData => {...}`.
- Async data-fetch functions use `async`/`await` and arrow-function form.

**Variables:**
- `camelCase` throughout (`isLoading`, `errorMessage`, `isSubmitting`).
- State flags use the `is` / `has` prefix (`isAuthenticated`, `isOnboarded`, `isBootstrapping`).

**Components / Types:**
- Components are `PascalCase` (e.g. `AppButton`).
- Screens are default-exported; shared components and hooks are named-exports.
- No TypeScript types/interfaces are declared anywhere in `src/`. Domain objects use plain object literals (see `src/features/trips/trips.mock.js`).

### Component Export Convention
- **Screens:** `export default function ScreenName()` — see `src/features/auth/screens/AuthScreen.js`.
- **Reusable components & hooks:** named exports — `export function AppText(...)`, `export function useTripsQuery()`.
- Sorting: common `src/components/common/`, feature-specific under `src/features/<feature>/components/`.

### Code Style

**Formatting (Prettier `2.8.8`, config `.prettierrc.js`):**
- `singleQuote: true`
- `trailingComma: 'all'`
- `arrowParens: 'avoid'` (single-param arrows without parens)
- 2-space indentation (Prettier default).

**Linting (ESLint, config `.eslintrc.js`):**
- `extends: '@react-native'` (React Native community preset), `root: true`.
- Lint command: `npm run lint` → `eslint .`

### Import Organization

**Order observed:**
1. React / core React Native imports.
2. Third-party libraries (react-hook-form, react-query, navigation, axios, zustand, zod, etc.).
3. Project imports (relative paths `../../`, `../../../`).
4. Relative imports use explicit path with `.js` omitted (e.g. `import {useTripsQuery} from '../hooks/useTripsQuery'`).

**Path aliases:** None configured. All imports are relative (`../../theme`, `../../../components/common/AppButton`, `../authValidation`). Do not introduce absolute path aliases unless added to `babel.config.js`/`metro.config.js`.

### State Management
- **Client state:** Zustand (`zustand`) — see `src/store/authStore.js` (`export const useAuthStore = create(...)` with `set`/`get`).
- **Server state:** TanStack React Query — see `src/services/api/queryClient.js` (queries: `retry: 1`, `staleTime: 30000`, `refetchOnWindowFocus: false`; mutations: `retry: 0`).
- Feature hooks wrap `useQuery`/`useMutation` — see `src/features/trips/hooks/useTripsQuery.js` and `useAddTripMutation.js`. Mutations invalidate their query key on success: `queryClient.invalidateQueries({queryKey: ['trips']})`.

### Form Validation
- **Zod schemas** define validation; **react-hook-form** with `zodResolver` runs them.
- Schemas live in `<feature>Validation.js` and are named `<flow>Schema` (e.g. `addTripSchema`, `addAdvanceSchema`, `loginSchema`).
- Enums use `z.enum([...]).default(...)` for option fields; amounts use regex `.refine(val => /^\d+(\.\d{1,2})?$/.test(val), 'Enter a valid amount')`.
- Forms wire the resolver: `useForm({resolver: zodResolver(loginSchema), defaultValues: {...}})` — see `src/features/auth/components/LoginForm.js`.
- Field errors shown via `errors.<name>?.message` passed to field components.

### API / Service Layer
- Axios instance created in `src/services/api/client.js` (`apiClient`), with request interceptor adding `Authorization: Bearer <token>` and response interceptor normalizing errors.
- Per-feature API modules (`.api.js`) define boundary methods but many are **conceptual placeholders** (they reference `/api/...` routes and note the real Laravel contract is pending). See `src/features/trips/trips.api.js`, `src/features/auth/auth.api.js` (currently only a comment block).
- **Mock-first:** features ship a `.mock.js` module (e.g. `src/features/trips/trips.mock.js`) with `delay()`-based fakes; hooks call mocks by default and comment the future `tripsApi.*` call. See `src/features/trips/hooks/useTripsQuery.js`.

### Styling
- Use `StyleSheet.create({...})` at the bottom of each component file (`const styles = StyleSheet.create({...})`).
- Reuse tokens from `src/theme/` (`colors`, `radius`, `spacing`, `typography`, `shadows`) via the barrel `src/theme/index.js`. Import as `import {colors, radius, spacing} from '../../../theme'`.
- Prefer theme tokens; inline hex colors appear in some screens (e.g. `#1E293B` in `LoginForm.js`) — prefer moving these to `src/theme/colors.js`.

### Error Handling
- Hooks use `try/catch/finally` with an `errorMessage` state string; the catch sets `setErrorMessage(error?.message || 'fallback message')` and re-throws. See `src/features/auth/hooks/useMockLogin.js`.
- API errors are normalized through `normalizeApiError` (`src/services/api/errors.js`) into `{status, message, data, type}` where `type` is one of `validation | authentication | authorization | not_found | server | http | timeout | network | unknown`.
- Screen-level error message rendering is conditional: `{errorMessage ? <AppText style={styles.error}>...</AppText> : null}`.
- Mock functions use `throw new Error('Trip not found')` for missing entities.

### Comments
- Block comments (`/* ... */`) document intent, temporary/mock behavior, and future backend swap points (see `src/features/auth/auth.api.js`, `src/store/authStore.js`, `src/services/api/queryClient.js`).
- `TODO(backend)` tags flag contract-dependent work (e.g. `src/features/auth/auth.mock.js`).
- Japanese-less; comments are English only.
- Avoid leaving commented-out code; commented-out route names in `src/navigation/routeNames.js` are an existing exception.

### Navigation
- Route name constants centralized in `src/navigation/routeNames.js` (`export const routes = {...}`).
- Navigators in `src/navigation/` (`RootNavigator.js`, `AppNavigator.js`, `MainTabNavigator.js`, `AuthNavigator.js`, `navigationRef.js`).
- Navigation state drives UI auth gating in `RootNavigator.js` based on Zustand flags (`isBootstrapping`, `isAuthenticated`, `isOnboarded`).

---

## PHP Backend Conventions (`transport backend/`)

### Language / Environment
- Legacy **procedural PHP** (no framework, no ORM). Raw `mysqli` for database access.
- Mixed PHP/HTML inline in page scripts (e.g. `dashboard.php`, `billing.php` are large page scripts mixing markup and logic).

### Naming Patterns
- **Page scripts:** `snake_case.php` at the backend root (e.g. `vehicle_master.php`, `payment-report.php`, `all-dispatch-entry.php`). Hyphenated names also exist (`driver-master.php`, `brand-master.php`, `state-master.php`).
- **AJAX endpoints:** under `ajax/` (e.g. `ajax/getvehicle.php`, `ajaxpayment/`), plus `mobile/ajax/` subdirectory for mobile-specific AJAX.
- **Mobile API endpoints:** `mobile/API/*.php` (e.g. `mobile/API/master.php`, `mobile/API/user_login.php`, `mobile/API/user_registration.php`).
- **Shared functions:** `function/` directory as `*_function.php` (e.g. `function/dispatch_function.php`, `function/payment_function.php`).
- **DB helpers & domain helpers:** class `Comman` in `lib/getval.php`; procedural utility functions in `lib/dboperation.php`.
- **Includes:** shared layouts in `inc/` (`top-header.php`, `top-files.php`, `left-menu.php`, `model.php`).

### PHP Style
- Full-size `<?php ... ?>` tags typically at file start, HTML assembled inline with mixed `<?php ?>` blocks throughout page scripts.
- Functions declared globally (procedural). Class `Comman` uses non-`static` methods called through an instance (`$cmn = new Comman(); $cmn->getvalfield(...)`) — see `check_login.php`.
- SQL built via string interpolation directly into `mysqli_query` calls. DB helper `test_input()` (`lib/dboperation.php`) applies `trim`/`addslashes`/`htmlspecialchars` — legacy-style sanitization (not parameterized prepared statements).
- Comment style: `// line comments` and `/* ... */` block comments used to disable debug output (e.g. `// echo "sql"; die;`).

### Mobile API Response Convention (`mobile/API/`)
- Every endpoint begins by including `top_file.php`, which initializes a standard set of variables: `$data = array();`, `$success = false;`, `$msg`', `$token`, `$tag`, `$status`, `$return_id`, `$version_code`, and reads `$_REQUEST['token']`, `$_REQUEST['userid']`, etc.
- The endpoint switches on `$_REQUEST['tag']` (e.g. `'company'`, `'session'`, `'get_otp'`) to dispatch the request. See `mobile/API/master.php`.
- Response emitted by `include('footer.php')` at the end, which `json_encode`s the standard envelope:
  ```php
  array(
    "success" => $success,
    "version" => $version_code,
    "tag" => $tag,
    "return_id" => $return_id,
    "msg" => $msg,
    "data" => $data,
    "data1" => $data1,
    "status" => $status,
    "response" => isset($response) ? $response : null,
  )
  ```
- Hardcoded auth token check: `if ($token == "GURU")` guards API access (see `mobile/API/master.php`). Do not replicate; this is a known weakness.

### Database Access
- Connections created in include files (`dbinfo.php` at backend root, `mobile/API/config.php` for the mobile API) via `mysqli_connect`. `.env` files: a `dbinfo.php`/`config.php` pattern holds DB credentials inline (do not quote these values).
- Many helper functions in `lib/dboperation.php` reference an **undefined global `$connection`** variable (e.g. `dbRowSelect`, `showdtable`, `getvalMultiple`, `selectsimple`) rather than receiving it as a parameter — an existing defect; callers must pass `$connection` and functions that rely on it are broken/error-prone. Prefer the `Comman` class methods that take `$connection` as the first argument.

### Dependencies
- `composer.json` requires only `phpoffice/phpword` (installed to `vendor/`, which is gitignored-independent legacy w/o strict management).

---

*Convention analysis: 2026-08-30*
