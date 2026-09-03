import {useState} from 'react';
import {useAuthStore} from '../../../store/authStore';
import {authApi} from '../auth.api';
import {mockLogin} from '../auth.mock';

export function useMockLogin() {
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [errorMessage, setErrorMessage] = useState('');
  const completeMockAuthentication = useAuthStore(state => state.completeMockAuthentication);

  const login = async ({emailOrMobile, email, password}) => {
    setIsSubmitting(true);
    setErrorMessage('');
    try {
      let session;
      try {
        const identifier = emailOrMobile || email;
        const res = await authApi.login({login: identifier, password});
        const token = res.data?.token || res.token || res.access_token;
        const user = res.data || res.user || {login: identifier, username: identifier};
        if (!token) {
          throw new Error(res.message || 'Invalid email/mobile or password');
        }
        // The login response does not include companyid, so fetch the current
        // user (GET /user returns the full user incl. companyid) to decide
        // whether Business Setup is still required. The token is passed
        // explicitly because the session (and its stored token) is not saved
        // until completeMockAuthentication runs below.
        let companyid = user.companyid;
        if (companyid == null) {
          try {
            const current = await authApi.getCurrentUser(token);
            const cu = current?.data || current;
            if (cu && cu.companyid != null) {
              companyid = cu.companyid;
              user.companyid = cu.companyid;
            }
          } catch {
            // Cannot reach /user; fall back to the login payload's flags.
          }
        }
        const onboarded = companyid != null;
        session = {
          accessToken: token,
          user: user,
          onboarded,
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
