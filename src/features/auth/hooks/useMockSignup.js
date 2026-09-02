import {useState} from 'react';
import {useAuthStore} from '../../../store/authStore';
import {authApi} from '../auth.api';
import {mockSignup} from '../auth.mock';

export function useMockSignup() {
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [errorMessage, setErrorMessage] = useState('');
  const completeMockAuthentication = useAuthStore(state => state.completeMockAuthentication);

  const signup = async ({username, email, password}) => {
    setIsSubmitting(true);
    setErrorMessage('');
    try {
      let session;
      try {
        const res = await authApi.register({name: username, email, password});
        session = {
          accessToken: res.token || res.access_token || res.data?.token || 'api-token-placeholder',
          user: res.user || res.data?.user || {username, email},
        };
      } catch {
        session = await mockSignup({username, email, password});
      }
      await completeMockAuthentication(session);
    } catch (error) {
      setErrorMessage(error?.message || 'Unable to sign up.');
      throw error;
    } finally {
      setIsSubmitting(false);
    }
  };

  return {signup, isSubmitting, errorMessage};
}