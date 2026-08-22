let volatileSession = null;

export const authStorage = {
  async getSession() {
    return volatileSession;
  },
  async setSession(session) {
    /*
     * Temporary volatile storage. Real authentication credentials must be
     * written to secure native storage once the backend response contract and
     * secure-storage package are finalized.
     */
    volatileSession = session;
  },
  async clearSession() {
    volatileSession = null;
  },
};
