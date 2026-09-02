import {useMutation, useQueryClient} from '@tanstack/react-query';
import {tripsApi} from '../trips.api';

export function useAddAdvanceMutation() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: ({id, ...data}) => tripsApi.addAdvance(id, data),
    onSuccess: (_, variables) => {
      queryClient.invalidateQueries({queryKey: ['trips']});
      queryClient.invalidateQueries({queryKey: ['trip', variables.id]});
    },
  });
}

