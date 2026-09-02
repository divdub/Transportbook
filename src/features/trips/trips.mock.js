import {addReceivablesFromTrip} from '../dashboard/dashboard.mock';

const delay = ms => new Promise(resolve => setTimeout(resolve, ms));

// In-memory only — resets on app reload. Seed list is empty until real
// trips are created against the backend.
let mockTrips = [];

export const mockFetchTrips = async () => {
  await delay(350);
  return [...mockTrips];
};

export const mockFetchTripById = async id => {
  await delay(250);
  const trip = mockTrips.find(t => t.id === id);
  if (!trip) throw new Error(`Trip with ID ${id} not found.`);
  return {...trip};
};

export const mockCreateTrip = async tripData => {
  await delay(400);
  const freight = Number(tripData.freightAmount) || 0;
  const newTrip = {
    id: `TRIP-${Math.floor(1000 + Math.random() * 9000)}`,
    partyName: tripData.partyName || 'Party Name',
    truckNumber: tripData.truckNumber ? tripData.truckNumber.toUpperCase() : 'KA 01 AA 0000',
    driverName: tripData.driverName || 'Unassigned',
    driverPhone: tripData.driverPhone || null,
    origin: tripData.origin || 'Origin',
    destination: tripData.destination || 'Destination',
    tripDate: tripData.tripStartDate || tripData.tripDate || '25 Aug 2026',
    billingType: tripData.billingType || 'Fixed',
    freightAmount: freight,
    advanceAmount: Number(tripData.advanceAmount) || 0,
    chargesAmount: 0,
    paymentsAmount: 0,
    pendingBalance: freight - (Number(tripData.advanceAmount) || 0),
    lrNumber: tripData.lrNumber || `LRN-${Math.floor(100 + Math.random() * 900)}`,
    material: tripData.material || '',
    startKm: tripData.startKm || '',
    status: 'Started',
    notes: tripData.note || tripData.notes || '',
    statusTimeline: [
      {status: 'Started', date: tripData.tripStartDate || '25 Aug 2026', completed: true, podUrl: null},
      {status: 'Completed', date: null, completed: false, podUrl: null},
      {status: 'POD Received', date: null, completed: false, podUrl: null},
      {status: 'POD Submitted', date: null, completed: false, podUrl: null},
      {status: 'Settled', date: null, completed: false, podUrl: null},
    ],
    expenses: [],
    advances: tripData.advanceAmount ? [{
      id: `ADV-${Date.now()}`,
      amount: Number(tripData.advanceAmount),
      paymentMode: tripData.paymentMode || 'Cash',
      date: tripData.tripStartDate || '25 Aug 2026',
      receivedByDriver: Boolean(tripData.receivedByDriver),
    }] : [],
    driverBalance: 0,
  };

  mockTrips = [newTrip, ...mockTrips];
  addReceivablesFromTrip(freight);
  return newTrip;
};

export const mockUpdateTripStatus = async ({id, status, podUrl}) => {
  await delay(350);
  const index = mockTrips.findIndex(t => t.id === id);
  if (index === -1) throw new Error('Trip not found');

  const trip = mockTrips[index];
  const order = ['Started', 'Completed', 'POD Received', 'POD Submitted', 'Settled'];
  const targetIdx = order.indexOf(status);

  const updatedTimeline = trip.statusTimeline.map((item, idx) => {
    if (idx <= targetIdx) {
      return {
        ...item,
        completed: true,
        date: item.date || '25 Aug 2026',
        podUrl: item.status.includes('POD') && podUrl ? podUrl : item.podUrl,
      };
    }
    return item;
  });

  const updatedTrip = {
    ...trip,
    status,
    statusTimeline: updatedTimeline,
  };

  mockTrips[index] = updatedTrip;
  return updatedTrip;
};

export const mockAddAdvance = async ({id, amount, paymentMode, date, receivedByDriver, note}) => {
  await delay(350);
  const index = mockTrips.findIndex(t => t.id === id);
  if (index === -1) throw new Error('Trip not found');

  const trip = mockTrips[index];
  const advNum = Number(amount) || 0;
  const newAdv = {
    id: `ADV-${Date.now()}`,
    amount: advNum,
    paymentMode: paymentMode || 'Cash',
    date: date || '25 Aug 2026',
    receivedByDriver: Boolean(receivedByDriver),
    note: note || '',
  };

  const updatedAdvances = [...trip.advances, newAdv];
  const totalAdvance = updatedAdvances.reduce((acc, curr) => acc + curr.amount, 0);
  const pendingBalance = Math.max(0, trip.freightAmount + trip.chargesAmount - totalAdvance - trip.paymentsAmount);

  const updatedTrip = {
    ...trip,
    advances: updatedAdvances,
    advanceAmount: totalAdvance,
    pendingBalance,
  };

  mockTrips[index] = updatedTrip;
  return updatedTrip;
};

export const mockAddDriverBalance = async ({id, amount, reason, date, note}) => {
  await delay(350);
  const index = mockTrips.findIndex(t => t.id === id);
  if (index === -1) throw new Error('Trip not found');

  const trip = mockTrips[index];
  const amt = Number(amount) || 0;
  const updatedTrip = {
    ...trip,
    driverBalance: (trip.driverBalance || 0) + amt,
    driverTransactions: [
      ...(trip.driverTransactions || []),
      {id: `DT-${Date.now()}`, amount: amt, reason, date: date || '25 Aug 2026', note},
    ],
  };

  mockTrips[index] = updatedTrip;
  return updatedTrip;
};
