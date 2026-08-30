const delay = ms => new Promise(resolve => setTimeout(resolve, ms));

let mockDashboardState = {
  user: {name: 'Rajesh'},
  overview: {
    activeTrips: 12,
    receivables: 284500,
    trucks: 9,
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
  return {...mockDashboardState, overview: {...mockDashboardState.overview}};
};

export const addReceivablesFromTrip = freightAmount => {
  const amount = Number(freightAmount) || 0;
  mockDashboardState.overview.receivables += amount;
  mockDashboardState.overview.activeTrips += 1;
};
