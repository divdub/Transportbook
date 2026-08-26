import {useQuery} from '@tanstack/react-query';
import {mockFetchTripById} from '../trips.mock';

export function useTripDetailsQuery(tripId) {
  return useQuery({
    queryKey: ['trip', tripId],
    queryFn: () => mockFetchTripById(tripId),
    enabled: Boolean(tripId),
  });
}
