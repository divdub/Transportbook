# Design Document

## 1. Design Objective

Create a premium, modern Android experience for a
transportation-business SaaS.

The product should feel more polished than a traditional
accounting/fleet application while remaining extremely practical for
users who manage transport operations.

## 2. Design Direction

### Visual characteristics

-   Clean
-   Premium
-   Professional
-   High information clarity
-   Strong hierarchy
-   Generous spacing
-   Rounded cards
-   Subtle shadows
-   Restrained color palette
-   Smooth micro-interactions

Avoid:

-   Excessive gradients
-   Excessive animations
-   Dense screens with no hierarchy
-   Inconsistent button styles
-   Random colors
-   Different spacing conventions between modules

## 3. Design System

The application must use centralized design tokens.

Suggested structure:

``` text
src/theme/
├── colors.js
├── typography.js
├── spacing.js
├── radius.js
├── shadows.js
└── index.js
```

### Colors

Initial direction:

-   Light neutral background
-   White surfaces
-   Dark primary text
-   Muted secondary text
-   Strong primary brand color
-   Dedicated success/warning/danger states

Exact brand colors are **TBD**.

### Typography

Use one consistent modern sans-serif font family.

Recommended initial family: Inter.

Required weights:

-   Regular
-   Medium
-   SemiBold
-   Bold

### Spacing

Use a consistent spacing scale instead of arbitrary values.

Example:

``` text
4
8
12
16
20
24
32
40
48
```

### Radius

Use a small number of radius tokens, for example:

``` text
8
12
16
24
```

### Shadows

Use subtle elevation. Avoid heavy shadows.

## 4. Reusable UI Components

Common components should live under:

``` text
src/components/common/
```

Examples:

-   AppButton
-   AppInput
-   AppText
-   AppCard
-   AppHeader
-   AppModal
-   AppBottomSheet
-   AppLoader
-   EmptyState

Additional UI components:

``` text
src/components/ui/
```

Examples:

-   StatusBadge
-   Avatar
-   SearchBar
-   Skeleton

## 5. Application Flow

``` text
Native Android Splash
        ↓
Animated Truck Intro
        ↓
Authentication Check
        ↓
   ┌────┴────┐
   ↓         ↓
 Login     Dashboard
```

The native Android splash should provide immediate launch feedback.

The React Native layer can then display the premium animated truck
introduction.

## 6. Splash Design

The splash experience should use a truck animation.

Potential implementation:

-   Lottie animation
-   React Native Reanimated
-   Premium dark or branded background
-   Logo
-   Short product tagline if required

Animation should be short and purposeful.

Do not delay application launch unnecessarily.

## 7. Authentication Screens

### Welcome

Purpose:

-   Introduce the application
-   Start registration/login

### Mobile Number

Purpose:

-   Capture mobile number
-   Start authentication

### OTP

Purpose:

-   Verify mobile number
-   Provide resend behavior
-   Handle invalid/expired OTP

### Business Setup

Purpose:

-   Capture user name
-   Business name
-   Business type where required

## 8. Dashboard

The dashboard should prioritize information users need immediately.

Suggested hierarchy:

``` text
Header
    ↓
Business overview
    ↓
Key financial/operational metrics
    ↓
Quick actions
    ↓
Active/recent trips
```

Cards should not become visually excessive.

## 9. Trip UX

Trip creation is one of the most important workflows.

Prefer a guided flow:

``` text
Party
  ↓
Truck
  ↓
Driver / Supplier
  ↓
Route
  ↓
Freight / Billing
  ↓
Review
  ↓
Create Trip
```

The user should always know:

-   Current step
-   Required fields
-   What has already been entered
-   What remains

## 10. Trip Details UX

A trip details screen should prioritize:

1.  Trip status
2.  Vehicle
3.  Route
4.  Financial summary
5.  Driver/supplier
6.  Expenses
7.  Documents
8.  Delivery/settlement actions

## 11. Bottom Navigation

Current proposal:

``` text
Home | Trips | Add | Khata | More
```

The Add button should be visually prominent but not overpower the
navigation.

## 12. Loading States

Use:

-   Skeletons for lists/cards
-   Small loaders for button actions
-   Full-screen loaders only when unavoidable

Avoid replacing the entire interface with a spinner for normal API
calls.

## 13. Empty States

Every list should have an intentional empty state.

Example:

``` text
No trips yet

Create your first trip to start
tracking your transport operations.

[ Create Trip ]
```

## 14. Error States

Errors should be:

-   Human-readable
-   Actionable
-   Consistent

Avoid exposing raw API/server errors directly to users.

## 15. Animation Guidelines

Use animation for:

-   Screen transitions
-   Button feedback
-   Card entrance
-   Bottom sheets
-   Success states
-   Splash

Do not animate every element.

Animation must improve perceived quality and usability.

## 16. Accessibility

The UI should support:

-   Sufficient text contrast
-   Readable font sizes
-   Touchable targets
-   Screen-reader labels where appropriate
-   Avoiding color-only status communication

## 17. Responsive Considerations

The first target is Android phones.

Nevertheless:

-   Avoid hardcoded screen dimensions
-   Use flexible layouts
-   Support different phone sizes
-   Account for safe areas
-   Handle keyboard appearance correctly

## 18. Design Decisions Still TBD

-   Final brand palette
-   Logo
-   Font licensing/source
-   Exact icon library
-   Dark mode
-   Figma source of truth
-   Exact dashboard metrics
-   Exact navigation after user research
