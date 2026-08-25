import {useQuery} from '@tanstack/react-query';
import {mockFetchParties} from '../parties.mock';

export function usePartiesQuery() {
  return useQuery({
    queryKey: ['parties'],
    queryFn: mockFetchParties,
    /*
     * Future flow: queryFn will call parties.api.js, which will call
     * services/api/client.js once the backend contract exists.
     */
  });
}