import React, {useRef, useState} from 'react';
import {
  KeyboardAvoidingView,
  Platform,
  ScrollView,
  StyleSheet,
  TextInput,
  View,
} from 'react-native';
import {SafeAreaView} from 'react-native-safe-area-context';
import Icon from 'react-native-vector-icons/MaterialCommunityIcons';
import {AppButton} from '../../../components/common/AppButton';
import {AppHeader} from '../../../components/common/AppHeader';
import {AppText} from '../../../components/common/AppText';
import {useAuthStore} from '../../../store/authStore';
import {useSendMobileOtp} from '../hooks/useSendMobileOtp';
import {useVerifyMobileOtp} from '../hooks/useVerifyMobileOtp';
import {colors, radius, spacing, typography} from '../../../theme';

const OTP_LENGTH = 6;

export default function BusinessSetupScreen() {
  const completeOnboarding = useAuthStore(state => state.completeOnboarding);
  const {sendOtp, isSending} = useSendMobileOtp();
  const {verifyOtp, isVerifying, errorMessage: otpError} = useVerifyMobileOtp();

  const [name, setName] = useState('');
  const [businessName, setBusinessName] = useState('');
  const [mobileNumber, setMobileNumber] = useState('');
  const [otpVisible, setOtpVisible] = useState(false);
  const [mobileVerified, setMobileVerified] = useState(false);
  const [digits, setDigits] = useState(Array(OTP_LENGTH).fill(''));
  const inputRefs = useRef([]);

  const otp = digits.join('');

  const handleVerifyMobilePress = async () => {
    if (mobileNumber.length < 10) return;
    await sendOtp(mobileNumber);
    setOtpVisible(true);
  };

  const handleChangeDigit = (value, index) => {
    const cleaned = value.replace(/[^0-9]/g, '').slice(-1);
    setDigits(prev => {
      const next = [...prev];
      next[index] = cleaned;
      return next;
    });
    if (cleaned && index < OTP_LENGTH - 1) {
      inputRefs.current[index + 1]?.focus();
    }
  };

  const handleKeyPress = ({nativeEvent}, index) => {
    if (nativeEvent.key === 'Backspace' && !digits[index] && index > 0) {
      inputRefs.current[index - 1]?.focus();
    }
  };

  const handleVerifyOtpPress = async () => {
    const result = await verifyOtp(mobileNumber, otp);
    if (result?.verified) {
      setMobileVerified(true);
      setOtpVisible(false);
    }
  };

  const handleComplete = () => {
    if (!mobileVerified) return;
    completeOnboarding({name, businessName, mobileNumber, mobileVerified});
  };

  return (
    <SafeAreaView style={styles.safeArea} edges={['top', 'bottom']}>
      <KeyboardAvoidingView
        behavior={Platform.OS === 'ios' ? 'padding' : undefined}
        style={styles.keyboardContainer}>
        <ScrollView
          contentContainerStyle={styles.scrollContent}
          showsVerticalScrollIndicator={false}
          keyboardShouldPersistTaps="handled">
          
          <AppHeader title="Business setup" subtitle="Tell us about you and your business" />

          <View style={styles.form}>
            <Field label="Your name" value={name} onChangeText={setName} placeholder="Full name" />
            <Field
              label="Business name"
              value={businessName}
              onChangeText={setBusinessName}
              placeholder="e.g. ABC Transport Co."
            />

            <View style={styles.field}>
              <AppText variant="label" color="textMuted" style={styles.fieldLabel}>
                Mobile number
              </AppText>
              <View style={styles.mobileRow}>
                <TextInput
                  value={mobileNumber}
                  onChangeText={setMobileNumber}
                  placeholder="10-digit number"
                  placeholderTextColor={colors.textMuted}
                  keyboardType="number-pad"
                  maxLength={10}
                  editable={!mobileVerified}
                  style={[styles.input, styles.mobileInput]}
                />
                {mobileVerified ? (
                  <View style={styles.verifiedBadge}>
                    <Icon name="check-circle" size={18} color={colors.success} />
                    <AppText variant="caption" color="success" style={styles.verifiedText}>
                      Verified
                    </AppText>
                  </View>
                ) : (
                  <AppButton
                    title={isSending ? 'Sending...' : 'Verify'}
                    onPress={handleVerifyMobilePress}
                    disabled={isSending || mobileNumber.length < 10}
                    style={styles.verifyMobileButton}
                  />
                )}
              </View>
            </View>

            {otpVisible && !mobileVerified ? (
              <View style={styles.otpSection}>
                <AppText variant="caption" color="textMuted">
                  Enter the 6-digit code sent to {mobileNumber}
                </AppText>
                <View style={styles.otpRow}>
                  {digits.map((digit, index) => (
                    <TextInput
                      key={index}
                      ref={ref => (inputRefs.current[index] = ref)}
                      value={digit}
                      onChangeText={value => handleChangeDigit(value, index)}
                      onKeyPress={event => handleKeyPress(event, index)}
                      keyboardType="number-pad"
                      maxLength={1}
                      style={[styles.otpBox, digit ? styles.otpBoxFilled : null]}
                    />
                  ))}
                </View>
                {otpError ? (
                  <AppText variant="caption" color="danger">{otpError}</AppText>
                ) : null}
                <View style={styles.otpBtnRow}>
                  <AppButton
                    title={isVerifying ? 'Verifying...' : 'Verify OTP'}
                    onPress={handleVerifyOtpPress}
                    disabled={otp.length !== OTP_LENGTH || isVerifying}
                    style={styles.otpVerifyButton}
                  />
                </View>
              </View>
            ) : null}
          </View>
        </ScrollView>

        {/* Pinned Bottom Footer for Complete Signup */}
        <View style={styles.bottomFooter}>
          <AppButton
            title="Complete Signup"
            onPress={handleComplete}
            disabled={!mobileVerified}
            style={styles.completeButton}
          />
        </View>
      </KeyboardAvoidingView>
    </SafeAreaView>
  );
}

function Field({label, ...inputProps}) {
  return (
    <View style={styles.field}>
      <AppText variant="label" color="textMuted" style={styles.fieldLabel}>
        {label}
      </AppText>
      <TextInput placeholderTextColor={colors.textMuted} style={styles.input} {...inputProps} />
    </View>
  );
}

const styles = StyleSheet.create({
  safeArea: {
    flex: 1,
    backgroundColor: colors.background,
  },
  keyboardContainer: {
    flex: 1,
  },
  scrollContent: {
    padding: spacing.xl,
    paddingBottom: spacing['2xl'],
  },
  form: {
    gap: spacing.lg,
    marginTop: spacing.md,
  },
  field: {
    gap: spacing.xs,
  },
  fieldLabel: {
    textTransform: 'uppercase',
    letterSpacing: 0.5,
  },
  input: {
    minHeight: 48,
    borderRadius: radius.md,
    borderWidth: 1,
    borderColor: colors.border,
    backgroundColor: colors.surface,
    paddingHorizontal: spacing.md,
    fontSize: typography.sizes.md,
    color: colors.text,
  },
  mobileRow: {
    flexDirection: 'row',
    gap: spacing.sm,
    alignItems: 'center',
  },
  mobileInput: {
    flex: 1,
  },
  verifyMobileButton: {
    minHeight: 46,
    paddingHorizontal: spacing.lg,
    backgroundColor: colors.primary2,
    borderRadius: radius.md,
  },
  verifiedBadge: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 4,
    paddingHorizontal: spacing.md,
    paddingVertical: 10,
    backgroundColor: colors.successSoft,
    borderRadius: radius.md,
  },
  verifiedText: {
    fontWeight: '700',
  },
  otpSection: {
    gap: spacing.sm,
    backgroundColor: colors.surface,
    padding: spacing.md,
    borderRadius: radius.md,
    borderWidth: 1,
    borderColor: colors.border,
  },
  otpRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginVertical: spacing.xs,
  },
  otpBox: {
    width: 44,
    height: 48,
    borderRadius: radius.md,
    borderWidth: 1.5,
    borderColor: colors.border,
    backgroundColor: colors.surfaceSubtle,
    textAlign: 'center',
    fontSize: typography.sizes.lg,
    fontWeight: typography.weights.semibold,
    color: colors.text,
  },
  otpBoxFilled: {
    borderColor: colors.primary2,
    backgroundColor: colors.surface,
  },
  otpBtnRow: {
    alignItems: 'flex-start',
    marginTop: spacing.xs,
  },
  otpVerifyButton: {
    minHeight: 40,
    paddingHorizontal: spacing.xl,
    backgroundColor: colors.primary2,
    borderRadius: radius.md,
  },
  bottomFooter: {
    paddingHorizontal: spacing.xl,
    paddingTop: spacing.md,
    paddingBottom: Platform.OS === 'ios' ? spacing.xs : spacing.md,
    backgroundColor: colors.background,
    borderTopWidth: 1,
    borderTopColor: colors.border,
  },
  completeButton: {
    minHeight: 48,
    borderRadius: radius.md,
    backgroundColor: colors.primary2,
  },
});