import React from 'react';
import {ScrollView, StyleSheet, TouchableOpacity, View} from 'react-native';
import {useNavigation} from '@react-navigation/native';
import Icon from 'react-native-vector-icons/MaterialCommunityIcons';
import {AppScreen} from '../../../components/common/AppScreen';
import {AppText} from '../../../components/common/AppText';
import {ModuleTile} from '../components/ModuleTile';
import {businessModules} from '../constants/businessModules';
import {routes} from '../../../navigation/routeNames';
import {colors, radius, spacing, typography} from '../../../theme';

// TODO(backend): replace with TanStack Query once dashboard API contract exists.
const mockDashboard = {
  user: {name: 'Rajesh'},
  fleetPerformance: {
    utilization: '78%',
    fuelEfficiency: '8.7 mpg',
    onTimeRate: '92%',
    idleTime: '1h 12m',
  },
  topDriver: {name: 'Lukas Weber', label: 'Top driver', rating: '9.7'},
  serviceAlert: {vehicleCount: 4, label: 'Needing service'},
};

// TODO(navigation): wire remaining actions once their feature screens/routes
// exist (Trips, Expenses, Payments, Trucks). Party is wired below.
const quickActions = [
  {key: 'trip', label: 'Add Trip', icon: 'truck-fast-outline'},
  {key: 'expense', label: 'Expense', icon: 'receipt'},
  {key: 'payment', label: 'Payment', icon: 'cash-multiple'},
  {key: 'party', label: 'Add Party', icon: 'account-group-outline'},
  {key: 'truck', label: 'Add Truck', icon: 'truck-plus-outline'},
];

export default function HomeScreen() {
  const navigation = useNavigation();
  const {user, fleetPerformance, topDriver, serviceAlert} = mockDashboard;

  const handleQuickAction = key => {
    if (key === 'party') {
      navigation.navigate(routes.addParty);
      return;
    }
    // other actions still TODO until their screens exist
  };

  return (
    <AppScreen>
      <ScrollView showsVerticalScrollIndicator={false}>
        <TopBar userName={user.name} />

        <QuickActionsCarousel actions={quickActions} onActionPress={handleQuickAction} />

        <HeroTrackingCard />

        <FleetPerformanceCard
          metrics={fleetPerformance}
          topDriver={topDriver}
          serviceAlert={serviceAlert}
        />

        <ManageModulesGrid navigation={navigation} />
      </ScrollView>
    </AppScreen>
  );
}

function TopBar({userName}) {
  return (
    <View style={styles.topBar}>
      <TouchableOpacity style={styles.iconCircle} accessibilityLabel="Notifications">
        <Icon name="bell-outline" size={20} color={colors.text} />
        <View style={styles.notificationDot} />
      </TouchableOpacity>

      <AppText variant="heading" style={styles.brandText}>
        Hi, {userName}
      </AppText>

      <View style={styles.avatarPlaceholder}>
        <AppText variant="label" color="onInk">
          {userName?.charAt(0) ?? '?'}
        </AppText>
      </View>
    </View>
  );
}

function QuickActionsCarousel({actions, onActionPress}) {
  return (
    <View style={styles.carouselWrap}>
      <AppText variant="label" color="textMuted" style={styles.carouselLabel}>
        QUICK ACTIONS
      </AppText>
      <ScrollView
        horizontal
        showsHorizontalScrollIndicator={false}
        contentContainerStyle={styles.carouselRow}>
        {actions.map(action => (
          <TouchableOpacity
            key={action.key}
            style={styles.actionTile}
            accessibilityLabel={action.label}
            onPress={() => onActionPress(action.key)}>
            <View style={styles.actionIconCircle}>
              <Icon name={action.icon} size={22} color={colors.ink} />
            </View>
            <AppText variant="caption" style={styles.actionLabel} numberOfLines={1}>
              {action.label}
            </AppText>
          </TouchableOpacity>
        ))}
      </ScrollView>
    </View>
  );
}

function HeroTrackingCard() {
  return (
    <View style={styles.heroCard}>
      <View style={styles.heroTextBlock}>
        <AppText variant="heading" style={styles.heroTitle}>
          Fleet on the road
        </AppText>
        <AppText variant="body" style={styles.heroSubtitle}>
          Track active trucks and trips in real time
        </AppText>
      </View>
      <TouchableOpacity style={styles.heroButton}>
        <Icon name="map-marker-radius-outline" size={18} color={colors.onInk} />
        <AppText variant="label" color="onInk">Track fleet</AppText>
      </TouchableOpacity>
    </View>
  );
}

function FleetPerformanceCard({metrics, topDriver, serviceAlert}) {
  return (
    <View style={styles.performanceCard}>
      <AppText variant="heading" style={styles.performanceTitle}>
        Fleet performance overview
      </AppText>

      <View style={styles.metricGrid}>
        <MetricTile label="Utilization" value={metrics.utilization} />
        <MetricTile label="Fuel Efficiency" value={metrics.fuelEfficiency} dark />
        <MetricTile label="On-time Rate" value={metrics.onTimeRate} />
        <MetricTile label="Idle Time" value={metrics.idleTime} />
      </View>

      <View style={styles.divider} />

      <View style={styles.driverRow}>
        <View style={styles.driverAvatarPlaceholder}>
          <AppText variant="label" color="onInk">
            {topDriver.name.charAt(0)}
          </AppText>
        </View>
        <View style={styles.driverInfo}>
          <AppText variant="body" style={styles.driverName}>
            {topDriver.name}
          </AppText>
          <AppText variant="caption" color="textMuted">
            {topDriver.label}
          </AppText>
        </View>
        <View style={styles.ratingBadge}>
          <Icon name="star" size={12} color={colors.onInk} />
          <AppText variant="label" color="onInk"> {topDriver.rating}</AppText>
        </View>
      </View>

      <View style={styles.divider} />

      <TouchableOpacity style={styles.serviceRow}>
        <Icon name="truck-alert-outline" size={20} color={colors.text} />
        <View style={styles.serviceInfo}>
          <AppText variant="body" style={styles.serviceCount}>
            {serviceAlert.vehicleCount} vehicles
          </AppText>
          <AppText variant="caption" color="textMuted">
            {serviceAlert.label}
          </AppText>
        </View>
        <Icon name="chevron-right" size={20} color={colors.textMuted} />
      </TouchableOpacity>
    </View>
  );
}

function MetricTile({label, value, dark}) {
  return (
    <View style={[styles.metricTile, dark && styles.metricTileDark]}>
      <AppText variant="caption" color={dark ? 'onInk' : 'textMuted'}>
        {label}
      </AppText>
      <AppText variant="heading" color={dark ? 'onInk' : 'text'} style={styles.metricValue}>
        {value}
      </AppText>
    </View>
  );
}

function ManageModulesGrid({navigation}) {
  return (
    <View style={styles.modulesSection}>
      <AppText variant="heading" style={styles.performanceTitle}>
        Manage business
      </AppText>
      <View style={styles.modulesGrid}>
        {businessModules.map(module => (
          <ModuleTile
            key={module.key}
            label={module.label}
            icon={module.icon}
            ready={Boolean(module.route)}
            onPress={() => navigation.navigate(module.route)}
          />
        ))}
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  topBar: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: spacing.lg,
  },
  iconCircle: {
    width: 40,
    height: 40,
    borderRadius: radius.md + 10,
    backgroundColor: colors.surfaceMuted,
    alignItems: 'center',
    justifyContent: 'center',
  },
  notificationDot: {
    position: 'absolute',
    top: 8,
    right: 9,
    width: 6,
    height: 6,
    borderRadius: 3,
    backgroundColor: colors.accentStrong,
  },
  brandText: {
    fontSize: typography.sizes.md,
  },
  avatarPlaceholder: {
    width: 40,
    height: 40,
    borderRadius: radius.md + 10,
    backgroundColor: colors.ink,
    alignItems: 'center',
    justifyContent: 'center',
  },
  carouselWrap: {
    marginBottom: spacing.lg,
  },
  carouselLabel: {
    marginBottom: spacing.sm,
    letterSpacing: 0.5,
  },
  carouselRow: {
    gap: spacing.sm,
  },
  actionTile: {
    width: 76,
    alignItems: 'center',
    gap: spacing.xs,
  },
  actionIconCircle: {
    width: 56,
    height: 56,
    borderRadius: radius.md,
    backgroundColor: colors.surfaceMuted,
    alignItems: 'center',
    justifyContent: 'center',
  },
  actionLabel: {
    textAlign: 'center',
  },
  heroCard: {
    backgroundColor: colors.accent,
    borderRadius: radius.lg,
    padding: spacing.lg,
    marginBottom: spacing.lg,
  },
  heroTextBlock: {
    marginBottom: spacing.lg,
  },
  heroTitle: {
    fontSize: typography.sizes.lg,
    marginBottom: spacing.xs,
  },
  heroSubtitle: {
    opacity: 0.75,
  },
  heroButton: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    gap: spacing.sm,
    backgroundColor: colors.ink,
    borderRadius: radius.md,
    height: 48,
  },
  performanceCard: {
    backgroundColor: colors.surface,
    borderRadius: radius.lg,
    borderWidth: 1,
    borderColor: colors.border,
    padding: spacing.lg,
    marginBottom: spacing.lg,
  },
  performanceTitle: {
    marginBottom: spacing.md,
  },
  metricGrid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: spacing.sm,
    marginBottom: spacing.md,
  },
  metricTile: {
    width: '48%',
    backgroundColor: colors.surfaceMuted,
    borderRadius: radius.md,
    padding: spacing.md,
    gap: spacing.xs,
  },
  metricTileDark: {
    backgroundColor: colors.ink,
  },
  metricValue: {
    fontSize: typography.sizes.md,
  },
  divider: {
    height: 1,
    backgroundColor: colors.border,
    marginVertical: spacing.md,
  },
  driverRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: spacing.sm,
  },
  driverAvatarPlaceholder: {
    width: 40,
    height: 40,
    borderRadius: radius.md + 10,
    backgroundColor: colors.ink,
    alignItems: 'center',
    justifyContent: 'center',
  },
  driverInfo: {
    flex: 1,
  },
  driverName: {
    fontWeight: typography.weights.semibold,
  },
  ratingBadge: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: colors.accentStrong,
    borderRadius: radius.md,
    paddingHorizontal: spacing.sm,
    paddingVertical: spacing.xs,
  },
  serviceRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: spacing.md,
  },
  serviceInfo: {
    flex: 1,
  },
  serviceCount: {
    fontWeight: typography.weights.semibold,
  },
  modulesSection: {
    marginBottom: spacing.xl,
  },
  modulesGrid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: spacing.sm,
  },
});