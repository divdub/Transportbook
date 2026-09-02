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

const SHORT_MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

function toIsoDate(value) {
  if (!value) return new Date().toISOString().split('T')[0];
  const m = String(value).match(/^(\d{1,2}) ([A-Za-z]{3}) (\d{4})$/);
  if (m) {
    const d = new Date(Date.UTC(Number(m[3]), SHORT_MONTHS.indexOf(m[2]), Number(m[1])));
    if (!isNaN(d.getTime())) return d.toISOString().split('T')[0];
  }
  const d = new Date(value);
  if (!isNaN(d.getTime())) return d.toISOString().split('T')[0];
  return String(value);
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
    const body = {
      // Backend expects integer foreign keys — send the IDs captured from the
      // parties/trucks/drivers list endpoints, falling back to null when the
      // entry was created locally (Quick Add) or left unassigned.
      tripdate: toIsoDate(data.tripStartDate || data.tripDate),
      truckid: data.truckId ? Number(data.truckId) : null,
      partyid: data.partyId ? Number(data.partyId) : null,
      supplierid: data.supplierId ? Number(data.supplierId) : null,
      driverid: data.driverId ? Number(data.driverId) : null,
      // TODO(backend): wire originid/destinationid once a city list endpoint
      // exists — for now they are nullable on the server and sent as null.
      originid: data.originId ? Number(data.originId) : null,
      destinationid: data.destinationId ? Number(data.destinationId) : null,
      partybillingtype: data.billingType || 'Fixed',
      rate: Number(data.billingRate) || Number(data.freightRate) || 0,
      wt: Number(data.billingQuantity) || Number(data.weight) || 0,
      freightamt: Number(data.freightAmount) || 0,
      material: data.material || '',
      remark: data.note || data.notes || '',
    };
    try {
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

