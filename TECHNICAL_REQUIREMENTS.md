# Technical Requirements Document

## 1. Technical Objective

Build a production-ready Android client using React Native CLI and
JavaScript.

The backend is developed separately and exposes the APIs consumed by
this application.

## 2. Technology Stack

### Mobile

-   React Native CLI
-   JavaScript
-   Android native project

### Navigation

-   React Navigation
-   Native Stack Navigator
-   Bottom Tab Navigator

### Server State

-   TanStack Query

### Client State

-   Zustand

### HTTP

-   Axios

### Forms

-   React Hook Form

### Validation

-   Zod
-   @hookform/resolvers

### Animation

-   React Native Reanimated
-   Lottie for the truck animation when required

### Backend

The current project brief identifies:

-   Node.js
-   Express
-   SQL database

The exact backend implementation and SQL technology are owned by the
backend developer and are outside the mobile frontend implementation.

## 3. Project Architecture

Use feature-based architecture.

``` text
src/
├── assets/
├── components/
│   ├── common/
│   └── ui/
├── config/
├── features/
│   ├── auth/
│   ├── dashboard/
│   ├── trucks/
│   ├── trips/
│   ├── drivers/
│   ├── expenses/
│   └── parties/
├── navigation/
├── services/
│   ├── api/
│   └── storage/
├── store/
├── theme/
├── hooks/
├── utils/
└── types/
```

## 4. Feature Architecture

Each major domain should own its screens, components, API functions and
domain-specific logic.

Example:

``` text
features/trucks/
├── screens/
├── components/
├── hooks/
├── trucks.api.js
├── trucks.types.js
└── trucks.validation.js
```

Do not place all application screens into one global `screens/`
directory.

## 5. API Layer

Screens must not contain raw API requests.

Required flow:

``` text
Screen
  ↓
Feature hook/query
  ↓
Feature API module
  ↓
Shared Axios client
  ↓
Backend
```

Example:

``` text
features/trucks/trucks.api.js
        ↓
services/api/client.js
        ↓
Node / Express API
```

## 6. Axios Client

Create a shared Axios client:

``` text
src/services/api/client.js
```

It should centrally handle:

-   Base URL
-   Request headers
-   Authentication
-   Response handling
-   Error normalization
-   Timeout configuration

## 7. Authentication

The mobile application should support the backend's authentication
mechanism.

The uploaded brief proposes a JWT-style access/refresh token model.

The final implementation must follow the actual backend contract.

Tokens must not be stored in ordinary unencrypted application state or
plain text files.

Use secure native storage for sensitive authentication credentials.

## 8. Server State

Use TanStack Query for backend-owned state:

-   Trucks
-   Trips
-   Drivers
-   Expenses
-   Parties
-   Suppliers
-   Payments
-   Documents
-   Reports

Avoid duplicating server state into Zustand unless there is a specific
reason.

## 9. Client State

Use Zustand for lightweight application/client state such as:

-   Authentication/session UI state
-   Current company context where appropriate
-   UI preferences
-   Temporary client state

Keep the store small.

## 10. Forms

Use React Hook Form for complex forms.

Use Zod for validation.

Examples:

-   Login
-   OTP
-   Add Truck
-   Create Trip
-   Add Expense
-   Add Party
-   Add Driver

Validation should be aligned with backend rules.

## 11. Navigation Architecture

Recommended:

``` text
RootNavigator
│
├── AuthNavigator
│   ├── Welcome
│   ├── Login
│   ├── OTP
│   └── Business Setup
│
└── AppNavigator
    │
    └── MainTabNavigator
        ├── Home
        ├── Trips
        ├── Add
        ├── Khata
        └── More
```

Feature-specific detail screens can be placed in stacks above the main
navigation.

## 12. Environment Configuration

Support separate configurations for:

``` text
.env.development
.env.staging
.env.production
```

At minimum, the API base URL must be environment-specific.

Do not hardcode production URLs inside feature screens.

## 13. Backend Contract

The backend developer and frontend developer must agree on:

-   Authentication endpoints
-   Request bodies
-   Response schemas
-   HTTP status codes
-   Error response format
-   Pagination
-   Sorting
-   Filtering
-   Search
-   Upload endpoints
-   Document URLs
-   Token refresh behavior
-   Trip status values
-   Truck status values
-   Financial calculation rules

The frontend must not invent API fields when the contract is
unavailable.

## 14. Error Handling

Centralize API error handling.

The application must distinguish between:

-   Validation errors
-   Authentication errors
-   Authorization errors
-   Network failures
-   Server failures
-   Not-found responses
-   Timeout errors

User-facing messages should be understandable.

## 15. Security Requirements

-   Never commit secrets to Git
-   Do not hardcode API credentials
-   Do not log access/refresh tokens
-   Use secure storage for sensitive tokens
-   Validate server responses where appropriate
-   Never trust client-side financial calculations as authoritative
-   Use HTTPS in staging/production
-   Keep sensitive data out of analytics/logging

## 16. Performance Requirements

-   Avoid unnecessary global state
-   Use TanStack Query caching
-   Use list virtualization for large lists
-   Paginate large backend datasets
-   Optimize images
-   Avoid unnecessary re-renders
-   Use memoization only where profiling justifies it
-   Keep animations smooth

## 17. Offline / Network Behavior

Offline requirements are currently **TBD**.

At minimum the application should:

-   Detect network/API failures
-   Show meaningful feedback
-   Avoid losing user-entered form data unexpectedly
-   Retry safe requests where appropriate

Full offline-first behavior should not be implemented until explicitly
required.

## 18. Documents and Media

The app may need:

-   Image upload
-   PDF/document upload
-   POD capture
-   Bilty/LR documents

The exact storage and upload contract must come from the backend.

## 19. Testing

Testing should eventually cover:

-   Utility functions
-   Validation
-   API integration behavior
-   Critical navigation
-   Authentication
-   Trip creation
-   Financial workflows

The most important end-to-end flow is:

``` text
Login
→ Dashboard
→ Create Trip
→ Add Expense/Payment
→ Trip Details
→ Delivery/POD
→ Settlement
```

## 20. Git Requirements

Use feature-focused commits.

Example:

``` text
feat: add authentication navigation
feat: add login screen
feat: integrate OTP API
feat: add dashboard shell
feat: add trip creation flow
fix: handle expired access token
```

Do not commit:

-   `.env` secrets
-   API keys
-   tokens
-   build artifacts
-   `node_modules`

## 21. Technical Decisions Still TBD

-   Exact React Native version
-   Exact Android minimum/target SDK
-   Secure storage package
-   Lottie package/version
-   Push notification provider
-   Analytics provider
-   Crash reporting
-   Image/document storage
-   Offline strategy
-   CI/CD
-   Release signing process
