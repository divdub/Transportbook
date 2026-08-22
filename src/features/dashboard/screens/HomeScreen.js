import React from 'react';
import {StyleSheet, View} from 'react-native';
import {AppCard} from '../../../components/common/AppCard';
import {AppHeader} from '../../../components/common/AppHeader';
import {AppScreen} from '../../../components/common/AppScreen';
import {AppText} from '../../../components/common/AppText';
import {StatusBadge} from '../../../components/ui/StatusBadge';
import {spacing} from '../../../theme';

export default function HomeScreen() {
  return (
    <AppScreen>
      <AppHeader
        title="Dashboard"
        subtitle="A foundation view for business metrics, quick actions and recent trips."
      />
      <View style={styles.grid}>
        <MetricCard label="Active trips" value="--" />
        <MetricCard label="Receivables" value="--" />
        <MetricCard label="Trucks" value="--" />
      </View>
      <AppCard style={styles.section}>
        <StatusBadge label="Foundation ready" />
        <AppText variant="heading">Recent trips</AppText>
        <AppText variant="body" color="textMuted">
          Trip data will come from TanStack Query once the backend API contract
          is available.
        </AppText>
      </AppCard>
    </AppScreen>
  );
}

function MetricCard({label, value}) {
  return (
    <AppCard style={styles.metric}>
      <AppText variant="caption" color="textMuted">
        {label}
      </AppText>
      <AppText variant="heading">{value}</AppText>
    </AppCard>
  );
}

const styles = StyleSheet.create({
  grid: {
    gap: spacing.md,
    marginBottom: spacing.lg,
  },
  metric: {
    gap: spacing.xs,
  },
  section: {
    gap: spacing.md,
  },
});
