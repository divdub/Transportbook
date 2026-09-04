import {tripsApi} from '../trips/trips.api';

const delay = ms => new Promise(resolve => setTimeout(resolve, ms));

let mockDashboardState = {
  user: {name: 'Rajesh'},
  overview: {
    receivables: 0,
    trucks: 9,
    parties: 18,
    pendingPods: 5,
  },
  fleetPerformance: {
    utilization: '78%',
    fuelEfficiency: '8.7 mpg',
    onTimeRate: '92%',
    idleTime: '1h 12m',
  },
  topDriver: {name: 'Lukas Weber', label: 'Top driver', rating: '9.7'},
  serviceAlert: {vehicleCount: 4, label: 'Needing service'},
};

export const mockFetchDashboard = async () => {
  await delay(200);
  let activeTrips = 0;
  try {
    const trips = await tripsApi.getTrips({});
    activeTrips = trips.filter(t => t.status !== 'Settled').length;
  } catch {
    activeTrips = 0;
  }
  return {
    ...mockDashboardState,
    overview: {...mockDashboardState.overview, activeTrips},
  };
};

export const addReceivablesFromTrip = freightAmount => {
  const amount = Number(freightAmount) || 0;
  mockDashboardState.overview.receivables += amount;
};
