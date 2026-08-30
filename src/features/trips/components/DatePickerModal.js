import React, {useMemo, useState} from 'react';
import {
  Modal,
  StyleSheet,
  TouchableOpacity,
  View,
} from 'react-native';
import {SafeAreaView} from 'react-native-safe-area-context';
import Icon from 'react-native-vector-icons/MaterialCommunityIcons';
import {AppText} from '../../../components/common/AppText';
import {AppButton} from '../../../components/common/AppButton';
import {colors, radius, spacing} from '../../../theme';

const MONTH_NAMES = [
  'January', 'February', 'March', 'April', 'May', 'June',
  'July', 'August', 'September', 'October', 'November', 'December',
];

const SHORT_MONTHS = [
  'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
  'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',
];

const DAYS_OF_WEEK = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

export function DatePickerModal({visible, initialDate, onSelectDate, onClose}) {
  const [currentMonth, setCurrentMonth] = useState(new Date().getMonth());
  const [currentYear, setCurrentYear] = useState(new Date().getFullYear());
  const [selectedDay, setSelectedDay] = useState(new Date().getDate());

  const daysInMonth = useMemo(() => {
    return new Date(currentYear, currentMonth + 1, 0).getDate();
  }, [currentYear, currentMonth]);

  const firstDayOffset = useMemo(() => {
    return new Date(currentYear, currentMonth, 1).getDay();
  }, [currentYear, currentMonth]);

  const handlePrevMonth = () => {
    if (currentMonth === 0) {
      setCurrentMonth(11);
      setCurrentYear(y => y - 1);
    } else {
      setCurrentMonth(m => m - 1);
    }
  };

  const handleNextMonth = () => {
    if (currentMonth === 11) {
      setCurrentMonth(0);
      setCurrentYear(y => y + 1);
    } else {
      setCurrentMonth(m => m + 1);
    }
  };

  const handleSelectDay = d => {
    setSelectedDay(d);
  };

  const handleConfirm = () => {
    const formattedDate = `${selectedDay} ${SHORT_MONTHS[currentMonth]} ${currentYear}`;
    onSelectDate(formattedDate);
    onClose();
  };

  const handleSetPreset = type => {
    const today = new Date();
    if (type === 'yesterday') {
      today.setDate(today.getDate() - 1);
    } else if (type === 'tomorrow') {
      today.setDate(today.getDate() + 1);
    }
    setCurrentMonth(today.getMonth());
    setCurrentYear(today.getFullYear());
    setSelectedDay(today.getDate());
    const formatted = `${today.getDate()} ${SHORT_MONTHS[today.getMonth()]} ${today.getFullYear()}`;
    onSelectDate(formatted);
    onClose();
  };

  // Build grid of day slots
  const daySlots = useMemo(() => {
    const slots = [];
    for (let i = 0; i < firstDayOffset; i++) {
      slots.push(null);
    }
    for (let d = 1; d <= daysInMonth; d++) {
      slots.push(d);
    }
    return slots;
  }, [firstDayOffset, daysInMonth]);

  return (
    <Modal
      visible={visible}
      animationType="fade"
      transparent
      onRequestClose={onClose}>
      <TouchableOpacity
        style={styles.backdrop}
        activeOpacity={1}
        onPress={onClose}>
        <SafeAreaView style={styles.modalOverlay}>
          <TouchableOpacity activeOpacity={1} style={styles.cardContainer}>
            {/* Header */}
            <View style={styles.cardHeader}>
              <AppText variant="heading" style={styles.cardTitle}>
                Select Trip Start Date
              </AppText>
              <TouchableOpacity onPress={onClose} style={styles.closeBtn}>
                <Icon name="close" size={22} color={colors.textMuted} />
              </TouchableOpacity>
            </View>

            {/* Presets */}
            <View style={styles.presetsRow}>
              <TouchableOpacity
                style={styles.presetChip}
                onPress={() => handleSetPreset('yesterday')}>
                <AppText variant="caption" style={styles.presetText}>
                  Yesterday
                </AppText>
              </TouchableOpacity>

              <TouchableOpacity
                style={[styles.presetChip, styles.presetChipActive]}
                onPress={() => handleSetPreset('today')}>
                <AppText variant="caption" style={styles.presetTextActive}>
                  Today
                </AppText>
              </TouchableOpacity>

              <TouchableOpacity
                style={styles.presetChip}
                onPress={() => handleSetPreset('tomorrow')}>
                <AppText variant="caption" style={styles.presetText}>
                  Tomorrow
                </AppText>
              </TouchableOpacity>
            </View>

            {/* Month Year Navigator */}
            <View style={styles.monthNav}>
              <TouchableOpacity onPress={handlePrevMonth} style={styles.navBtn}>
                <Icon name="chevron-left" size={24} color={colors.text} />
              </TouchableOpacity>
              <AppText variant="heading" style={styles.monthYearText}>
                {MONTH_NAMES[currentMonth]} {currentYear}
              </AppText>
              <TouchableOpacity onPress={handleNextMonth} style={styles.navBtn}>
                <Icon name="chevron-right" size={24} color={colors.text} />
              </TouchableOpacity>
            </View>

            {/* Days of Week Row */}
            <View style={styles.daysHeader}>
              {DAYS_OF_WEEK.map(d => (
                <AppText key={d} variant="caption" color="textMuted" style={styles.dayHeaderCell}>
                  {d}
                </AppText>
              ))}
            </View>

            {/* Days Grid */}
            <View style={styles.daysGrid}>
              {daySlots.map((slot, index) => {
                if (slot === null) {
                  return <View key={`empty-${index}`} style={styles.dayCell} />;
                }
                const isSelected = slot === selectedDay;
                return (
                  <TouchableOpacity
                    key={`day-${slot}`}
                    style={[styles.dayCell, isSelected && styles.dayCellSelected]}
                    onPress={() => handleSelectDay(slot)}>
                    <AppText
                      variant="body"
                      style={[styles.dayText, isSelected && styles.dayTextSelected]}>
                      {slot}
                    </AppText>
                  </TouchableOpacity>
                );
              })}
            </View>

            {/* Confirm Button */}
            <AppButton
              title={`Confirm (${selectedDay} ${SHORT_MONTHS[currentMonth]} ${currentYear})`}
              onPress={handleConfirm}
              style={styles.confirmBtn}
            />
          </TouchableOpacity>
        </SafeAreaView>
      </TouchableOpacity>
    </Modal>
  );
}

const styles = StyleSheet.create({
  backdrop: {
    flex: 1,
    backgroundColor: 'rgba(0,0,0,0.5)',
    justifyContent: 'center',
    alignItems: 'center',
  },
  modalOverlay: {
    width: '100%',
    paddingHorizontal: spacing.md,
    alignItems: 'center',
  },
  cardContainer: {
    width: '100%',
    maxWidth: 360,
    backgroundColor: colors.surface,
    borderRadius: radius.lg,
    padding: spacing.md,
    gap: spacing.sm,
    shadowColor: '#000',
    shadowOffset: {width: 0, height: 6},
    shadowOpacity: 0.15,
    shadowRadius: 16,
    elevation: 8,
  },
  cardHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingBottom: spacing.xs,
    borderBottomWidth: 1,
    borderBottomColor: colors.border,
  },
  cardTitle: {
    fontSize: 16,
    fontWeight: '700',
  },
  closeBtn: {
    padding: 4,
  },
  presetsRow: {
    flexDirection: 'row',
    justifyContent: 'center',
    gap: spacing.sm,
    marginVertical: spacing.xs,
  },
  presetChip: {
    paddingHorizontal: spacing.md,
    paddingVertical: 6,
    borderRadius: radius.round,
    backgroundColor: colors.surfaceSubtle,
    borderWidth: 1,
    borderColor: colors.border,
  },
  presetChipActive: {
    backgroundColor: colors.primarySoft,
    borderColor: colors.primary,
  },
  presetText: {
    fontWeight: '600',
    color: colors.text,
  },
  presetTextActive: {
    fontWeight: '700',
    color: colors.primary,
  },
  monthNav: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingHorizontal: spacing.sm,
  },
  navBtn: {
    padding: spacing.xs,
  },
  monthYearText: {
    fontSize: 16,
    fontWeight: '700',
  },
  daysHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
  },
  dayHeaderCell: {
    width: 40,
    textAlign: 'center',
    fontWeight: '600',
  },
  daysGrid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    justifyContent: 'flex-start',
  },
  dayCell: {
    width: '14.28%',
    height: 38,
    alignItems: 'center',
    justifyContent: 'center',
    borderRadius: radius.md,
  },
  dayCellSelected: {
    backgroundColor: colors.primary,
  },
  dayText: {
    fontSize: 14,
    color: colors.text,
  },
  dayTextSelected: {
    color: '#FFF',
    fontWeight: '700',
  },
  confirmBtn: {
    marginTop: spacing.xs,
    height: 44,
  },
});
