# Codebase Structure

**Analysis Date:** 2026-08-30

## Directory Layout

```
TransportApp/                          # Git root — contains TWO sub-projects
│
├── App.js                             # RN app: provider composition
├── index.js                           # RN native entry (registers App)
├── app.json                           # App name/displayName
├── package.json                       # RN deps + scripts
├── babel.config.js                    # Babel presets + reanimated plugin
├── jest.config.js / jest.setup.js     # Jest test config
├── tsconfig.json                      # TS config (extends @react-native/typescript-config)
├── metro.config.js                    # Metro bundler config
├── .eslintrc.js / .prettierrc.js      # Lint/format config
├── Gemfile / Gemfile.lock             # CocoaPods (iOS) Ruby deps
├── README.md / PRD.md / DESIGN.md     # Project docs
├── IMPLEMENTATION_PLAN.md             # Plan doc
├── TECHNICAL_REQUIREMENTS.md          # Requirements doc
│
├── src/                               # React Native application source
│   ├── assets/                        # Animations (Lottie), images, fonts
│   ├── components/                    # Shared UI components
│   ├── config/                        # env.js (dev/prod endpoints)
│   ├── features/                      # Feature-based modules
│   ├── hooks/                         # (empty — reserved)
│   ├── navigation/                    # Navigators + route names
│   ├── services/                      # API client, query client, storage
│   ├── store/                         # Zustand stores
│   ├── theme/                         # Design tokens
│   ├── types/                         # (empty — reserved)
│   └── utils/                         # (empty — reserved)
│
├── android/                           # Native Android project
│   ├── app/  build.gradle  gradle/  gradlew  settings.gradle  gradle.properties
│
├── ios/                               # Native iOS project
│   ├── TransportApp/  Podfile  Podfile.lock  Pods/  *.xcodeproj  *.xcworkspace  build/
│
├── node_modules/                      # npm deps (ignored)
├── __tests__/                         # RN Jest test files
├── .bundle/  .opencode/  .planning/   # Tooling directories
│
└── transport backend/                 # PHP backend (see second tree below)
```

### PHP Backend layout

```
transport backend/
├── index.php                          # Web login page (entry)
├── dashboard.php                      # Main post-login shell
├── *.php                              # ~120 page-per-feature web pages (top level)
├── dbinfo.php  dbbackup.php  check_login.php  loginotp.php  logout.php
├── *.sql                              # SQL database backups (8x ~7.5MB dumps)
│
├── inc/                               # Shared layout partials
│   ├── top-files.php  top-header.php  left-menu.php
│   ├── model.php  breadcrumbs.php  alert.php  inc_ex_head.php
│
├── lib/                               # Shared server helpers
│   ├── dboperation.php                # DB CRUD + util functions
│   ├── getval.php  getval2.php        # `Comman` class ($cmn->)
│   ├── smsinfo.php                     # SMS helper
│   └── commonfun.js                   # Client-side JS helpers
│
├── function/                          # Client-side feature JS libraries (10 files)
│   ├── dispatch_function.php  payment_function.php  bill_function.php  etc.
│
├── ajax/                              # Web AJAX endpoints (~40 files)
│   ├── ajax_savconsignee.php  save_dispatch_adv.php  approve.php  etc.
│
├── ajaxaccount/  ajaxbill/  ajaxissue/  ajaxmaintenance/
│   ajaxpayment/  ajaxpayroll/  ajaxpurchase/  ajaxreturn/  ajaxsale/
│                                       # Domain-split AJAX subdirectories
│
├── mobile/                            # Mobile (separate web UI + API)
│   ├── API/                           # Token-gated REST-lite JSON endpoints
│   │   ├── config.php  top_file.php  footer.php   # API bootstrap
│   │   ├── user_login.php  user_registration.php  user_varification.php
│   │   ├── master.php  edit_profile.php  resend_otp.php  save_receipt.php
│   │   └── *.report.php  *.php        # Per-feature report/voucher endpoints
│   ├── ajax/                          # Mobile AJAX endpoints (~25 files)
│   ├── inc/                           # Mobile shared layout partials
│   ├── *.php                          # Mobile web UI pages (report_list, dispatch, etc.)
│   └── assets/  css/  images/  js/
│
├── master/                            # Admin entry (index.php, login.php)
├── select/                            # select2 assets
│
├── pdf/                               # PDF report generators (61 files) — uses fpdf17/, fpdf184/
├── excel/                             # Excel report generators (~39 files)
├── whatsapp/                          # WhatsApp-share PDF outputs (many .pdf files)
├── pdf_*.php                          # Root-level PDF/WhatsApp generators
│
├── fpdf17/  fpdf184/                  # Embedded FPDF library versions
├── vendor/                            # Composer deps (phpoffice/phpword) — ignored
├── composer.json  composer.lock       # PHP dependency manifest
│
├── css/  js/  font/  icon/  img/  image/  upload/  temp/   # Static + runtime assets
└── error_log                          # Runtime log files
```

## Directory Purposes

### React Native app

**`src/features/`**
- Purpose: Feature-based business modules. Every feature is a self-contained folder.
- Contains: `screens/`, `components/`, `hooks/`, `sheets/`, `constants/`, plus `<feature>.api.js`, `<feature>.mock.js`, `<feature>Validation.js`.
- Key files:
  - `src/features/auth/` — login/signup/OTP/onboarding (screens: `SplashScreen`, `WelcomeScreen`, `AuthScreen`, `LoginScreen`, `OtpScreen`, `BusinessSetupScreen`).
  - `src/features/trips/` — most complete feature; trips CRUD, status stepper, sheets (`AddAdvanceSheet`, `AddDriverBalanceSheet`, `AddMoreDetailsSheet`).
  - `src/features/parties/` — party list/add/select-state; constants (`indianStates.js`).
  - `src/features/trucks/` — truck hooks/queries only (no screens yet).
  - `src/features/dashboard/` — home screen, module tiles, promo carousel, `constants/businessModules.js`.
  - `src/features/khata/`, `src/features/more/`, `src/features/quickActions/` — ledger placeholder, "more" menu, quick-action add sheet.
  - Stub features (only `.gitkeep`): `documents/`, `drivers/`, `expenses/`, `reports/`, `suppliers/`, and partial stubs in `parties/`, `trucks/`.

**`src/components/`**
- Purpose: Shared/reusable UI.
- Contains: `common/` (AppButton, AppCard, AppHeader, AppScreen, AppText, EmptyState), `ui/` (StatusBadge).
- Key files: `src/components/common/AppScreen.js` (safe-area + scroll wrapper), `src/components/common/AppText.js` (text variants).

**`src/navigation/`**
- Purpose: Declarative routing.
- Contains: `RootNavigator.js`, `AuthNavigator.js`, `AppNavigator.js`, `MainTabNavigator.js`, `routeNames.js` (all route string constants), `navigationRef.js`.
- Pattern: Route names centralized in `routeNames.js` under `routes.*`.

**`src/services/`**
- Purpose: Cross-cutting infrastructure.
- Contains: `api/client.js` (axios), `api/queryClient.js`, `api/errors.js`, `storage/authStorage.js`.

**`src/store/`**
- Purpose: Global client state.
- Contains: `authStore.js` (Zustand).

**`src/theme/`**
- Purpose: Design tokens.
- Contains: `colors.js`, `spacing.js`, `radius.js`, `shadows.js`, `typography.js`, barrel `index.js`.

**`src/config/`**
- Purpose: Environment config.
- Contains: `env.js` (`dev`/`prod` base URL + timeout, toggled by `__DEV__`).

**`src/assets/`**
- Purpose: Static assets.
- Contains: `animation/` (Lottie JSON), `images/`, `fonts/` (currently empty).

**`src/hooks/`, `src/types/`, `src/utils/`**
- Purpose: Reserved global folders.
- Contains: Currently **empty**. Put cross-feature generic hooks, shared TS types, and shared utilities here; feature-specific logic belongs in `src/features/<feature>/`.

### PHP backend

**`transport backend/` (root)**
- Purpose: Top-level page-per-feature web pages.
- Contains: ~120 procedural PHP pages (masters, dispatch, billing, payment, reports, journals).

**`transport backend/lib/`**
- Purpose: Shared backend helpers.
- Contains: `dboperation.php` (DB CRUD), `getval.php`/`getval2.php` (`Comman` class), `smsinfo.php`, `commonfun.js`.

**`transport backend/inc/`**
- Purpose: Shared page-fragment includes for the web UI (head, top nav, left menu).

**`transport backend/function/`**
- Purpose: Client-side JS feature libraries (AJAX + validation) rendered as PHP.

**`transport backend/ajax/` + `transport backend/ajax*/`**
- Purpose: Server-side AJAX handlers (form/JSON responses).

**`transport backend/mobile/`**
- Purpose: Mobile web UI + the mobile JSON API.
- Key: `mobile/API/` is the actual REST-lite endpoint layer; `mobile/ajax/` is AJAX; `mobile/inc/` is layout.

**`transport backend/pdf/`, `excel/`, `whatsapp/`, root `pdf_*.php`**
- Purpose: Report/export generators (FPDF, Excel, WhatsApp-share PDFs).

**`transport backend/vendor/`, `composer.json`, `composer.lock`**
- Purpose: Composer deps (`phpoffice/phpword`). `vendor/` is dependency code (ignored in scans).

## Key File Locations

**Entry Points (RN):**
- `index.js`: native registration.
- `App.js`: provider composition.
- `src/navigation/RootNavigator.js`: top-level auth-gated switch.

**Configuration (RN):**
- `src/config/env.js`: API base URL + timeout.
- `babel.config.js`, `metro.config.js`, `jest.config.js`, `jest.setup.js`, `.eslintrc.js`, `.prettierrc.js`, `tsconfig.json`.

**Core Logic (RN):**
- `src/features/trips/`: richest feature (screens, hooks, sheets, api/mock/validation).
- `src/store/authStore.js`: global auth state.
- `src/services/api/client.js`: HTTP client.

**Testing (RN):**
- `__tests__/`: top-level Jest tests (`AddTrip.test.js`, `TripDetails.test.js`, `TripsList.test.js`, `AuthScreen.test.js`, `BusinessSetup.test.js`, `App.test.tsx`).

**Entry Points (PHP):**
- `transport backend/index.php`: web login.
- `transport backend/dashboard.php`: post-login shell.
- `transport backend/mobile/API/*.php`: mobile JSON API.

**Configuration (PHP):**
- `transport backend/mobile/API/config.php`: DB connection + timezone.
- `transport backend/composer.json`: PHP package manifest.

## Naming Conventions

**Files:**
- **RN features:** screens `*Screen.js`, hooks `use*.js`, forms `*Form.js`, sheets `*Sheet.js`, validation `*Validation.js`, api `*.api.js`, mock `*.mock.js`. Kebab-ish lowercase filenames (e.g. `useAddTripMutation.js`, `TripsListScreen.js`).
- **RN components:** `App*.js` prefix for shared design-system components (`AppButton`, `AppCard`, `AppHeader`, `AppScreen`, `AppText`).
- **PHP web pages:** lowercase descriptive, often `snake_case` or hyphenated (`dispatch-process.php`, `vehicle_master.php`, `all-dispatch-entry.php`, `consignee-master.php`).
- **PHP AJAX:** `ajax_save*.php`, `save_*.php`, `get*.php` (e.g. `ajax_savedriver.php`).
- **PHP functions:** `*_function.php` (e.g. `dispatch_function.php`, `payment_function.php`).
- **PHP mobile API:** descriptive endpoints (`user_login.php`, `master.php`, `*_report.php`, `*_report1.php`).
- **PHP PDFs:** `pdf_*.php`; Excel `excel_*.php`; WhatsApp `pdf_*_whatsapp.php`.
- **DB dumps:** `*_backup_<timestamp>.sql`.

**Directories:**
- **RN features:** lowercase singular feature names (`auth`, `trips`, `parties`, `trucks`, `khata`).
- **PHP:** feature/domain-prefixed `ajax<domain>/` directories (`ajaxpayment/`, `ajaxpurchase/`).

## Where to Add New Code

**New Feature (RN):**
- Create `src/features/<feature>/` with `screens/`, `components/`, `hooks/`, and `sheets/` as needed.
- Add `<feature>.api.js` (future API contract), `<feature>.mock.js` (mock data for now), and `<feature>Validation.js` (Zod schemas) — mirror `src/features/trips/`.
- Register screens/routes in `src/navigation/routeNames.js` and wire into `AppNavigator.js` (or as a tab in `MainTabNavigator.js`).
- Add tests in `__tests__/`.

**New Shared Service (RN):**
- Add to `src/services/` (e.g. new `api/*.js` or `storage/*.js`).

**New Shared UI Component (RN):**
- Add to `src/components/common/` with `App*` prefix.

**New Design Token:**
- Add to `src/theme/`, export via `src/theme/index.js`.

**New Global Hook / Type / Util (RN):**
- Add to `src/hooks/`, `src/types/`, or `src/utils/` (currently empty reserved folders). Prefer co-locating feature-specific logic in `src/features/<feature>/hooks|constants|utils` first.

**New PHP Web Page:**
- Add `.php` at `transport backend/` root; `include` the needed `inc/` partials and `lib/` helpers.

**New PHP AJAX Endpoint:**
- Add to `transport backend/ajax/` (or a domain subdirectory like `ajaxpayment/`).

**New PHP Mobile API Endpoint:**
- Add to `transport backend/mobile/API/`; `include('top_file.php')` at top and `include('footer.php')` at bottom; gate on `$token`.

**New PDF / Excel export:**
- Add to `transport backend/pdf/` (`pdf_*.php`) or `transport backend/excel/` (`excel_*.php`).

## Special Directories

**`node_modules/`**
- Purpose: npm dependencies.
- Generated: Yes. Committed: No.

**`transport backend/vendor/`**
- Purpose: Composer dependencies.
- Generated: Yes. Committed: No.

**`transport backend/temp/`**
- Purpose: Runtime/scratch files (includes old theme HTML samples).
- Generated: Mostly. Committed: Yes (contains template samples).

**`transport backend/whatsapp/`**
- Purpose: Runtime output of generated WhatsApp-share PDFs.
- Generated: Yes. Committed: Yes (many `.pdf` files present).

**`transport backend/*.sql`**
- Purpose: Full database backups.
- Generated: Yes (scheduled dumps). Committed: Yes (~7.5MB each).

**`src/assets/`**
- Purpose: App static assets (Lottie animations, images).
- Generated: No. Committed: Yes.

**`android/build/`, `ios/build/`, `ios/Pods/`, `.bundle/`**
- Purpose: Native build artifacts / CocoaPods output.
- Generated: Yes. Committed: No.

---

*Structure analysis: 2026-08-30*
