import React from 'react';
import {StyleSheet, TextInput, View} from 'react-native';
import {AppButton} from '../../../components/common/AppButton';
import {AppHeader} from '../../../components/common/AppHeader';
import {AppScreen} from '../../../components/common/AppScreen';
import {useAuthStore} from '../../../store/authStore';
import {colors, radius, spacing, typography} from '../../../theme';

export default function BusinessSetupScreen() {
  const completeOnboarding = useAuthStore(state => state.completeOnboarding);

  return (
    <AppScreen>
      <AppHeader
        title="Business setup"
        subtitle="Capture the basics now; backend-driven fields can be added once finalized."
      />
      <View style={styles.form}>
        <TextInput
          placeholder="Your name"
          placeholderTextColor={colors.textMuted}
          style={styles.input}
        />
        <TextInput
          placeholder="Business name"
          placeholderTextColor={colors.textMuted}
          style={styles.input}
        />
        <AppButton title="Submit" onPress={() => completeOnboarding()} />
      </View>
    </AppScreen>
  );
}

const styles = StyleSheet.create({
  form: {
    gap: spacing.lg,
  },
  input: {
    minHeight: 52,
    borderRadius: radius.md,
    borderWidth: 1,
    borderColor: colors.border,
    backgroundColor: colors.surface,
    paddingHorizontal: spacing.lg,
    fontSize: typography.sizes.md,
    color: colors.text,
  },
});