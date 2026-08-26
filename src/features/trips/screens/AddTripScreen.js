import React, {useMemo, useState} from 'react';
import {
  KeyboardAvoidingView,
  Platform,
  ScrollView,
  StyleSheet,
  TextInput,
  TouchableOpacity,
  View,
} from 'react-native';
import {useNavigation} from '@react-navigation/native';
import {Controller, useForm} from 'react-hook-form';
import {zodResolver} from '@hookform/resolvers/zod';
import Icon from 'react-native-vector-icons/MaterialCommunityIcons';
import {AppButton} from '../../../components/common/AppButton';
import {AppScreen} from '../../../components/common/AppScreen';
import {AppText} from '../../../components/common/AppText';
import {SelectOptionModal} from '../components/SelectOptionModal';
import {AddMoreDetailsSheet} from '../sheets/AddMoreDetailsSheet';
import {useAddTripMutation} from '../hooks/useAddTripMutation';
import {usePartiesQuery} from '../../parties/hooks/usePartiesQuery';
import {addTripSchema} from '../tripsValidation';
import {routes} from '../../../navigation/routeNames';
import {colors, radius, spacing} from '../../../theme';

const BILLING_TYPES = ['Fixed', 'Per Tonne', 'Per KG', 'More'];

const COMMON_TRUCKS = [
  'KA 12 DS 3747',
  'MH 04 AB 8821',
  'GJ 01 XX 4410',
  'DL 01 AA 9021',
  'RJ 14 GB 1290',
  'HR 26 DQ 5520',
  'AP 09 CK 3311',
  'TN 02 BB 7744',
];

const COMMON_DRIVERS = [
  'Ramesh Kumar',
  'Suresh Patil',
  'Vikram Singh',
  'Manoj Yadav',
  'Deepak Sharma',
  'Rajesh Verma',
  'Unassigned',
];

const COMMON_CITIES = [
  'Bangalore',
  'Hyderabad',
  'Mumbai',
  'Delhi NCR',
  'Pune',
  'Chennai',
  'Ahmedabad',
  'Kolkata',
  'Jaipur',
  'Indore',
  'Surat',
  'Nagpur',
  'Lucknow',
  'Chandigarh',
  'Visakhapatnam',
  'Coimbatore',
];

function getFormattedToday() {
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  const now = new Date();
  return `${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
}

export default function AddTripScreen() {
  const navigation = useNavigation();
  const {mutateAsync: createTrip, isPending} = useAddTripMutation();
  const {data: parties} = usePartiesQuery();

  const [moreDetailsVisible, setMoreDetailsVisible] = useState(false);
  const [activePicker, setActivePicker] = useState(null); // 'party' | 'truck' | 'driver' | 'origin' | 'destination' | null
  const [sendSmsToParty, setSendSmsToParty] = useState(false);

  const partyOptions = useMemo(() => {
    if (!parties || parties.length === 0) {
      return ['Sainy Logistics', 'Tata Steel Ltd', 'Reliance Retail', 'Ultratech Cement', 'Ambuja Logistics'];
    }
    return parties.map(p => ({
      name: p.name,
      label: p.name,
      sublabel: p.category,
      value: p.name,
    }));
  }, [parties]);

  const {
    control,
    handleSubmit,
    setValue,
    watch,
    formState: {errors, isValid},
  } = useForm({
    resolver: zodResolver(addTripSchema),
    mode: 'onChange',
    defaultValues: {
      partyName: 'Sainy',
      truckNumber: 'KA12DS3747',
      driverName: '',
      driverPhone: '',
      origin: '',
      destination: '',
      billingType: 'Fixed',
      freightAmount: '',
      tripStartDate: getFormattedToday(),
      lrNumber: '',
      material: '',
      startKm: '',
      note: '',
    },
  });

  const formValues = watch();

  const onSubmit = async values => {
    const created = await createTrip(values);
    if (created && created.id) {
      navigation.replace(routes.tripDetails, {tripId: created.id});
    } else {
      navigation.goBack();
    }
  };

  const handleMoreDetailsSave = details => {
    setValue('lrNumber', details.lrNumber);
    setValue('material', details.material);
    setValue('startKm', details.startKm);
    setValue('note', details.note);
  };

  return (
    <KeyboardAvoidingView
      behavior={Platform.OS === 'ios' ? 'padding' : undefined}
      style={styles.keyboardContainer}>
      <AppScreen scroll={false} style={styles.screen} contentStyle={styles.screenContent}>
        {/* Custom Header */}
        <View style={styles.header}>
          <TouchableOpacity
            onPress={() => navigation.goBack()}
            style={styles.headerBackBtn}
            accessibilityLabel="Back">
            <Icon name="arrow-left" size={24} color={colors.text} />
          </TouchableOpacity>

          <AppText variant="heading" style={styles.headerTitle}>
            Add Trip
          </AppText>

          <TouchableOpacity
            style={styles.youtubeBtn}
            accessibilityLabel="Help Video">
            <Icon name="youtube" size={28} color="#FF0000" />
          </TouchableOpacity>
        </View>

        <ScrollView
          showsVerticalScrollIndicator={false}
          contentContainerStyle={styles.scrollContent}>
          
          {/* Main Form Fields Container */}
          <View style={styles.formCard}>
            
            {/* Party / Customer Name */}
            <Controller
              control={control}
              name="partyName"
              render={({field: {value}}) => (
                <TouchableOpacity
                  style={styles.fieldContainer}
                  onPress={() => setActivePicker('party')}
                  activeOpacity={0.7}>
                  <View style={styles.floatingLabel}>
                    <AppText variant="caption" color="textMuted" style={styles.labelText}>
                      Party/Customer Name
                    </AppText>
                  </View>
                  <View style={styles.dropdownInput}>
                    <AppText
                      variant="body"
                      style={[styles.inputText, !value && styles.placeholderText]}>
                      {value || 'Select Party / Customer'}
                    </AppText>
                    <Icon name="menu-down" size={22} color={colors.textMuted} />
                  </View>
                </TouchableOpacity>
              )}
            />

            {/* Row: Truck No & Driver Name */}
            <View style={styles.row}>
              {/* Truck No */}
              <Controller
                control={control}
                name="truckNumber"
                render={({field: {value}}) => (
                  <TouchableOpacity
                    style={[styles.fieldContainer, styles.rowField]}
                    onPress={() => setActivePicker('truck')}
                    activeOpacity={0.7}>
                    <View style={styles.floatingLabel}>
                      <AppText variant="caption" color="textMuted" style={styles.labelText}>
                        Truck No.
                      </AppText>
                    </View>
                    <View style={styles.dropdownInput}>
                      <AppText
                        variant="body"
                        style={[styles.inputText, styles.boldInput, !value && styles.placeholderText]}>
                        {value || 'Truck No.'}
                      </AppText>
                      <Icon name="menu-down" size={22} color={colors.textMuted} />
                    </View>
                  </TouchableOpacity>
                )}
              />

              {/* Driver Name */}
              <Controller
                control={control}
                name="driverName"
                render={({field: {value}}) => (
                  <TouchableOpacity
                    style={[styles.fieldContainer, styles.rowField]}
                    onPress={() => setActivePicker('driver')}
                    activeOpacity={0.7}>
                    <View style={styles.floatingLabel}>
                      <AppText variant="caption" color="textMuted" style={styles.labelText}>
                        Driver Name
                      </AppText>
                    </View>
                    <View style={styles.dropdownInput}>
                      <AppText
                        variant="body"
                        style={[styles.inputText, !value && styles.placeholderText]}>
                        {value || 'Optional'}
                      </AppText>
                      <Icon name="menu-down" size={22} color={colors.textMuted} />
                    </View>
                  </TouchableOpacity>
                )}
              />
            </View>

            {/* Row: Origin & Destination */}
            <View style={styles.row}>
              {/* Origin */}
              <Controller
                control={control}
                name="origin"
                render={({field: {value}}) => (
                  <TouchableOpacity
                    style={[styles.fieldContainer, styles.rowField]}
                    onPress={() => setActivePicker('origin')}
                    activeOpacity={0.7}>
                    <View style={styles.dropdownInput}>
                      <AppText
                        variant="body"
                        style={[styles.inputText, !value && styles.placeholderText]}>
                        {value || 'Origin'}
                      </AppText>
                      <Icon name="menu-down" size={22} color={colors.textMuted} />
                    </View>
                  </TouchableOpacity>
                )}
              />

              {/* Destination */}
              <Controller
                control={control}
                name="destination"
                render={({field: {value}}) => (
                  <TouchableOpacity
                    style={[styles.fieldContainer, styles.rowField]}
                    onPress={() => setActivePicker('destination')}
                    activeOpacity={0.7}>
                    <View style={styles.dropdownInput}>
                      <AppText
                        variant="body"
                        style={[styles.inputText, !value && styles.placeholderText]}>
                        {value || 'Destination'}
                      </AppText>
                      <Icon name="menu-down" size={22} color={colors.textMuted} />
                    </View>
                  </TouchableOpacity>
                )}
              />
            </View>

            {/* Party Billing Type */}
            <View style={styles.billingSection}>
              <View style={styles.billingHeader}>
                <AppText variant="body" color="textMuted" style={styles.billingLabel}>
                  Party Billing Type
                </AppText>
                <Icon name="information-outline" size={16} color={colors.textMuted} />
              </View>

              <Controller
                control={control}
                name="billingType"
                render={({field: {value, onChange}}) => (
                  <View style={styles.billingChipsRow}>
                    {BILLING_TYPES.map(type => {
                      const isSelected = value === type;
                      return (
                        <TouchableOpacity
                          key={type}
                          style={[
                            styles.billingChip,
                            isSelected && styles.billingChipSelected,
                          ]}
                          onPress={() => onChange(type)}
                          activeOpacity={0.7}>
                          <AppText
                            variant="label"
                            style={[
                              styles.billingChipText,
                              isSelected && styles.billingChipTextSelected,
                            ]}>
                            {type === 'More' ? 'More ▾' : type}
                          </AppText>
                        </TouchableOpacity>
                      );
                    })}
                  </View>
                )}
              />
            </View>

            {/* Party Freight Amount */}
            <Controller
              control={control}
              name="freightAmount"
              render={({field: {value, onChange}}) => (
                <View style={styles.fieldContainer}>
                  <View style={styles.inputWithSuffix}>
                    <TextInput
                      value={value}
                      onChangeText={onChange}
                      placeholder="Party Freight Amount"
                      placeholderTextColor={colors.textMuted}
                      keyboardType="numeric"
                      style={styles.flexInput}
                    />
                    <AppText variant="body" color="textMuted" style={styles.currencySymbol}>
                      ₹
                    </AppText>
                  </View>
                  {errors.freightAmount ? (
                    <AppText variant="caption" color="danger">
                      {errors.freightAmount.message}
                    </AppText>
                  ) : null}
                </View>
              )}
            />

            {/* Trip Start Date */}
            <Controller
              control={control}
              name="tripStartDate"
              render={({field: {value, onChange}}) => (
                <View style={styles.fieldContainer}>
                  <View style={styles.floatingLabel}>
                    <AppText variant="caption" color="textMuted" style={styles.labelText}>
                      Trip Start Date
                    </AppText>
                  </View>
                  <View style={styles.inputWithSuffix}>
                    <TextInput
                      value={value}
                      onChangeText={onChange}
                      placeholder="Trip Start Date"
                      placeholderTextColor={colors.textMuted}
                      style={styles.flexInput}
                    />
                    <Icon name="calendar-month-outline" size={20} color={colors.textMuted} />
                  </View>
                </View>
              )}
            />

            {/* Add More Details Button */}
            <View style={styles.moreDetailsRow}>
              <TouchableOpacity
                style={styles.addMoreDetailsBtn}
                onPress={() => setMoreDetailsVisible(true)}
                activeOpacity={0.7}>
                <AppText variant="label" style={styles.addMoreDetailsText}>
                  Add More Details
                </AppText>
              </TouchableOpacity>
            </View>

          </View>
        </ScrollView>

        {/* Bottom SMS Checkbox & Save Trip Button */}
        <View style={styles.footerContainer}>
          {/* SMS Checkbox */}
          <View style={styles.smsBox}>
            <AppText variant="body" color="textMuted" style={styles.smsLabel}>
              Send SMS to :
            </AppText>
            <TouchableOpacity
              style={styles.checkboxRow}
              onPress={() => setSendSmsToParty(!sendSmsToParty)}
              activeOpacity={0.7}>
              <Icon
                name={sendSmsToParty ? 'checkbox-marked' : 'checkbox-blank-outline'}
                size={20}
                color={sendSmsToParty ? colors.primary : colors.textMuted}
              />
              <AppText variant="body" style={styles.checkboxLabel}>
                Party
              </AppText>
            </TouchableOpacity>
          </View>

          {/* Save Button */}
          <AppButton
            title={isPending ? 'Saving...' : 'Save Trip'}
            onPress={handleSubmit(onSubmit)}
            disabled={isPending || !formValues.partyName || !formValues.truckNumber || !isValid}
            style={styles.saveTripBtn}
          />
        </View>

        {/* Selection Picker Modals */}
        <SelectOptionModal
          visible={activePicker === 'party'}
          title="Select Party / Customer"
          options={partyOptions}
          selectedValue={formValues.partyName}
          onSelect={val => setValue('partyName', val, {shouldValidate: true})}
          onClose={() => setActivePicker(null)}
          placeholder="Search party name..."
        />

        <SelectOptionModal
          visible={activePicker === 'truck'}
          title="Select Truck Number"
          options={COMMON_TRUCKS}
          selectedValue={formValues.truckNumber}
          onSelect={val => setValue('truckNumber', val, {shouldValidate: true})}
          onClose={() => setActivePicker(null)}
          placeholder="Search or enter truck no..."
        />

        <SelectOptionModal
          visible={activePicker === 'driver'}
          title="Select Driver"
          options={COMMON_DRIVERS}
          selectedValue={formValues.driverName}
          onSelect={val => setValue('driverName', val, {shouldValidate: true})}
          onClose={() => setActivePicker(null)}
          placeholder="Search or enter driver name..."
        />

        <SelectOptionModal
          visible={activePicker === 'origin'}
          title="Select Origin City"
          options={COMMON_CITIES}
          selectedValue={formValues.origin}
          onSelect={val => setValue('origin', val, {shouldValidate: true})}
          onClose={() => setActivePicker(null)}
          placeholder="Search origin city..."
        />

        <SelectOptionModal
          visible={activePicker === 'destination'}
          title="Select Destination City"
          options={COMMON_CITIES}
          selectedValue={formValues.destination}
          onSelect={val => setValue('destination', val, {shouldValidate: true})}
          onClose={() => setActivePicker(null)}
          placeholder="Search destination city..."
        />

        {/* Add More Details Bottom Sheet */}
        <AddMoreDetailsSheet
          visible={moreDetailsVisible}
          initialValues={{
            lrNumber: formValues.lrNumber,
            material: formValues.material,
            startKm: formValues.startKm,
            note: formValues.note,
          }}
          onSave={handleMoreDetailsSave}
          onClose={() => setMoreDetailsVisible(false)}
        />
      </AppScreen>
    </KeyboardAvoidingView>
  );
}

const styles = StyleSheet.create({
  keyboardContainer: {
    flex: 1,
  },
  screen: {
    flex: 1,
    backgroundColor: colors.background,
  },
  screenContent: {
    padding: 0,
  },
  header: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.md,
    backgroundColor: colors.surface,
    borderBottomWidth: 1,
    borderBottomColor: colors.border,
  },
  headerBackBtn: {
    padding: spacing.xs,
  },
  headerTitle: {
    fontSize: 18,
    fontWeight: '700',
    color: colors.text,
  },
  youtubeBtn: {
    padding: spacing.xs,
  },
  scrollContent: {
    padding: spacing.md,
    paddingBottom: spacing['3xl'],
  },
  formCard: {
    gap: spacing.lg,
  },
  fieldContainer: {
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
  dropdownInput: {
    height: 52,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    borderWidth: 1,
    borderColor: colors.border,
    borderRadius: radius.md,
    backgroundColor: colors.surface,
    paddingHorizontal: spacing.md,
  },
  inputText: {
    fontSize: 15,
    color: colors.text,
  },
  boldInput: {
    fontWeight: '700',
  },
  placeholderText: {
    color: colors.textMuted,
  },
  row: {
    flexDirection: 'row',
    gap: spacing.md,
  },
  rowField: {
    flex: 1,
  },
  billingSection: {
    gap: spacing.sm,
  },
  billingHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: spacing.xs,
  },
  billingLabel: {
    fontSize: 13,
    fontWeight: '500',
  },
  billingChipsRow: {
    flexDirection: 'row',
    gap: spacing.sm,
  },
  billingChip: {
    paddingHorizontal: spacing.md,
    paddingVertical: 7,
    borderRadius: radius.round,
    backgroundColor: '#D1D5DB',
  },
  billingChipSelected: {
    backgroundColor: colors.primarySoft,
    borderWidth: 1.5,
    borderColor: colors.primary,
  },
  billingChipText: {
    fontSize: 13,
    fontWeight: '600',
    color: colors.text,
  },
  billingChipTextSelected: {
    color: colors.primary,
    fontWeight: '700',
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
  flexInput: {
    flex: 1,
    fontSize: 15,
    color: colors.text,
    paddingVertical: 0,
  },
  currencySymbol: {
    fontSize: 16,
    fontWeight: '600',
  },
  moreDetailsRow: {
    alignItems: 'flex-end',
  },
  addMoreDetailsBtn: {
    borderWidth: 1,
    borderColor: colors.primary,
    borderRadius: radius.sm,
    paddingHorizontal: spacing.md,
    paddingVertical: 8,
  },
  addMoreDetailsText: {
    color: colors.primary,
    fontWeight: '600',
    fontSize: 13,
  },
  footerContainer: {
    padding: spacing.md,
    backgroundColor: colors.surface,
    borderTopWidth: 1,
    borderTopColor: colors.border,
    gap: spacing.sm,
  },
  smsBox: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: spacing.md,
    backgroundColor: colors.surfaceSubtle,
    borderRadius: radius.md,
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.sm,
  },
  smsLabel: {
    fontSize: 13,
  },
  checkboxRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 6,
  },
  checkboxLabel: {
    fontSize: 13,
    fontWeight: '600',
  },
  saveTripBtn: {
    height: 48,
    borderRadius: radius.md,
    backgroundColor: colors.primary,
  },
});
