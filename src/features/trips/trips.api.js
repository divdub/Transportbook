import {apiClient} from '../../services/api/client';
import {authStorage} from '../../services/storage/authStorage';
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
    partyId: item.partyid == null ? null : String(item.partyid),
    truckId: item.truckid == null ? null : String(item.truckid),
    driverId: item.driverid == null ? null : String(item.driverid),
    partyName: item.partyname || item.partyName || '',
    truckNumber: item.trucknumber || item.truckNumber || 'Commercial Truck',
    driverName: item.drivername || item.driverName || 'Driver',
    originId: item.originid == null ? null : String(item.originid),
    destinationId: item.destinationid == null ? null : String(item.destinationid),
    origin: item.origin_name || item.origin || '',
    destination: item.destination_name || item.destination || '',
    tripDate: item.tripdate || item.tripDate || new Date().toLocaleDateString('en-GB'),
    billingType: item.partybillingtype || item.billingType || 'Fixed',
    freightAmount: Number(item.freightamt || item.freightAmount || 0),
    advanceAmount: Number(item.advanceAmount || 0),
    pendingBalance: Number(item.freightamt || 0) - Number(item.advanceAmount || 0),
    material: item.material || '',
    status: item.tripstatus || item.status || 'Started',
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
    const session = await authStorage.getSession();
    try {
      const response = await apiClient.get('/trips', {params});
      const data = response.data?.data || response.data;
      if (Array.isArray(data)) {
        return data.map(mapTripFromBackend);
      }
      return [];
    } catch (error) {
      if (session?.accessToken) {
        throw error;
      }
      return mockFetchTrips();
    }
  },

  getTripById: async id => {
    const session = await authStorage.getSession();
    try {
      const response = await apiClient.get(`/trips/${id}`);
      const raw = response.data?.data || response.data;
      if (raw) {
        return mapTripFromBackend(raw);
      }
      return null;
    } catch (error) {
      if (session?.accessToken) {
        throw error;
      }
      return mockFetchTripById(id);
    }
  },

  createTrip: async data => {
    const session = await authStorage.getSession();
    const body = {
      // Backend expects integer foreign keys — send the IDs captured from the
      // parties/trucks/drivers list endpoints, falling back to null when the
      // entry was created locally (Quick Add) or left unassigned.
      tripdate: toIsoDate(data.tripStartDate || data.tripDate),
      truckid: data.truckId ? Number(data.truckId) : null,
      partyid: data.partyId ? Number(data.partyId) : null,
      supplierid: data.supplierId ? Number(data.supplierId) : null,
      driverid: data.driverId ? Number(data.driverId) : null,
      originid: data.originId ? Number(data.originId) : null,
      destinationid: data.destinationId ? Number(data.destinationId) : null,
      partybillingtype: data.billingType || 'Fixed',
      rate: Number(data.billingRate) || Number(data.freightRate) || 0,
      wt: Number(data.billingQuantity) || Number(data.weight) || 0,
      freightamt: Number(data.freightAmount) || 0,
      supplierbillingtype: data.supplierBillingType || 'Fixed',
      sup_rate: Number(data.supplierBillingRate) || 0,
      supwt: Number(data.supplierBillingQuantity) || 0,
      sup_freightamt: Number(data.truckHireCost) || Number(data.supplierBillingAmount) || 0,
      material: data.material || '',
      remark: data.note || data.notes || '',
    };
    try {
      const response = await apiClient.post('/trips', body);
      const created = response.data?.data || response.data;
      if (created && (created.tripid || created.id || created.tripno)) {
        return mapTripFromBackend(created);
      }
    } catch (error) {
      if (session?.accessToken) {
        throw error;
      }
    }
    return mockCreateTrip(data);
  },

  updateTrip: async (id, data) => {
    const session = await authStorage.getSession();
    try {
      const response = await apiClient.put(`/trips/${id}`, data);
      return response.data?.data || response.data;
    } catch (error) {
      if (session?.accessToken) {
        throw error;
      }
      return {id, ...data};
    }
  },

  updateTripStatus: async (id, data) => {
    const session = await authStorage.getSession();
    try {
      const response = await apiClient.post(`/trips/${id}/status`, data);
      return response.data?.data || response.data;
    } catch (error) {
      if (session?.accessToken) {
        throw error;
      }
      return mockUpdateTripStatus({id, ...data});
    }
  },

  addAdvance: async (id, data) => {
    const session = await authStorage.getSession();
    try {
      const response = await apiClient.post(`/trips/${id}/advance`, data);
      return response.data?.data || response.data;
    } catch (error) {
      if (session?.accessToken) {
        throw error;
      }
      return mockAddAdvance({id, ...data});
    }
  },

  addExpense: async (id, data) => {
    const session = await authStorage.getSession();
    try {
      const response = await apiClient.post(`/trips/${id}/expenses`, data);
      return response.data?.data || response.data;
    } catch (error) {
      if (session?.accessToken) {
        throw error;
      }
      return {id, ...data};
    }
  },

  addLoad: async (id, data) => {
    const session = await authStorage.getSession();
    try {
      const response = await apiClient.post(`/trips/${id}/loads`, data);
      return response.data?.data || response.data;
    } catch (error) {
      if (session?.accessToken) {
        throw error;
      }
      return {id, ...data};
    }
  },

  addDriverBalance: async (id, data) => {
    const session = await authStorage.getSession();
    try {
      const response = await apiClient.post(`/trips/${id}/driver-balance`, data);
      return response.data?.data || response.data;
    } catch (error) {
      if (session?.accessToken) {
        throw error;
      }
      return mockAddDriverBalance({id, ...data});
    }
  },
};

