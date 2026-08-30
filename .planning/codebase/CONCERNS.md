# Codebase Concerns

**Analysis Date:** 2026-08-30

This repo contains TWO sub-projects with very different maturity levels:
1. **React Native app** (root: `App.js`, `src/`, `package.json`) — a modern RN 0.87 app, early-stage, largely mock-driven.
2. **PHP backend** (`transport backend/`) — a ~578-file legacy PHP monolith (transport/GST/ledger ERP) with severe security and maintenance problems.

The overwhelming majority of critical concerns live in the PHP monolith. Analysis below covers both, ordered by severity.

## Security Considerations

### CRITICAL: Plaintext database credentials hardcoded and committed to git

**Risk:** Full production DB access for anyone with repo access.
**Files:**
- `transport backend/mobile/API/config.php` — hardcoded `$db_user`/`$db_pwd` for `chaarqvc_guruassociates` DB.
- `transport backend/dbinfo.php` — same production credentials duplicated.
- `transport backend/dbbackup.php` — production credentials again, plus dumps the whole DB to the browser.
**Current mitigation:** None. Credentials are committed in source.
**Recommendations:** Move credentials to environment variables / a git-ignored config file. Rotate the current DB password (it is exposed in at least 3 committed files). Same for the harsher risk below.

### CRITICAL: Hardcoded third-party API keys committed to git

**Risk:** Abuse of paid SMS/WhatsApp API accounts leading to cost/abuse, plus direct wallet drain.
**Files:** Multiple SMS API keys and sender credentials are hardcoded:
- `transport backend/mobile/API/user_login.php` (line 29, `apikey=fc86f138...`)
- `transport backend/getotp.php` (line 13, `apikey=0ac19e01...`)
- `transport backend/whatsapp.php` (line with `apikey=0ac19e01...`)
- `transport backend/whatsappreport.php`
- `transport backend/mobile/API/user_registration.php`
- `transport backend/mobile/API/resend_otp.php`
- `transport backend/mobile/API/user_varification.php`
- `transport backend/lib/smsinfo.php`
- `transport backend/lib/dboperation.php` (`sendsms()`/`sendsmsGET()` receive credentials as parameters from callers that pass hardcoded values)
**Current mitigation:** None.
**Recommendations:** Move all keys to server environment variables or a secrets store. Rotate all currently-exposed keys.

### CRITICAL: Massive SQL injection surface (no prepared statements)

**Risk:** Full database compromise via crafted input — virtually every endpoint. Direct user input is interpolated into SQL strings.
**Files:** Nearly every PHP file. Representative examples:
- `transport backend/mobile/API/user_login.php` — `"select * from m_vehicle_owner where mobileno1='$mobile'"`, `"UPDATE get_otp ... WHERE mobile = '$mobile'"`, `"update user set mobile='$mobile',password='$password' where userid='$userid'"`.
- `transport backend/mobile/API/user_varification.php` — `"SELECT * FROM m_driver WHERE mobile_no = '$mobile'"` and 3 more interpolated queries.
- `transport backend/check_login.php`, `transport backend/loginotp.php` — `"...where user_name='$user_name' && password='$password'"`.
- `transport backend/lib/dboperation.php` — helper functions `dbRowInsert`, `dbRowUpdate`, `dbRowDelete`, `SelectDB`, `selectsimple`, `getvalfield` all build queries via string interpolation.
- `transport backend/save_document.php`, `transport backend/whatsapp.php`, `transport backend/save_receipt.php` (mobile API).
**Root cause:** The only "defense" is `test_input()` in `transport backend/lib/dboperation.php`, which uses `addslashes()` + `htmlspecialchars()` — neither is an adequate SQL-injection defense (character-set bypasses), and it is not consistently applied. There is a helper named `quote()` (line 377) that calls the **removed** `mysql_real_escape_string()` function, which does not even exist in modern PHP (would fatal if called).
**Current mitigation:** Inconsistent, ineffective `addslashes`/`htmlspecialchars` in a minority of files.
**Recommendations:** Convert all queries to **prepared statements** (mysqli prepared / PDO). This is a large, mechanical but high-value refactor; prioritize the mobile API and auth/update endpoints first.

### CRITICAL: Plaintext password storage and comparison

**Risk:** Credentials compromise; passwords recoverable from DB dumps (which are committed to git — see below).
**Files:**
- `transport backend/check_login.php` — `"...where user_name='$user_name' && password='$password'"` (plaintext compare).
- `transport backend/loginotp.php` — same plaintext compare.
- `transport backend/mobile/API/user_login.php` — usertypes 2/3/4 compare `password='$password'` in plaintext.
- `transport backend/mobile/API/user_login.php` (update_profile) — writes `password='$password'` directly to DB, plaintext.
- `transport backend/mobile/API/user_registration.php` — registers passwords (need to verify hashing; by default appears plaintext).
- **No uses of `password_hash()`/`password_verify()` exist** — the only `encrypt()`/`decrypt()` matches are a custom XOR-style cipher (see below), not password hashing.
**Current mitigation:** None.
**Recommendations:** Hash with `password_hash()`/`password_verify()`. Never store plaintext passwords. Remove exposing `$_SESSION['password']` (set in `transport backend/loginotp.php` line 32).

### CRITICAL: Weak custom encryption function (obfuscation, not security)

**Risk:** Any data "encrypted" with this is trivially reversible and insecure; gives false sense of security.
**Files:**
- `transport backend/lib/dboperation.php` (lines 10–36) — `encrypt()`/`decrypt()` implement a Vigenère-style XOR with a repeating key then `base64_encode`. This is cryptographically broken.
- Same function duplicated in `transport backend/lib/getval.php` (line 733) and `transport backend/lib/getval2.php` (line 459) — triplication.
**Current mitigation:** None.
**Recommendations:** If encryption of data-at-rest is actually needed, replace with a vetted library (e.g., `openssl_encrypt` with random IV, or sodium). If it's just obfuscation, remove it.

### HIGH: Hardcoded master OTP — all OTPs share a single global row

**Risk:** OTP is effectively **global and shared** across the entire system, stored in a single-row table. Any user's OTP is valid for any other user's login/action; refresh for one user invalidates all.
**Files:**
- OTP stored in single row `get_otp` `id='1'`: `transport backend/loginotp.php` (line 28), `transport backend/check_login.php` (line 15), `transport backend/match_otp.php` (line 5), `transport backend/getotp.php` `"update get_otp set otpcode='$otpcode'"` (no WHERE — updates whole table).
- The mobile API `/API/user_login.php` similarly does `UPDATE get_otp SET mobile_otp = '$otp' WHERE mobile = '$mobile'` but the mobile API has its own separate OTP columns/rows.
**Current mitigation:** None. The OTP is also **predictable** (`rand(1000,9999)` / `mt_rand(1000,9999)` — only 9000 possible values, no expiry, no attempt limiting).
**Recommendations:** Issue per-user, per-session OTPs with expiry and attempt throttling. Use CSPRNG (`random_int`).

### HIGH: OTP code exposed directly to end user / debug echo

**Risk:** Attacker can bypass verification.
**Files:**
- `transport backend/show_otp.php` — a page that prints the current OTP directly to the browser with a "Refresh For New OTP" button. Guarded only by session, but OTPs meant as a second factor are being shown in plaintext on a screen.
- `transport backend/getotp.php` — ends with `echo $otpcode;` (line output after curl), leaking the OTP in the HTTP response.
- `transport backend/mobile/API/user_login.php` line 16 — `echo "select * from m_vehicle_owner where mobileno1='$mobile'";` dumps the SQL to the client (info disclosure).
**Current mitigation:** None.
**Recommendations:** Remove debug `echo`s. Never render OTPs to the browser in production.

### HIGH: Auth is a shared static token `"GURU"` with no session

**Risk:** The entire mobile API authenticates via a **single shared static token** (`$token == "GURU"`) passed as a request param. Anyone knowing "GURU" (it is in the source, committed to git) can call every mobile endpoint as any user — no per-user auth, no session.
**Files:**
- `transport backend/mobile/API/config.php` (source of token) → used by every mobile/API endpoint via `top_file.php`, e.g. `transport backend/mobile/API/user_login.php`, `user_varification.php`, `save_receipt.php`, `mobile/ajax/get*.php`.
- Token checked at `transport backend/mobile/API/top_file.php` / per-file `if ($token == "GURU")`.
**Current mitigation:** Secret-by-obscurity static string, committed to source.
**Recommendations:** Replace with per-user token/session auth (e.g., signed tokens, bearer, token tied to the user). The RN app's `apiClient` already sends a `Bearer` token (`src/services/api/client.js`) — the backend must validate it.

### HIGH: Arbitrary local file read (LFI) in whatsapp.php

**Risk:** Path/ID-based arbitrary file read.
**Files:**
- `transport backend/whatsapp.php` — `$photopath = 'whatsapp/'.$billid.'.pdf'; ... file_get_contents($photopath);` where `$billid = $_REQUEST['billid']` is unsanitized. `../` traversal could read arbitrary files on the server.
**Current mitigation:** None.
**Recommendations:** Validate/whitelist `$billid` to an integer before building the file path; restrict to the intended directory.

### MEDIUM: Arbitrary file upload in web-root directories

**Risk:** If an attacker can register or reach these, uploaded files are written into web-accessible directories.
**Files:**
- `transport backend/mobile/API/save_receipt.php` — uploads to `./receipt_img/` inside the API dir (web-accessible).
- `transport backend/save_document.php` — uploads to `upload/doc_upload/`.
- `transport backend/mobile/API/user_registration.php` / `edit_profile.php` — profile images to `profile_img/`.
- Extensions are checked (jpg/jpeg/png) for receipts, which reduces risk, but content is not validated and the files are publicly reachable.
**Current mitigation:** Extension whitelist in some, not all, upload paths.
**Recommendations:** Validate file MIME/content (not just extension), store outside the web root, serve via a controlled endpoint, and scan/limit sizes.

### MEDIUM: Sensitive artifacts COMMITTED to git

**Risk:** Full database dumps + error logs containing query parameters/values are in version control.
**Files (all tracked in git):**
- `transport backend/chaarqvc_guruassociates_backup_*.sql` — 6 files, each ~7.5 MB **full database dumps**, including user tables, likely password hashes/plaintext, PII, financial data.
- `transport backend/sjt_backup_*.sql` — additional dumps.
- `transport backend/error_log`, `transport backend/mobile/API/error_log` (2 MB), `transport backend/mobile/ajax/error_log` (155 KB), plus `transport backend/ajax*/error_log` and `excel/error_log` — PHP error logs committed to git; may contain SQL query strings with user data.
**Current mitigation:** None; `.gitignore` (root) does not cover SQL dumps or error_log.
**Recommendations:** Add `*.sql`, `error_log`, and `vendor/` to `.gitignore`. Purge these from git history. Stop committing server error logs.

## Tech Debt

**[Legacy PHP monolith / no structure]:**
- Issue: The `transport backend/` is a flat, ~578-file PHP 5-era monolith. Logic is inline in pages (e.g., `transport backend/dashboard.php` is 2792 lines, 106 KB; `transport backend/billing.php` 1317 lines; `transport backend/dispatch-process.php` 1533 lines; `transport backend/x_party_entry.php` 1001 lines). No framework, no router, no ORM, no templating layer.
- Files: `transport backend/dashboard.php`, `billing.php`, `dispatch-process.php`, `x_party_entry.php`, `return.php` (65 KB), `payment-process.php` (52 KB).
- Impact: Extremely hard to maintain, test, or reason about; changes risk breaking unrelated features.
- Fix approach: Incrementally extract shared query helpers and business logic; migrate to prepared-statement wrapper functions; eventually PDO.

**[Deprecated/removed PHP functions still used]:**
- Issue: `mysql_connect`, `mysql_select_db`, `mysql_free_result` (removed in PHP 7.0) in `transport backend/lib/dboperation.php` (`dbInfo()`, `database_select()` lines ~236, ~576) and `quote()` calls `mysql_real_escape_string`. These will fatal on PHP 7+. The mobile `top_file.php` re-implements `getvalfield` with a redundant first query.
- Files: `transport backend/lib/dboperation.php`.
- Impact: Fatal errors on modern PHP; these code paths effectively dead/breaking.
- Fix approach: Remove/port to mysqli; replace `quote()` with `mysqli_real_escape_string($connection, ...)`.

**[Duplicated code across files]:**
- Issue: The same helper functions are redefined in multiple files — e.g., `getvalfield`/`dateformatindia` in `transport backend/lib/getval.php`, `lib/getval2.php`, `lib/dboperation.php`, and `mobile/API/top_file.php`; `encrypt`/`decrypt` in three files; `dateformat` variants repeated.
- Files: `transport backend/lib/*.php`, `transport backend/mobile/API/top_file.php`.
- Impact: Drift between copies, bug fixes applied in only one place.
- Fix approach: Centralize into a single included utility/autoloaded module.

**[Stub/empty production files]:**
- Issue: `transport backend/approval_report.php` is 0 bytes; `transport backend/test.php` and `testing3.php` are leftover dev/test pages still present in the product tree.
- Files: `transport backend/approval_report.php`, `test.php`, `testing3.php`.
- Impact: Publicly reachable test pages; dead endpoints.
- Fix approach: Delete or complete; disable/remove test pages in production.

**[Duplicate PDF libraries shipped]:**
- Issue: Two FPDF versions (`fpdf17/` and `fpdf184/`) plus rendered PDFs committed under `pdf/` (61 files) and `temp/` (85 files).
- Files: `transport backend/fpdf17/`, `fpdf184/`, `pdf/`, `temp/`.
- Impact: Maintenance confusion; generated artifacts bloating repo.
- Fix approach: Keep one FPDF version; treat generated PDFs as build artifacts not source.

## Known Bugs

**[DB helper uses undefined `$connection` global]:**
- Symptoms: Helper functions like `dbRowSelect`, `selectsimple`, `getvalfield` reference a global `$connection` that is not declared `global` inside the functions, so `$connection` is undefined at call time in the function scope → queries fail (unless `$connection` happens to be in scope via other means).
- Files: `transport backend/lib/dboperation.php` (e.g., lines 46, 99, 246, 353, 388).
- Trigger: Calling these helpers from a file that doesn't have `$connection` imported into function scope.
- Workaround: Files that fail typically define their own inline queries or include globals-permissively.
- Note: This is likely why many pages write raw `mysqli_query` inline instead of using the helpers.

**[Global OTP table causes cross-user interference]:**
- Symptoms: `update get_otp set otpcode='$otpcode'` (no WHERE) in `transport backend/getotp.php` clobbers the single OTP row; a new OTP generated for one operation invalidates another.
- Files: `transport backend/getotp.php`, `loginotp.php`, `check_login.php`, `match_otp.php`.
- Trigger: Concurrent OTP-dependent operations (edit + delete) race on the same row.
- Workaround: None.

**[Mobile `user_login.php` usertype!=1 branches use unset `$user_name`/`$password`]:**
- Symptoms: For `usertype` 2/3/4, the code queries `password='$password'` and `mobile_no='$user_name'` but never sets `$user_name`/`$password` from `$_REQUEST` (only `$mobile` is read). Result: these login branches compare against undefined (empty) values and effectively fail or match wrong rows.
- Files: `transport backend/mobile/API/user_login.php` (lines 46–84).
- Trigger: Login attempts with usertype 2, 3, or 4.
- Workaround: Known-broken login path for drivers/pumps/employees through this endpoint.

## Fragile Areas

**[OTP + login flow]:** `transport backend/check_login.php`, `loginotp.php`, `match_otp.php`, `mobile/API/user_login.php`, `user_varification.php` — globals + shared OTP row + plaintext compare. Any change risks breaking auth. Test coverage: none.

**[Financial/ledger processing]:** `transport backend/payment-process.php` (52 KB), `dispatch-process.php` (66 KB), `billing.php` (56 KB), `gstpaypdf*.php`, `pdf_voucher_*.php` — large inline logic with heavy interdependence on DB schema and `compid`/`session_id`/`consignor_id` filters. Safe modification requires careful regression testing. Coverage: none for the PHP side.

**[Mobile API get* report endpoints]:** `transport backend/mobile/ajax/get*.php` (25 files) and `mobile/API/*.php` — heavy SQL duplication, shared `GURU` token, no abstraction. Adding a new report means copying an entire file and editing queries (structural duplication).

## Performance Bottlenecks

**[Dashboard monolith page]:** `transport backend/dashboard.php` — 2792 lines, 106 KB, performs many chained queries per request, no pagination/caching.
- Files: `transport backend/dashboard.php`.
- Cause: Everything in one page; expensive aggregations inline; no query caching.
- Improvement path: Decompose into focused endpoints; index hot queries; cache aggregate/summary data.

**[`lib/getval.php` / `getval2.php` reused helpers]:** Each `getvalfield` call executes a fresh query; high-traffic pages invoke them repeatedly in loops.
- Files: `transport backend/lib/getval.php`, `lib/getval2.php`.
- Cause: N+1 query pattern.
- Improvement path: Batch queries / joins; add caching.

**[DB dumps in web root]:** `transport backend/dbbackup.php` streams a full mysqldump-style export through PHP on demand with no auth beyond session — heavy and, if triggered, resource-intensive.
- Files: `transport backend/dbbackup.php`.

## Missing Critical Features

**[No prepared statements / parameterized queries anywhere]:** The single most important modernization. Blocks safe public exposure of the backend.
- Problem: Every query is string-interpolated; porting to prepared statements is a large mechanical effort.
- Blocks: Safe auth, public API hardening, PCI/security auditing.

**[No authentication/session model for the RN mobile API]:** Static `"GURU"` token only.
- Problem: Cannot enforce per-user authorization, rate limiting, or audit.
- Blocks: Real per-driver/pump/owner identity in the RN app.

**[No input validation framework / CAPTCHA]:** Despite `captcha.php` existing, auth flows (OTP, login) lack robust rate limiting and attempt throttling.

## Test Coverage Gaps

**[React Native app — auth & API untested]:**
- What's not tested: `src/store/authStore.js`, `src/services/api/client.js`, `src/services/api/errors.js`, `src/services/storage/authStorage.js`, `src/features/auth/auth.api.js`, all `useMock*.js` hooks. Existing tests are UI smoke tests only: `__tests__/AuthScreen.test.js`, `BusinessSetup.test.js`, `TripsList.test.js`, `TripDetails.test.js`, `AddTrip.test.js`.
- Files: see above; tests in `__tests__/`.
- Risk: Auth/API/state logic (the most business-critical RN code) is untested.
- Priority: High.

**[PHP backend — zero automated tests]:**
- What's not tested: The entire `transport backend/` monolith has no test suite, no test framework configured.
- Files: all `transport backend/**/*.php`.
- Risk: Financial/ledger logic and auth have no regression protection.
- Priority: High.

**[RN app depends on a non-existent backend]:**
- What's not tested / not possible: `src/config/env.js` sets `apiBaseUrl: 'http://10.0.2.2:3000/api'` (dev) and `''` (production); the production base URL is empty. The `auth.api.js` boundary has no endpoint defined ("backend contract is unavailable"). Auth is entirely mock (`src/features/auth/auth.mock.js`).
- Files: `src/config/env.js`, `src/features/auth/auth.api.js`, `auth.mock.js`.
- Risk: The app currently authenticates against mocks; real API shape/token/onboarding contract is unbuilt, so the RN app cannot talk to the PHP backend as-is.
- Priority: High — this reflects an integration gap between the two sub-projects.

## Dependencies at Risk

**[Composer vendor committed to git]:**
- Risk: `transport backend/vendor/` (Composer deps) is tracked in git.
- Files: `transport backend/vendor/autoload.php`, `vendor/composer/*`.
- Impact: Bloat and inconsistency; Composer-managed files should be git-ignored and installed from `composer.lock`.
- Migration: Add `transport backend/vendor/` to `.gitignore`; stop tracking.

**[PHPWord pinned `^1.3`]:** Only dependency in `transport backend/composer.json`; fine, but the project generally runs on legacy PHP so package compatibility with the target PHP version should be verified.

## React Native App — Additional Concerns

**[Mock-driven authentication in production path]:**
- Issue: `src/features/auth/auth.mock.js` and `src/store/authStore.js` provide mock sessions; comments mark them as temporary pending a backend contract. Shipping with mocks means no real authentication.
- Files: `src/features/auth/auth.mock.js`, `auth.api.js`, `useMockLogin.js`, `useMockOtpVerification.js`, `useMockSignup.js`, `useMockLoginRequest.js`, `useMockOtpVerification.js`, `src/store/authStore.js`.
- Impact: No real user verification; production `apiBaseUrl` empty.
- Fix approach: Implement the real API contract once the PHP backend auth contract is defined; wire `apiClient` bearer flow.

**[Empty directories / stubbed layers]:**
- Issue: Several structural directories are empty stubs: `src/hooks/` (empty), `src/types/` (empty), `src/utils/` (empty).
- Files: `src/hooks/`, `src/types/`, `src/utils/`.
- Impact: Indicates incomplete scaffolding; types dir empty means no centralized TS types.

**[API client targets an unused local port for dev]:** `apiBaseUrl: 'http://10.0.2.2:3000/api'` — the RN app's backend contract and the PHP backend are not connected; port 3000 hosts no matching service.
- Files: `src/config/env.js`.

## Scaling Limits

**[Global OTP table]:** Single-row `get_otp` table cannot scale to per-user OTPs; functionally one user at a time.
- Current capacity: One shared OTP for the whole app.
- Limit: Concurrent users break each other.
- Scaling path: Per-user OTP table keyed by mobile/user id with expiry.

**[Session cookie lifetime 12h, no regenerate]:** `transport backend/adminsession.php` sets `$timeout = 43200` (12h) with `ini_set("session.cookie_lifetime",...)`, `session_set_cookie_params`. No `session_regenerate_id()` on login → session fixation risk.
- Files: `transport backend/adminsession.php`, `check_login.php`.

---

*Concerns audit: 2026-08-30*
