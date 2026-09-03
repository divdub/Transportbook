import React, {useMemo, useState} from 'react';
import {
  FlatList,
  ScrollView,
  StyleSheet,
  TextInput,
  TouchableOpacity,
  View,
} from 'react-native';
import {useNavigation} from '@react-navigation/native';
import Icon from 'react-native-vector-icons/MaterialCommunityIcons';

import {AppScreen} from '../../../components/common/AppScreen';
import {AppText} from '../../../components/common/AppText';
import {useTrucksQuery} from '../hooks/useTrucksQuery';
import {routes} from '../../../navigation/routeNames';
import {colors, radius, spacing} from '../../../theme';

export default function TrucksListScreen() {
  const navigation = useNavigation();
  const {data: trucks = [], isLoading, refetch} = useTrucksQuery();

  const [activeTab, setActiveTab] = useState('trucks'); // 'trucks' | 'documents'
  const [filterType, setFilterType] = useState('all'); // 'all' | 'available' | 'on_trip'
  const [searchQuery, setSearchQuery] = useState('');

  // Calculate counters
  const totalCount = trucks.length;
  const availableCount = trucks.filter(t => t.status === 'available').length;
  const onTripCount = trucks.filter(t => t.status === 'on_trip').length;

  // Filter trucks list
  const filteredTrucks = useMemo(() => {
    return trucks.filter(t => {
      // Filter by tab stat filter
      if (filterType === 'available' && t.status !== 'available') return false;
      if (filterType === 'on_trip' && t.status !== 'on_trip') return false;

      // Filter by search query
      if (searchQuery.trim()) {
        const q = searchQuery.trim().toLowerCase();
        const numMatches = t.vehicleNumber && t.vehicleNumber.toLowerCase().includes(q);
        const ownerMatches = t.ownerName && t.ownerName.toLowerCase().includes(q);
        const driverMatches = t.driverName && t.driverName.toLowerCase().includes(q);
        return numMatches || ownerMatches || driverMatches;
      }
      return true;
    });
  }, [trucks, filterType, searchQuery]);

  return (
    <AppScreen scroll={false} style={styles.container}>
      {/* Header */}
      <View style={styles.header}>
        <TouchableOpacity
          onPress={() => navigation.goBack()}
          style={styles.headerBackBtn}
          accessibilityLabel="Back">
          <Icon name="arrow-left" size={24} color={colors.text} />
        </TouchableOpacity>

        <AppText variant="heading" style={styles.headerTitle}>
          Trucks & Documents
        </AppText>

        <TouchableOpacity style={styles.youtubeBtn} accessibilityLabel="Help Video">
          <Icon name="youtube" size={28} color="#FF0000" />
        </TouchableOpacity>
      </View>

      {/* Main Tabs Header */}
      <View style={styles.tabContainer}>
        <TouchableOpacity
          style={[styles.tabButton, activeTab === 'trucks' && styles.tabButtonActive]}
          onPress={() => setActiveTab('trucks')}
          activeOpacity={0.8}>
          <AppText
            variant="label"
            style={[styles.tabText, activeTab === 'trucks' && styles.tabTextActive]}>
            Trucks
          </AppText>
        </TouchableOpacity>

        <TouchableOpacity
          style={[styles.tabButton, activeTab === 'documents' && styles.tabButtonActive]}
          onPress={() => setActiveTab('documents')}
          activeOpacity={0.8}>
          <View style={styles.docTabContent}>
            <AppText
              variant="label"
              style={[styles.tabText, activeTab === 'documents' && styles.tabTextActive]}>
              Documents
            </AppText>
            <View style={styles.newTag}>
              <AppText variant="caption" style={styles.newTagText}>
                NEW
              </AppText>
            </View>
          </View>
        </TouchableOpacity>
      </View>

      {activeTab === 'trucks' ? (
        <View style={styles.content}>
          {/* Top Metric Cards */}
          <View style={styles.metricsRowContainer}>
            <ScrollView
              horizontal
              showsHorizontalScrollIndicator={false}
              contentContainerStyle={styles.metricsScrollContent}>
              {/* All Trucks Card */}
              <TouchableOpacity
                style={[
                  styles.metricCard,
                  filterType === 'all' && styles.metricCardSelected,
                ]}
                onPress={() => setFilterType('all')}
                activeOpacity={0.7}>
                <AppText
                  variant="caption"
                  color={filterType === 'all' ? 'primary' : 'textMuted'}>
                  All Trucks
                </AppText>
                <AppText variant="heading" style={styles.metricNumber}>
                  {totalCount}
                </AppText>
              </TouchableOpacity>

              {/* Available Trucks Card */}
              <TouchableOpacity
                style={[
                  styles.metricCard,
                  filterType === 'available' && styles.metricCardSelected,
                ]}
                onPress={() => setFilterType('available')}
                activeOpacity={0.7}>
                <AppText
                  variant="caption"
                  style={{color: filterType === 'available' ? colors.primary : '#059669'}}>
                  Available Trucks
                </AppText>
                <AppText variant="heading" style={styles.metricNumber}>
                  {availableCount}
                </AppText>
              </TouchableOpacity>

              {/* Trucks On Trip Card */}
              <TouchableOpacity
                style={[
                  styles.metricCard,
                  filterType === 'on_trip' && styles.metricCardSelected,
                ]}
                onPress={() => setFilterType('on_trip')}
                activeOpacity={0.7}>
                <AppText
                  variant="caption"
                  style={{color: filterType === 'on_trip' ? colors.primary : '#2563EB'}}>
                  Trucks On Trip
                </AppText>
                <AppText variant="heading" style={styles.metricNumber}>
                  {onTripCount}
                </AppText>
              </TouchableOpacity>
            </ScrollView>
          </View>

          {/* Search Bar */}
          <View style={styles.searchSection}>
            <View style={styles.searchBox}>
              <TextInput
                value={searchQuery}
                onChangeText={setSearchQuery}
                placeholder="Search by Truck Number"
                placeholderTextColor={colors.textMuted}
                style={styles.searchInput}
              />
              <Icon name="magnify" size={22} color={colors.textMuted} />
            </View>
          </View>

          {/* Trucks List */}
          <FlatList
            data={filteredTrucks}
            keyExtractor={item => item.id}
            contentContainerStyle={styles.listContainer}
            showsVerticalScrollIndicator={false}
            onRefresh={refetch}
            refreshing={isLoading}
            renderItem={({item}) => {
              const isMarket =
                item.ownership === 'market' ||
                item.ownership === 'Market';
              const isOnTrip = item.status === 'on_trip';
              const routeText = item.activeTrip?.route || (item.activeTrip ? `${item.activeTrip.origin} → ${item.activeTrip.destination}` : null);
              const ownerDriverInfo = item.driverName || item.ownerName ? `${item.driverName || item.ownerName}${item.driverPhone || item.ownerPhone ? ` • ${item.driverPhone || item.ownerPhone}` : ''}` : null;

              return (
                <TouchableOpacity
                  style={styles.truckCard}
                  activeOpacity={0.7}>
                  {/* Top Row: Vehicle Number, Ownership Badge & Status */}
                  <View style={styles.cardHeader}>
                    <View style={styles.vehicleInfoGroup}>
                      <AppText variant="heading" style={styles.vehicleNumber}>
                        {formatVehicleNumber(item.vehicleNumber)}
                      </AppText>

                      {/* Status Dot & Label */}
                      <View style={styles.statusGroup}>
                        <View
                          style={[
                            styles.statusDot,
                            {backgroundColor: isOnTrip ? '#2563EB' : '#16A34A'},
                          ]}
                        />
                        <AppText
                          variant="caption"
                          style={[
                            styles.statusText,
                            {color: isOnTrip ? '#2563EB' : '#16A34A'},
                          ]}>
                          {isOnTrip ? 'On Trip' : 'Available'}
                        </AppText>
                      </View>
                    </View>

                    {/* Chevron Icon */}
                    <Icon name="chevron-right" size={22} color={colors.textMuted} />
                  </View>

                  {/* Bottom Row: Ownership Badge & Details Subtitle */}
                  <View style={styles.cardFooter}>
                    {/* Ownership Badge */}
                    <View
                      style={[
                        styles.ownershipBadge,
                        isMarket ? styles.marketBadge : styles.ownBadge,
                      ]}>
                      <AppText
                        variant="caption"
                        style={styles.ownershipBadgeText}>
                        {isMarket ? 'Market' : 'Own'}
                      </AppText>
                    </View>

                    {/* Subtitle Details: Route or Owner Info */}
                    {routeText ? (
                      <AppText
                        variant="caption"
                        color="textMuted"
                        style={styles.subtext}>
                        {routeText}
                      </AppText>
                    ) : ownerDriverInfo ? (
                      <AppText
                        variant="caption"
                        color="textMuted"
                        style={styles.subtext}>
                        {ownerDriverInfo}
                      </AppText>
                    ) : null}
                  </View>
                </TouchableOpacity>
              );
            }}
            ListEmptyComponent={
              <View style={styles.emptyState}>
                <Icon name="truck-outline" size={48} color={colors.textMuted} />
                <AppText variant="body" color="textMuted" style={{marginTop: spacing.sm}}>
                  No trucks found matching your search.
                </AppText>
              </View>
            }
          />
        </View>
      ) : (
        /* Documents Tab View */
        <View style={styles.documentsContainer}>
          <FlatList
            data={trucks}
            keyExtractor={item => `doc-${item.id}`}
            contentContainerStyle={styles.listContainer}
            renderItem={({item}) => (
              <View style={styles.docTruckCard}>
                <View style={styles.docCardHeader}>
                  <AppText variant="heading" style={styles.vehicleNumber}>
                    {formatVehicleNumber(item.vehicleNumber)}
                  </AppText>
                  <View
                    style={[
                      styles.ownershipBadge,
                      item.ownership === 'market' ? styles.marketBadge : styles.ownBadge,
                    ]}>
                    <AppText style={styles.ownershipBadgeText}>
                      {item.ownership === 'market' ? 'Market' : 'Own'}
                    </AppText>
                  </View>
                </View>
                <AppText variant="caption" color="textMuted" style={{marginTop: 4}}>
                  {(item.documents && item.documents.length) || 0} active documents recorded
                </AppText>
              </View>
            )}
          />
        </View>
      )}

      {/* Floating Add Trip / Add Truck Button */}
      <View style={styles.fabContainer}>
        <TouchableOpacity
          style={styles.fabButton}
          activeOpacity={0.85}
          onPress={() => navigation.navigate(routes.addTrip)}>
          <Icon name="plus" size={22} color="#FFFFFF" />
          <AppText variant="label" style={styles.fabText}>
            ADD TRUCK
          </AppText>
        </TouchableOpacity>
      </View>
    </AppScreen>
  );
}

/** Helper to format KA 12 DS 3747 into styled parts */
function formatVehicleNumber(numStr) {
  if (!numStr) return '';
  const parts = numStr.trim().split(' ');
  if (parts.length >= 4) {
    return `${parts[0]} ${parts[1]} ${parts[2]} ${parts[3]}`;
  }
  return numStr;
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#F8FAFC',
  },
  header: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.md,
    backgroundColor: '#FFFFFF',
  },
  headerBackBtn: {
    padding: spacing.xs,
  },
  headerTitle: {
    fontSize: 18,
    fontWeight: '700',
    color: colors.text,
  },
  youtubeBtn: {
    padding: spacing.xs,
  },
  tabContainer: {
    flexDirection: 'row',
    backgroundColor: '#FFFFFF',
    borderBottomWidth: 1,
    borderBottomColor: colors.border,
  },
  tabButton: {
    flex: 1,
    paddingVertical: spacing.md,
    alignItems: 'center',
    justifyContent: 'center',
    borderBottomWidth: 3,
    borderBottomColor: 'transparent',
  },
  tabButtonActive: {
    borderBottomColor: '#2563EB',
  },
  tabText: {
    fontSize: 15,
    fontWeight: '600',
    color: colors.textMuted,
  },
  tabTextActive: {
    color: '#2563EB',
    fontWeight: '700',
  },
  docTabContent: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 6,
  },
  newTag: {
    backgroundColor: '#16A34A',
    paddingHorizontal: 5,
    paddingVertical: 2,
    borderRadius: 4,
  },
  newTagText: {
    color: '#FFFFFF',
    fontSize: 9,
    fontWeight: '800',
  },
  content: {
    flex: 1,
  },
  metricsRowContainer: {
    paddingVertical: spacing.md,
  },
  metricsScrollContent: {
    paddingHorizontal: spacing.md,
    gap: spacing.sm,
  },
  metricCard: {
    width: 120,
    backgroundColor: '#FFFFFF',
    borderRadius: radius.md,
    padding: spacing.sm + 2,
    borderWidth: 1.5,
    borderColor: '#E2E8F0',
    justifyContent: 'center',
  },
  metricCardSelected: {
    borderColor: '#2563EB',
    backgroundColor: '#EFF6FF',
  },
  metricNumber: {
    fontSize: 18,
    fontWeight: '800',
    marginTop: 4,
    color: colors.text,
  },
  searchSection: {
    paddingHorizontal: spacing.md,
    marginBottom: spacing.md,
  },
  searchBox: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#FFFFFF',
    borderWidth: 1,
    borderColor: '#CBD5E1',
    borderRadius: radius.md,
    paddingHorizontal: spacing.md,
    height: 48,
  },
  searchInput: {
    flex: 1,
    fontSize: 14,
    color: colors.text,
  },
  listContainer: {
    paddingHorizontal: spacing.md,
    paddingBottom: 80,
    gap: spacing.sm + 2,
  },
  truckCard: {
    backgroundColor: '#FFFFFF',
    borderRadius: radius.md,
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.md,
    borderWidth: 1,
    borderColor: '#E2E8F0',
    shadowColor: '#000',
    shadowOffset: {width: 0, height: 1},
    shadowOpacity: 0.03,
    shadowRadius: 4,
    elevation: 1,
  },
  cardHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
  },
  vehicleInfoGroup: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: spacing.md,
  },
  vehicleNumber: {
    fontSize: 16,
    fontWeight: '800',
    color: '#0F172A',
    letterSpacing: 0.2,
  },
  statusGroup: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 4,
  },
  statusDot: {
    width: 7,
    height: 7,
    borderRadius: 3.5,
  },
  statusText: {
    fontSize: 12,
    fontWeight: '600',
  },
  cardFooter: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginTop: spacing.sm,
  },
  ownershipBadge: {
    paddingHorizontal: spacing.sm + 2,
    paddingVertical: 3,
    borderRadius: 4,
  },
  ownBadge: {
    backgroundColor: '#2563EB', // Blue for Own truck
  },
  marketBadge: {
    backgroundColor: '#EA580C', // Orange for Market truck
  },
  ownershipBadgeText: {
    color: '#FFFFFF',
    fontSize: 11,
    fontWeight: '700',
  },
  subtext: {
    fontSize: 12,
  },
  emptyState: {
    alignItems: 'center',
    justifyContent: 'center',
    paddingVertical: 40,
  },
  documentsContainer: {
    flex: 1,
    paddingTop: spacing.md,
  },
  docTruckCard: {
    backgroundColor: '#FFFFFF',
    borderRadius: radius.md,
    padding: spacing.md,
    borderWidth: 1,
    borderColor: '#E2E8F0',
  },
  docCardHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
  },
  fabContainer: {
    position: 'absolute',
    bottom: spacing.lg,
    left: 0,
    right: 0,
    alignItems: 'center',
  },
  fabButton: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: spacing.xs,
    backgroundColor: '#059669', // Emerald Green
    paddingHorizontal: spacing.lg,
    paddingVertical: spacing.sm + 4,
    borderRadius: radius.full,
    elevation: 4,
    shadowColor: '#059669',
    shadowOffset: {width: 0, height: 4},
    shadowOpacity: 0.3,
    shadowRadius: 8,
  },
  fabText: {
    color: '#FFFFFF',
    fontSize: 14,
    fontWeight: '800',
    letterSpacing: 0.5,
  },
});
