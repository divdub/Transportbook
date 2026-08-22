import React from 'react';
import {StyleSheet, View} from 'react-native';
import {AppButton} from '../../../components/common/AppButton';
import {AppCard} from '../../../components/common/AppCard';
import {AppScreen} from '../../../components/common/AppScreen';
import {AppText} from '../../../components/common/AppText';
import {routes} from '../../../navigation/routeNames';
import {colors, radius, spacing} from '../../../theme';

export default function WelcomeScreen({navigation}) {
  return (
    <AppScreen contentStyle={styles.content}>
      <View style={styles.topBar}>
        <View style={styles.brandMark}>
          <AppText variant="heading" style={styles.brandText}>
            TA
          </AppText>
        </View>
        <AppText variant="label" color="textMuted">
          Transport SaaS
        </AppText>
      </View>

      <View style={styles.visualPanel}>
        <View style={styles.routeLine} />
        <View style={[styles.routePoint, styles.routeStart]} />
        <View style={[styles.routePoint, styles.routeEnd]} />
        <View style={styles.truck}>
          <View style={styles.truckBody} />
          <View style={styles.truckCab} />
          <View style={styles.wheels}>
            <View style={styles.wheel} />
            <View style={styles.wheel} />
          </View>
        </View>
      </View>

      <View style={styles.hero}>
        <AppText variant="title">Run your transport business with clarity</AppText>
        <AppText variant="body" color="textMuted">
          Track trips, fleet, payments and khata from a focused Android
          workspace built for day-to-day transport operations.
        </AppText>
      </View>

      <AppCard style={styles.card}>
        <View style={styles.cardCopy}>
          <AppText variant="heading">Start with mobile login</AppText>
          <AppText variant="body" color="textMuted">
            We will connect OTP authentication after the backend contract is
            confirmed. This build uses a clearly named mock flow for UI testing.
          </AppText>
        </View>
        <AppButton
          title="Continue with mobile"
          onPress={() => navigation.navigate(routes.login)}
        />
      </AppCard>
    </AppScreen>
  );
}

const styles = StyleSheet.create({
  content: {
    justifyContent: 'space-between',
    gap: spacing.xl,
  },
  topBar: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
  },
  brandMark: {
    width: 52,
    height: 52,
    borderRadius: radius.md,
    backgroundColor: colors.primary,
    alignItems: 'center',
    justifyContent: 'center',
  },
  brandText: {
    color: colors.surface,
  },
  visualPanel: {
    minHeight: 190,
    borderRadius: radius.xl,
    padding: spacing.xl,
    justifyContent: 'center',
    backgroundColor: colors.surface,
    borderWidth: StyleSheet.hairlineWidth,
    borderColor: colors.border,
  },
  routeLine: {
    height: 4,
    borderRadius: radius.round,
    backgroundColor: colors.primarySoft,
  },
  routePoint: {
    position: 'absolute',
    width: 18,
    height: 18,
    borderRadius: radius.round,
    backgroundColor: colors.primary,
  },
  routeStart: {
    left: spacing.xl,
  },
  routeEnd: {
    right: spacing.xl,
  },
  truck: {
    position: 'absolute',
    left: spacing['4xl'],
    right: spacing['4xl'],
    alignSelf: 'center',
    height: 64,
  },
  truckBody: {
    position: 'absolute',
    left: 0,
    bottom: 20,
    width: 92,
    height: 38,
    borderRadius: radius.sm,
    backgroundColor: colors.primary,
  },
  truckCab: {
    position: 'absolute',
    left: 88,
    bottom: 20,
    width: 46,
    height: 32,
    borderTopRightRadius: radius.md,
    borderBottomRightRadius: radius.sm,
    backgroundColor: colors.primaryDark,
  },
  wheels: {
    position: 'absolute',
    left: 18,
    width: 104,
    bottom: 6,
    flexDirection: 'row',
    justifyContent: 'space-between',
  },
  wheel: {
    width: 18,
    height: 18,
    borderRadius: radius.round,
    borderWidth: 4,
    borderColor: colors.surface,
    backgroundColor: colors.text,
  },
  hero: {
    gap: spacing.md,
  },
  card: {
    gap: spacing.lg,
  },
  cardCopy: {
    gap: spacing.sm,
  },
});
