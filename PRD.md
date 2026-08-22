# Product Requirements Document (PRD)

## 1. Product Overview

**Working product:** Transportation SaaS Android application

The product is a transportation-business management application inspired
by the functional scope of TransportBook by LOADSHARE. The Android
application is the first client to be implemented. A separate developer
is responsible for the backend.

The intended product model is a shared backend/database serving mobile
and, later, a web application.

## 2. Product Goal

Build a premium-looking Android application that helps transportation
businesses manage their daily operations and financial records from one
place.

The application should cover the core transportation workflow around:

-   Trips
-   Trucks / fleet
-   Drivers
-   Parties / customers
-   Suppliers
-   Expenses
-   Payments
-   Bilty / LR
-   POD / delivery documents
-   Khata / ledger
-   Reports and profit/loss
-   Transport-related utilities and reminders

## 3. Reference Product

TransportBook by LOADSHARE is the functional reference for the product.

The uploaded project brief describes TransportBook as a
premium-subscription product available on mobile and website with a
shared database, and identifies trips, trucks, drivers, expenses,
parties and related transportation workflows as the target scope.

**Important:** The application may use the reference product for
understanding workflows and functionality, but must not copy proprietary
source code, branding, or protected assets.

## 4. Target Platform

### Current priority

-   Android
-   React Native CLI
-   JavaScript
-   Native Android project

### Future direction

-   Web client using React
-   Same backend/API and database

## 5. Primary Users

The product is intended for transportation businesses, including
workflows for:

-   Transporters
-   Fleet owners
-   Transport contractors
-   Commission agents

Exact roles, permissions and staff access rules are **TBD with the
backend/product owner**.

## 6. Core Modules

### Authentication and onboarding

-   Splash / application launch
-   Mobile number login
-   OTP verification
-   Business setup
-   Authentication/session persistence

### Dashboard

The dashboard should provide a quick overview of the business, such as:

-   Revenue / financial overview
-   Receivables
-   Number of trucks
-   Active trips
-   Quick actions
-   Recent trips

Exact metrics and API fields are **TBD**.

### Trips

Trips are the central operational workflow.

A trip can involve:

-   Party
-   Truck
-   Driver
-   Supplier
-   Origin
-   Destination
-   Billing type
-   Freight
-   Advance
-   Expenses
-   Trip status
-   Bilty / LR
-   POD
-   Delivery / settlement

The exact fields and lifecycle must be finalized against the backend API
contract.

### Trucks / Fleet

-   Truck list
-   Truck details
-   Add/edit truck
-   Truck status
-   Driver association
-   Vehicle documents
-   Truck-related expenses
-   Truck profitability

### Drivers

-   Driver list
-   Driver details
-   Driver association with trips/trucks
-   Driver-related records

### Parties

-   Customer/party list
-   Party details
-   Balances
-   Transactions / ledger

### Suppliers

-   Supplier list
-   Supplier details
-   Supplier balances
-   Supplier transactions

### Expenses

Transportation expenses may include items such as:

-   Diesel
-   Toll / FASTag
-   Repairs
-   Driver advance
-   Other trip/business expenses

Exact categories should come from the backend/product specification.

### Payments and ledger

-   Payments
-   Party ledger
-   Supplier ledger
-   Outstanding balances
-   Receivables/payables

### Documents

-   Bilty / LR
-   POD
-   Invoice
-   Other business documents
-   Document upload/view/share where supported by the backend

### Reports

Potential reports include:

-   Revenue
-   Expenses
-   Profit and loss
-   Outstanding balances
-   Truck profitability

Exact reports and calculations are **TBD**.

### Utilities

Potential transportation utilities include:

-   Vehicle information
-   Diesel prices
-   Trip calculator
-   Reminders

Exact external integrations are **TBD**.

## 7. UX/Product Principles

The application should feel:

-   Premium
-   Modern
-   Clean
-   Fast
-   Easy for transport-business users
-   Consistent across modules

Design principles:

-   Consistent spacing
-   Reusable components
-   Clear typography hierarchy
-   Consistent status colors
-   Cards where useful
-   Loading skeletons
-   Empty states
-   Error states
-   Subtle animations
-   Smooth transitions

## 8. Main Navigation Concept

The current proposed navigation is:

-   Home
-   Trips
-   Add / Quick Action
-   Khata
-   More

The central Add action can expose:

-   New Trip
-   Expense
-   Payment
-   Party
-   Truck
-   Driver

This navigation is a product-design proposal and should be validated
during implementation.

## 9. Non-Goals for the Initial Build

Do not expand the first implementation into unrelated functionality.

The first implementation priority is:

1.  Foundation
2.  Authentication
3.  App shell
4.  Dashboard
5.  Trips
6.  Trucks
7.  Ledger / parties / suppliers
8.  Expenses and payments
9.  Documents
10. Reports and utilities
11. Production polish

## 10. Success Criteria

The Android client should:

-   Run reliably on Android
-   Authenticate against the backend
-   Consume the backend APIs cleanly
-   Provide the core transportation workflows
-   Maintain consistent UI/UX
-   Handle loading, empty, error and offline-related states
    appropriately
-   Be structured so additional modules can be added without major
    refactoring

## 11. Open Product Questions

These must be resolved before implementing dependent functionality:

-   Exact authentication API and OTP behavior
-   User roles and permissions
-   Company/tenant model
-   Exact trip fields
-   Trip status lifecycle
-   Exact truck fields
-   Exact party/supplier accounting behavior
-   Payment and settlement rules
-   Document upload/storage API
-   POD workflow
-   Report calculations
-   Pagination/filter/search behavior
-   Notification requirements
-   Offline support requirements
