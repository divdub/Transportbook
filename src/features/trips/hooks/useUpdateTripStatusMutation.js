import {useMutation, useQueryClient} from '@tanstack/react-query';
import {mockUpdateTripStatus} from '../trips.mock';

export function useUpdateTripStatusMutation() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: mockUpdateTripStatus,
    onSuccess: (_, variables) => {
      queryClient.invalidateQueries({queryKey: ['trips']});
      queryClient.invalidateQueries({queryKey: ['trip', variables.id]});
    },
  });
}
