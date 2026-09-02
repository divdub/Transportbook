import {useQuery} from '@tanstack/react-query';
import {partiesApi} from '../parties.api';

export function usePartiesQuery() {
  return useQuery({
    queryKey: ['parties'],
    queryFn: partiesApi.getParties,
  });
}