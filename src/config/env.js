const development = {
  name: 'development',
  apiBaseUrl: 'http://10.0.2.2:3000/api',
  apiTimeoutMs: 15000,
};

const production = {
  name: 'production',
  apiBaseUrl: '',
  apiTimeoutMs: 15000,
};

export const env = __DEV__ ? development : production;
