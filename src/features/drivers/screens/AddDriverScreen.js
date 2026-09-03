import React from 'react';
import {Controller, useForm} from 'react-hook-form';
import {zodResolver} from '@hookform/resolvers/zod';
import {StyleSheet, TextInput, TouchableOpacity, View} from 'react-native';
import {useNavigation} from '@react-navigation/native';
import {AppButton} from '../../../components/common/AppButton';
import {AppScreen} from '../../../components/common/AppScreen';
import {AppText} from '../../../components/common/AppText';
import {useAddDriverMutation} from '../hooks/useAddDriverMutation';
import {addDriverSchema} from '../driversValidation';
import {colors, radius, spacing, typography} from '../../../theme';

export default function AddDriverScreen() {
  const navigation = useNavigation();
  const {mutateAsync, isPending, error} = useAddDriverMutation();
  const submitError = error?.message || (error ? "Couldn't save this driver. Please try again." : null);

  const {
    control,
    handleSubmit,
    formState: {errors},
  } = useForm({
    resolver: zodResolver(addDriverSchema),
    defaultValues: {
      drivername: '',
      mobile: '',
      opening_balance: '',
      balance_type: 'has_to_pay',
    },
  });

  const onSubmit = async values => {
    try {
      await mutateAsync({
        ...values,
        opening_balance: values.opening_balance || undefined,
      });
      navigation.goBack();
    } catch {
      // error is exposed via `error` from useAddDriverMutation below
    }
  };

  return (
    <AppScreen>
      <View style={styles.form}>
        <FormField
          control={control}
          name="drivername"
          label="Driver Name"
          placeholder="e.g. Suresh Yadav"
          error={errors.drivername?.message}
        />
        <FormField
          control={control}
          name="mobile"
          label="Mobile Number"
          placeholder="10-digit mobile number"
          keyboardType="number-pad"
          maxLength={10}
          error={errors.mobile?.message}
        />
        <FormField
          control={control}
          name="opening_balance"
          label="Opening Balance"
          placeholder="0.00"
          keyboardType="decimal-pad"
          error={errors.opening_balance?.message}
        />
        <BalanceTypeField control={control} error={errors.balance_type?.message} />

        {submitError ? (
          <AppText variant="label" color="danger">
            {submitError}
          </AppText>
        ) : null}

        <AppButton
          title={isPending ? 'Saving...' : 'Save Driver'}
          onPress={handleSubmit(onSubmit)}
          disabled={isPending}
        />
      </View>
    </AppScreen>
  );
}

const BALANCE_TYPES = [
  {value: 'has_to_get', label: 'To Get', color: colors.success},
  {value: 'has_to_pay', label: 'To Pay', color: colors.danger},
];

function BalanceTypeField({control, error}) {
  return (
    <View style={styles.field}>
      <AppText variant="label" color="textMuted" style={styles.fieldLabel}>
        Balance Type
      </AppText>
      <Controller
        control={control}
        name="balance_type"
        render={({field: {onChange, value}}) => (
          <View style={styles.segmentRow}>
            {BALANCE_TYPES.map(option => {
              const selected = value === option.value;
              return (
                <TouchableOpacity
                  key={option.value}
                  style={[
                    styles.segment,
                    selected && {
                      backgroundColor: option.color,
                      borderColor: option.color,
                    },
                  ]}
                  onPress={() => onChange(option.value)}
                  activeOpacity={0.7}>
                  <AppText
                    style={[
                      styles.segmentLabel,
                      {color: selected ? colors.surface : colors.text},
                    ]}>
                    {option.label}
                  </AppText>
                </TouchableOpacity>
              );
            })}
          </View>
        )}
      />
      {error ? (
        <AppText variant="caption" color="danger">
          {error}
        </AppText>
      ) : null}
    </View>
  );
}

function FormField({control, name, label, error, uppercase, ...inputProps}) {
  return (
    <View style={styles.field}>
      {label ? (
        <AppText variant="label" color="textMuted" style={styles.fieldLabel}>
          {label}
        </AppText>
      ) : null}
      <Controller
        control={control}
        name={name}
        render={({field: {onChange, onBlur, value}}) => (
          <TextInput
            value={value}
            onChangeText={text => onChange(uppercase ? text.toUpperCase() : text)}
            onBlur={onBlur}
            placeholderTextColor={colors.textMuted}
            style={[styles.input, error && styles.inputError]}
            {...inputProps}
          />
        )}
      />
      {error ? (
        <AppText variant="caption" color="danger">
          {error}
        </AppText>
      ) : null}
    </View>
  );
}

const styles = StyleSheet.create({
  form: {gap: spacing.lg},
  field: {gap: spacing.xs},
  fieldLabel: {textTransform: 'uppercase', letterSpacing: 0.5},
  input: {
    minHeight: 54,
    borderRadius: radius.md,
    borderWidth: 1,
    borderColor: colors.border,
    backgroundColor: colors.surface,
    paddingHorizontal: spacing.lg,
    fontSize: typography.sizes.md,
    color: colors.text,
  },
  inputError: {
    borderColor: colors.danger,
  },
  segmentRow: {
    flexDirection: 'row',
    gap: spacing.sm,
  },
  segment: {
    flex: 1,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    gap: spacing.xs,
    minHeight: 42,
    borderRadius: radius.md,
    borderWidth: 1,
    borderColor: colors.border,
    backgroundColor: colors.surface,
    paddingHorizontal: spacing.sm,
    paddingVertical: spacing.xs,
  },
  segmentLabel: {
    fontSize: typography.sizes.sm,
    fontWeight: '600',
    lineHeight: 20,
    flexShrink: 0,
    minWidth: 64,
    textAlign: 'center',
  },
});
