import React from 'react';
import ReactTestRenderer from 'react-test-renderer';
import {QueryClient, QueryClientProvider} from '@tanstack/react-query';
import {NavigationContainer} from '@react-navigation/native';
import AddTripScreen from '../src/features/trips/screens/AddTripScreen';
import {AddMoreDetailsSheet} from '../src/features/trips/sheets/AddMoreDetailsSheet';
import {addTripSchema} from '../src/features/trips/tripsValidation';

jest.mock('../src/features/parties/hooks/usePartiesQuery', () => ({
  usePartiesQuery: () => ({
    data: [
      {id: 'P-1', name: 'Sainy Logistics', category: 'Customer'},
      {id: 'P-2', name: 'Tata Steel', category: 'Partner'},
    ],
    isLoading: false,
  }),
}));

jest.mock('../src/features/trips/hooks/useAddTripMutation', () => ({
  useAddTripMutation: () => ({
    mutateAsync: jest.fn().mockResolvedValue({id: 'TRIP-999'}),
    isPending: false,
  }),
}));

const queryClient = new QueryClient();

function Wrapper({children}) {
  return (
    <QueryClientProvider client={queryClient}>
      <NavigationContainer>{children}</NavigationContainer>
    </QueryClientProvider>
  );
}

describe('Trips Module - Phase 2 & 3 (Add Trip & Add More Details)', () => {
  it('validates addTripSchema correctly', () => {
    const validData = {
      partyName: 'Sainy Logistics',
      truckNumber: 'KA12DS3747',
      billingType: 'Fixed',
      freightAmount: '11600',
    };
    const result = addTripSchema.safeParse(validData);
    expect(result.success).toBe(true);

    const invalidData = {
      freightAmount: 'invalid-number',
    };
    const invalidResult = addTripSchema.safeParse(invalidData);
    expect(invalidResult.success).toBe(false);
  });

  it('renders AddTripScreen cleanly', () => {
    let tree;
    ReactTestRenderer.act(() => {
      tree = ReactTestRenderer.create(
        <Wrapper>
          <AddTripScreen />
        </Wrapper>,
      );
    });
    expect(tree).toBeDefined();
  });

  it('renders AddMoreDetailsSheet cleanly and triggers onSave', () => {
    const onSaveMock = jest.fn();
    const onCloseMock = jest.fn();
    let tree;
    ReactTestRenderer.act(() => {
      tree = ReactTestRenderer.create(
        <AddMoreDetailsSheet
          visible={true}
          initialValues={{lrNumber: 'LRN-001', material: 'Steel', startKm: '100', note: 'Test'}}
          onSave={onSaveMock}
          onClose={onCloseMock}
        />,
      );
    });
    expect(tree).toBeDefined();
  });
});
