import {useMutation, useQueryClient} from '@tanstack/react-query';
import {mockAddAdvance} from '../trips.mock';

export function useAddAdvanceMutation() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: mockAddAdvance,
    onSuccess: (_, variables) => {
      queryClient.invalidateQueries({queryKey: ['trips']});
      queryClient.invalidateQueries({queryKey: ['trip', variables.id]});
    },
  });
}
