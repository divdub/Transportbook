import React from 'react';
import {StyleSheet, View} from 'react-native';
import LottieView from 'lottie-react-native';
import {AppButton} from '../../../components/common/AppButton';
import {AppCard} from '../../../components/common/AppCard';
import {AppScreen} from '../../../components/common/AppScreen';
import {AppText} from '../../../components/common/AppText';
import {routes} from '../../../navigation/routeNames';
import {colors, radius, spacing} from '../../../theme';

import warehouseAnimation from '../../../assets/animation/warehouse-delivery.json';

export default function WelcomeScreen({navigation}) {
  return (
    <AppScreen contentStyle={styles.content}>
      <View style={styles.topBar}>
        <View style={styles.brandMark}>
          <AppText variant="heading" style={styles.brandText}>
            TB
          </AppText>
        </View>
        <View style={styles.brandInfo}>
          <AppText variant="heading" style={styles.brandTitle}>
            TransportBook
          </AppText>
          <AppText variant="caption" color="textMuted">
            Fleet & Operations Platform
          </AppText>
        </View>
      </View>

      <View style={styles.visualPanel}>
        <LottieView
          source={warehouseAnimation}
          autoPlay
          loop
          style={styles.animation}
          resizeMode="contain"
        />
      </View>

      <View style={styles.hero}>
        <AppText variant="title" style={styles.heroTitle}>
          Run your transport business with clarity
        </AppText>
        <AppText variant="body" color="textMuted" style={styles.heroSubtitle}>
          Track trips, fleet performance, payments, and khata from a focused
          workspace built for daily logistics operations.
        </AppText>
      </View>

      <AppCard style={styles.card}>
        <AppButton
          title="Continue with Mobile"
          onPress={() => navigation.navigate(routes.authForm)}
        />
      </AppCard>
    </AppScreen>
  );
}

const styles = StyleSheet.create({
  content: {
    justifyContent: 'space-between',
    gap: spacing.xl,
    paddingVertical: spacing.md,
  },
  topBar: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: spacing.md,
  },
  brandMark: {
    width: 48,
    height: 48,
    borderRadius: radius.md,
    backgroundColor: colors.primary,
    alignItems: 'center',
    justifyContent: 'center',
  },
  brandText: {
    color: colors.surface,
    fontWeight: '700',
  },
  brandInfo: {
    justifyContent: 'center',
  },
  brandTitle: {
    fontSize: 18,
    fontWeight: '700',
    color: colors.text,
  },
  visualPanel: {
    height: 240,
    borderRadius: radius.xl,
    backgroundColor: colors.surface,
    borderWidth: StyleSheet.hairlineWidth,
    borderColor: colors.border,
    overflow: 'hidden',
    alignItems: 'center',
    justifyContent: 'center',
  },
  animation: {
    width: '100%',
    height: '100%',
  },
  hero: {
    gap: spacing.sm,
  },
  heroTitle: {
    fontSize: 24,
    lineHeight: 32,
  },
  heroSubtitle: {
    lineHeight: 22,
  },
  card: {
    gap: spacing.md,
  },
});

