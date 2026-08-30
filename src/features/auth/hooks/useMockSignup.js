import {useState} from 'react';
import {useAuthStore} from '../../../store/authStore';
import {mockSignup} from '../auth.mock';

export function useMockSignup() {
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [errorMessage, setErrorMessage] = useState('');
  const completeMockAuthentication = useAuthStore(state => state.completeMockAuthentication);

  const signup = async ({username, email, password}) => {
    setIsSubmitting(true);
    setErrorMessage('');
    try {
      const session = await mockSignup({username, email, password});
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