# External Integrations

**Analysis Date:** 2026-08-30

## APIs & External Services

**SMS / WhatsApp Gateway — Iconic Solution (`api.iconicsolution.co.in`):**
- Used for OTP delivery and sending PDF documents via WhatsApp. Endpoint: `http://api.iconicsolution.co.in/wapp/api/send` (POST form-encoded: `apikey`, `mobile`, `msg`; PDFs are base64-encoded and URL-encoded in the message body).
- Usage sites: `transport backend/getotp.php` (dispatch edit/delete OTP), `transport backend/whatsapp.php` (vehicle owner / pump / agent / consignee billing PDF), `transport backend/whatsappreport.php` (report PDFs), `transport backend/mobile/API/user_login.php`, `transport backend/mobile/API/resend_otp.php`, `transport backend/mobile/API/user_varification.php` (mobile app OTP login).
- Auth: API key hardcoded per call site (e.g. `transport backend/getotp.php`, `transport backend/mobile/API/user_login.php`). Keys are committed in source — rotate and move to env/config.
- Generated PDFs are read from local disk (`transport backend/whatsapp/*.pdf`) and uploaded inline; after send, `whatsappreport.php` unlinks the file.

**SMS Gateway — MSGClub (`msg.msgclub.net`):**
- Transactional SMS for the web admin app. Server URL, sender ID (`SJRAJA`), route ID, and AUTH_KEY are hardcoded in `transport backend/lib/smsinfo.php`.
- Actually invoked from `transport backend/lib/dboperation.php` (≈line 470) via `http://msg.msgclub.net/rest/services/sendSMS/sendGroupSms?AUTH_KEY=...` using `curl` — sends owner/driver notification SMS on record save.

**Google Fonts / jQuery CDN:**
- Web-frontend only (`transport backend/mobile/head.php`, `transport backend/mobile/inc/head.php`): Google Fonts (Nunito Sans, Poppins) and `https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js`. Not used by the React Native app.

## Data Storage

**Databases:**
- MySQL, accessed exclusively through the `mysqli` extension (procedural). No ORM, no query builder.
- Two independent DB connection entry points:
  - `transport backend/dbinfo.php` — global `$connection` for the web admin. Selects local dev DB (`guru`, root, no password) when `SERVER_NAME` is `localhost`/`ghanshyam`/`trinityhome`; otherwise the production DB (`chaarqvc_guruassociates`). Production credentials are hardcoded in this file (committed — treat as exposed).
  - `transport backend/mobile/API/config.php` — global `$con` for the mobile JSON API. Same production DB name, credentials hardcoded (committed). Also sets `memory_limit=512M` and `Asia/Kolkata` timezone.
- Schema backup: full DB dumps are committed at `transport backend/chaarqvc_guruassociates_backup_*.sql` and `transport backend/sjt_backup_*.sql`.
- Representative tables referenced in code: `m_vehicle_owner`, `m_driver`, `m_userlogin`, `m_vehicle`, `m_company`, `get_otp`, `dispatch_entry`, `m_session`, `m_consignee`, `m_agent`, `m_petrol_pump`.

**File Storage:**
- Local filesystem only. Report/PDF outputs: `transport backend/whatsapp/` (generated + sent via WhatsApp), `transport backend/pdf/` scripts. Uploads: `transport backend/upload/`, `transport backend/image/`, `transport backend/img/`, `transport backend/mobile/API/profile_img/`, `transport backend/mobile/API/receipt_img/`. Excel exports are streamed via HTTP headers, not stored (see `transport backend/excel/*.php`).
- No object storage (no S3/GCS), no CDN.

**Caching:**
- None. No Redis/Memcached. React Query (`src/services/api/queryClient.js`) is the only caching layer (app-side: `staleTime: 30000`, `retry: 1`).

## Authentication & Identity

**Web Admin (PHP):**
- Server-side PHP sessions, 12-hour lifetime (`transport backend/adminsession.php` sets `session.gc_maxlifetime`/`cookie_lifetime` to 43200). Login via `transport backend/loginotp.php` (username+password → OTP stored in `get_otp` table) or `transport backend/checklogin_admin.php`; protected pages include `adminsession.php`, which redirects to `index.php` when no `$_SESSION['user_id']`.

**Mobile JSON API (PHP):**
- Static shared token: every request must pass `token=GURU` — checked in `transport backend/mobile/API/top_file.php` (`if ($token == "GURU")`). Hardcoded, single credential for all users; no per-user bearer tokens.
- OTP login: 4-digit OTP via `rand(1000, 9999)` in `transport backend/mobile/API/user_login.php` (vehicle owners: `mobileno1`; drivers/agents in `user_varification.php`), delivered through the Iconic SMS API, stored in the `get_otp` table, verified by `transport backend/mobile/API/user_varification.php` / `match_otp.php`.
- CAPTCHA for admin login: GD-generated image in `transport backend/captcha.php`, code in `$_SESSION["code"]`.

**React Native App:**
- Not connected yet. `src/features/auth/auth.api.js` is an intentional placeholder ("Deliberately no endpoint... defined here yet"). `src/services/storage/authStorage.js` is volatile in-memory only (no AsyncStorage/Keychain). `src/store/authStore.js` carries a temporary `completeMockAuthentication(mockSession)` UI-testing path.
- The axios client (`src/services/api/client.js`) is pre-wired to attach `Authorization: Bearer <session.accessToken>` from `authStorage` — the token contract is anticipated but not yet produced by any backend.

## Monitoring & Observability

**Error Tracking:**
- None (no Sentry/Bugsnag). The app normalizes axios failures into typed errors (`src/services/api/errors.js`) for UI display only.

**Logs:**
- PHP: raw `error_log` files committed in the repo (`transport backend/error_log`, `transport backend/ajax/error_log`, `transport backend/mobile/API/error_log`). No structured logging.
- App: no logging framework; React Query retries (1) and timeout (15 s via `src/config/env.js`) are the app-side amplification limits.
- OTP responses are sometimes echoed/printed (e.g. `getotp.php` `var_dump($result)`) — debug output shipped to production code paths.

## CI/CD & Deployment

**Hosting:**
- Not documented in-repo. PHP backend connection settings (`localhost`, `chaarqvc_guruassociates` DB, committed SQL dumps) indicate cPanel-style shared hosting. React Native app targets Android/iOS stores (`applicationId com.transportapp` in `android/app/build.gradle`).

**CI Pipeline:**
- None detected. No `.github/`/`.gitlab-ci.yml`/Jenkins/Docker files. `npm test` / `npm run lint` are local-only.

## Environment Configuration

**Required env vars:**
- None — the project does not use environment variables. All configuration is hardcoded in source:
  - DB: `transport backend/dbinfo.php`, `transport backend/mobile/API/config.php`
  - SMS keys: `transport backend/lib/smsinfo.php`, `transport backend/getotp.php`, `transport backend/mobile/API/user_login.php`
  - App API base URL: `src/config/env.js` (dev `http://10.0.2.2:3000/api`, prod empty)
- No `.env` / `.env.*` files exist in the repo (existence check only; contents not inspected).

**Secrets location:**
- Committed in PHP source files (DB passwords, SMS/WhatsApp API keys, and the static `GURU` token). This is a security exposure — see CONCERNS.md scope; immediate action: move to server-side env config and rotate all committed keys.

## Webhooks & Callbacks

**Incoming:**
- None. No webhook receivers, no OAuth callback endpoints.

**Outgoing:**
- Iconic Solution WhatsApp/SMS API (`http://api.iconicsolution.co.in/wapp/api/send`) — synchronous `curl` POSTs from `transport backend/getotp.php`, `transport backend/whatsapp.php`, `transport backend/whatsappreport.php`, `transport backend/mobile/API/user_login.php`, `transport backend/mobile/API/resend_otp.php`, `transport backend/mobile/API/user_varification.php`.

## App ↔ Backend Contract (Current State)

**Configured API base:** `http://10.0.2.2:3000/api` (dev, Android emulator loopback; `src/config/env.js`) — a server on the host's port 3000 is expected but **not present in this repo**.

**Two divergent endpoint shapes are referenced by app code:**

1. **PHP JSON endpoints (working shape):**
   - `src/features/trucks/trucks.api.js` → `GET {base}/dispatch_report.php` with `token=GURU`, `tag=m_vehicle`, `user_id`, `user_type`; expects `{success, data: [...]}` and maps `m_vehicle` rows to the truck model. Falls back to `src/features/trucks/trucks.mock.js` data when the request fails ("Backend not running or offline").
   - The corresponding PHP file is `transport backend/mobile/API/dispatch_report.php` (same mobile-API family as `user_login.php`/`resend_otp.php`).
2. **REST endpoint shape (placeholder, unimplemented):**
   - `src/features/trips/trips.api.js` → `GET|POST /api/trips`, `PUT /api/trips/:id`, `POST /api/trips/:id/status|advance|expenses|loads|driver-balance`. File comment: "Backend: PHP + Laravel + SQL REST API ... conceptual backend-contract placeholders until the production Laravel API specification is shared." No Laravel app or `/api/trips` route exists in this repo.
   - `src/features/parties/parties.api.js` — empty (0 lines).

**Integration consequence:** the mobile app currently ships mock-first (in-memory fallbacks in `trucks.api.js`/`trips.api.js`/`trucks.mock.js`/`trips.mock.js`/`parties.mock.js`), with one real-world PHP endpoint prototyped (`dispatch_report.php`) and the auth contract still undefined.

---

*Integration audit: 2026-08-30*