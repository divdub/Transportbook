# Requirements

v1 for the first milestone — full PRD scope for the transport app delivered against the existing PHP backend. All requirements are hypotheses until shipped and validated (per PROJECT.md).

## v1 Requirements

### Auth, Tenancy & Onboarding

- [ ] **AUTH-01**: Owner can log in with mobile number + OTP and stay logged in across app restarts.
- [ ] **AUTH-02**: Driver, petrol-pump operator, and employee/admin can log in with mobile number (OTP) and secure password.
- [ ] **AUTH-03**: Every login/activation resolves a tenant session (comp_id, session_id, consignorid, user_id, role) that the app persists and sends with every API call.
- [ ] **AUTH-04**: Owner can create a new business from the app's business-setup flow (company + consignor + owner account = a new self-served tenant).
- [ ] **AUTH-05**: User can log out and end the session server-side.
- [ ] **AUTH-06**: Backend enforces role- and tenant-scoped data: owner sees the tenant's full data, driver sees assigned trips + receiving actions, pump sees fuel/diesel entries, employee sees the tenant's permitted records.
- [ ] **AUTH-07**: User can re-authenticate when a token expires or is revoked without losing local state.

### Trips

- [ ] **TRIP-01**: User can create a new trip (party, truck, driver, origin, destination, billing type, freight) and receive a bilty/LR number issued by the backend.
- [ ] **TRIP-02**: User can list trips with filters (status, date range, truck) and open a trip detail view.
- [ ] **TRIP-03**: User can record advances on a trip (cash, diesel, consignor, consignee advance types).
- [ ] **TRIP-04**: Driver/pump can record receiving/unload with POD photos against a trip.
- [ ] **TRIP-05**: User can move a trip through its lifecycle statuses (assigned → loaded → in-transit → delivered → settled).
- [ ] **TRIP-06**: User can settle a trip with final freight, expenses, and advances reconciled against backend totals.
- [ ] **TRIP-07**: Trip detail shows the full record — bilty number, party, truck, driver, freight calculation, advances, expenses, status, POD evidence.

### Trucks / Fleet

- [ ] **TRK-01**: User can list trucks with status and open truck details.
- [ ] **TRK-02**: User can add and edit a truck.
- [ ] **TRK-03**: User can associate a driver with a truck.
- [ ] **TRK-04**: User can record truck documents (type, number, expiry) and see expiry/warning status.
- [ ] **TRK-05**: User can record truck maintenance and truck-related expenses.
- [ ] **TRK-06**: User can view per-truck statistics/profitability.

### Parties

- [ ] **PRT-01**: User can search/filter and list parties (consignor/consignee) and view details.
- [ ] **PRT-02**: User can add and edit a party.
- [ ] **PRT-03**: User can view a party's current balance.
- [ ] **PRT-04**: User can view a party's ledger/transactions.

### Drivers

- [ ] **DRV-01**: User can list drivers and view driver details.
- [ ] **DRV-02**: User can add and edit a driver.
- [ ] **DRV-03**: User can assign a driver to trips/trucks and view his trip history.
- [ ] **DRV-04**: Driver can view their own assigned trips and a summary of advances/earnings.

### Suppliers

- [ ] **SPL-01**: User can list suppliers and view details.
- [ ] **SPL-02**: User can add and edit a supplier.
- [ ] **SPL-03**: User can view a supplier's balance and transactions.

### Expenses & Payments

- [ ] **EXP-01**: User can record expenses against categories (diesel, toll/FASTag, repairs, driver advance, other).
- [ ] **EXP-02**: User can record payments received from parties and paid to suppliers.
- [ ] **EXP-03**: User can view expenses filtered by trip, date range, or category.
- [ ] **EXP-04**: Diesel slip/ack flow works between pump operator and owner through the API.

### Khata / Ledger

- [ ] **KHATA-01**: User can open a party/supplier khata ledger.
- [ ] **KHATA-02**: User can view outstanding receivables and payables.
- [ ] **KHATA-03**: User can record manual khata entries (credit/debit).

### Documents

- [ ] **DOC-01**: User can view bilty/LR, POD, and invoice documents.
- [ ] **DOC-02**: User can upload document photos (e.g., POD) against trip/vehicle.
- [ ] **DOC-03**: User can share a document through the system share sheet.

### Reports

- [ ] **RPT-01**: User can view revenue and expense summaries for a date range.
- [ ] **RPT-02**: User can view a profit & loss summary.
- [ ] **RPT-03**: User can view per-truck profitability.
- [ ] **RPT-04**: User can view outstanding balances (receivables/payables).

### Integration & Data Layer

- [ ] **DATA-01**: All modules consume the backend through a shared API-client adapter using the existing JSON envelope; production builds never fall back to mock data.
- [ ] **DATA-02**: API client consistently handles auth/tenant headers, loading, empty, error, and offline-aware states.
- [ ] **DATA-03**: New backend endpoints are tenant- and role-scoped, parameterized, and follow existing mobile/API + `lib/` + `ajax*/save_*` patterns.
- [ ] **DATA-04**: A local PHP backend + MySQL copy of the schema runs for development and automated verification.
- [ ] **DATA-05**: Freight/billing rules (freight slabs, GST, TDS) execute server-side, not in client-side ERP JS.
- [ ] **DATA-06**: No DB credentials or secrets are shipped in the app; secret handling stays server-side.

## v2 (Deferred)

- [ ] Push notifications and trip alerts
- [ ] Full offline support / offline sync
- [ ] PDF/Excel/WhatsApp report generation from the app
- [ ] Transport utilities (diesel prices, trip calculator, reminders)
- [ ] Web (React) client

## Out of Scope

- Web (React) client in this milestone — same backend later
- Inventory, sale/purchase, and payroll ERP modules — outside the transport PRD
- Copying TransportBook/LOADSHARE proprietary source, branding, or protected assets — per PRD §3

## Traceability

Each v1 requirement maps to exactly one phase (set 2026-08-30 by roadmap).

| Phase | Requirement IDs |
|-------|-----------------|
| Phase 1: Integration & Data Foundation | AUTH-01..07, DATA-01..06 |
| Phase 2: Trip Lifecycle | TRIP-01..07 |
| Phase 3: Master Data | TRK-01..06, PRT-01..04, DRV-01..04 |
| Phase 4: Financials | SPL-01..03, EXP-01..04, KHATA-01..03 |
| Phase 5: Documents & Reports | DOC-01..03, RPT-01..04 |

---
*Last updated: 2026-08-30 after initialization*