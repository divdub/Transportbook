import React from 'react';
import {StyleSheet, TextInput, View} from 'react-native';
import {AppButton} from '../../../components/common/AppButton';
import {AppHeader} from '../../../components/common/AppHeader';
import {AppScreen} from '../../../components/common/AppScreen';
import {AppText} from '../../../components/common/AppText';
import {useMockOtpVerification} from '../hooks/useMockOtpVerification';
import {colors, radius, spacing, typography} from '../../../theme';

export default function OtpScreen({route}) {
  const mobileNumber = route.params?.mobileNumber;
  const {verifyOtp, isSubmitting, errorMessage} = useMockOtpVerification();

  return (
    <AppScreen>
      <AppHeader
        title="OTP placeholder"
        subtitle="The real OTP verification step will be implemented after the backend authentication contract is available."
      />
      <View style={styles.form}>
        <TextInput
          accessibilityLabel="OTP"
          keyboardType="number-pad"
          maxLength={6}
          placeholder="Mock OTP"
          placeholderTextColor={colors.textMuted}
          style={styles.input}
        />
        {errorMessage ? (
          <AppText variant="label" style={styles.errorText}>
            {errorMessage}
          </AppText>
        ) : null}
        <AppButton
          title={isSubmitting ? 'Opening...' : 'Use mock authentication'}
          onPress={() => verifyOtp(mobileNumber)}
          disabled={isSubmitting}
        />
        <AppText variant="caption" color="textMuted">
          This action writes a mock session through authStore/authStorage so the
          authenticated app placeholder can be tested.
        </AppText>
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
    letterSpacing: 2,
  },
  errorText: {
    color: colors.danger,
  },
});
