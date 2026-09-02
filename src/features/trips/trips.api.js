import {apiClient} from '../../services/api/client';
import {
  mockFetchTrips,
  mockFetchTripById,
  mockCreateTrip,
  mockUpdateTripStatus,
  mockAddAdvance,
  mockAddDriverBalance,
} from './trips.mock';

export function mapTripFromBackend(item) {
  if (!item) return null;
  return {
    id: String(item.tripid || item.id || item.tripno),
    tripno: item.tripno || item.id,
    partyName: item.partyname || item.partyName || 'Party Name',
    truckNumber: item.trucknumber || item.truckNumber || 'Commercial Truck',
    driverName: item.drivername || item.driverName || 'Driver',
    origin: item.origin_name || item.origin || 'Origin',
    destination: item.destination_name || item.destination || 'Destination',
    tripDate: item.tripdate || item.tripDate || new Date().toLocaleDateString('en-GB'),
    billingType: item.partybillingtype || item.billingType || 'Fixed',
    freightAmount: Number(item.freightamt || item.freightAmount || 0),
    advanceAmount: Number(item.advanceAmount || 0),
    pendingBalance: Number(item.freightamt || 0) - Number(item.advanceAmount || 0),
    material: item.material || '',
    status: item.status || 'Started',
    notes: item.remark || item.notes || '',
    statusTimeline: item.statusTimeline || [
      {status: 'Started', date: item.tripdate || 'Today', completed: true, podUrl: null},
      {status: 'Completed', date: null, completed: false, podUrl: null},
      {status: 'POD Received', date: null, completed: false, podUrl: null},
      {status: 'POD Submitted', date: null, completed: false, podUrl: null},
      {status: 'Settled', date: null, completed: false, podUrl: null},
    ],
    expenses: item.expenses || [],
    advances: item.advances || [],
  };
}

export const tripsApi = {
  getTrips: async params => {
    try {
      const response = await apiClient.get('/trips', {params});
      const data = response.data?.data || response.data;
      if (Array.isArray(data) && data.length > 0) {
        return data.map(mapTripFromBackend);
      }
    } catch {
      // Backend offline / mock fallback
    }
    return mockFetchTrips();
  },

  getTripById: async id => {
    try {
      const response = await apiClient.get(`/trips/${id}`);
      const raw = response.data?.data || response.data;
      if (raw) {
        return mapTripFromBackend(raw);
      }
    } catch {
      // Backend offline / mock fallback
    }
    return mockFetchTripById(id);
  },

  createTrip: async data => {
    try {
      const body = {
        tripdate: data.tripStartDate || data.tripDate || new Date().toISOString().split('T')[0],
        truckid: data.truckId ? Number(data.truckId) : null,
        partyid: data.partyId ? Number(data.partyId) : null,
        supplierid: data.supplierId ? Number(data.supplierId) : null,
        driverid: data.driverId ? Number(data.driverId) : null,
        partybillingtype: data.billingType || 'Fixed',
        rate: Number(data.freightRate) || 0,
        wt: Number(data.weight) || 0,
        freightamt: Number(data.freightAmount) || 0,
        material: data.material || '',
        remark: data.note || data.notes || '',
      };
      const response = await apiClient.post('/trips', body);
      const created = response.data?.data || response.data;
      if (created && (created.tripid || created.id || created.tripno)) {
        return mapTripFromBackend(created);
      }
    } catch {
      // Backend offline / mock fallback
    }
    return mockCreateTrip(data);
  },


  updateTrip: async (id, data) => {
    try {
      const response = await apiClient.put(`/trips/${id}`, data);
      return response.data?.data || response.data;
    } catch {
      return {id, ...data};
    }
  },

  updateTripStatus: async (id, data) => {
    try {
      const response = await apiClient.post(`/trips/${id}/status`, data);
      return response.data?.data || response.data;
    } catch {
      return mockUpdateTripStatus({id, ...data});
    }
  },

  addAdvance: async (id, data) => {
    try {
      const response = await apiClient.post(`/trips/${id}/advance`, data);
      return response.data?.data || response.data;
    } catch {
      return mockAddAdvance({id, ...data});
    }
  },

  addExpense: async (id, data) => {
    try {
      const response = await apiClient.post(`/trips/${id}/expenses`, data);
      return response.data?.data || response.data;
    } catch {
      return {id, ...data};
    }
  },

  addLoad: async (id, data) => {
    try {
      const response = await apiClient.post(`/trips/${id}/loads`, data);
      return response.data?.data || response.data;
    } catch {
      return {id, ...data};
    }
  },

  addDriverBalance: async (id, data) => {
    try {
      const response = await apiClient.post(`/trips/${id}/driver-balance`, data);
      return response.data?.data || response.data;
    } catch {
      return mockAddDriverBalance({id, ...data});
    }
  },
};

