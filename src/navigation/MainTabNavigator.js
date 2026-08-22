import React from 'react';
import {createBottomTabNavigator} from '@react-navigation/bottom-tabs';
import {StyleSheet, View} from 'react-native';
import HomeScreen from '../features/dashboard/screens/HomeScreen';
import TripsScreen from '../features/trips/screens/TripsScreen';
import AddScreen from '../features/quickActions/screens/AddScreen';
import KhataScreen from '../features/khata/screens/KhataScreen';
import MoreScreen from '../features/more/screens/MoreScreen';
import {routes} from './routeNames';
import {colors, radius, spacing, typography} from '../theme';
import {AppText} from '../components/common/AppText';

const Tab = createBottomTabNavigator();

export default function MainTabNavigator() {
  return (
    <Tab.Navigator
      screenOptions={({route}) => ({
        headerShown: false,
        tabBarActiveTintColor: colors.primary,
        tabBarInactiveTintColor: colors.textMuted,
        tabBarLabelStyle: styles.label,
        tabBarStyle: styles.tabBar,
        tabBarIcon: tabIcons[route.name],
      })}>
      <Tab.Screen name={routes.home} component={HomeScreen} />
      <Tab.Screen name={routes.trips} component={TripsScreen} />
      <Tab.Screen name={routes.add} component={AddScreen} />
      <Tab.Screen name={routes.khata} component={KhataScreen} />
      <Tab.Screen name={routes.more} component={MoreScreen} />
    </Tab.Navigator>
  );
}

const tabIcons = {
  [routes.home]: props => <TabGlyph label="H" {...props} />,
  [routes.trips]: props => <TabGlyph label="T" {...props} />,
  [routes.add]: props => <TabGlyph label="+" prominent {...props} />,
  [routes.khata]: props => <TabGlyph label="K" {...props} />,
  [routes.more]: props => <TabGlyph label="M" {...props} />,
};

function TabGlyph({label, focused, color, prominent}) {
  return (
    <View
      style={[
        styles.glyph,
        prominent && styles.prominentGlyph,
        focused && !prominent && styles.focusedGlyph,
      ]}>
      <AppText
        variant="label"
        style={[
          styles.glyphText,
          {color: prominent ? colors.surface : color},
          prominent && styles.prominentGlyphText,
        ]}>
        {label}
      </AppText>
    </View>
  );
}

const styles = StyleSheet.create({
  tabBar: {
    minHeight: 68,
    paddingTop: spacing.sm,
    paddingBottom: spacing.sm,
    borderTopColor: colors.border,
    backgroundColor: colors.surface,
  },
  label: {
    fontSize: typography.sizes.xs,
    fontWeight: typography.weights.medium,
  },
  glyph: {
    width: 28,
    height: 28,
    borderRadius: radius.round,
    alignItems: 'center',
    justifyContent: 'center',
  },
  focusedGlyph: {
    backgroundColor: colors.primarySoft,
  },
  prominentGlyph: {
    width: 42,
    height: 42,
    backgroundColor: colors.primary,
    marginTop: -spacing.lg,
  },
  glyphText: {
    lineHeight: 18,
  },
  prominentGlyphText: {
    fontSize: 24,
    lineHeight: 28,
  },
});
