import axios from 'axios';
import {env} from '../../config/env';
import {authStorage} from '../storage/authStorage';
import {normalizeApiError} from './errors';

export const apiClient = axios.create({
  baseURL: env.apiBaseUrl,
  timeout: env.apiTimeoutMs,
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  },
});

apiClient.interceptors.request.use(async config => {
  const session = await authStorage.getSession();

  if (session?.accessToken) {
    config.headers.Authorization = `Bearer ${session.accessToken}`;
  }

  return config;
});

apiClient.interceptors.response.use(
  response => response,
  error => Promise.reject(normalizeApiError(error)),
);
