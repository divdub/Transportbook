/*
 * Future authentication API boundary.
 *
 * LoginScreen should not call axios directly. When the backend contract is
 * ready, the login hook will call a function in this file, this file will call
 * src/services/api/client.js, and the successful response will be passed into
 * authStore so sensitive credentials can be persisted through authStorage.
 *
 * Deliberately no endpoint, request shape, response shape, token name, or OTP
 * behavior is defined here yet because the backend contract is unavailable.
 */
