import React, {useCallback, useMemo, useState} from 'react';
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
import {ContactsPickerModal} from '../components/ContactsPickerModal';
import {StateCityPickerModal} from '../components/StateCityPickerModal';
import {DatePickerModal} from '../components/DatePickerModal';
import {QuickAddModal} from '../components/QuickAddModal';
import {AddMoreDetailsSheet} from '../sheets/AddMoreDetailsSheet';
import {useAddTripMutation} from '../hooks/useAddTripMutation';
import {usePartiesQuery} from '../../parties/hooks/usePartiesQuery';
import {useTrucksQuery} from '../../trucks/hooks/useTrucksQuery';
import {addTripSchema} from '../tripsValidation';
import {routes} from '../../../navigation/routeNames';
import {colors, radius, spacing} from '../../../theme';

const PRIMARY_BILLING_TYPES = ['Fixed', 'Per Tonne', 'Per KG', 'More'];

const ALL_BILLING_TYPES = [
  'Fixed',
  'Per Tonne',
  'Per KG',
  'Per Km',
  'Per Trip',
  'Per Day',
  'Per Hour',
  'Per Litre',
  'Per Bag',
  'Per Box',
];

const BILLING_CONFIG = {
  Fixed: {rateLabel: '', qtyLabel: '', unitName: ''},
  'Per Tonne': {rateLabel: 'Rate per Tonne (₹)', qtyLabel: 'Total Tonnes', unitName: 'Tonne'},
  'Per KG': {rateLabel: 'Rate per KG (₹)', qtyLabel: 'Total KG', unitName: 'KG'},
  'Per Km': {rateLabel: 'Rate per Km (₹)', qtyLabel: 'Total Km', unitName: 'Km'},
  'Per Trip': {rateLabel: 'Rate per Trip (₹)', qtyLabel: 'Total Trips', unitName: 'Trip'},
  'Per Day': {rateLabel: 'Rate per Day (₹)', qtyLabel: 'Total Days', unitName: 'Day'},
  'Per Hour': {rateLabel: 'Rate per Hour (₹)', qtyLabel: 'Total Hours', unitName: 'Hour'},
  'Per Litre': {rateLabel: 'Rate per Litre (₹)', qtyLabel: 'Total Litres', unitName: 'Litre'},
  'Per Bag': {rateLabel: 'Rate per Bag (₹)', qtyLabel: 'Total Bags', unitName: 'Bag'},
  'Per Box': {rateLabel: 'Rate per Box (₹)', qtyLabel: 'Total Boxes', unitName: 'Box'},
};

const DEFAULT_TRUCKS = [
  'KA 12 DS 3747',
  'MH 04 AB 8821',
  'GJ 01 XX 4410',
  'DL 01 AA 9021',
  'RJ 14 GB 1290',
  'HR 26 DQ 5520',
  'AP 09 CK 3311',
  'TN 02 BB 7744',
];

const DEFAULT_DRIVERS = [
  {name: 'Ramesh Kumar', phone: '9876543210'},
  {name: 'Suresh Patil', phone: '9822011223'},
  {name: 'Vikram Singh', phone: '9711223344'},
  {name: 'Manoj Yadav', phone: '9988776655'},
  {name: 'Deepak Sharma', phone: '9811224466'},
  {name: 'Rajesh Verma', phone: '9845012345'},
  {name: 'Unassigned', phone: ''},
];

function getFormattedToday() {
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  const now = new Date();
  return `${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
}

export default function AddTripScreen() {
  const navigation = useNavigation();
  const {mutateAsync: createTrip, isPending} = useAddTripMutation();
  const {data: apiParties} = usePartiesQuery();
  const {data: apiTrucks} = useTrucksQuery();

  // Custom added items in state
  const [customParties, setCustomParties] = useState([]);
  const [customTrucks, setCustomTrucks] = useState([]);
  const [customDrivers, setCustomDrivers] = useState([]);

  // Modals visibility state
  const [moreDetailsVisible, setMoreDetailsVisible] = useState(false);
  const [activePicker, setActivePicker] = useState(null); // 'party' | 'truck' | 'driver' | 'moreBilling' | null
  const [activeLocationPicker, setActiveLocationPicker] = useState(null); // 'origin' | 'destination' | null
  const [contactsModalVisible, setContactsModalVisible] = useState(false);
  const [contactsTarget, setContactsTarget] = useState('party'); // 'party' | 'driver'
  const [datePickerVisible, setDatePickerVisible] = useState(false);
  const [quickAddModalVisible, setQuickAddModalVisible] = useState(false);
  const [quickAddType, setQuickAddType] = useState('party'); // 'party' | 'truck' | 'driver'

  const [sendSmsToParty, setSendSmsToParty] = useState(false);

  // Form setup
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
      partyName: 'Sainy Logistics',
      truckNumber: 'KA12DS3747',
      driverName: '',
      driverPhone: '',
      origin: '',
      destination: '',
      billingType: 'Fixed',
      billingRate: '',
      billingQuantity: '',
      freightAmount: '',
      tripStartDate: getFormattedToday(),
      lrNumber: '',
      material: '',
      startKm: '',
      note: '',
    },
  });

  const formValues = watch();

  // Combined Party Options
  const partyOptions = useMemo(() => {
    const defaultList = [
      {name: 'Sainy Logistics', category: 'Transport Partner'},
      {name: 'Tata Steel Ltd', category: 'Goods Supplier'},
      {name: 'Reliance Retail', category: 'FMCG Partner'},
      {name: 'Ultratech Cement', category: 'Manufacturer'},
      {name: 'Ambuja Logistics', category: 'Partner'},
    ];
    const fromApi = apiParties && apiParties.length > 0 ? apiParties : defaultList;
    const combined = [...customParties, ...fromApi];
    // Remove duplicates
    const seen = new Set();
    return combined.filter(p => {
      if (seen.has(p.name)) return false;
      seen.add(p.name);
      return true;
    }).map(p => ({
      name: p.name,
      label: p.name,
      sublabel: p.category || p.phoneNumber || '',
      value: p.name,
    }));
  }, [apiParties, customParties]);

  // Combined Truck Options
  const truckOptions = useMemo(() => {
    const fromApi = apiTrucks && apiTrucks.length > 0
      ? apiTrucks.map(t => t.vehicleNumber)
      : DEFAULT_TRUCKS;
    const combined = [...customTrucks, ...fromApi];
    const seen = new Set();
    return combined.filter(t => {
      const val = typeof t === 'string' ? t : t.vehicleNumber;
      if (seen.has(val)) return false;
      seen.add(val);
      return true;
    });
  }, [apiTrucks, customTrucks]);

  // Combined Driver Options
  const driverOptions = useMemo(() => {
    const combined = [...customDrivers, ...DEFAULT_DRIVERS];
    const seen = new Set();
    return combined.filter(d => {
      if (seen.has(d.name)) return false;
      seen.add(d.name);
      return true;
    }).map(d => ({
      name: d.name,
      label: d.name,
      sublabel: d.phone ? `Phone: ${d.phone}` : '',
      value: d.name,
      phone: d.phone || '',
    }));
  }, [customDrivers]);

  // Form Handlers
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

  // Live Auto-Calculation for Rate * Quantity
  const calculateFreight = useCallback((rateStr, qtyStr) => {
    const rate = parseFloat(rateStr);
    const qty = parseFloat(qtyStr);
    if (!isNaN(rate) && !isNaN(qty) && rate >= 0 && qty >= 0) {
      const total = rate * qty;
      const formatted = Number.isInteger(total) ? total.toString() : total.toFixed(2);
      setValue('freightAmount', formatted, {shouldValidate: true});
    }
  }, [setValue]);

  const handleRateChange = val => {
    setValue('billingRate', val, {shouldValidate: true});
    calculateFreight(val, formValues.billingQuantity);
  };

  const handleQuantityChange = val => {
    setValue('billingQuantity', val, {shouldValidate: true});
    calculateFreight(formValues.billingRate, val);
  };

  // Contacts picker selection handler
  const handleSelectContact = contact => {
    if (contactsTarget === 'party') {
      setValue('partyName', contact.name, {shouldValidate: true});
    } else if (contactsTarget === 'driver') {
      setValue('driverName', contact.name, {shouldValidate: true});
      setValue('driverPhone', contact.phone, {shouldValidate: true});
    }
  };

  // Quick Add handler
  const handleQuickAdd = addedData => {
    if (quickAddType === 'party') {
      setCustomParties(prev => [addedData, ...prev]);
      setValue('partyName', addedData.name, {shouldValidate: true});
    } else if (quickAddType === 'truck') {
      setCustomTrucks(prev => [addedData.vehicleNumber, ...prev]);
      setValue('truckNumber', addedData.vehicleNumber, {shouldValidate: true});
    } else if (quickAddType === 'driver') {
      setCustomDrivers(prev => [addedData, ...prev]);
      setValue('driverName', addedData.name, {shouldValidate: true});
      if (addedData.phone) setValue('driverPhone', addedData.phone, {shouldValidate: true});
    }
  };

  // Top action creators for pickers
  const partyTopActions = useMemo(() => [
    {
      label: '+ Add Party',
      icon: 'account-plus-outline',
      onPress: () => {
        setQuickAddType('party');
        setQuickAddModalVisible(true);
      },
    },
    {
      label: 'Choose from Contacts',
      icon: 'account-box-outline',
      onPress: () => {
        setContactsTarget('party');
        setContactsModalVisible(true);
      },
    },
  ], []);

  const truckTopActions = useMemo(() => [
    {
      label: '+ Add Truck',
      icon: 'truck-plus-outline',
      onPress: () => {
        setQuickAddType('truck');
        setQuickAddModalVisible(true);
      },
    },
  ], []);

  const driverTopActions = useMemo(() => [
    {
      label: '+ Add Driver',
      icon: 'account-cog-outline',
      onPress: () => {
        setQuickAddType('driver');
        setQuickAddModalVisible(true);
      },
    },
    {
      label: 'Choose from Contacts',
      icon: 'account-box-outline',
      onPress: () => {
        setContactsTarget('driver');
        setContactsModalVisible(true);
      },
    },
  ], []);

  const currentBillingConfig = BILLING_CONFIG[formValues.billingType] || BILLING_CONFIG.Fixed;
  const isFixedBilling = formValues.billingType === 'Fixed';

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

            {/* Row: Origin & Destination (Cascading State -> City) */}
            <View style={styles.row}>
              {/* Origin */}
              <Controller
                control={control}
                name="origin"
                render={({field: {value}}) => (
                  <TouchableOpacity
                    style={[styles.fieldContainer, styles.rowField]}
                    onPress={() => setActiveLocationPicker('origin')}
                    activeOpacity={0.7}>
                    <View style={styles.dropdownInput}>
                      <AppText
                        variant="body"
                        style={[styles.inputText, !value && styles.placeholderText]}
                        numberOfLines={1}>
                        {value || 'Origin'}
                      </AppText>
                      <Icon name="map-marker-outline" size={20} color={colors.primary} />
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
                    onPress={() => setActiveLocationPicker('destination')}
                    activeOpacity={0.7}>
                    <View style={styles.dropdownInput}>
                      <AppText
                        variant="body"
                        style={[styles.inputText, !value && styles.placeholderText]}
                        numberOfLines={1}>
                        {value || 'Destination'}
                      </AppText>
                      <Icon name="flag-checkered" size={20} color={colors.primary} />
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
                    {PRIMARY_BILLING_TYPES.map(type => {
                      const isMore = type === 'More';
                      const isSelected = isMore
                        ? !['Fixed', 'Per Tonne', 'Per KG'].includes(value)
                        : value === type;

                      const displayLabel = isMore
                        ? !['Fixed', 'Per Tonne', 'Per KG'].includes(value)
                          ? `${value} ▾`
                          : 'More ▾'
                        : type;

                      return (
                        <TouchableOpacity
                          key={type}
                          style={[
                            styles.billingChip,
                            isSelected && styles.billingChipSelected,
                          ]}
                          onPress={() => {
                            if (isMore) {
                              setActivePicker('moreBilling');
                            } else {
                              onChange(type);
                            }
                          }}
                          activeOpacity={0.7}>
                          <AppText
                            variant="label"
                            style={[
                              styles.billingChipText,
                              isSelected && styles.billingChipTextSelected,
                            ]}>
                            {displayLabel}
                          </AppText>
                        </TouchableOpacity>
                      );
                    })}
                  </View>
                )}
              />
            </View>

            {/* Dynamic Billing Rate & Quantity Inputs for Non-Fixed Types */}
            {!isFixedBilling ? (
              <View style={styles.row}>
                {/* Rate per Unit */}
                <View style={[styles.fieldContainer, styles.rowField]}>
                  <View style={styles.floatingLabel}>
                    <AppText variant="caption" color="textMuted" style={styles.labelText}>
                      Rate / {currentBillingConfig.unitName}
                    </AppText>
                  </View>
                  <View style={styles.inputWithSuffix}>
                    <TextInput
                      value={formValues.billingRate}
                      onChangeText={handleRateChange}
                      placeholder="0.00"
                      placeholderTextColor={colors.textMuted}
                      keyboardType="numeric"
                      style={styles.flexInput}
                    />
                    <AppText variant="body" color="textMuted" style={styles.currencySymbol}>
                      ₹
                    </AppText>
                  </View>
                </View>

                {/* Total Quantity */}
                <View style={[styles.fieldContainer, styles.rowField]}>
                  <View style={styles.floatingLabel}>
                    <AppText variant="caption" color="textMuted" style={styles.labelText}>
                      Total {currentBillingConfig.unitName}s
                    </AppText>
                  </View>
                  <View style={styles.inputWithSuffix}>
                    <TextInput
                      value={formValues.billingQuantity}
                      onChangeText={handleQuantityChange}
                      placeholder="0"
                      placeholderTextColor={colors.textMuted}
                      keyboardType="numeric"
                      style={styles.flexInput}
                    />
                  </View>
                </View>
              </View>
            ) : null}

            {/* Party Freight Amount (Calculated / Editable) */}
            <Controller
              control={control}
              name="freightAmount"
              render={({field: {value, onChange}}) => (
                <View style={styles.fieldContainer}>
                  <View style={styles.floatingLabel}>
                    <AppText variant="caption" color="textMuted" style={styles.labelText}>
                      Party Freight Amount {!isFixedBilling ? '(Auto-calculated)' : ''}
                    </AppText>
                  </View>
                  <View style={styles.inputWithSuffix}>
                    <TextInput
                      value={value}
                      onChangeText={onChange}
                      placeholder="Party Freight Amount"
                      placeholderTextColor={colors.textMuted}
                      keyboardType="numeric"
                      style={[styles.flexInput, !isFixedBilling && styles.autoCalculatedInput]}
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

            {/* Trip Start Date (Calendar Picker) */}
            <Controller
              control={control}
              name="tripStartDate"
              render={({field: {value}}) => (
                <TouchableOpacity
                  style={styles.fieldContainer}
                  onPress={() => setDatePickerVisible(true)}
                  activeOpacity={0.7}>
                  <View style={styles.floatingLabel}>
                    <AppText variant="caption" color="textMuted" style={styles.labelText}>
                      Trip Start Date
                    </AppText>
                  </View>
                  <View style={styles.inputWithSuffix}>
                    <AppText
                      variant="body"
                      style={[styles.flexInputText, !value && styles.placeholderText]}>
                      {value || 'Select Start Date'}
                    </AppText>
                    <Icon name="calendar-month-outline" size={22} color={colors.primary} />
                  </View>
                </TouchableOpacity>
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
        {/* Party Modal */}
        <SelectOptionModal
          visible={activePicker === 'party'}
          title="Select Party / Customer"
          options={partyOptions}
          topActions={partyTopActions}
          selectedValue={formValues.partyName}
          onSelect={val => setValue('partyName', val, {shouldValidate: true})}
          onClose={() => setActivePicker(null)}
          placeholder="Search party name..."
        />

        {/* Truck Modal */}
        <SelectOptionModal
          visible={activePicker === 'truck'}
          title="Select Truck Number"
          options={truckOptions}
          topActions={truckTopActions}
          selectedValue={formValues.truckNumber}
          onSelect={val => setValue('truckNumber', val, {shouldValidate: true})}
          onClose={() => setActivePicker(null)}
          placeholder="Search or enter truck no..."
        />

        {/* Driver Modal */}
        <SelectOptionModal
          visible={activePicker === 'driver'}
          title="Select Driver"
          options={driverOptions}
          topActions={driverTopActions}
          selectedValue={formValues.driverName}
          onSelect={item => {
            const val = typeof item === 'string' ? item : item.name;
            const phoneVal = typeof item === 'object' ? item.phone : '';
            setValue('driverName', val, {shouldValidate: true});
            if (phoneVal) setValue('driverPhone', phoneVal, {shouldValidate: true});
          }}
          onClose={() => setActivePicker(null)}
          placeholder="Search or enter driver name..."
        />

        {/* More Billing Types Modal */}
        <SelectOptionModal
          visible={activePicker === 'moreBilling'}
          title="Select Party Billing Type"
          options={ALL_BILLING_TYPES}
          selectedValue={formValues.billingType}
          onSelect={type => setValue('billingType', type, {shouldValidate: true})}
          onClose={() => setActivePicker(null)}
          allowCustom={false}
        />

        {/* Origin & Destination Cascading State -> City Picker */}
        <StateCityPickerModal
          visible={Boolean(activeLocationPicker)}
          title={activeLocationPicker === 'origin' ? 'Origin' : 'Destination'}
          onSelectLocation={loc => {
            if (activeLocationPicker === 'origin') {
              setValue('origin', loc, {shouldValidate: true});
            } else if (activeLocationPicker === 'destination') {
              setValue('destination', loc, {shouldValidate: true});
            }
          }}
          onClose={() => setActiveLocationPicker(null)}
        />

        {/* Device Contacts Picker Modal */}
        <ContactsPickerModal
          visible={contactsModalVisible}
          title={contactsTarget === 'party' ? 'Select Party Contact' : 'Select Driver Contact'}
          onSelectContact={handleSelectContact}
          onClose={() => setContactsModalVisible(false)}
        />

        {/* Trip Start Date Calendar Picker Modal */}
        <DatePickerModal
          visible={datePickerVisible}
          initialDate={formValues.tripStartDate}
          onSelectDate={d => setValue('tripStartDate', d, {shouldValidate: true})}
          onClose={() => setDatePickerVisible(false)}
        />

        {/* Quick Add Party / Truck / Driver Modal */}
        <QuickAddModal
          visible={quickAddModalVisible}
          type={quickAddType}
          onAdd={handleQuickAdd}
          onClose={() => setQuickAddModalVisible(false)}
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
  flexInputText: {
    flex: 1,
    fontSize: 15,
    color: colors.text,
  },
  autoCalculatedInput: {
    fontWeight: '700',
    color: colors.primary,
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
