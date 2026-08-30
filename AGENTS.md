<!-- GSD:project-start source:PROJECT.md -->

## Project

**TransportApp**

A premium Android application (React Native / JavaScript) for transportation businesses that lets fleet owners and their staff run daily operations — trips/biltys, trucks, drivers, parties, suppliers, expenses, khata/ledger and reports — from the phone. The app is the mobile client of an existing PHP/MySQL transportation ERP ("transport backend"): a shared JSON API touches the same database the web panel uses. It is a multi-tenant product: each transport business is its own tenant with role-based staff login (owner, driver, petrol-pump operator, employee/admin).

**Core Value:** Every trip must be creatable, trackable and settled end-to-end from the phone against real backend data — if the trip lifecycle breaks or silently falls back to mock data, the product fails.

### Constraints

- **Tech stack**: React Native CLI + JavaScript (existing app) — no framework migration; backend stays procedural PHP + mysqli on the existing 77-table schema
- **Compatibility**: App speaks the existing `mobile/API` JSON envelope (`token`,`tag`, `data`/`data1`, `footer.php`); new endpoints must mirror its patterns and the web `ajax*/save_*` handler logic, plus the `lib/getval.php` numbering/tax conventions
- **Tenancy**: Every write must stamp `comp_id`, `session_id`, `consignorid`, `user_id` — the DB enforces no FK constraints, so the application layer owns integrity
- **Security debt**: DB credentials are committed/embedded and passwords plaintext — a hardening pass is a prerequisite, not an option
- **Reuse**: keep existing app screens and rewire their data layer through an adapter; do not rebuild working UI
- **Dev environment**: PHP + a local MySQL copy must run for development/verification, mirroring the prod DB name/schema

<!-- GSD:project-end -->

<!-- GSD:stack-start source:codebase/STACK.md -->

## Technology Stack

## Repo Layout — Two Sub-Projects

## Languages

- JavaScript (React Native 0.87.0, ES modules via Babel) — all app code under `src/` and `App.js`, `index.js`
- PHP 7+ (procedural, `mysqli` extension; code uses `??` null-coalescing in `transport backend/loginotp.php`, `transport backend/mobile/API/resend_otp.php`) — entire `transport backend/` codebase, no framework
- Java/Kotlin — Android native shell (`android/`, Kotlin 2.2.0, Gradle)
- Objective-C/Swift (via CocoaPods) — iOS native shell (`ios/`)
- Ruby — `Gemfile`/`Gemfile.lock` for CocoaPods toolchain
- SQL — MySQL; full DB dumps committed alongside the app: `transport backend/chaarqvc_guruassociates_backup_*.sql`, `transport backend/sjt_backup_*.sql`
- TypeScript — only for config/types (`tsconfig.json` extends `@react-native/typescript-config`; app source is JS, `src/` has no `.ts` files)

## Runtime

- Mobile: React Native 0.87.0 (installed, verified via `node_modules/react-native/package.json`); Hermes engine default for RN 0.87
- Node.js: `>= 22.11.0` required (`package.json` → `"engines"`); local dev machine has v25.4.0
- PHP: no version pinned in-repo; Composer deps (`phpoffice/math`) require `^7.1|^8.0`; local machine has PHP 8.5.4. Code uses pre-PHP8 idioms everywhere (no native types, procedural `mysqli`)
- npm — root `package-lock.json` present (480 KB)
- Composer — `transport backend/composer.json` + `transport backend/composer.lock` (only for `phpoffice/phpword`)
- Ruby Bundler — `Gemfile.lock` for CocoaPods (pinned `cocoapods 1.15.2`, `activesupport`, `xcodeproj < 1.26.0`; `.bundle/config` sets `BUNDLE_PATH: "vendor/bundle"`, local `vendor/` dir contains the bundled gems)
- No Yarn, no pnpm, no `.nvmrc`

## Frameworks

- React 19.2.3 + React Native 0.87.0 — mobile framework (`package.json`)
- React Navigation 7 (`@react-navigation/native`, `native-stack`, `bottom-tabs`) — navigation (`src/navigation/RootNavigator.js`, `AppNavigator.js`, `MainTabNavigator.js`)
- TanStack React Query 5 — server-state cache (`src/services/api/queryClient.js`)
- Zustand 5 — client state/auth store (`src/store/authStore.js`)
- react-hook-form 7 + zod 4 (`@hookform/resolvers`) — form + validation (`src/features/*/tripsValidation.js`, `partiesValidation.js`, `trucksValidation.js`)
- Plain PHP — no framework, no Composer autoload beyond PHPWord; each page includes `transport backend/dbinfo.php` + `transport backend/lib/dboperation.php` + `transport backend/adminsession.php` (session guard)
- Frontend assets: Bootstrap, jQuery, jQuery UI, select2, chosen, fullcalendar (vendored in `transport backend/css/`, `transport backend/js/`)
- Jest 29.6.3 with `@react-native/jest-preset` (`jest.config.js`, `jest.setup.js`); suites in `__tests__/` (`App.test.tsx`, `AuthScreen.test.js`, `TripsList.test.js`, `AddTrip.test.js`, `TripDetails.test.js`, `BusinessSetup.test.js`); SQL/PHP backend is untested
- Metro bundler — `metro.config.js` (default `@react-native/metro-config`)
- Babel — `babel.config.js` (`@react-native/babel-preset` + `react-native-reanimated/plugin` LAST)
- `@react-native-community/cli` 20.2.0 — android/ios run scripts (`package.json`)
- ESLint 8 (`@react-native/eslint-config`, `.eslintrc.js`), Prettier 2.8.8 (`.prettierrc.js`: `singleQuote`, `avoid` arrow parens, trailing commas)
- Android: `android/build.gradle` — compileSdk 37, targetSdk 36, minSdk 24, buildTools 37.0.0, NDK 27.1.12297006, Kotlin 2.2.0, AGP via `com.android.tools.build:gradle` classpath
- iOS: `ios/Podfile` uses `min_ios_version_supported` from RN 0.87, `use_native_modules!`, optional `USE_FRAMEWORKS`

## Key Dependencies

- `axios` ^1.19.0 — HTTP client (`src/services/api/client.js`)
- `@gorhom/bottom-sheet` ^5.2.14 — bottom sheets (`App.js`, `src/features/quickActions/`)
- `react-native-reanimated` ^4.6.0 + `react-native-worklets` 0.12.1 — animations; Babel plugin must stay last (`babel.config.js`)
- `react-native-gesture-handler` ^3.2.1 — gestures (`App.js` wraps root)
- `lottie-react-native` ^7.4.0 — splash animations (`src/assets/animation`)
- `react-native-vector-icons` ^10.3.0 — MaterialCommunityIcons tab/base icons (`src/navigation/MainTabNavigator.js`)
- `react-native-safe-area-context` ^5.9.1, `react-native-screens` ^4.27.0
- `phpoffice/phpword` ^1.3 (with `phpoffice/math` 0.2.0) — Word document generation (`transport backend/vendor/phpoffice/`)
- FPDF 1.7 + 1.84 — PDF generation, vendored at `transport backend/fpdf17/` and `transport backend/fpdf184/` (plus `transport backend/pdf/*.php` report scripts)
- GD extension — CAPTCHA image generation (`transport backend/captcha.php`)
- No PHP framework, no ORM — raw `mysqli` queries throughout
- MySQL — relational store (see INTEGRATIONS.md for connection details)
- PHP `curl` — SMS/WhatsApp gateway calls (`transport backend/getotp.php`, `transport backend/whatsapp.php`)

## Configuration

- `src/config/env.js` — dev: `apiBaseUrl: 'http://10.0.2.2:3000/api'`, timeout 15000 ms; prod: empty `apiBaseUrl` (not yet set). Selected by `__DEV__`
- No `.env` / `.env.*` files present at repo root — environment lives in code, not env files
- `app.json` — app `name`/`displayName` = TransportApp; `android/app/build.gradle` — `applicationId "com.transportapp"`, versionCode 1, versionName "1.0"
- No config files; DB credentials are hardcoded inline in `transport backend/dbinfo.php` and `transport backend/mobile/API/config.php`
- `transport backend/mobile/API/config.php` additionally sets `memory_limit=512M`, `date_default_timezone_set("Asia/Kolkata")`
- SMS gateway keys hardcoded in `transport backend/lib/smsinfo.php`
- `babel.config.js`, `metro.config.js`, `jest.config.js`, `tsconfig.json`, `eslintrc.js`, `.prettierrc.js`, `.watchmanconfig`, `Gemfile`
- `transport backend/composer.json` — single require: `phpoffice/phpword`

## Platform Requirements

- Node >= 22.11.0 + npm; Xcode/CocoaPods for iOS (`bundle install`, `bundle exec pod install`); Android Studio with SDK 36/37, NDK 27.1
- PHP 7.1+ (8.x works) with `mysqli`, `gd`, `curl` extensions; MySQL server; Composer for PHPWord
- Watchman (`.watchmanconfig`)
- React Native: Apple App Store / Google Play (no CI/CD or hosting config in-repo — no `.github/`, no Docker, no deploy scripts detected)
- PHP backend: shared hosting–style LAMP setup assumed (db host is `localhost`, dumps + hardcoded creds imply cPanel-style hosting); not documented in-repo

<!-- GSD:stack-end -->

<!-- GSD:conventions-start source:CONVENTIONS.md -->

## Conventions

## React Native App Conventions

### Language / Type Usage

- **All application source is plain JavaScript (`.js`)**. No `.ts`/`.tsx` files exist under `src/` despite a `tsconfig.json` that extends `@react-native/typescript-config`. The only `.tsx` file is `__tests__/App.test.tsx`.
- Do not introduce TypeScript into the `src/` tree without establishing the toolchain; match the existing `.js` source convention.

### Naming Patterns

- **Screens:** `PascalCase` ending in `Screen.js` — e.g. `src/features/auth/screens/AuthScreen.js`, `src/features/trips/screens/AddTripScreen.js`.
- **Presentational components:** `PascalCase.js` — e.g. `src/components/common/AppText.js`, `src/components/ui/StatusBadge.js`.
- **Sheets/bottom-sheets:** `PascalCase` ending in `Sheet.js` — e.g. `src/features/trips/sheets/AddAdvanceSheet.js`.
- **Hooks:** `useXxx.js` (camelCase with `use` prefix) — e.g. `src/features/trips/hooks/useTripsQuery.js`.
- **API modules (per feature):** `kebab`-free lowercase: `trips.api.js`, `parties.api.js`, `auth.api.js`.
- **Mock modules (per feature):** `<feature>.mock.js` — e.g. `src/features/trips/trips.mock.js`.
- **Validation modules (per feature):** `<feature>Validation.js` — e.g. `src/features/trips/tripsValidation.js`, `src/features/auth/authValidation.js`.
- **Constants (per feature):** camelCase file — e.g. `src/features/dashboard/constants/businessModules.js`, `src/features/parties/constants/indianStates.js`.
- **Theme files:** lowercase `colors.js`, `spacing.js`, `typography.js`, etc. under `src/theme/`.
- Hooks and helper functions use `function name()` declarations — e.g. `export function useTripsQuery()`, `export function AppText({...})`.
- Arrow functions used for inline callbacks and exported mock/API callbacks — e.g. `export const mockCreateTrip = async tripData => {...}`.
- Async data-fetch functions use `async`/`await` and arrow-function form.
- `camelCase` throughout (`isLoading`, `errorMessage`, `isSubmitting`).
- State flags use the `is` / `has` prefix (`isAuthenticated`, `isOnboarded`, `isBootstrapping`).
- Components are `PascalCase` (e.g. `AppButton`).
- Screens are default-exported; shared components and hooks are named-exports.
- No TypeScript types/interfaces are declared anywhere in `src/`. Domain objects use plain object literals (see `src/features/trips/trips.mock.js`).

### Component Export Convention

- **Screens:** `export default function ScreenName()` — see `src/features/auth/screens/AuthScreen.js`.
- **Reusable components & hooks:** named exports — `export function AppText(...)`, `export function useTripsQuery()`.
- Sorting: common `src/components/common/`, feature-specific under `src/features/<feature>/components/`.

### Code Style

- `singleQuote: true`
- `trailingComma: 'all'`
- `arrowParens: 'avoid'` (single-param arrows without parens)
- 2-space indentation (Prettier default).
- `extends: '@react-native'` (React Native community preset), `root: true`.
- Lint command: `npm run lint` → `eslint .`

### Import Organization

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
- Hardcoded auth token check: `if ($token == "GURU")` guards API access (see `mobile/API/master.php`). Do not replicate; this is a known weakness.

### Database Access

- Connections created in include files (`dbinfo.php` at backend root, `mobile/API/config.php` for the mobile API) via `mysqli_connect`. `.env` files: a `dbinfo.php`/`config.php` pattern holds DB credentials inline (do not quote these values).
- Many helper functions in `lib/dboperation.php` reference an **undefined global `$connection`** variable (e.g. `dbRowSelect`, `showdtable`, `getvalMultiple`, `selectsimple`) rather than receiving it as a parameter — an existing defect; callers must pass `$connection` and functions that rely on it are broken/error-prone. Prefer the `Comman` class methods that take `$connection` as the first argument.

### Dependencies

- `composer.json` requires only `phpoffice/phpword` (installed to `vendor/`, which is gitignored-independent legacy w/o strict management).

<!-- GSD:conventions-end -->

<!-- GSD:architecture-start source:ARCHITECTURE.md -->

## Architecture

## System Overview

```text

```

## Component Responsibilities

### React Native App

| Component | Responsibility | File |
|-----------|----------------|------|
| App root | Composes providers (query, safe-area, bottom-sheet, gesture) | `App.js` |
| Entry | Registers app with React Native | `index.js` |
| Auth store | Session/onboarding state, restore/logout | `src/store/authStore.js` |
| API client | Axios instance + auth header + error normalization | `src/services/api/client.js` |
| Query client | TanStack Query defaults | `src/services/api/queryClient.js` |
| Auth storage | (Volatile) session persistence boundary | `src/services/storage/authStorage.js` |
| Navigation refs | Imperative navigation outside components | `src/navigation/navigationRef.js` |
| Root navigator | Auth-gated top-level routing | `src/navigation/RootNavigator.js` |
| Feature layer | Per-feature screens/hooks/api/mock/validation | `src/features/*/` |
| Shared UI | Reusable App* components | `src/components/common/` |
| Theme | Design tokens (colors/spacing/typography/radius/shadows) | `src/theme/` |

### PHP Backend

| Component | Responsibility | File |
|-----------|----------------|------|
| Web login | Auth entry (session-based) | `transport backend/index.php` |
| Main dashboard | Top-level page shell + menu | `transport backend/dashboard.php` |
| Common class | Reusable query/helper methods (`$cmn->`) | `transport backend/lib/getval.php` |
| DB helpers | SQL CRUD + utilities | `transport backend/lib/dboperation.php` |
| Header/layout partials | Shared HTML head + top nav + left menu | `transport backend/inc/*.php` |
| Feature JS libs | Client-side ajax/validation helpers | `transport backend/function/*.php` |
| AJAX endpoints | Minimal JSON/form handlers | `transport backend/ajax/*.php` |
| Mobile API | Token-gated REST-lite endpoints | `transport backend/mobile/API/*.php` |
| Mobile web UI | Separate mobile-optimized web pages | `transport backend/mobile/*.php` |
| Report generators | PDF / Excel / WhatsApp exports | `transport backend/pdf/`, `excel/`, `whatsapp/` |

## Pattern Overview

- RN app is provider-driven composition at `App.js` (QueryClientProvider, SafeAreaProvider, BottomSheetModalProvider, GestureHandlerRootView).
- Feature folders follow a consistent internal layout: `screens/`, `components/`, `hooks/`, plus a feature-level `*.api.js`, `*.mock.js`, `*.validation.js`.
- Current data flow routes through `*.mock.js` (e.g. `src/features/trips/trips.mock.js`), with `*.api.js` stubs defining the future contract.
- PHP backend follows page-per-file with `include`-based layout partials and shared `common` utility includes.

## Layers

### React Native App

- Purpose: Bootstrap providers and root navigation.
- Location: `App.js`, `index.js`
- Contains: Provider composition, native registration.
- Depends on: `src/navigation/RootNavigator`, `src/services/api/queryClient`, `src/theme`.
- Used by: The native runtime.
- Purpose: Declarative routing, gated by auth/onboarding state.
- Location: `src/navigation/`
- Contains: `RootNavigator.js`, `AuthNavigator.js`, `AppNavigator.js`, `MainTabNavigator.js`, `routeNames.js`, `navigationRef.js`.
- Depends on: `src/features/*/screens`, `src/store/authStore`, `src/theme`.
- Used by: `App.js`.
- Purpose: Owns all UI + data logic for a business domain (auth, trips, parties, trucks, dashboard, khata, quickActions, more).
- Location: `src/features/<feature>/`
- Contains: `screens/`, `components/`, `hooks/`, `sheets/`, `constants/`, and files `*.api.js`, `*.mock.js`, `*Validation.js`.
- Depends on: `src/services/api/client`, `src/services/api/queryClient`, `src/store`, `src/components/common`, `src/theme`, `src/navigation`.
- Used by: The navigation layer.
- Purpose: Shared infrastructure (HTTP, storage, error handling).
- Location: `src/services/`
- Contains: `api/client.js`, `api/queryClient.js`, `api/errors.js`, `storage/authStorage.js`.
- Depends on: `src/config/env`.
- Used by: Feature layers.
- Purpose: Global auth/onboarding client state.
- Location: `src/store/authStore.js`
- Depends on: `src/services/storage/authStorage`.
- Used by: Root navigator + auth hooks.
- Purpose: Centralized design tokens.
- Location: `src/theme/` (`colors.js`, `spacing.js`, `radius.js`, `shadows.js`, `typography.js`, `index.js` barrel).
- Used by: All layers.

### PHP Backend

- Purpose: Full server-rendered CRUD/transaction pages.
- Location: `transport backend/*.php` (e.g. `dispatch-process.php`, `billing.php`, `payment-process.php`, `vehicle_master.php`).
- Depends on: `inc/*.php` partials, `lib/*.php`, `function/*.php`.
- Purpose: Shared HTML head, nav, menu, alerts.
- Location: `transport backend/inc/` (`top-files.php`, `top-header.php`, `left-menu.php`, `model.php`, `breadcrumbs.php`, `alert.php`).
- Used by: Web UI pages.
- Purpose: DB CRUD + utilities, common class.
- Location: `transport backend/lib/` (`dboperation.php`, `getval.php`, `getval2.php`, `smsinfo.php`).
- Used by: Web UI pages, mobile API.
- Purpose: AJAX + validation helper JS.
- Location: `transport backend/function/*.php` (`dispatch_function.php`, `payment_function.php`, `bill_function.php`, etc.).
- Used by: Web UI pages via `<script>` includes.
- Purpose: Lightweight JSON/form endpoints called from function JS.
- Location: `transport backend/ajax/*.php` (e.g. `ajax_savconsignee.php`, `save_dispatch_adv.php`).
- Purpose: Token-gated JSON endpoints for the mobile app.
- Location: `transport backend/mobile/API/*.php` (`user_login.php`, `user_registration.php`, `master.php`, `*.report.php`, etc.).
- Each endpoint includes `top_file.php` (token check) and `footer.php` (JSON envelope).
- Depends on: `mobile/API/config.php` (DB connection), `mobile/API/top_file.php`.
- Purpose: Separate mobile web pages (hybrid-web style).
- Location: `transport backend/mobile/*.php` + `mobile/inc/`.
- Purpose: Export PDF / Excel / WhatsApp reports.
- Location: `transport backend/pdf/` (60+ `pdf_*.php` using `fpdf17/`, `fpdf184/`), `excel/` (`excel_*.php`), `whatsapp/`, `function/` (`*.whatsapp.php` in root `pdf_*_whatsapp.php`).

## Data Flow

### React Native App — Trips list (current mock path)

### React Native App — Authentication / onboarding (mock path)

### PHP backend — Web page request

### PHP backend — Mobile API request

- RN app: Zustand (`src/store/authStore.js`) for global auth/onboarding; TanStack Query for server-cache state (per-query `queryKey`s); local component state via `useState` in hooks.
- PHP backend: PHP `$_SESSION`-based auth; no client-side state framework beyond jQuery.

## Key Abstractions

- Purpose: Encapsulates one business domain.
- Examples: `src/features/trips/`, `src/features/parties/`, `src/features/auth/`, `src/features/trucks/`.
- Pattern: `screens/`, `components/`, `hooks/`, `sheets/`, `constants/` + `<feature>.api.js`, `<feature>.mock.js`, `<feature>Validation.js`.
- Purpose: Single configured HTTP client.
- Example: `src/services/api/client.js`.
- Pattern: axios `create` + request/response interceptors.
- Purpose: In-memory stand-in for the future backend.
- Example: `src/features/trips/trips.mock.js`, `src/features/auth/auth.mock.js`.
- Pattern: `mockFetch*` / `mockCreate*` async functions with artificial `delay`.
- Purpose: Reusable query/helper methods across pages.
- Example: `transport backend/lib/getval.php` (`class Comman`).
- Pattern: Object accessed as `$cmn->method($connection, ...)`.
- Purpose: Manual SQL CRUD + transformation utilities.
- Example: `transport backend/lib/dboperation.php` (`dbRowSelect`, `dbRowInsert`, `dbRowUpdate`, `dbRowDelete`, `SelectDB`, `getvalfield`, `dateformat*`).

## Entry Points

- `index.js` — native registration entry.
- `App.js` — provider composition + mounts `RootNavigator`.
- `src/navigation/RootNavigator.js` — top-level auth-gated switch.
- `transport backend/index.php` — login screen (session entry).
- `transport backend/dashboard.php` — main post-login shell.
- `transport backend/mobile/API/user_login.php`, `user_registration.php`, `master.php`, per-feature report files — token-gated JSON endpoints.

## Architectural Constraints

- **Threading:** RN app is single-threaded JS (React Native) with native async; no worker threads in `src/`. PHP is request-scoped single-threaded.
- **Global state (RN):** Module-level singletons — `queryClient` (`src/services/api/queryClient.js`), `navigationRef` (`src/navigation/navigationRef.js`), `quickActionSheetController` (`src/features/quickActions/quickActionSheetController.js`), volatile `authStorage` (`src/services/storage/authStorage.js` uses a module-level `volatileSession` variable).
- **Global state (PHP):** `$_SESSION` holds `user_id`, `comp_id`, `session_id`, `consignor_id`; helper functions rely on the global `$connection` variable passed in or captured from `config.php`.
- **Circular imports:** Not detected within RN `src/` (navigation imports screens; screens import navigation for routes/refs — this is a one-directional-ish pairing but no cycle observed).
- **Backend contract coupling:** RN `*.api.js` files assume a Laravel-style `/api/...` REST contract. The actual PHP backend exposes `mobile/API/*.php` with a `token`+`tag` scheme — **the RN app's API layer is NOT aligned with the real backend yet** (both sides agree this is a placeholder).
- **Volatile session storage:** `authStorage` is intentionally in-memory only (`authStorage.js`); no persistence on restart.

## Anti-Patterns

### Procedural "God file" pages (PHP)

### Raw SQL string interpolation (PHP)

### Duplicate ad-hoc helper implementations (PHP)

### Mock-first with placeholder API in frontend

## Error Handling

- RN: Centralized `normalizeApiError` (`src/services/api/errors.js`) maps status codes to error types (`validation`, `authentication`, `authorization`, `not_found`, `server`, `timeout`, `network`, `unknown`). Hooks expose `errorMessage` via `useState` and rethrow.
- PHP: `error_reporting(0)` in UI pages (errors suppressed); `adminsession.php` guards protected pages; manual `if ($count > 0)` checks in mobile API.
- RN: fetch-hook `try/catch/finally` with `isSubmitting`/`isSending` flags and `errorMessage` state (see `useMockLogin.js`, `useSendMobileOtp.js`).
- PHP: `die()` / `echo "..."` inline error messages; no exception framework.

## Cross-Cutting Concerns

- RN: No structured logging beyond `console.warn` in `navigationRef.js`; `jest.setup.js` configures test mocks of `console`.
- PHP: Native `error_log` files present at backend root and `ajax/` and `excel/`; `dbbackup.php` handles DB dumps; `error_reporting(0)` suppresses display errors.
- RN: Zod schemas per feature (`*Validation.js`) e.g. `addTripSchema` in `src/features/trips/tripsValidation.js`; used with `react-hook-form` (resolvers present in `package.json`).
- PHP: Client-side JS validation in `function/*.php` (`checkinputmaster`, `onlyalphabets`, etc. in `lib/commonfun.js`); minimal server-side checks.
- RN: Zustand auth store + volatile storage; token injected via axios interceptor (`client.js:15-23`).
- PHP: Web uses `$_SESSION` + `adminsession.php`; mobile API uses a hardcoded shared token (`GURU`) in a `token` request param (`mobile/API/top_file.php:78`, checked in each endpoint).

<!-- GSD:architecture-end -->

<!-- GSD:skills-start source:skills/ -->

## Project Skills

No project skills found. Add skills to any of: `.claude/skills/`, `.agents/skills/`, `.cursor/skills/`, `.github/skills/`, or `.codex/skills/` with a `SKILL.md` index file.
<!-- GSD:skills-end -->

<!-- GSD:workflow-start source:GSD defaults -->

## GSD Workflow Enforcement

Before using Edit, Write, or other file-changing tools, start work through a GSD command so planning artifacts and execution context stay in sync.

Use these entry points:

- `/gsd-quick` for small fixes, doc updates, and ad-hoc tasks
- `/gsd-debug` for investigation and bug fixing
- `/gsd-execute-phase` for planned phase work

Do not make direct repo edits outside a GSD workflow unless the user explicitly asks to bypass it.
<!-- GSD:workflow-end -->

<!-- GSD:profile-start -->

## Developer Profile

> Profile not yet configured. Run `/gsd-profile-user` to generate your developer profile.
> This section is managed by `generate-claude-profile` -- do not edit manually.
<!-- GSD:profile-end -->
