import {useMutation, useQueryClient} from '@tanstack/react-query';
import {tripsApi} from '../trips.api';

export function useAddChargeMutation() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: ({id, ...data}) => tripsApi.addCharge(id, data),
    onSuccess: (_, variables) => {
      const {id, ...data} = variables;
      // The trip-detail endpoint may not return a charges array, so append the
      // newly created charge to the cached trip to keep the Party tab Charges
      // line items in sync without depending on a refetch.
      queryClient.setQueryData(['trip', id], old => {
        if (!old) return old;
        const newCharge = {
          id: `charge-${Date.now()}`,
          amount: Number(data.amount) || 0,
          billAdjustment: data.billAdjustment === 'reduce' ? 'reduce' : 'add',
          chargeType: data.chargeType || 'Charge',
          date: data.date || '',
          note: data.note || '',
          cid: data.cid != null ? data.cid : null,
        };
        return {...old, charges: [...(old.charges || []), newCharge]};
      });
      queryClient.invalidateQueries({queryKey: ['trips']});
    },
  });
}
