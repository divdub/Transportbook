import {useState} from 'react';
import {useAuthStore} from '../../../store/authStore';
import {mockLogin} from '../auth.mock';

export function useMockLogin() {
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [errorMessage, setErrorMessage] = useState('');
  const completeMockAuthentication = useAuthStore(state => state.completeMockAuthentication);

  const login = async ({email, password}) => {
    setIsSubmitting(true);
    setErrorMessage('');
    try {
      const session = await mockLogin({email, password});
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