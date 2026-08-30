import {useQuery} from '@tanstack/react-query';
import {trucksApi} from '../trucks.api';

export const TRUCKS_QUERY_KEY = ['trucks'];

export function useTrucksQuery(params = {}) {
  return useQuery({
    queryKey: [...TRUCKS_QUERY_KEY, params],
    queryFn: () => trucksApi.getTrucks(params),
  });
}
