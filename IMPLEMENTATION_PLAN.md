# Implementation Plan

## 1. Objective

Implement the Android frontend incrementally, keeping the codebase
production-ready and aligned with the backend API being developed
separately.

The product is a TransportBook-like transportation business SaaS.

## 2. Current Starting Point

Completed:

-   React Native CLI project created
-   JavaScript entry point created
-   Android project runs successfully
-   Git repository created
-   GitHub authentication configured
-   Production `src/` folder structure created
-   Core dependency installation started/planned

## 3. Phase 1 --- Foundation

### Tasks

-   [ ] Confirm JavaScript project entry point
-   [ ] Install React Navigation
-   [ ] Install Axios
-   [ ] Install TanStack Query
-   [ ] Install Zustand
-   [ ] Install React Hook Form
-   [ ] Install Zod
-   [ ] Install Reanimated
-   [ ] Configure Reanimated correctly
-   [ ] Create theme tokens
-   [ ] Create shared components
-   [ ] Create API client
-   [ ] Create secure auth storage
-   [ ] Create root navigation

### Deliverable

A clean app shell that can navigate between authentication and
application areas.

## 4. Phase 2 --- Authentication

### Screens

-   [ ] Native splash
-   [ ] Animated truck intro
-   [ ] Welcome
-   [ ] Login/mobile number
-   [ ] OTP
-   [ ] Business setup

### Technical work

-   [ ] Connect login API
-   [ ] Connect OTP API
-   [ ] Store authentication credentials securely
-   [ ] Restore session on app launch
-   [ ] Handle expired authentication
-   [ ] Handle logout

### Deliverable

A user can authenticate and reach the application dashboard.

## 5. Phase 3 --- Application Shell

### Tasks

-   [ ] Main tab navigator
-   [ ] Home
-   [ ] Trips
-   [ ] Add/Quick Action
-   [ ] Khata
-   [ ] More
-   [ ] Global header
-   [ ] Global loading state
-   [ ] Error state
-   [ ] Empty state
-   [ ] Theme implementation

### Deliverable

A stable application shell into which business modules can be added.

## 6. Phase 4 --- Dashboard

### Tasks

-   [ ] Dashboard layout
-   [ ] Business overview cards
-   [ ] Operational metrics
-   [ ] Financial metrics
-   [ ] Quick actions
-   [ ] Recent trips
-   [ ] API integration
-   [ ] Loading skeletons
-   [ ] Empty/error states

### Deliverable

A useful business overview immediately after login.

## 7. Phase 5 --- Trips

Trips are the highest-priority business module.

### Screens

-   [ ] Trips list
-   [ ] Create trip
-   [ ] Trip details
-   [ ] Edit trip
-   [ ] Trip status
-   [ ] Add expense
-   [ ] Add payment
-   [ ] Bilty/LR
-   [ ] POD
-   [ ] Delivery/settlement

### Create Trip Flow

``` text
Party
→ Truck
→ Driver/Supplier
→ Origin/Destination
→ Billing/Freight
→ Review
→ Create
```

### Technical work

-   [ ] Define API contract with backend developer
-   [ ] Implement queries
-   [ ] Implement mutations
-   [ ] Implement validation
-   [ ] Implement cache invalidation
-   [ ] Implement pagination
-   [ ] Implement search/filter if supported

### Deliverable

A complete trip lifecycle from creation through delivery/settlement.

## 8. Phase 6 --- Trucks

### Tasks

-   [ ] Truck list
-   [ ] Truck details
-   [ ] Add truck
-   [ ] Edit truck
-   [ ] Truck status
-   [ ] Driver association
-   [ ] Documents
-   [ ] Truck expenses
-   [ ] Truck P&L if supported

### Deliverable

Complete fleet management workflow.

## 9. Phase 7 --- Drivers

### Tasks

-   [ ] Driver list
-   [ ] Driver details
-   [ ] Add driver
-   [ ] Edit driver
-   [ ] Driver-trip association
-   [ ] Driver-related records

## 10. Phase 8 --- Parties and Suppliers

### Parties

-   [ ] Party list
-   [ ] Party details
-   [ ] Add party
-   [ ] Edit party
-   [ ] Party ledger
-   [ ] Outstanding balance

### Suppliers

-   [ ] Supplier list
-   [ ] Supplier details
-   [ ] Add supplier
-   [ ] Edit supplier
-   [ ] Supplier ledger
-   [ ] Outstanding balance

## 11. Phase 9 --- Expenses and Payments

### Expenses

-   [ ] Expense list
-   [ ] Add expense
-   [ ] Expense details
-   [ ] Expense categories
-   [ ] Trip-linked expenses
-   [ ] Receipt attachment if supported

### Payments

-   [ ] Payment list
-   [ ] Record payment
-   [ ] Payment details
-   [ ] Link payment to relevant business entity
-   [ ] Balance updates from backend

## 12. Phase 10 --- Documents

### Tasks

-   [ ] Bilty/LR
-   [ ] POD
-   [ ] Invoice
-   [ ] Document list
-   [ ] Document viewer
-   [ ] Upload
-   [ ] Share/download where supported

## 13. Phase 11 --- Khata and Reports

### Khata

-   [ ] Ledger overview
-   [ ] Party ledger
-   [ ] Supplier ledger
-   [ ] Driver ledger if required
-   [ ] Outstanding balances
-   [ ] Transactions

### Reports

-   [ ] Revenue
-   [ ] Expenses
-   [ ] Profit & loss
-   [ ] Outstanding
-   [ ] Truck profitability

All financial calculations must follow backend-authoritative rules.

## 14. Phase 12 --- Utilities

Potential features:

-   [ ] Vahan/vehicle information
-   [ ] Diesel prices
-   [ ] Trip calculator
-   [ ] Reminders
-   [ ] Document expiry notifications

Only implement external integrations after requirements and API sources
are confirmed.

## 15. Phase 13 --- Production Polish

### UX

-   [ ] Skeleton loading
-   [ ] Empty states
-   [ ] Error states
-   [ ] Retry actions
-   [ ] Keyboard handling
-   [ ] Safe-area handling
-   [ ] Accessibility review

### Animation

-   [ ] Splash animation
-   [ ] Screen transitions
-   [ ] Button feedback
-   [ ] Card entrance animations
-   [ ] Success animations

### Performance

-   [ ] Optimize lists
-   [ ] Review unnecessary renders
-   [ ] Optimize images
-   [ ] Review API caching
-   [ ] Test on lower-end Android devices

## 16. Phase 14 --- Testing

### Unit

-   [ ] Utilities
-   [ ] Formatters
-   [ ] Validation
-   [ ] Business-independent helpers

### Integration

-   [ ] Authentication
-   [ ] Dashboard API
-   [ ] Trip creation
-   [ ] Truck CRUD
-   [ ] Party ledger
-   \[Expense/payment workflows

### End-to-end

-   [ ] Login → Dashboard
-   [ ] Dashboard → Create Trip
-   [ ] Create Trip → Trip Details
-   [ ] Trip → Expense/Payment
-   [ ] Trip → POD/Delivery
-   [ ] Logout → Login

## 17. AI Agent Development Rules

Any AI coding agent working on this repository must:

1.  Read `PRD.md` before implementing product functionality.
2.  Read `DESIGN.md` before implementing UI.
3.  Read `TECHNICAL_REQUIREMENTS.md` before changing architecture or
    dependencies.
4.  Read `IMPLEMENTATION_PLAN.md` before selecting the next feature.
5.  Inspect the existing repository before creating new files.
6.  Prefer existing reusable components over creating duplicates.
7.  Follow feature-based architecture.
8.  Do not move business logic into UI components unnecessarily.
9.  Do not invent backend API fields.
10. Ask for or inspect the backend API contract when required
    information is missing.
11. Keep server state in TanStack Query unless there is a specific
    reason not to.
12. Keep Zustand focused on client/application state.
13. Do not hardcode API URLs or secrets.
14. Do not introduce a new dependency without a clear reason.
15. Preserve existing behavior unless the task explicitly changes it.
16. Run relevant checks after changes.
17. Keep commits focused and descriptive.
18. Update documentation when an architectural or product decision
    changes.

## 18. Definition of Done

A feature is considered complete when:

-   UI matches the design system
-   API integration works
-   Loading state exists
-   Empty state exists where applicable
-   Error handling exists
-   Form validation exists where applicable
-   Navigation works
-   Authentication behavior is correct
-   No secrets are committed
-   Relevant tests/checks pass
-   Code follows the project architecture
-   Documentation is updated when necessary

## 19. Current Next Action

The immediate next implementation step is:

``` text
Configure core dependencies
        ↓
Create theme
        ↓
Create API client
        ↓
Create navigation
        ↓
Build splash/auth flow
```

Do not start the full Trip, Truck or accounting modules until the
application foundation and backend API contracts are sufficiently
defined.
