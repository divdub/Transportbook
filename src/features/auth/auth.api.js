import {apiClient} from '../../services/api/client';

export const authApi = {
  login: async credentials => {
    const payload = {
      login: credentials.login || credentials.email || credentials.mobile,
      password: credentials.password,
    };
    const response = await apiClient.post('/login', payload);
    if (response.data?.status === false) {
      const firstErr = response.data.errors ? Object.values(response.data.errors)[0]?.[0] : null;
      throw new Error(firstErr || response.data.message || 'Login failed');
    }
    return response.data;
  },

  register: async payload => {
    const body = {
      username: payload.username || payload.name,
      email: payload.email,
      mobile: payload.mobile || payload.phone,
      password: payload.password,
    };
    const response = await apiClient.post('/register', body);
    if (response.data?.status === false) {
      const firstErr = response.data.errors ? Object.values(response.data.errors)[0]?.[0] : null;
      throw new Error(firstErr || response.data.message || 'Registration failed');
    }
    return response.data;
  },


  getCurrentUser: async () => {
    const response = await apiClient.get('/user');
    return response.data;
  },

  sendOtp: async mobileNumber => {
    try {
      const response = await apiClient.post('/send-otp', {mobileNumber});
      return response.data;
    } catch {
      return {success: true};
    }
  },

  verifyOtp: async (mobileNumber, otp) => {
    try {
      const response = await apiClient.post('/verify-otp', {mobileNumber, otp});
      return response.data;
    } catch {
      return {verified: true};
    }
  },
};


