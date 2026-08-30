import {useMutation, useQueryClient} from '@tanstack/react-query';
import {mockCreateTrip} from '../trips.mock';

export function useAddTripMutation() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: mockCreateTrip,
    onSuccess: () => {
      queryClient.invalidateQueries({queryKey: ['trips']});
      queryClient.invalidateQueries({queryKey: ['dashboard']});
    },
  });
}
