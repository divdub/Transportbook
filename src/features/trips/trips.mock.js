import {addReceivablesFromTrip} from '../dashboard/dashboard.mock';

const delay = ms => new Promise(resolve => setTimeout(resolve, ms));

let mockTrips = [
  {
    id: 'TRIP-1001',
    partyName: 'Sainy Logistics',
    truckNumber: 'KA 12 DS 3747',
    driverName: 'Ramesh Kumar',
    driverPhone: '9876543210',
    origin: 'Bangalore',
    destination: 'Hyderabad',
    tripDate: '25 Aug 2026',
    billingType: 'Fixed',
    freightAmount: 11600,
    advanceAmount: 0,
    chargesAmount: 0,
    paymentsAmount: 0,
    pendingBalance: 11600,
    lrNumber: 'LRN-001',
    material: 'Industrial Goods',
    startKm: '45,200',
    status: 'Started', // Started | Completed | POD Received | POD Submitted | Settled
    notes: 'Urgent delivery required by 26th Aug noon.',
    statusTimeline: [
      {status: 'Started', date: '25 Aug 2026', completed: true, podUrl: null},
      {status: 'Completed', date: null, completed: false, podUrl: null},
      {status: 'POD Received', date: null, completed: false, podUrl: null},
      {status: 'POD Submitted', date: null, completed: false, podUrl: null},
      {status: 'Settled', date: null, completed: false, podUrl: null},
    ],
    expenses: [],
    advances: [],
    driverBalance: 0,
  },
  {
    id: 'TRIP-1002',
    partyName: 'Tata Steel Ltd',
    truckNumber: 'MH 04 AB 8821',
    driverName: 'Suresh Patil',
    driverPhone: '9822334455',
    origin: 'Jamshedpur',
    destination: 'Pune',
    tripDate: '24 Aug 2026',
    billingType: 'Per Tonne',
    freightAmount: 48500,
    advanceAmount: 15000,
    chargesAmount: 2000,
    paymentsAmount: 0,
    pendingBalance: 35500,
    lrNumber: 'LRN-002',
    material: 'Steel Coils (22T)',
    startKm: '68,140',
    status: 'POD Received',
    notes: 'POD received from driver on WhatsApp.',
    statusTimeline: [
      {status: 'Started', date: '20 Aug 2026', completed: true, podUrl: null},
      {status: 'Completed', date: '23 Aug 2026', completed: true, podUrl: null},
      {status: 'POD Received', date: '24 Aug 2026', completed: true, podUrl: 'https://placehold.co/400x600/png?text=POD+Image'},
      {status: 'POD Submitted', date: null, completed: false, podUrl: null},
      {status: 'Settled', date: null, completed: false, podUrl: null},
    ],
    expenses: [
      {id: 'EXP-1', type: 'Diesel', amount: 18000, date: '21 Aug 2026'},
      {id: 'EXP-2', type: 'Toll', amount: 3200, date: '22 Aug 2026'},
    ],
    advances: [
      {id: 'ADV-1', amount: 15000, paymentMode: 'UPI', date: '20 Aug 2026', receivedByDriver: true},
    ],
    driverBalance: 2500,
  },
  {
    id: 'TRIP-1003',
    partyName: 'Reliance Retail',
    truckNumber: 'GJ 01 XX 4410',
    driverName: 'Vikram Singh',
    driverPhone: '9711223344',
    origin: 'Ahmedabad',
    destination: 'Mumbai',
    tripDate: '23 Aug 2026',
    billingType: 'Fixed',
    freightAmount: 24000,
    advanceAmount: 10000,
    chargesAmount: 1500,
    paymentsAmount: 15500,
    pendingBalance: 0,
    lrNumber: 'LRN-003',
    material: 'FMCG Packaged Goods',
    startKm: '12,500',
    status: 'Settled',
    notes: 'Full payment received via NEFT.',
    statusTimeline: [
      {status: 'Started', date: '18 Aug 2026', completed: true, podUrl: null},
      {status: 'Completed', date: '20 Aug 2026', completed: true, podUrl: null},
      {status: 'POD Received', date: '21 Aug 2026', completed: true, podUrl: 'https://placehold.co/400x600/png?text=POD'},
      {status: 'POD Submitted', date: '22 Aug 2026', completed: true, podUrl: 'https://placehold.co/400x600/png?text=POD'},
      {status: 'Settled', date: '23 Aug 2026', completed: true, podUrl: null},
    ],
    expenses: [
      {id: 'EXP-3', type: 'Diesel', amount: 7500, date: '18 Aug 2026'},
      {id: 'EXP-4', type: 'Driver Bhatta', amount: 1500, date: '19 Aug 2026'},
    ],
    advances: [
      {id: 'ADV-2', amount: 10000, paymentMode: 'Bank Transfer', date: '18 Aug 2026', receivedByDriver: false},
    ],
    driverBalance: 0,
  },
  {
    id: 'TRIP-1004',
    partyName: 'Ultratech Cement',
    truckNumber: 'DL 01 AA 9021',
    driverName: 'Manoj Yadav',
    driverPhone: '9988776655',
    origin: 'Jaipur',
    destination: 'Delhi NCR',
    tripDate: '24 Aug 2026',
    billingType: 'Per Tonne',
    freightAmount: 32000,
    advanceAmount: 10000,
    chargesAmount: 0,
    paymentsAmount: 0,
    pendingBalance: 22000,
    lrNumber: 'LRN-004',
    material: 'Cement Bags (30T)',
    startKm: '31,800',
    status: 'Completed',
    notes: 'Unloading completed at Okhla yard.',
    statusTimeline: [
      {status: 'Started', date: '23 Aug 2026', completed: true, podUrl: null},
      {status: 'Completed', date: '24 Aug 2026', completed: true, podUrl: null},
      {status: 'POD Received', date: null, completed: false, podUrl: null},
      {status: 'POD Submitted', date: null, completed: false, podUrl: null},
      {status: 'Settled', date: null, completed: false, podUrl: null},
    ],
    expenses: [
      {id: 'EXP-5', type: 'Diesel', amount: 11000, date: '23 Aug 2026'},
    ],
    advances: [
      {id: 'ADV-3', amount: 10000, paymentMode: 'UPI', date: '23 Aug 2026', receivedByDriver: true},
    ],
    driverBalance: 1200,
  },
  {
    id: 'TRIP-1005',
    partyName: 'Ambuja Logistics',
    truckNumber: 'RJ 14 GB 1290',
    driverName: 'Deepak Sharma',
    driverPhone: '9811224466',
    origin: 'Kota',
    destination: 'Indore',
    tripDate: '22 Aug 2026',
    billingType: 'Fixed',
    freightAmount: 18500,
    advanceAmount: 5000,
    chargesAmount: 1000,
    paymentsAmount: 0,
    pendingBalance: 14500,
    lrNumber: 'LRN-005',
    material: 'Fertilizers',
    startKm: '88,900',
    status: 'POD Submitted',
    notes: 'Original physical POD submitted to customer branch office.',
    statusTimeline: [
      {status: 'Started', date: '20 Aug 2026', completed: true, podUrl: null},
      {status: 'Completed', date: '21 Aug 2026', completed: true, podUrl: null},
      {status: 'POD Received', date: '22 Aug 2026', completed: true, podUrl: 'https://placehold.co/400x600/png?text=POD'},
      {status: 'POD Submitted', date: '22 Aug 2026', completed: true, podUrl: 'https://placehold.co/400x600/png?text=POD'},
      {status: 'Settled', date: null, completed: false, podUrl: null},
    ],
    expenses: [
      {id: 'EXP-6', type: 'Diesel', amount: 6200, date: '20 Aug 2026'},
      {id: 'EXP-7', type: 'Toll', amount: 1400, date: '21 Aug 2026'},
    ],
    advances: [
      {id: 'ADV-4', amount: 5000, paymentMode: 'Cash', date: '20 Aug 2026', receivedByDriver: true},
    ],
    driverBalance: 800,
  },
];

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
