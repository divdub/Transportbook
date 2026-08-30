<!-- refreshed: 2026-08-30 -->
# Architecture

**Analysis Date:** 2026-08-30

## System Overview

This repository contains TWO independent sub-projects sharing one git repo:

1. **React Native mobile app** (frontend) — root-level `App.js`, `src/`, `android/`, `ios/`
2. **PHP web application + mobile REST API** — `transport backend/` directory

They are architecturally separate. The React Native app currently uses in-app mock data layers and defines its (future) API boundary against a Laravel-style REST contract (`/api/...`), while the existing PHP backend at `transport backend/` is a legacy procedural MySQL application (no framework) with its own mobile API surface. **The two do not yet talk to each other** — the RN app's `.mock.js` layers simulate the backend.

```text
┌──────────────────────────────────────────────────────────────┐
│              React Native App  (root: App.js, src/)           │
│                                                              │
│  Screens (features/*/screens)                                │
│      │                                                       │
│      ├─► Hooks (features/*/hooks)  useQuery/useMutation      │
│      │       │                                               │
│      │       ▼                                               │
│      ├─► {*.mock.js}  ──(currently wired)──►  local data     │
│      │       │                                               │
│      │       ▼  (future)                                     │
│      ├─► *.api.js ──► services/api/client.js (axios)         │
│      │                                                       │
│      └─► store/authStore.js (zustand) ─► services/storage    │
│                                                              │
│  Navigation: RootNavigator → Auth/App Navigators            │
└──────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────┐
│          PHP Backend  (transport backend/)                   │
│                                                              │
│  Web UI: index.php → dashboard.php (procedural, session)     │
│  Mobile API: mobile/API/*.php (token-gated REST-lite)        │
│      │                                                       │
│      ▼                                                       │
│  lib/*.php (dboperation, getval) ──► MySQL (mysqli_*)        │
│  function/*.php (js helper libs)                             │
│  pdf/, excel/, whatsapp/ (report generators)                 │
└──────────────────────────────────────────────────────────────┘
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

**Overall:** The RN app uses a **feature-based, layered** architecture (feature folders containing screens/hooks/api/mock/validation), with **centralized cross-cutting services** (api, storage, theme) and **state via Zustand + TanStack Query**. Data access is currently behind **mock layers** awaiting a real backend contract.

The PHP backend uses a **legacy procedural page-per-feature** architecture (each `.php` is an entry point doing its own DB + HTML), with a thin shared `Comman` class (`lib/getval.php`) and DB helper functions (`lib/dboperation.php`). No framework, no router, no ORM.

**Key Characteristics:**
- RN app is provider-driven composition at `App.js` (QueryClientProvider, SafeAreaProvider, BottomSheetModalProvider, GestureHandlerRootView).
- Feature folders follow a consistent internal layout: `screens/`, `components/`, `hooks/`, plus a feature-level `*.api.js`, `*.mock.js`, `*.validation.js`.
- Current data flow routes through `*.mock.js` (e.g. `src/features/trips/trips.mock.js`), with `*.api.js` stubs defining the future contract.
- PHP backend follows page-per-file with `include`-based layout partials and shared `common` utility includes.

## Layers

### React Native App

**Application shell:**
- Purpose: Bootstrap providers and root navigation.
- Location: `App.js`, `index.js`
- Contains: Provider composition, native registration.
- Depends on: `src/navigation/RootNavigator`, `src/services/api/queryClient`, `src/theme`.
- Used by: The native runtime.

**Navigation layer:**
- Purpose: Declarative routing, gated by auth/onboarding state.
- Location: `src/navigation/`
- Contains: `RootNavigator.js`, `AuthNavigator.js`, `AppNavigator.js`, `MainTabNavigator.js`, `routeNames.js`, `navigationRef.js`.
- Depends on: `src/features/*/screens`, `src/store/authStore`, `src/theme`.
- Used by: `App.js`.

**Feature layer:**
- Purpose: Owns all UI + data logic for a business domain (auth, trips, parties, trucks, dashboard, khata, quickActions, more).
- Location: `src/features/<feature>/`
- Contains: `screens/`, `components/`, `hooks/`, `sheets/`, `constants/`, and files `*.api.js`, `*.mock.js`, `*Validation.js`.
- Depends on: `src/services/api/client`, `src/services/api/queryClient`, `src/store`, `src/components/common`, `src/theme`, `src/navigation`.
- Used by: The navigation layer.

**Services layer:**
- Purpose: Shared infrastructure (HTTP, storage, error handling).
- Location: `src/services/`
- Contains: `api/client.js`, `api/queryClient.js`, `api/errors.js`, `storage/authStorage.js`.
- Depends on: `src/config/env`.
- Used by: Feature layers.

**State layer:**
- Purpose: Global auth/onboarding client state.
- Location: `src/store/authStore.js`
- Depends on: `src/services/storage/authStorage`.
- Used by: Root navigator + auth hooks.

**Theme layer:**
- Purpose: Centralized design tokens.
- Location: `src/theme/` (`colors.js`, `spacing.js`, `radius.js`, `shadows.js`, `typography.js`, `index.js` barrel).
- Used by: All layers.

### PHP Backend

**Web UI pages (page-per-feature):**
- Purpose: Full server-rendered CRUD/transaction pages.
- Location: `transport backend/*.php` (e.g. `dispatch-process.php`, `billing.php`, `payment-process.php`, `vehicle_master.php`).
- Depends on: `inc/*.php` partials, `lib/*.php`, `function/*.php`.

**Layout partials:**
- Purpose: Shared HTML head, nav, menu, alerts.
- Location: `transport backend/inc/` (`top-files.php`, `top-header.php`, `left-menu.php`, `model.php`, `breadcrumbs.php`, `alert.php`).
- Used by: Web UI pages.

**Shared helpers:**
- Purpose: DB CRUD + utilities, common class.
- Location: `transport backend/lib/` (`dboperation.php`, `getval.php`, `getval2.php`, `smsinfo.php`).
- Used by: Web UI pages, mobile API.

**Client-side function libraries:**
- Purpose: AJAX + validation helper JS.
- Location: `transport backend/function/*.php` (`dispatch_function.php`, `payment_function.php`, `bill_function.php`, etc.).
- Used by: Web UI pages via `<script>` includes.

**AJAX handlers:**
- Purpose: Lightweight JSON/form endpoints called from function JS.
- Location: `transport backend/ajax/*.php` (e.g. `ajax_savconsignee.php`, `save_dispatch_adv.php`).

**Mobile API (REST-lite):**
- Purpose: Token-gated JSON endpoints for the mobile app.
- Location: `transport backend/mobile/API/*.php` (`user_login.php`, `user_registration.php`, `master.php`, `*.report.php`, etc.).
- Each endpoint includes `top_file.php` (token check) and `footer.php` (JSON envelope).
- Depends on: `mobile/API/config.php` (DB connection), `mobile/API/top_file.php`.

**Mobile web UI:**
- Purpose: Separate mobile web pages (hybrid-web style).
- Location: `transport backend/mobile/*.php` + `mobile/inc/`.

**Report generators:**
- Purpose: Export PDF / Excel / WhatsApp reports.
- Location: `transport backend/pdf/` (60+ `pdf_*.php` using `fpdf17/`, `fpdf184/`), `excel/` (`excel_*.php`), `whatsapp/`, `function/` (`*.whatsapp.php` in root `pdf_*_whatsapp.php`).

## Data Flow

### React Native App — Trips list (current mock path)

1. `TripsListScreen` (`src/features/trips/screens/TripsListScreen.js`) calls `useTripsQuery()`.
2. `useTripsQuery` (`src/features/trips/hooks/useTripsQuery.js`) invokes `mockFetchTrips` from `src/features/trips/trips.mock.js`.
3. Mock returns local in-memory array (`trips.mock.js:3`).
4. `TripsListScreen` renders the returned data.

**Future backend path** (noted in `useTripsQuery.js:9-11`):
1. `useTripsQuery` → `tripsApi.getTrips()` (`src/features/trips/trips.api.js:13`).
2. `tripsApi.getTrips` calls `apiClient.get('/api/trips', {params})` (`src/services/api/client.js`).
3. axios request interceptor attaches `Authorization: Bearer <token>` from `authStorage` (`client.js:15-23`).
4. Response interceptor normalizes errors via `normalizeApiError` (`src/services/api/errors.js`).

### React Native App — Authentication / onboarding (mock path)

1. `SplashScreen` → `RootNavigator` `useEffect` calls `restoreSession()` (`RootNavigator.js:21-23`).
2. `restoreSession` reads `authStorage.getSession()` and sets `isAuthenticated`/`isOnboarded` (`authStore.js:10-18`).
3. `RootNavigator` renders `AuthNavigator`, `BusinessSetupScreen`, or `AppNavigator` based on these flags (`RootNavigator.js:36-42`).
4. Login uses `useMockLogin` (`src/features/auth/hooks/useMockLogin.js`) → `mockLogin` (`auth.mock.js`) → `completeMockAuthentication` on the store.
5. `AppNavigator` exposes feature screens via a native stack; `MainTabNavigator` exposes the 5 bottom tabs (Home/Trips/Add/Khata/More) — the "Add" tab opens `QuickActionSheet` (`MainTabNavigator.js:32-39`).

### PHP backend — Web page request

1. Request hits `index.php` (login) → posts to `loginotp.php` → establishes session → redirects to `dashboard.php`.
2. `dashboard.php` includes `adminsession.php` (guard) + `inc/*.php` layout.
3. Page code calls helper functions from `lib/dboperation.php` / `lib/getval.php` (e.g. `dbRowSelect`, `getvalfield`).
4. Inline JS from `function/*.php` fires AJAX calls to `ajax/*.php` which return HTML/JSON snippets rendered into the page.

### PHP backend — Mobile API request

1. Mobile client POSTs with `token=GURU` and a `tag` parameter to `mobile/API/<endpoint>.php`.
2. Endpoint includes `top_file.php` → `config.php` (DB connection), sets up `$data`, `$success`, `$msg` array envelope.
3. Code validates `$token == "GURU"`, branches on `$_REQUEST['tag']`, runs `mysqli` queries.
4. Endpoint includes `footer.php` which JSON-encodes the `$data`/`$success`/`$msg` response.

**State Management:**
- RN app: Zustand (`src/store/authStore.js`) for global auth/onboarding; TanStack Query for server-cache state (per-query `queryKey`s); local component state via `useState` in hooks.
- PHP backend: PHP `$_SESSION`-based auth; no client-side state framework beyond jQuery.

## Key Abstractions

**Feature module** (RN):
- Purpose: Encapsulates one business domain.
- Examples: `src/features/trips/`, `src/features/parties/`, `src/features/auth/`, `src/features/trucks/`.
- Pattern: `screens/`, `components/`, `hooks/`, `sheets/`, `constants/` + `<feature>.api.js`, `<feature>.mock.js`, `<feature>Validation.js`.

**API client** (RN):
- Purpose: Single configured HTTP client.
- Example: `src/services/api/client.js`.
- Pattern: axios `create` + request/response interceptors.

**Mock data layer** (RN):
- Purpose: In-memory stand-in for the future backend.
- Example: `src/features/trips/trips.mock.js`, `src/features/auth/auth.mock.js`.
- Pattern: `mockFetch*` / `mockCreate*` async functions with artificial `delay`.

**Common class (`$cmn`)** (PHP):
- Purpose: Reusable query/helper methods across pages.
- Example: `transport backend/lib/getval.php` (`class Comman`).
- Pattern: Object accessed as `$cmn->method($connection, ...)`.

**DB helper functions** (PHP):
- Purpose: Manual SQL CRUD + transformation utilities.
- Example: `transport backend/lib/dboperation.php` (`dbRowSelect`, `dbRowInsert`, `dbRowUpdate`, `dbRowDelete`, `SelectDB`, `getvalfield`, `dateformat*`).

## Entry Points

**React Native App:**
- `index.js` — native registration entry.
- `App.js` — provider composition + mounts `RootNavigator`.
- `src/navigation/RootNavigator.js` — top-level auth-gated switch.

**PHP Backend (Web):**
- `transport backend/index.php` — login screen (session entry).
- `transport backend/dashboard.php` — main post-login shell.

**PHP Backend (Mobile API):**
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

**What happens:** Many PHP pages are large, single files mixing DB queries, HTML, and inline JS (e.g. `dashboard.php` ~106KB, `billing.php` ~56KB, `dispatch-process.php` ~66KB, `return.php` ~65KB).
**Why it's wrong:** No separation of concerns; hard to test, reuse, or change without risk.
**Do this instead:** Extract business logic into classes/functions and keep pages as thin view/controller shells — the `lib/` and `function/` directories are the intended home but are underused.

### Raw SQL string interpolation (PHP)

**What happens:** Queries built by concatenating request values directly into SQL (e.g. `"select * from m_vehicle_owner where mobileno1='$mobile'"` in `mobile/API/user_login.php:17`).
**Why it's wrong:** SQL injection risk; `dboperation.php` helper `test_input` exists but is inconsistently applied.
**Do this instead:** Use `mysqli` prepared statements (parameter binding) consistently.

### Duplicate ad-hoc helper implementations (PHP)

**What happens:** `getvalfield` / `dateformatindia` are redefined in `lib/dboperation.php` AND again in `mobile/API/top_file.php` (and similar in `mobile/API/config.php`).
**Why it's wrong:** Divergent copies drift and create maintenance confusion.
**Do this instead:** Include a single shared bootstrap (`lib/`) from both web and mobile API paths.

### Mock-first with placeholder API in frontend

**What happens:** Feature hooks currently call `.mock.js` directly (e.g. `useTripsQuery` → `mockFetchTrips`), while `*.api.js` is empty/stub (`parties.api.js` is empty).
**Why it's wrong:** The real backend contract is unknown, so the API layer is guesswork; when the backend arrives, wiring must be re-done.
**Do this instead:** Follow the documented future path (hook → `*.api.js` → `services/api/client.js`), which is already scaffolded in `trips.api.js`.

## Error Handling

**Strategy:**
- RN: Centralized `normalizeApiError` (`src/services/api/errors.js`) maps status codes to error types (`validation`, `authentication`, `authorization`, `not_found`, `server`, `timeout`, `network`, `unknown`). Hooks expose `errorMessage` via `useState` and rethrow.
- PHP: `error_reporting(0)` in UI pages (errors suppressed); `adminsession.php` guards protected pages; manual `if ($count > 0)` checks in mobile API.

**Patterns:**
- RN: fetch-hook `try/catch/finally` with `isSubmitting`/`isSending` flags and `errorMessage` state (see `useMockLogin.js`, `useSendMobileOtp.js`).
- PHP: `die()` / `echo "..."` inline error messages; no exception framework.

## Cross-Cutting Concerns

**Logging:**
- RN: No structured logging beyond `console.warn` in `navigationRef.js`; `jest.setup.js` configures test mocks of `console`.
- PHP: Native `error_log` files present at backend root and `ajax/` and `excel/`; `dbbackup.php` handles DB dumps; `error_reporting(0)` suppresses display errors.

**Validation:**
- RN: Zod schemas per feature (`*Validation.js`) e.g. `addTripSchema` in `src/features/trips/tripsValidation.js`; used with `react-hook-form` (resolvers present in `package.json`).
- PHP: Client-side JS validation in `function/*.php` (`checkinputmaster`, `onlyalphabets`, etc. in `lib/commonfun.js`); minimal server-side checks.

**Authentication:**
- RN: Zustand auth store + volatile storage; token injected via axios interceptor (`client.js:15-23`).
- PHP: Web uses `$_SESSION` + `adminsession.php`; mobile API uses a hardcoded shared token (`GURU`) in a `token` request param (`mobile/API/top_file.php:78`, checked in each endpoint).

---

*Architecture analysis: 2026-08-30*
