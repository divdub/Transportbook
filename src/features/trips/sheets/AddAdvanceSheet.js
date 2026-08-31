import React, {useState} from 'react';
import {
  KeyboardAvoidingView,
  Modal,
  Platform,
  StyleSheet,
  TextInput,
  TouchableOpacity,
  TouchableWithoutFeedback,
  View,
} from 'react-native';
import Icon from 'react-native-vector-icons/MaterialCommunityIcons';
import {AppButton} from '../../../components/common/AppButton';
import {AppText} from '../../../components/common/AppText';
import {DatePickerModal} from '../components/DatePickerModal';
import {colors, radius, spacing} from '../../../theme';

const PAYMENT_MODES = ['Cash', 'Cheque', 'UPI', 'Bank Transfer','Fuel',"Others"];

function getFormattedToday() {
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  const now = new Date();
  return `${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
}

export function AddAdvanceSheet({
  visible,
  onSave,
  onClose,
  isPending,
}) {
  const [amount, setAmount] = useState('');
  const [date, setDate] = useState(getFormattedToday());
  const [paymentMode, setPaymentMode] = useState('Cash');
  const [receivedByDriver, setReceivedByDriver] = useState(false);
  const [note, setNote] = useState('');
  const [datePickerVisible, setDatePickerVisible] = useState(false);
  const handleSave = () => {
    if (!amount.trim()) return;
    onSave({
      amount: Number(amount),
      date,
      paymentMode,
      receivedByDriver,
      note: note.trim(),
    });
  };

  return (
    <Modal
      visible={visible}
      animationType="slide"
      transparent
      onRequestClose={onClose}>
      <TouchableWithoutFeedback onPress={onClose}>
        <View style={styles.overlay}>
          <TouchableWithoutFeedback onPress={e => e.stopPropagation()}>
            <KeyboardAvoidingView
              behavior={Platform.OS === 'ios' ? 'padding' : undefined}
              style={styles.sheetContainer}>
              
              {/* Header */}
              <View style={styles.header}>
                <AppText variant="heading" style={styles.title}>
                  Add Advance
                </AppText>
                <TouchableOpacity
                  onPress={onClose}
                  style={styles.closeBtn}
                  accessibilityLabel="Close">
                  <Icon name="close" size={24} color={colors.text} />
                </TouchableOpacity>
              </View>

              {/* Form Fields */}
              <View style={styles.form}>
                {/* Advance Amount */}
                <View style={styles.fieldWrapper}>
                  <View style={styles.inputWithPrefix}>
                    <AppText variant="body" style={styles.currencyPrefix}>
                      ₹
                    </AppText>
                    <TextInput
                      value={amount}
                      onChangeText={setAmount}
                      placeholder="Advance Amount"
                      placeholderTextColor={colors.textMuted}
                      keyboardType="numeric"
                      style={styles.flexInput}
                      autoFocus
                    />
                  </View>
                </View>

                {/* Advance Date */}
                <TouchableOpacity
                  style={styles.fieldWrapper}
                  onPress={() => setDatePickerVisible(true)}
                  activeOpacity={0.7}>
                  <View style={styles.floatingLabel}>
                    <AppText variant="caption" color="textMuted" style={styles.labelText}>
                      Advance Date
                    </AppText>
                  </View>
                  <View style={styles.inputWithSuffix}>
                    <AppText
                      variant="body"
                      style={[styles.flexInputText, !date && styles.placeholderText]}>
                      {date || 'Select Advance Date'}
                    </AppText>
                    <Icon name="calendar-month-outline" size={20} color={colors.primary} />
                  </View>
                </TouchableOpacity>

                {/* Payment Mode Selector */}
                <View style={styles.paymentSection}>
                  <AppText variant="caption" color="textMuted" style={styles.sectionLabel}>
                    Payment Mode
                  </AppText>
                  <View style={styles.chipRow}>
                    {PAYMENT_MODES.map(mode => {
                      const isSelected = paymentMode === mode;
                      return (
                        <TouchableOpacity
                          key={mode}
                          style={[
                            styles.chip,
                            isSelected && styles.chipSelected,
                          ]}
                          onPress={() => setPaymentMode(mode)}
                          activeOpacity={0.7}>
                          <AppText
                            variant="label"
                            style={[
                              styles.chipText,
                              isSelected && styles.chipTextSelected,
                            ]}>
                            {mode}
                          </AppText>
                        </TouchableOpacity>
                      );
                    })}
                  </View>
                </View>

                {/* Received by Driver Toggle */}
                <TouchableOpacity
                  style={styles.checkboxRow}
                  onPress={() => setReceivedByDriver(!receivedByDriver)}
                  activeOpacity={0.7}>
                  <Icon
                    name={receivedByDriver ? 'checkbox-marked' : 'checkbox-blank-outline'}
                    size={22}
                    color={receivedByDriver ? colors.primary : colors.textMuted}
                  />
                  <AppText variant="body" style={styles.checkboxLabel}>
                    Received by Driver
                  </AppText>
                </TouchableOpacity>

                {/* Note */}
                <View style={styles.fieldWrapper}>
                  <TextInput
                    value={note}
                    onChangeText={setNote}
                    placeholder="Note (Optional)"
                    placeholderTextColor={colors.textMuted}
                    style={styles.input}
                  />
                </View>

                {/* Save Button */}
                <AppButton
                  title={isPending ? 'Saving...' : 'Save'}
                  onPress={handleSave}
                  disabled={!amount.trim() || isPending}
                  style={styles.saveBtn}
                />
              </View>
            </KeyboardAvoidingView>
          </TouchableWithoutFeedback>
        </View>
      </TouchableWithoutFeedback>

      {/* Advance Date Calendar Picker Modal */}
      <DatePickerModal
        visible={datePickerVisible}
        initialDate={date}
        onSelectDate={setDate}
        onClose={() => setDatePickerVisible(false)}
        title="Select Advance Date"
      />
    </Modal>
  );
}

const styles = StyleSheet.create({
  overlay: {
    flex: 1,
    backgroundColor: 'rgba(0, 0, 0, 0.45)',
    justifyContent: 'flex-end',
  },
  sheetContainer: {
    backgroundColor: colors.surface,
    borderTopLeftRadius: radius.xl,
    borderTopRightRadius: radius.xl,
    paddingHorizontal: spacing.lg,
    paddingTop: spacing.lg,
    paddingBottom: Platform.OS === 'ios' ? spacing['3xl'] : spacing.xl,
  },
  header: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: spacing.lg,
  },
  title: {
    fontSize: 18,
    fontWeight: '700',
    color: colors.text,
  },
  closeBtn: {
    padding: spacing.xs,
  },
  form: {
    gap: spacing.md,
  },
  fieldWrapper: {
    position: 'relative',
  },
  floatingLabel: {
    position: 'absolute',
    top: -9,
    left: 14,
    backgroundColor: colors.surface,
    paddingHorizontal: 4,
    zIndex: 2,
  },
  labelText: {
    fontSize: 11,
    fontWeight: '600',
    color: colors.textMuted,
  },
  sectionLabel: {
    fontSize: 12,
    fontWeight: '600',
    color: colors.textMuted,
    marginBottom: 6,
  },
  input: {
    height: 52,
    borderWidth: 1,
    borderColor: colors.border,
    borderRadius: radius.md,
    backgroundColor: colors.surface,
    paddingHorizontal: spacing.md,
    fontSize: 15,
    color: colors.text,
  },
  inputWithPrefix: {
    flexDirection: 'row',
    alignItems: 'center',
    height: 52,
    borderWidth: 1,
    borderColor: colors.border,
    borderRadius: radius.md,
    backgroundColor: colors.surface,
    paddingHorizontal: spacing.md,
  },
  inputWithSuffix: {
    flexDirection: 'row',
    alignItems: 'center',
    height: 52,
    borderWidth: 1,
    borderColor: colors.border,
    borderRadius: radius.md,
    backgroundColor: colors.surface,
    paddingHorizontal: spacing.md,
  },
  currencyPrefix: {
    fontSize: 18,
    fontWeight: '700',
    color: colors.text,
    marginRight: 6,
  },
  flexInput: {
    flex: 1,
    fontSize: 15,
    color: colors.text,
    paddingVertical: 0,
  },
  flexInputText: {
    flex: 1,
    fontSize: 15,
    color: colors.text,
  },
  placeholderText: {
    color: colors.textMuted,
  },
  paymentSection: {
    gap: 4,
  },
  chipRow: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: spacing.sm,
  },
  chip: {
    paddingHorizontal: spacing.md,
    paddingVertical: 7,
    borderRadius: radius.round,
    backgroundColor: colors.surfaceSubtle,
    borderWidth: 1,
    borderColor: colors.border,
  },
  chipSelected: {
    backgroundColor: colors.primarySoft,
    borderColor: colors.primary,
  },
  chipText: {
    fontSize: 12,
    fontWeight: '600',
    color: colors.textMuted,
  },
  chipTextSelected: {
    color: colors.primary,
    fontWeight: '700',
  },
  checkboxRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: spacing.sm,
    paddingVertical: spacing.xs,
  },
  checkboxLabel: {
    fontSize: 14,
    fontWeight: '500',
    color: colors.text,
  },
  saveBtn: {
    marginTop: spacing.sm,
    backgroundColor: colors.primary,
    height: 50,
    borderRadius: radius.md,
  },
});
