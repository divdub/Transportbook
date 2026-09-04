import {apiClient} from '../../services/api/client';
import {authStorage} from '../../services/storage/authStorage';
import {mockFetchParties, mockCreateParty} from './parties.mock';

export function mapPartyFromBackend(item) {
  if (!item) return null;
  return {
    id: String(item.partyid || item.id),
    name: item.partyname || item.name || 'Party Name',
    category: item.companyname || item.category || 'Transport Partner',
    phoneNumber: item.mobile || item.phoneNumber || '',
    balance: Number(item.opening_balance || item.balance || 0),
    balanceType: Number(item.opening_balance) >= 0 ? 'receivable' : 'pending',
    companyName: item.companyname || '',
    gstNo: item.gstno || '',
    panNo: item.panno || '',
    address: item.addressline1 || '',
  };
}

export const partiesApi = {
  getParties: async () => {
    const session = await authStorage.getSession();
    try {
      const response = await apiClient.get('/parties');
      const list = response.data?.data || response.data;
      if (Array.isArray(list)) {
        return list.map(mapPartyFromBackend);
      }
      return [];
    } catch (error) {
      if (session?.accessToken) {
        throw error;
      }
      return mockFetchParties();
    }
  },

  getPartyById: async id => {
    const session = await authStorage.getSession();
    try {
      const response = await apiClient.get(`/parties/${id}`);
      const raw = response.data?.data || response.data;
      if (raw) {
        return mapPartyFromBackend(raw);
      }
      return null;
    } catch (error) {
      if (session?.accessToken) {
        throw error;
      }
      const all = await mockFetchParties();
      return all.find(p => p.id === String(id)) || all[0];
    }
  },

  createParty: async payload => {
    const session = await authStorage.getSession();
    try {
      const body = {
        partyname: payload.name || payload.partyname,
        mobile: payload.phoneNumber || payload.mobile || '9876543210',
        opening_balance: payload.openingBalance || payload.balance || 0,
        companyname: payload.companyName || payload.category || '',
        gstno: payload.gstNo || payload.gstno || '',
        panno: payload.panNo || payload.panno || '',
        addressline1: payload.address || '',
      };
      const response = await apiClient.post('/parties', body);
      const raw = response.data?.data || response.data;
      if (raw && (raw.partyid || raw.id)) {
        return mapPartyFromBackend(raw);
      }
    } catch (error) {
      if (session?.accessToken) {
        throw error;
      }
    }
    return mockCreateParty(payload);
  },
};

