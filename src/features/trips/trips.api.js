import {apiClient} from '../../services/api/client';

/**
 * Trips API Service Layer
 *
 * Backend: PHP + Laravel + SQL REST API
 * Note: Endpoint routes, payload shapes, and responses below are conceptual
 * backend-contract placeholders until the production Laravel API specification is shared.
 */

export const tripsApi = {
  getTrips: async params => {
    const response = await apiClient.get('/api/trips', {params});
    return response.data;
  },

  getTripById: async id => {
    const response = await apiClient.get(`/api/trips/${id}`);
    return response.data;
  },

  createTrip: async data => {
    const response = await apiClient.post('/api/trips', data);
    return response.data;
  },

  updateTrip: async (id, data) => {
    const response = await apiClient.put(`/api/trips/${id}`, data);
    return response.data;
  },

  updateTripStatus: async (id, data) => {
    const response = await apiClient.post(`/api/trips/${id}/status`, data);
    return response.data;
  },

  addAdvance: async (id, data) => {
    const response = await apiClient.post(`/api/trips/${id}/advance`, data);
    return response.data;
  },

  addExpense: async (id, data) => {
    const response = await apiClient.post(`/api/trips/${id}/expenses`, data);
    return response.data;
  },

  addLoad: async (id, data) => {
    const response = await apiClient.post(`/api/trips/${id}/loads`, data);
    return response.data;
  },

  addDriverBalance: async (id, data) => {
    const response = await apiClient.post(`/api/trips/${id}/driver-balance`, data);
    return response.data;
  },
};
