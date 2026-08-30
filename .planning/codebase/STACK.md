# Technology Stack

**Analysis Date:** 2026-08-30

## Repo Layout — Two Sub-Projects

This repository contains two independent codebases:

1. **React Native mobile app** at the repo root (`App.js`, `src/`, `android/`, `ios/`, `package.json`) — the TransportApp driver/owner mobile client.
2. **PHP backend** at `transport backend/` — a legacy PHP/MySQL transport management system (578 PHP files, MySQL, FPDF, WhatsApp/SMS integrations) that the app is being wired to.

They are not yet fully integrated: the app's API layer targets two different backend shapes (see INTEGRATIONS.md).

---

## Languages

**Primary:**
- JavaScript (React Native 0.87.0, ES modules via Babel) — all app code under `src/` and `App.js`, `index.js`
- PHP 7+ (procedural, `mysqli` extension; code uses `??` null-coalescing in `transport backend/loginotp.php`, `transport backend/mobile/API/resend_otp.php`) — entire `transport backend/` codebase, no framework

**Secondary:**
- Java/Kotlin — Android native shell (`android/`, Kotlin 2.2.0, Gradle)
- Objective-C/Swift (via CocoaPods) — iOS native shell (`ios/`)
- Ruby — `Gemfile`/`Gemfile.lock` for CocoaPods toolchain
- SQL — MySQL; full DB dumps committed alongside the app: `transport backend/chaarqvc_guruassociates_backup_*.sql`, `transport backend/sjt_backup_*.sql`
- TypeScript — only for config/types (`tsconfig.json` extends `@react-native/typescript-config`; app source is JS, `src/` has no `.ts` files)

## Runtime

**Environment:**
- Mobile: React Native 0.87.0 (installed, verified via `node_modules/react-native/package.json`); Hermes engine default for RN 0.87
- Node.js: `>= 22.11.0` required (`package.json` → `"engines"`); local dev machine has v25.4.0
- PHP: no version pinned in-repo; Composer deps (`phpoffice/math`) require `^7.1|^8.0`; local machine has PHP 8.5.4. Code uses pre-PHP8 idioms everywhere (no native types, procedural `mysqli`)

**Package Manager:**
- npm — root `package-lock.json` present (480 KB)
- Composer — `transport backend/composer.json` + `transport backend/composer.lock` (only for `phpoffice/phpword`)
- Ruby Bundler — `Gemfile.lock` for CocoaPods (pinned `cocoapods 1.15.2`, `activesupport`, `xcodeproj < 1.26.0`; `.bundle/config` sets `BUNDLE_PATH: "vendor/bundle"`, local `vendor/` dir contains the bundled gems)
- No Yarn, no pnpm, no `.nvmrc`

## Frameworks

**Core (React Native app):**
- React 19.2.3 + React Native 0.87.0 — mobile framework (`package.json`)
- React Navigation 7 (`@react-navigation/native`, `native-stack`, `bottom-tabs`) — navigation (`src/navigation/RootNavigator.js`, `AppNavigator.js`, `MainTabNavigator.js`)
- TanStack React Query 5 — server-state cache (`src/services/api/queryClient.js`)
- Zustand 5 — client state/auth store (`src/store/authStore.js`)
- react-hook-form 7 + zod 4 (`@hookform/resolvers`) — form + validation (`src/features/*/tripsValidation.js`, `partiesValidation.js`, `trucksValidation.js`)

**Core (PHP backend):**
- Plain PHP — no framework, no Composer autoload beyond PHPWord; each page includes `transport backend/dbinfo.php` + `transport backend/lib/dboperation.php` + `transport backend/adminsession.php` (session guard)
- Frontend assets: Bootstrap, jQuery, jQuery UI, select2, chosen, fullcalendar (vendored in `transport backend/css/`, `transport backend/js/`)

**Testing:**
- Jest 29.6.3 with `@react-native/jest-preset` (`jest.config.js`, `jest.setup.js`); suites in `__tests__/` (`App.test.tsx`, `AuthScreen.test.js`, `TripsList.test.js`, `AddTrip.test.js`, `TripDetails.test.js`, `BusinessSetup.test.js`); SQL/PHP backend is untested

**Build/Dev (React Native app):**
- Metro bundler — `metro.config.js` (default `@react-native/metro-config`)
- Babel — `babel.config.js` (`@react-native/babel-preset` + `react-native-reanimated/plugin` LAST)
- `@react-native-community/cli` 20.2.0 — android/ios run scripts (`package.json`)
- ESLint 8 (`@react-native/eslint-config`, `.eslintrc.js`), Prettier 2.8.8 (`.prettierrc.js`: `singleQuote`, `avoid` arrow parens, trailing commas)
- Android: `android/build.gradle` — compileSdk 37, targetSdk 36, minSdk 24, buildTools 37.0.0, NDK 27.1.12297006, Kotlin 2.2.0, AGP via `com.android.tools.build:gradle` classpath
- iOS: `ios/Podfile` uses `min_ios_version_supported` from RN 0.87, `use_native_modules!`, optional `USE_FRAMEWORKS`

## Key Dependencies

**Critical (React Native app — `package.json`):**
- `axios` ^1.19.0 — HTTP client (`src/services/api/client.js`)
- `@gorhom/bottom-sheet` ^5.2.14 — bottom sheets (`App.js`, `src/features/quickActions/`)
- `react-native-reanimated` ^4.6.0 + `react-native-worklets` 0.12.1 — animations; Babel plugin must stay last (`babel.config.js`)
- `react-native-gesture-handler` ^3.2.1 — gestures (`App.js` wraps root)
- `lottie-react-native` ^7.4.0 — splash animations (`src/assets/animation`)
- `react-native-vector-icons` ^10.3.0 — MaterialCommunityIcons tab/base icons (`src/navigation/MainTabNavigator.js`)
- `react-native-safe-area-context` ^5.9.1, `react-native-screens` ^4.27.0

**Critical (PHP backend — `transport backend/composer.json` + vendored):**
- `phpoffice/phpword` ^1.3 (with `phpoffice/math` 0.2.0) — Word document generation (`transport backend/vendor/phpoffice/`)
- FPDF 1.7 + 1.84 — PDF generation, vendored at `transport backend/fpdf17/` and `transport backend/fpdf184/` (plus `transport backend/pdf/*.php` report scripts)
- GD extension — CAPTCHA image generation (`transport backend/captcha.php`)
- No PHP framework, no ORM — raw `mysqli` queries throughout

**Infrastructure:**
- MySQL — relational store (see INTEGRATIONS.md for connection details)
- PHP `curl` — SMS/WhatsApp gateway calls (`transport backend/getotp.php`, `transport backend/whatsapp.php`)

## Configuration

**Environment (app):**
- `src/config/env.js` — dev: `apiBaseUrl: 'http://10.0.2.2:3000/api'`, timeout 15000 ms; prod: empty `apiBaseUrl` (not yet set). Selected by `__DEV__`
- No `.env` / `.env.*` files present at repo root — environment lives in code, not env files
- `app.json` — app `name`/`displayName` = TransportApp; `android/app/build.gradle` — `applicationId "com.transportapp"`, versionCode 1, versionName "1.0"

**Environment (backend):**
- No config files; DB credentials are hardcoded inline in `transport backend/dbinfo.php` and `transport backend/mobile/API/config.php`
- `transport backend/mobile/API/config.php` additionally sets `memory_limit=512M`, `date_default_timezone_set("Asia/Kolkata")`
- SMS gateway keys hardcoded in `transport backend/lib/smsinfo.php`

**Build:**
- `babel.config.js`, `metro.config.js`, `jest.config.js`, `tsconfig.json`, `eslintrc.js`, `.prettierrc.js`, `.watchmanconfig`, `Gemfile`
- `transport backend/composer.json` — single require: `phpoffice/phpword`

## Platform Requirements

**Development:**
- Node >= 22.11.0 + npm; Xcode/CocoaPods for iOS (`bundle install`, `bundle exec pod install`); Android Studio with SDK 36/37, NDK 27.1
- PHP 7.1+ (8.x works) with `mysqli`, `gd`, `curl` extensions; MySQL server; Composer for PHPWord
- Watchman (`.watchmanconfig`)

**Production:**
- React Native: Apple App Store / Google Play (no CI/CD or hosting config in-repo — no `.github/`, no Docker, no deploy scripts detected)
- PHP backend: shared hosting–style LAMP setup assumed (db host is `localhost`, dumps + hardcoded creds imply cPanel-style hosting); not documented in-repo

---

*Stack analysis: 2026-08-30*