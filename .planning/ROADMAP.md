# Roadmap: TransportApp

## Overview

TransportApp v1 turns the existing mock-driven React Native Android app into the mobile client of the existing PHP/MySQL transport ERP. The journey starts with the integration and data foundation — authentication with role- and tenant-scoped sessions against the real backend, a shared API adapter over the existing JSON envelope, server-side freight/GST/TDS rules, and a local PHP + MySQL dev backend — because every module consumes it. From there, vertical slices ship in dependency order: the end-to-end trip lifecycle (the core value), master data (trucks, parties, drivers), financials (suppliers, expenses & payments, khata), and finally documents & reports. Each phase delivers an observable, backend-backed capability; no production module ever falls back to mock data.

## Phases

**Phase Numbering:**
- Integer phases (1, 2, 3): Planned milestone work
- Decimal phases (2.1, 2.2): Urgent insertions (marked with INSERTED)

Decimal phases appear between their surrounding integers in numeric order.

- [ ] **Phase 1: Integration & Data Foundation** - Auth/tenancy for all 4 roles, self-serve tenant creation, shared API adapter, server-side rules, local dev backend
- [ ] **Phase 2: Trip Lifecycle** - Create, track, advance, receive/POD, and settle trips end-to-end from the phone against backend data
- [ ] **Phase 3: Master Data** - Trucks, parties, and drivers CRUD with documents, maintenance, balances, and ledgers
- [ ] **Phase 4: Financials** - Suppliers, expenses & payments (incl. diesel slip/ack), and khata ledgers
- [ ] **Phase 5: Documents & Reports** - View/upload/share documents; revenue, P&L, profitability, and outstanding reports

## Phase Details

### Phase 1: Integration & Data Foundation
**Goal**: Users authenticate with role- and tenant-scoped sessions against the real backend, every module reads/writes through one shared adapter using the existing JSON envelope, and a local dev backend supports build and verification.
**Mode**: mvp
**Depends on**: Nothing (first phase)
**Requirements**: AUTH-01..07, DATA-01..06
**Success Criteria** (what must be TRUE):
  1. Owner logs in with mobile + OTP; driver, petrol-pump operator, and employee log in with OTP + password. Every login resolves a tenant session (comp_id, session_id, consignorid, user_id, role) that persists across app restarts and is sent with every API call.
  2. Owner creates a new business from the business-setup flow (company + consignor + owner account = a new self-served tenant) and immediately signs into the new tenant.
  3. User logs out and the session ends server-side; when a token expires or is revoked, re-authentication restores the session without losing local state.
  4. All modules consume the real backend through the shared adapter (no mock fallbacks in production); the API client handles loading, empty, error, and offline-aware states; the backend enforces role- and tenant-scoped data and new endpoints are tenant-/role-scoped, parameterized, and follow existing mobile/API + lib/ + ajax*/save_* patterns.
  5. A local PHP backend + MySQL copy of the schema runs for development and automated verification; freight/GST/TDS rules execute server-side, not in client-side ERP JS; no DB credentials or secrets are shipped in the app.
**Plans**: TBD
**UI hint**: yes

### Phase 2: Trip Lifecycle
**Goal**: Users create, track, and settle a trip end-to-end from the phone — backend-issued bilty numbers, advances, receiving/POD, lifecycle statuses, and settlement reconciliation.
**Mode**: mvp
**Depends on**: Phase 1 (adapter, tenant session, new server-side trip write endpoints)
**Requirements**: TRIP-01..07
**Success Criteria** (what must be TRUE):
  1. User creates a new trip (party, truck, driver, origin, destination, billing type, freight per backend rules) and receives a bilty/LR number issued by the backend.
  2. User lists trips with status/date-range/truck filters, opens a trip, and the detail shows the full record — bilty number, party, truck, driver, freight calculation, advances, expenses, status, POD evidence.
  3. User records advances on a trip (cash, diesel, consignor, consignee); driver/pump records receiving/unload with POD photos against a trip.
  4. User moves a trip through its lifecycle statuses (assigned → loaded → in-transit → delivered → settled) and sees the updated status immediately.
  5. User settles a trip with final freight, expenses, and advances reconciled against backend totals.
**Plans**: TBD
**UI hint**: yes

### Phase 3: Master Data
**Goal**: Users manage fleet and counterparty master records — trucks, parties, and drivers — from the phone against the backend.
**Mode**: mvp
**Depends on**: Phase 1 (adapter + tenant session; trip data feeds driver trip-history and per-truck statistics)
**Requirements**: TRK-01..06, PRT-01..04, DRV-01..04
**Success Criteria** (what must be TRUE):
  1. User lists trucks with status, opens truck details, adds and edits a truck, and associates a driver with a truck.
  2. User records truck documents (type, number, expiry), sees expiry/warning status, records maintenance and truck-related expenses, and views per-truck statistics/profitability.
  3. User searches/filters and lists parties (consignor/consignee), views details, and adds and edits a party.
  4. User views a party's current balance and ledger/transactions.
  5. User lists drivers, views details, adds and edits a driver, assigns drivers to trips/trucks with trip history; a driver can view their own assigned trips and a summary of advances/earnings.
**Plans**: TBD
**UI hint**: yes

### Phase 4: Financials
**Goal**: Users record expenses and payments, manage suppliers, and track khata ledgers with outstanding balances — all against the backend.
**Mode**: mvp
**Depends on**: Phase 2 (trip-linked expenses), Phase 3 (party/supplier master records for ledgers)
**Requirements**: SPL-01..03, EXP-01..04, KHATA-01..03
**Success Criteria** (what must be TRUE):
  1. User lists suppliers, views supplier details, adds and edits a supplier, and views a supplier's balance and transactions.
  2. User records expenses against categories (diesel, toll/FASTag, repairs, driver advance, other) and views expenses filtered by trip, date range, or category.
  3. User records payments received from parties and paid to suppliers.
  4. Diesel slip/ack flow works between pump operator and owner through the API.
  5. User opens a party/supplier khata ledger, views outstanding receivables and payables, and records manual credit/debit entries.
**Plans**: TBD
**UI hint**: yes

### Phase 5: Documents & Reports
**Goal**: Users view, upload, and share trip/vehicle documents and view business reports computed from real backend data.
**Mode**: mvp
**Depends on**: Phase 2 (trip documents: bilty/LR, POD), Phase 4 (financial data for revenue/expense and outstanding reports)
**Requirements**: DOC-01..03, RPT-01..04
**Success Criteria** (what must be TRUE):
  1. User views bilty/LR, POD, and invoice documents from the app.
  2. User uploads document photos (e.g., POD) against a trip/vehicle and shares a document through the system share sheet.
  3. User views revenue and expense summaries for a date range and a profit & loss summary.
  4. User views per-truck profitability.
  5. User views outstanding balances (receivables/payables).
**Plans**: TBD
**UI hint**: yes

## Progress

**Execution Order:**
Phases execute in numeric order: 1 → 2 → 3 → 4 → 5

| Phase | Plans Complete | Status | Completed |
|-------|----------------|--------|-----------|
| 1. Integration & Data Foundation | 0/TBD | Not started | - |
| 2. Trip Lifecycle | 0/TBD | Not started | - |
| 3. Master Data | 0/TBD | Not started | - |
| 4. Financials | 0/TBD | Not started | - |
| 5. Documents & Reports | 0/TBD | Not started | - |