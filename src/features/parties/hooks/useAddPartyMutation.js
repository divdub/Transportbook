import {useMutation, useQueryClient} from '@tanstack/react-query';
import {mockCreateParty} from '../parties.mock';

export function useAddPartyMutation() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: mockCreateParty,
    onSuccess: () => {
      queryClient.invalidateQueries({queryKey: ['parties']});
    },
  });
}