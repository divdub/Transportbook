import {create} from 'zustand';
import {authStorage} from '../services/storage/authStorage';

export const useAuthStore = create((set, get) => ({
  isBootstrapping: true,
  isAuthenticated: false,
  session: null,
  async restoreSession() {
    const session = await authStorage.getSession();
    set({
      session,
      isAuthenticated: Boolean(session),
      isBootstrapping: false,
    });
  },
  async setSession(session) {
    await authStorage.setSession(session);
    set({session, isAuthenticated: Boolean(session)});
  },
  async completeMockAuthentication(mockSession) {
    /*
     * Temporary UI-testing path only.
     * When the backend contract exists, auth hooks will call auth.api.js,
     * normalize the real response into a session, and then call setSession().
     * RootNavigator observes isAuthenticated and switches to AppNavigator.
     */
    await get().setSession(mockSession);
  },
  async logout() {
    await authStorage.clearSession();
    set({session: null, isAuthenticated: false});
  },
  finishBootstrapping() {
    if (get().isBootstrapping) {
      set({isBootstrapping: false});
    }
  },
}));
