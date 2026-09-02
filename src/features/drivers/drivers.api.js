import {apiClient} from '../../services/api/client';
import {mockFetchDrivers, mockCreateDriver} from './drivers.mock';

export function mapDriverFromBackend(item) {
  if (!item) return null;
  const openingBalance = Number(item.opening_balance || item.openingBalance || 0);
  return {
    id: String(item.driverid || item.id),
    drivername: item.drivername || item.driverName || 'Driver',
    mobile: item.mobile || item.mobile_no || item.phone || '',
    opening_balance: openingBalance,
    balance_type: item.balance_type || item.balanceType || (openingBalance >= 0 ? 'has_to_pay' : 'has_to_get'),
    status: item.status == null ? 1 : Number(item.status),
  };
}

function firstErrorMessage(apiError) {
  const data = apiError?.response?.data || apiError?.data;
  if (apiError?.message) {
    return apiError.message;
  }
  if (data?.message) {
    return data.message;
  }
  if (data?.errors) {
    const first = Object.values(data.errors)[0];
    return Array.isArray(first) ? first[0] : String(first || '');
  }
  return '';
}

export const driversApi = {
  getDrivers: async () => {
    try {
      const response = await apiClient.get('/drivers');
      const list = response.data?.data || response.data;
      if (Array.isArray(list) && list.length > 0) {
        return list.map(mapDriverFromBackend);
      }
    } catch {
      // Fallback to mock data if backend endpoint is unavailable
    }
    return mockFetchDrivers();
  },

  getDriverById: async id => {
    try {
      const response = await apiClient.get(`/drivers/${id}`);
      const raw = response.data?.data || response.data;
      if (raw) {
        return mapDriverFromBackend(raw);
      }
    } catch {
      const all = await mockFetchDrivers();
      return all.find(d => d.id === String(id)) || null;
    }
  },

  createDriver: async payload => {
    const body = {
      drivername: payload.drivername,
      mobile: payload.mobile,
      opening_balance: payload.opening_balance || payload.openingBalance || 0,
      balance_type: payload.balance_type || payload.balanceType || 'has_to_pay',
    };
    try {
      const response = await apiClient.post('/drivers', body);
      const raw = response.data?.data || response.data;
      if (raw && (raw.driverid || raw.id)) {
        return mapDriverFromBackend(raw);
      }
      if (response.data?.status === true) {
        return mapDriverFromBackend({...body, id: `${Date.now()}`});
      }
      // 2xx/unknown envelope with status false — surface the message.
      throw new Error(firstErrorMessage({response: response}) || 'Driver could not be saved.');
    } catch (apiError) {
      // Backend answered with an HTTP error (4xx/5xx) — surface it.
      if (apiError?.response || apiError?.status) {
        throw new Error(firstErrorMessage(apiError) || 'Driver could not be saved.');
      }
      // No response at all (network/timeout) — fall back to mock.
      return mockCreateDriver(body);
    }
  },
};