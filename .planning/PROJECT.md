# TransportApp

## What This Is

A premium Android application (React Native / JavaScript) for transportation businesses that lets fleet owners and their staff run daily operations — trips/biltys, trucks, drivers, parties, suppliers, expenses, khata/ledger and reports — from the phone. The app is the mobile client of an existing PHP/MySQL transportation ERP ("transport backend"): a shared JSON API touches the same database the web panel uses. It is a multi-tenant product: each transport business is its own tenant with role-based staff login (owner, driver, petrol-pump operator, employee/admin).

## Core Value

Every trip must be creatable, trackable and settled end-to-end from the phone against real backend data — if the trip lifecycle breaks or silently falls back to mock data, the product fails.

## Business Context

- **Customer**: Fleet owners and transport businesses (transporter, fleet owner, transport contractor, commission agent)
- **Revenue model**: Premium subscription (per TransportBook/LOADSHARE reference model; TBD with product owner)
- **Success metric**: Trips recorded + settled through the app against the backend, not lost on reload
- **Strategy notes**: Functional reference is TransportBook by LOADSHARE (reference only — no copied source/branding)

## Requirements

### Validated

Dashboard/readside of the backend is proven:

- ✓ Android app shell: 5-tab navigation (Home, Trips, Add, Khata, More), theme system, shared components — existing
- ✓ Auth onboarding UI (splash → welcome → login/signup → business setup) — existing, mock-backed
- ✓ Parties list + add form UI with GST/PAN/phone/pincode validation — existing, mock-backed
- ✓ Trips list/create/details/status-stepper/advances UI — existing, mock-backed
- ✓ Dashboard home + quick-action sheet (New Trip / Add Party live) — existing
- ✓ Trucks data layer (api/mock/hooks/zod validation) — existing, unwired
- ✓ PHP transport ERP backend: 77-table MySQL schema covering fleet, dispatch, diesel, billing, ledger (`transport backend/`) — existing
- ✓ Mobile JSON API (`.php?tag=…&token=GURU`) with a stable envelope `{success,tag,msg,data,data1,status,response}` for reads/receipts (`transport backend/mobile/API/`) — existing
- ✓ Backend computation core `lib/dboperation.php` + `lib/getval.php` (`class Comman`): CRUD, numbering, billing/balance math — existing
- ✓ Jest test setup for the React Native app — existing

### Active

- [ ] **AUTH-01**: Owner, driver, petrol-pump operator, and employee/admin can all log in securely (OTP and/or password) against the backend
- [ ] **AUTH-02**: Every session resolves the tenant (comp_id/session_id/consignorid) and user role; all data access is role-and-tenant-scoped
- [ ] **AUTH-03**: New businesses self-serve tenant creation from the app (business setup → company + consignor + owner login)
- [ ] **TRIP-01**: User can create a trip/bilty from the app (party, truck, driver, origin/destination, billing type, freight per backend rules)
- [ ] **TRIP-02**: User can record advances (cash, diesel, consignor/consignee) on a trip
- [ ] **TRIP-03**: Driver/pump can record receiving + unload + POD photo against a trip
- [ ] **TRIP-04**: Trip list/details read live backend trips (bilty_no, freight, status) with search/filter
- [ ] **TRK-01**: User can add, edit and list trucks (m_vehicle) from the app
- [ ] **TRK-02**: User can view/add vehicle documents (truck_doc taxonomy) with expiry status
- [ ] **TRK-03**: User can record maintenance/service entries and see fleet stats per truck
- [ ] **PARTY-01**: User can add, edit and list parties (consignor/consignee) from the app
- [ ] **PARTY-02**: User can view party balances and ledger/transactions
- [ ] **DATA-01**: All modules consume the backend through an adapter layer (no mock fallbacks in production) using the shared API envelope
- [ ] **DATA-02**: Local PHP backend + MySQL copy runs for development and automated verification
- [ ] Remaining PRD modules (drivers, suppliers, expenses/payments, khata, documents, reports) delivered in later phases

### Out of Scope

- Web (React) client — deferred; same backend/API later
- Inventory / sale / purchase / payroll ERP modules — not part of the transport PRD
- PDF/Excel/WhatsApp report generation from the app — backend web/print only for now
- Notification (push) and full offline sync — deferred
- Copying TransportBook/LOADSHARE source, branding, or protected assets — prohibited

## Context

Brownfield: an existing React Native scaffold and an existing PHP/MySQL ERP both live in this repo. The app is UI-first and 100% mock-driven today — every module falls back to in-memory data on reload; `apiBaseUrl` is unset in production; session storage is volatile; the only real HTTP attempt (trucks) uses hardcoded `token=GURU&user_id=1`. The backend's mobile API is read-heavy (report/list tags), with write endpoints only for receiving, diesel ack, slip no, profile image, and yard registration. The freight-slab / GST / TDS business rules currently live as client-side JavaScript in the ERP's `function/*.php` files and must move server-side. The mobile API auth is a shared static `GURU` token with no per-user tenancy; OTP login works only for owners. `transport backend/` mixes web presentation with real backend logic (`lib/`, `ajax*/save_*`, `mobile/API`) — an app integration should target the logiconly, ignoring the HTML admin UI.

## Constraints

- **Tech stack**: React Native CLI + JavaScript (existing app) — no framework migration; backend stays procedural PHP + mysqli on the existing 77-table schema
- **Compatibility**: App speaks the existing `mobile/API` JSON envelope (`token`,`tag`, `data`/`data1`, `footer.php`); new endpoints must mirror its patterns and the web `ajax*/save_*` handler logic, plus the `lib/getval.php` numbering/tax conventions
- **Tenancy**: Every write must stamp `comp_id`, `session_id`, `consignorid`, `user_id` — the DB enforces no FK constraints, so the application layer owns integrity
- **Security debt**: DB credentials are committed/embedded and passwords plaintext — a hardening pass is a prerequisite, not an option
- **Reuse**: keep existing app screens and rewire their data layer through an adapter; do not rebuild working UI
- **Dev environment**: PHP + a local MySQL copy must run for development/verification, mirroring the prod DB name/schema

## Key Decisions

| Decision | Rationale | Outcome |
|----------|-----------|---------|
| Android app + PHP backend only for now | Web client is future direction; shared backend/DB | — Pending |
| Multi-tenant; tenant = company + consignor + session | Backend tenancy spine is `consignorid`/`comp_id`/`session_id`; each business isolated | — Pending |
| Tenants self-serve setup in-app | Product model is subscription SaaS; business setup is an existing onboarding step | — Pending |
| All 4 roles log in (owner/driver/pump/employee) | Backend already models these actors; each sees a role-scoped slice | — Pending |
| Trips full lifecycle from the app (create/advance/receive+POD/settle) | Core value is end-to-end trip management; requires new backend write endpoints | — Pending |
| Trucks + parties: smartphone CRUD with linked records | "Full functionality" per user; docs/maintenance and ledgers are the differentiating records | — Pending |
| Reuse existing screens, rewire through an adapter | Avoids rebuilding working UI; mock models bridge to backend fields via mapping | — Pending |
| Freight/billing business rules move server-side | Rules currently live in ERP client-side JS; must be authoritative on the API | — Pending |
| Local dev backend for build/verify | Safe iteration + automated verification without touching prod data | — Pending |

## Evolution

This document evolves at phase transitions and milestone boundaries.

**After each phase transition** (via `/gsd-transition`):
1. Requirements invalidated? → Move to Out of Scope with reason
2. Requirements validated? → Move to Validated with phase reference
3. New requirements emerged? → Add to Active
4. Decisions to log? → Add to Key Decisions
5. "What This Is" still accurate? → Update if drifted

**After each milestone** (via `/gsd-complete-milestone`):
1. Full review of all sections
2. Core Value check — still the right priority?
3. Audit Out of Scope — reasons still valid?
4. Update Context with current state

---
*Last updated: 2026-08-30 after initialization*