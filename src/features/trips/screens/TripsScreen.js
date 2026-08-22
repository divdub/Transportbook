import React from 'react';
import {EmptyState} from '../../../components/common/EmptyState';
import {AppHeader} from '../../../components/common/AppHeader';
import {AppScreen} from '../../../components/common/AppScreen';

export default function TripsScreen() {
  return (
    <AppScreen>
      <AppHeader
        title="Trips"
        subtitle="The trip lifecycle will be implemented after the foundation and API contract."
      />
      <EmptyState
        title="No trips yet"
        message="Create your first trip once the trip API and required fields are finalized."
        actionLabel="Create Trip"
      />
    </AppScreen>
  );
}
