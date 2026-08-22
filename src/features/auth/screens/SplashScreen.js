import React, {useEffect} from 'react';
import {StyleSheet, View} from 'react-native';
import Animated, {
  Easing,
  useAnimatedStyle,
  useSharedValue,
  withTiming,
} from 'react-native-reanimated';
import {AppText} from '../../../components/common/AppText';
import {routes} from '../../../navigation/routeNames';
import {colors, radius, spacing} from '../../../theme';

export default function SplashScreen({navigation}) {
  const truckPosition = useSharedValue(-80);
  const contentOpacity = useSharedValue(0);

  useEffect(() => {
    truckPosition.value = withTiming(0, {
      duration: 850,
      easing: Easing.out(Easing.cubic),
    });
    contentOpacity.value = withTiming(1, {
      duration: 500,
      easing: Easing.out(Easing.cubic),
    });

    const timer = setTimeout(() => {
      navigation.replace(routes.welcome);
    }, 1300);

    return () => clearTimeout(timer);
  }, [contentOpacity, navigation, truckPosition]);

  const truckStyle = useAnimatedStyle(() => ({
    transform: [{translateX: truckPosition.value}],
  }));

  const contentStyle = useAnimatedStyle(() => ({
    opacity: contentOpacity.value,
  }));

  return (
    <View style={styles.screen}>
      <Animated.View style={[styles.content, contentStyle]}>
        <View style={styles.logo}>
          <AppText variant="heading" style={styles.logoText}>
            TA
          </AppText>
        </View>
        <View style={styles.titleBlock}>
          <AppText variant="title" style={styles.title}>
            Transport App
          </AppText>
          <AppText variant="body" style={styles.subtitle}>
            Operations, fleet and khata in one place.
          </AppText>
        </View>
      </Animated.View>

      <View style={styles.road}>
        <Animated.View style={[styles.truck, truckStyle]}>
          <View style={styles.truckCargo} />
          <View style={styles.truckCab} />
          <View style={styles.wheelRow}>
            <View style={styles.wheel} />
            <View style={styles.wheel} />
          </View>
        </Animated.View>
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  screen: {
    flex: 1,
    justifyContent: 'center',
    padding: spacing['2xl'],
    backgroundColor: colors.primaryDark,
  },
  content: {
    alignItems: 'center',
    gap: spacing.xl,
  },
  logo: {
    width: 72,
    height: 72,
    borderRadius: radius.xl,
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: colors.surface,
  },
  logoText: {
    color: colors.primaryDark,
  },
  titleBlock: {
    alignItems: 'center',
    gap: spacing.sm,
  },
  title: {
    color: colors.surface,
    textAlign: 'center',
  },
  subtitle: {
    color: colors.primarySoft,
    textAlign: 'center',
  },
  road: {
    height: 88,
    marginTop: spacing['4xl'],
    justifyContent: 'center',
    borderBottomWidth: 2,
    borderBottomColor: colors.primarySoft,
  },
  truck: {
    width: 148,
    height: 60,
    alignSelf: 'center',
  },
  truckCargo: {
    position: 'absolute',
    left: 0,
    bottom: 18,
    width: 92,
    height: 36,
    borderRadius: radius.sm,
    backgroundColor: colors.surface,
  },
  truckCab: {
    position: 'absolute',
    right: 0,
    bottom: 18,
    width: 48,
    height: 32,
    borderTopRightRadius: radius.md,
    borderBottomRightRadius: radius.sm,
    backgroundColor: colors.primarySoft,
  },
  wheelRow: {
    position: 'absolute',
    left: 18,
    right: 18,
    bottom: 4,
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
});
