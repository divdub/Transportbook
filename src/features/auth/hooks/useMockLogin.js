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
        const res = await authApi.login({login: email, password});
        const token = res.data?.token || res.token || res.access_token;
        const user = res.data || res.user || {email, username: email};
        if (!token) {
          throw new Error(res.message || 'Invalid email/mobile or password');
        }
        session = {
          accessToken: token,
          user: user,
          onboarded: true,
        };
      } catch (apiError) {
        if (apiError.status || apiError.type === 'validation' || apiError.type === 'authentication') {
          setErrorMessage(apiError.message || 'Invalid email/mobile or password');
          return;
        }
        // Fallback to mock login if offline
        session = await mockLogin({email, password});
        session.onboarded = true;
      }
      await completeMockAuthentication(session);
    } catch (error) {
      setErrorMessage(error?.message || 'Unable to log in.');
    } finally {
      setIsSubmitting(false);
    }
  };

  return {login, isSubmitting, errorMessage};
}
