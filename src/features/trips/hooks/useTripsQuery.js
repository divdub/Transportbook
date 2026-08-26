import {useQuery} from '@tanstack/react-query';
import {mockFetchTrips} from '../trips.mock';

export function useTripsQuery() {
  return useQuery({
    queryKey: ['trips'],
    queryFn: mockFetchTrips,
    /**
     * Future Laravel backend flow:
     * queryFn: () => tripsApi.getTrips(),
     */
  });
}
