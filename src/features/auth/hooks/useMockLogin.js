import {useState} from 'react';
import {useAuthStore} from '../../../store/authStore';
import {authApi} from '../auth.api';
import {mockLogin} from '../auth.mock';

export function useMockLogin() {
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [errorMessage, setErrorMessage] = useState('');
  const completeMockAuthentication = useAuthStore(state => state.completeMockAuthentication);

  const login = async ({email, password}) => {
    setIsSubmitting(true);
    setErrorMessage('');
    try {
      let session;
      try {
        const res = await authApi.login({email, password});
        session = {
          accessToken: res.token || res.access_token || res.data?.token || 'api-token-placeholder',
          user: res.user || res.data?.user || {email, name: email.split('@')[0]},
        };
      } catch {
        session = await mockLogin({email, password});
      }
      await completeMockAuthentication(session);
    } catch (error) {
      setErrorMessage(error?.message || 'Unable to log in.');
      throw error;
    } finally {
      setIsSubmitting(false);
    }
  };

  return {login, isSubmitting, errorMessage};
}