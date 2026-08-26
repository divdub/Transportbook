import {useMutation, useQueryClient} from '@tanstack/react-query';
import {mockAddDriverBalance} from '../trips.mock';

export function useAddDriverBalanceMutation() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: mockAddDriverBalance,
    onSuccess: (_, variables) => {
      queryClient.invalidateQueries({queryKey: ['trips']});
      queryClient.invalidateQueries({queryKey: ['trip', variables.id]});
    },
  });
}
