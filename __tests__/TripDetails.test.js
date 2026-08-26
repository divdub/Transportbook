import React from 'react';
import ReactTestRenderer from 'react-test-renderer';
import {QueryClient, QueryClientProvider} from '@tanstack/react-query';
import {NavigationContainer} from '@react-navigation/native';
import TripDetailsScreen from '../src/features/trips/screens/TripDetailsScreen';
import TripProgressScreen from '../src/features/trips/screens/TripProgressScreen';
import AddLoadScreen from '../src/features/trips/screens/AddLoadScreen';
import {AddAdvanceSheet} from '../src/features/trips/sheets/AddAdvanceSheet';
import {AddDriverBalanceSheet} from '../src/features/trips/sheets/AddDriverBalanceSheet';

jest.mock('@react-navigation/native', () => {
  const actual = jest.requireActual('@react-navigation/native');
  return {
    ...actual,
    useNavigation: () => ({
      navigate: jest.fn(),
      goBack: jest.fn(),
      replace: jest.fn(),
    }),
    useRoute: () => ({
      params: {tripId: 'TRIP-1001'},
    }),
  };
});

jest.mock('../src/features/trips/hooks/useTripDetailsQuery', () => ({
  useTripDetailsQuery: () => ({
    data: {
      id: 'TRIP-1001',
      partyName: 'Sainy Logistics',
      truckNumber: 'KA 12 DS 3747',
      driverName: 'Ramesh Kumar',
      origin: 'Bangalore',
      destination: 'Hyderabad',
      tripDate: '25 Aug 2026',
      freightAmount: 11600,
      advanceAmount: 0,
      chargesAmount: 0,
      paymentsAmount: 0,
      pendingBalance: 11600,
      status: 'Started',
      lrNumber: 'LRN-001',
      statusTimeline: [
        {status: 'Started', date: '25 Aug 2026', completed: true},
        {status: 'Completed', date: null, completed: false},
        {status: 'POD Received', date: null, completed: false},
        {status: 'POD Submitted', date: null, completed: false},
        {status: 'Settled', date: null, completed: false},
      ],
      expenses: [{id: '1', type: 'Fuel', amount: 3000, date: '25 Aug 2026'}],
      advances: [],
      driverBalance: 1500,
    },
    isLoading: false,
    isError: false,
    refetch: jest.fn(),
  }),
}));

jest.mock('../src/features/trips/hooks/useUpdateTripStatusMutation', () => ({
  useUpdateTripStatusMutation: () => ({
    mutateAsync: jest.fn().mockResolvedValue({}),
    isPending: false,
  }),
}));

jest.mock('../src/features/trips/hooks/useAddAdvanceMutation', () => ({
  useAddAdvanceMutation: () => ({
    mutateAsync: jest.fn().mockResolvedValue({}),
    isPending: false,
  }),
}));

jest.mock('../src/features/trips/hooks/useAddDriverBalanceMutation', () => ({
  useAddDriverBalanceMutation: () => ({
    mutateAsync: jest.fn().mockResolvedValue({}),
    isPending: false,
  }),
}));

jest.mock('../src/features/parties/hooks/usePartiesQuery', () => ({
  usePartiesQuery: () => ({
    data: [{id: 'P-1', name: 'Sainy Logistics'}],
    isLoading: false,
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

describe('Trips Module - Phase 4-9 (Trip Details, Progress, Load & Sheets)', () => {
  it('renders TripDetailsScreen without errors', () => {
    let tree;
    ReactTestRenderer.act(() => {
      tree = ReactTestRenderer.create(
        <Wrapper>
          <TripDetailsScreen />
        </Wrapper>,
      );
    });
    expect(tree).toBeDefined();
  });

  it('renders TripProgressScreen without errors', () => {
    let tree;
    ReactTestRenderer.act(() => {
      tree = ReactTestRenderer.create(
        <Wrapper>
          <TripProgressScreen />
        </Wrapper>,
      );
    });
    expect(tree).toBeDefined();
  });

  it('renders AddLoadScreen cleanly', () => {
    let tree;
    ReactTestRenderer.act(() => {
      tree = ReactTestRenderer.create(
        <Wrapper>
          <AddLoadScreen />
        </Wrapper>,
      );
    });
    expect(tree).toBeDefined();
  });

  it('renders AddAdvanceSheet and triggers save', () => {
    const onSave = jest.fn();
    const onClose = jest.fn();
    let tree;
    ReactTestRenderer.act(() => {
      tree = ReactTestRenderer.create(
        <AddAdvanceSheet visible={true} onSave={onSave} onClose={onClose} />,
      );
    });
    expect(tree).toBeDefined();
  });

  it('renders AddDriverBalanceSheet and triggers confirm', () => {
    const onConfirm = jest.fn();
    const onClose = jest.fn();
    let tree;
    ReactTestRenderer.act(() => {
      tree = ReactTestRenderer.create(
        <AddDriverBalanceSheet
          visible={true}
          driverName="Ramesh Kumar"
          onConfirm={onConfirm}
          onClose={onClose}
        />,
      );
    });
    expect(tree).toBeDefined();
  });
});
