import React, {useEffect} from 'react';
import {StyleSheet, View} from 'react-native';
import LottieView from 'lottie-react-native';
import Animated, {
  Easing,
  useAnimatedStyle,
  useSharedValue,
  withDelay,
  withTiming,
} from 'react-native-reanimated';
import {AppText} from '../../../components/common/AppText';
import {routes} from '../../../navigation/routeNames';
import {colors, radius, spacing} from '../../../theme';

import truckAnimation from '../../../assets/animation/Truck Icon Animation.json';

export default function SplashScreen({navigation}) {
  const contentOpacity = useSharedValue(0);
  const contentScale = useSharedValue(0.92);
  const lottieOpacity = useSharedValue(0);
  const progressWidth = useSharedValue(0);

  useEffect(() => {
    contentOpacity.value = withTiming(1, {
      duration: 600,
      easing: Easing.out(Easing.cubic),
    });

    contentScale.value = withTiming(1, {
      duration: 700,
      easing: Easing.out(Easing.back(1.2)),
    });

    lottieOpacity.value = withDelay(
      200,
      withTiming(1, {
        duration: 500,
        easing: Easing.out(Easing.cubic),
      }),
    );

    progressWidth.value = withTiming(100, {
      duration: 2200,
      easing: Easing.inOut(Easing.quad),
    });

    const timer = setTimeout(() => {
      navigation.replace(routes.welcome);
    }, 2400);

    return () => clearTimeout(timer);
  }, [contentOpacity, contentScale, lottieOpacity, navigation, progressWidth]);

  const animatedContentStyle = useAnimatedStyle(() => ({
    opacity: contentOpacity.value,
    transform: [{scale: contentScale.value}],
  }));

  const animatedLottieStyle = useAnimatedStyle(() => ({
    opacity: lottieOpacity.value,
  }));

  const animatedProgressStyle = useAnimatedStyle(() => ({
    width: `${progressWidth.value}%`,
  }));

  return (
    <View style={styles.screen}>
      <Animated.View style={[styles.mainContainer, animatedContentStyle]}>
        <View style={styles.brandHeader}>
          <View style={styles.logoBadge}>
            <AppText variant="heading" style={styles.logoText}>
              TB
            </AppText>
          </View>
          <View style={styles.titleBlock}>
            <AppText variant="title" style={styles.title}>
              TransportBook
            </AppText>
            <AppText variant="body" style={styles.subtitle}>
              Fleet, Trips & Khata — Simplified
            </AppText>
          </View>
        </View>

        <Animated.View style={[styles.animationCard, animatedLottieStyle]}>
          <LottieView
            source={truckAnimation}
            autoPlay
            loop
            style={styles.lottie}
            resizeMode="contain"
          />
        </Animated.View>
      </Animated.View>

      <View style={styles.footer}>
        <View style={styles.progressTrack}>
          <Animated.View style={[styles.progressBar, animatedProgressStyle]} />
        </View>
        <AppText variant="caption" style={styles.footerText}>
          POWERED BY TRANSPORTBOOK OS
        </AppText>
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  screen: {
    flex: 1,
    backgroundColor: colors.primaryDark,
    justifyContent: 'space-between',
    paddingHorizontal: spacing.xl,
    paddingTop: spacing['4xl'],
    paddingBottom: spacing['2xl'],
  },
  mainContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    gap: spacing['3xl'],
  },
  brandHeader: {
    alignItems: 'center',
    gap: spacing.md,
  },
  logoBadge: {
    width: 64,
    height: 64,
    borderRadius: radius.xl,
    backgroundColor: colors.surface,
    alignItems: 'center',
    justifyContent: 'center',
    shadowColor: colors.text,
    shadowOffset: {width: 0, height: 4},
    shadowOpacity: 0.15,
    shadowRadius: 12,
    elevation: 6,
  },
  logoText: {
    color: colors.primaryDark,
    fontSize: 24,
    fontWeight: '800',
  },
  titleBlock: {
    alignItems: 'center',
    gap: spacing.xs,
  },
  title: {
    color: colors.surface,
    fontSize: 28,
    fontWeight: '700',
    letterSpacing: 0.5,
  },
  subtitle: {
    color: colors.primarySoft,
    fontSize: 14,
    textAlign: 'center',
  },
  animationCard: {
    width: 220,
    height: 220,
    borderRadius: radius['2xl'],
    backgroundColor: 'rgba(255, 255, 255, 0.08)',
    justifyContent: 'center',
    alignItems: 'center',
    padding: spacing.md,
    borderWidth: 1,
    borderColor: 'rgba(255, 255, 255, 0.12)',
  },
  lottie: {
    width: '100%',
    height: '100%',
  },
  footer: {
    alignItems: 'center',
    gap: spacing.sm,
  },
  progressTrack: {
    width: 140,
    height: 3,
    backgroundColor: 'rgba(255, 255, 255, 0.15)',
    borderRadius: radius.round,
    overflow: 'hidden',
  },
  progressBar: {
    height: '100%',
    backgroundColor: colors.surface,
    borderRadius: radius.round,
  },
  footerText: {
    color: colors.primarySoft,
    fontSize: 11,
    fontWeight: '600',
    letterSpacing: 1.2,
    opacity: 0.8,
  },
});

