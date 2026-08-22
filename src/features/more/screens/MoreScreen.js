import React from 'react';
import {StyleSheet, View} from 'react-native';
import {AppButton} from '../../../components/common/AppButton';
import {AppCard} from '../../../components/common/AppCard';
import {AppHeader} from '../../../components/common/AppHeader';
import {AppScreen} from '../../../components/common/AppScreen';
import {AppText} from '../../../components/common/AppText';
import {useAuthStore} from '../../../store/authStore';
import {spacing} from '../../../theme';

export default function MoreScreen() {
  const logout = useAuthStore(state => state.logout);

  return (
    <AppScreen>
      <AppHeader
        title="More"
        subtitle="Settings, fleet records, documents, reports and utilities will live here."
      />
      <View style={styles.list}>
        {['Trucks', 'Drivers', 'Parties', 'Suppliers', 'Reports'].map(item => (
          <AppCard key={item}>
            <AppText variant="heading">{item}</AppText>
          </AppCard>
        ))}
      </View>
      <View style={styles.logout}>
        <AppButton title="Log out" variant="secondary" onPress={logout} />
      </View>
    </AppScreen>
  );
}

const styles = StyleSheet.create({
  list: {
    gap: spacing.md,
  },
  logout: {
    marginTop: spacing.xl,
  },
});
