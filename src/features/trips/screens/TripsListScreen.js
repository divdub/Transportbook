import React, {useMemo, useState} from 'react';
import {
  ActivityIndicator,
  FlatList,
  StyleSheet,
  TextInput,
  TouchableOpacity,
  View,
} from 'react-native';
import {useNavigation} from '@react-navigation/native';
import Icon from 'react-native-vector-icons/MaterialCommunityIcons';
import {AppButton} from '../../../components/common/AppButton';
import {AppScreen} from '../../../components/common/AppScreen';
import {AppText} from '../../../components/common/AppText';
import {EmptyState} from '../../../components/common/EmptyState';
import {TripCard} from '../components/TripCard';
import {TripStatusFilter} from '../components/TripStatusFilter';
import {useTripsQuery} from '../hooks/useTripsQuery';
import {usePartiesQuery} from '../../parties/hooks/usePartiesQuery';
import {useTrucksQuery} from '../../trucks/hooks/useTrucksQuery';
import {useDriversQuery} from '../../drivers/hooks/useDriversQuery';
import {useCitiesQuery} from '../../cities/hooks/useCitiesQuery';
import {routes} from '../../../navigation/routeNames';
import {colors, radius, spacing} from '../../../theme';

export default function TripsListScreen() {
  const navigation = useNavigation();
  const {data: trips, isLoading, isError, refetch, isRefetching} = useTripsQuery();
  const {data: parties = []} = usePartiesQuery();
  const {data: trucks = []} = useTrucksQuery();
  const {data: drivers = []} = useDriversQuery();
  const {data: cities = []} = useCitiesQuery();
  const [search, setSearch] = useState('');
  const [selectedStatus, setSelectedStatus] = useState('All');

  // Backend trips return integer FKs (partyid/truckid/driverid) but not the
  // display names, so join the reference lists loaded by the shared hooks.
  const enrichedTrips = useMemo(() => {
    if (!trips) return [];
    const partyById = new Map(parties.map(p => [String(p.id), p.name]));
    const truckById = new Map(trucks.map(t => [String(t.id), t.vehicleNumber]));
    const driverById = new Map(drivers.map(d => [String(d.id), d.drivername]));
    const cityById = new Map(cities.map(c => [String(c.id), c.name]));
    return trips.map(trip => ({
      ...trip,
      partyName:
        trip.partyName ||
        (trip.partyId && partyById.get(trip.partyId)) ||
        'No Party',
      truckNumber:
        trip.truckNumber ||
        (trip.truckId && truckById.get(trip.truckId)) ||
        'Unassigned',
      driverName:
        trip.driverName ||
        (trip.driverId && driverById.get(trip.driverId)) ||
        'Unassigned',
      origin:
        trip.origin ||
        (trip.originId && cityById.get(trip.originId)) ||
        'Origin',
      destination:
        trip.destination ||
        (trip.destinationId && cityById.get(trip.destinationId)) ||
        'Destination',
    }));
  }, [trips, parties, trucks, drivers, cities]);

  // Compute status counts for filter pills
  const statusCounts = useMemo(() => {
    if (!enrichedTrips) return {};
    const counts = {All: enrichedTrips.length};
    enrichedTrips.forEach(trip => {
      counts[trip.status] = (counts[trip.status] || 0) + 1;
    });
    return counts;
  }, [enrichedTrips]);

  // Compute high-level financial summary
  const summaryStats = useMemo(() => {
    if (!enrichedTrips || enrichedTrips.length === 0) {
      return {totalFreight: 0, activeTrips: 0, pendingBalance: 0};
    }
    const totalFreight = enrichedTrips.reduce((acc, t) => acc + (t.freightAmount || 0), 0);
    const pendingBalance = enrichedTrips.reduce((acc, t) => acc + (t.pendingBalance || 0), 0);
    const activeTrips = enrichedTrips.filter(t => t.status !== 'Settled').length;
    return {totalFreight, activeTrips, pendingBalance};
  }, [enrichedTrips]);

  // Filter trips based on search query and selected status
  const filteredTrips = useMemo(() => {
    if (!enrichedTrips) return [];
    let result = enrichedTrips;

    if (selectedStatus !== 'All') {
      result = result.filter(t => t.status === selectedStatus);
    }

    if (search.trim()) {
      const q = search.trim().toLowerCase();
      result = result.filter(
        t =>
          (t.partyName && t.partyName.toLowerCase().includes(q)) ||
          (t.truckNumber && t.truckNumber.toLowerCase().includes(q)) ||
          (t.origin && t.origin.toLowerCase().includes(q)) ||
          (t.destination && t.destination.toLowerCase().includes(q)) ||
          (t.lrNumber && t.lrNumber.toLowerCase().includes(q)) ||
          (t.driverName && t.driverName.toLowerCase().includes(q)),
      );
    }

    return result;
  }, [enrichedTrips, selectedStatus, search]);

  const handleTripPress = tripId => {
    navigation.navigate(routes.tripDetails, {tripId});
  };

  const handleCreateTrip = () => {
    navigation.navigate(routes.addTrip);
  };

  return (
    <AppScreen scroll={false} style={styles.screen} contentStyle={styles.screenContent}>
      {/* Header */}
      <View style={styles.header}>
        <View>
          <AppText variant="heading" style={styles.title}>
            Trips
          </AppText>
          <AppText variant="caption" color="textMuted">
            {trips ? `${trips.length} Total Trips • ${summaryStats.activeTrips} On Road` : 'Fleet movements'}
          </AppText>
        </View>
        <TouchableOpacity
          style={styles.headerActionBtn}
          onPress={handleCreateTrip}
          accessibilityLabel="Add Trip">
          <Icon name="plus" size={18} color={colors.surface} />
          <AppText variant="label" style={styles.headerActionText}>
            New Trip
          </AppText>
        </TouchableOpacity>
      </View>

      {/* Summary Stat Banner */}
      <View style={styles.summaryBanner}>
        <View style={styles.statItem}>
          <AppText variant="caption" color="textMuted">
            Total Freight
          </AppText>
          <AppText variant="label" style={styles.statValue}>
            ₹{summaryStats.totalFreight.toLocaleString('en-IN')}
          </AppText>
        </View>
        <View style={styles.statDivider} />
        <View style={styles.statItem}>
          <AppText variant="caption" color="textMuted">
            Active Trips
          </AppText>
          <AppText variant="label" style={[styles.statValue, {color: colors.primary}]}>
            {summaryStats.activeTrips}
          </AppText>
        </View>
        <View style={styles.statDivider} />
        <View style={styles.statItem}>
          <AppText variant="caption" color="textMuted">
            Pending Balance
          </AppText>
          <AppText variant="label" style={[styles.statValue, {color: colors.danger}]}>
            ₹{summaryStats.pendingBalance.toLocaleString('en-IN')}
          </AppText>
        </View>
      </View>

      {/* Search Bar */}
      <View style={styles.searchBarContainer}>
        <View style={styles.searchField}>
          <Icon name="magnify" size={20} color={colors.textMuted} />
          <TextInput
            value={search}
            onChangeText={setSearch}
            placeholder="Search party, truck, route, LR..."
            placeholderTextColor={colors.textMuted}
            style={styles.searchInput}
            returnKeyType="search"
          />
          {search ? (
            <TouchableOpacity
              onPress={() => setSearch('')}
              accessibilityLabel="Clear search">
              <Icon name="close-circle" size={18} color={colors.textMuted} />
            </TouchableOpacity>
          ) : null}
        </View>
      </View>

      {/* Status Filter Chips */}
      <TripStatusFilter
        selectedStatus={selectedStatus}
        onSelectStatus={setSelectedStatus}
        counts={statusCounts}
      />

      {/* Content: List / Loading / Error / Empty */}
      {isLoading ? (
        <View style={styles.centerMessage}>
          <ActivityIndicator size="large" color={colors.primary} />
          <AppText variant="body" color="textMuted" style={styles.loadingText}>
            Loading trips...
          </AppText>
        </View>
      ) : isError ? (
        <View style={styles.centerMessage}>
          <Icon name="alert-circle-outline" size={40} color={colors.danger} />
          <AppText variant="body" color="danger">
            Couldn't load trips.
          </AppText>
          <AppButton title="Retry" onPress={() => refetch()} style={styles.actionBtn} />
        </View>
      ) : filteredTrips.length === 0 ? (
        <EmptyState
          title={
            search
              ? 'No trips found'
              : selectedStatus !== 'All'
              ? `No ${selectedStatus} trips`
              : 'No trips yet'
          }
          message={
            search
              ? 'No trips match your search.'
              : selectedStatus !== 'All'
              ? `No ${selectedStatus} trips found.`
              : 'No trips created yet. Start with your first trip.'
          }
          actionLabel={search ? 'Clear Search' : 'Create First Trip'}
          onAction={search ? () => setSearch('') : handleCreateTrip}
        />
      ) : (
        <FlatList
          data={filteredTrips}
          keyExtractor={item => item.id}
          onRefresh={refetch}
          refreshing={isRefetching}
          renderItem={({item}) => (
            <TripCard trip={item} onPress={() => handleTripPress(item.id)} />
          )}
          contentContainerStyle={styles.listContent}
          style={styles.list}
          showsVerticalScrollIndicator={false}
        />
      )}
    </AppScreen>
  );
}

const styles = StyleSheet.create({
  screen: {
    flex: 1,
    backgroundColor: colors.background,
  },
  screenContent: {
    flex: 1,
    padding: 0,
  },
  header: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingHorizontal: spacing.md,
    paddingTop: spacing.sm,
    paddingBottom: spacing.xs,
  },
  title: {
    fontSize: 22,
    fontWeight: '700',
    color: colors.text,
  },
  headerActionBtn: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 4,
    backgroundColor: colors.primary,
    paddingHorizontal: spacing.md,
    paddingVertical: 7,
    borderRadius: radius.md,
  },
  headerActionText: {
    color: colors.surface,
    fontWeight: '600',
    fontSize: 13,
  },
  summaryBanner: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    backgroundColor: colors.surface,
    marginHorizontal: spacing.md,
    marginVertical: spacing.xs,
    paddingVertical: spacing.sm,
    paddingHorizontal: spacing.md,
    borderRadius: radius.md,
    borderWidth: 1,
    borderColor: colors.border,
  },
  statItem: {
    flex: 1,
    alignItems: 'center',
    gap: 2,
  },
  statValue: {
    fontWeight: '700',
    fontSize: 13,
    color: colors.text,
  },
  statDivider: {
    width: 1,
    height: 24,
    backgroundColor: colors.border,
  },
  searchBarContainer: {
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.xs,
  },
  searchField: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: spacing.sm,
    backgroundColor: colors.surface,
    borderWidth: 1,
    borderColor: colors.border,
    borderRadius: radius.md,
    paddingHorizontal: spacing.md,
    height: 44,
  },
  searchInput: {
    flex: 1,
    color: colors.text,
    padding: 0,
    fontSize: 13,
  },
  centerMessage: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
    gap: spacing.md,
    paddingHorizontal: spacing.xl,
    paddingVertical: spacing['3xl'],
  },
  loadingText: {
    marginTop: spacing.xs,
  },
  actionBtn: {
    minWidth: 160,
    marginTop: spacing.xs,
  },
  list: {
    flex: 1,
  },
  listContent: {
    paddingTop: spacing.xs,
    paddingBottom: spacing.xl,
  },
});
