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
import {useDriversQuery} from '../../drivers/hooks/useDriversQuery';
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
  const {data: apiDrivers} = useDriversQuery();

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
      partyName: '',
      partyId: null,
      truckNumber: '',
      truckId: null,
      ownership: 'own',
      supplierName: '',
      supplierId: null,
      driverName: '',
      driverId: null,
      driverPhone: '',
      origin: '',
      destination: '',
      billingType: 'Fixed',
      billingRate: '',
      billingQuantity: '',
      freightAmount: '',
      supplierBillingType: 'Fixed',
      supplierBillingRate: '',
      supplierBillingQuantity: '',
      truckHireCost: '',
      sendSmsToSupplier: false,
      tripStartDate: getFormattedToday(),
      lrNumber: '',
      material: '',
      startKm: '',
      note: '',
    },
  });

  const formValues = watch();

  // Combined Party Options (carry partyid from the backend)
  const partyOptions = useMemo(() => {
    const combined = [...customParties, ...(apiParties || [])];
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
      id: p.id || null,
    }));
  }, [apiParties, customParties]);

  // Combined Truck Options (grouped into MY TRUCKS & MARKET TRUCKS with ownership metadata)
  const truckOptions = useMemo(() => {
    const fromApi = (apiTrucks || []).map(t => ({
      name: t.vehicleNumber,
      label: t.vehicleNumber,
      value: t.vehicleNumber,
      id: t.id || null,
      ownership: t.ownership || 'own',
      ownerName: t.ownerName || t.supplierName || '',
      ownerPhone: t.ownerPhone || t.supplierPhone || '',
      supplierName: t.supplierName || t.ownerName || '',
      supplierPhone: t.supplierPhone || t.ownerPhone || '',
      status: t.status || 'available',
      sublabel: t.activeTrip?.route || (t.driverName || t.ownerName ? `${t.driverName || t.ownerName}${t.driverPhone || t.ownerPhone ? ` • ${t.driverPhone || t.ownerPhone}` : ''}` : ''),
    }));
    const fromCustom = customTrucks.map(t => {
      const number = typeof t === 'string' ? t : t.vehicleNumber;
      return {
        name: number,
        label: number,
        value: number,
        id: (typeof t === 'object' && t.id) || null,
        ownership: (typeof t === 'object' && t.ownership) || 'own',
        ownerName: (typeof t === 'object' && (t.ownerName || t.supplierName)) || '',
        supplierName: (typeof t === 'object' && (t.supplierName || t.ownerName)) || '',
        status: 'available',
      };
    });
    const combined = [...fromCustom, ...fromApi];
    const seen = new Set();
    const uniqueTrucks = combined.filter(t => {
      if (seen.has(t.value)) return false;
      seen.add(t.value);
      return true;
    });

    const myTrucks = uniqueTrucks.filter(t => t.ownership === 'own' || t.ownership === 'Own');
    const marketTrucks = uniqueTrucks.filter(t => t.ownership === 'market' || t.ownership === 'Market');

    const result = [];
    if (myTrucks.length > 0) {
      result.push({isHeader: true, title: 'MY TRUCKS'});
      result.push(...myTrucks);
    }
    if (marketTrucks.length > 0) {
      result.push({isHeader: true, title: 'MARKET TRUCKS'});
      result.push(...marketTrucks);
    }
    return result.length > 0 ? result : uniqueTrucks;
  }, [apiTrucks, customTrucks]);

  // Combined Driver Options (carry driverid from the backend)
  const driverOptions = useMemo(() => {
    const combined = [...customDrivers, ...(apiDrivers || [])];
    const seen = new Set();
    return combined.filter(d => {
      const name = d.drivername || d.name;
      if (!name || seen.has(name)) return false;
      seen.add(name);
      return true;
    }).map(d => {
      const name = d.drivername || d.name;
      const phone = d.mobile || d.phone || '';
      return {
        name,
        label: name,
        sublabel: phone ? `Phone: ${phone}` : '',
        value: name,
        id: d.id || null,
        phone,
      };
    });
  }, [apiDrivers, customDrivers]);

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

  // Live Auto-Calculation for Supplier Rate * Quantity
  const calculateTruckHireCost = useCallback((rateStr, qtyStr) => {
    const rate = parseFloat(rateStr);
    const qty = parseFloat(qtyStr);
    if (!isNaN(rate) && !isNaN(qty) && rate >= 0 && qty >= 0) {
      const total = rate * qty;
      const formatted = Number.isInteger(total) ? total.toString() : total.toFixed(2);
      setValue('truckHireCost', formatted, {shouldValidate: true});
    }
  }, [setValue]);

  const handleSupplierRateChange = val => {
    setValue('supplierBillingRate', val, {shouldValidate: true});
    calculateTruckHireCost(val, formValues.supplierBillingQuantity);
  };

  const handleSupplierQuantityChange = val => {
    setValue('supplierBillingQuantity', val, {shouldValidate: true});
    calculateTruckHireCost(formValues.supplierBillingRate, val);
  };

  // Contacts picker selection handler
  const handleSelectContact = contact => {
    if (contactsTarget === 'party') {
      setValue('partyName', contact.name, {shouldValidate: true});
      setValue('partyId', null);
    } else if (contactsTarget === 'driver') {
      setValue('driverName', contact.name, {shouldValidate: true});
      setValue('driverId', null);
      setValue('driverPhone', contact.phone, {shouldValidate: true});
    }
  };

  // Quick Add handler
  const handleQuickAdd = addedData => {
    if (quickAddType === 'party') {
      setCustomParties(prev => [addedData, ...prev]);
      setValue('partyName', addedData.name, {shouldValidate: true});
      setValue('partyId', addedData.id || null);
    } else if (quickAddType === 'truck') {
      setCustomTrucks(prev => [addedData, ...prev]);
      setValue('truckNumber', addedData.vehicleNumber, {shouldValidate: true});
      setValue('truckId', addedData.id || null);
    } else if (quickAddType === 'driver') {
      setCustomDrivers(prev => [addedData, ...prev]);
      setValue('driverName', addedData.name, {shouldValidate: true});
      setValue('driverId', addedData.id || null);
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

  const selectedTruckObj = useMemo(() => {
    if (!formValues.truckNumber || !apiTrucks) return null;
    return apiTrucks.find(t => t.vehicleNumber === formValues.truckNumber);
  }, [apiTrucks, formValues.truckNumber]);

  const isMarketTruck =
    formValues.ownership === 'market' ||
    formValues.ownership === 'Market' ||
    (selectedTruckObj && (selectedTruckObj.ownership === 'market' || selectedTruckObj.ownership === 'Market'));

  const currentSupplierBillingConfig = BILLING_CONFIG[formValues.supplierBillingType] || BILLING_CONFIG.Fixed;
  const isFixedSupplierBilling = formValues.supplierBillingType === 'Fixed';

  const supplierOptions = useMemo(() => {
    const combined = (apiTrucks || [])
      .map(t => t.supplierName || t.ownerName)
      .filter(Boolean);
    const seen = new Set();
    return combined.filter(name => {
      if (seen.has(name)) return false;
      seen.add(name);
      return true;
    }).map(name => ({
      name,
      label: name,
      value: name,
    }));
  }, [apiTrucks]);

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

            {/* Row: Truck No & Driver / Supplier Name */}
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

              {/* Supplier/Truck Owner (if Market truck) OR Driver Name */}
              {isMarketTruck ? (
                <Controller
                  control={control}
                  name="supplierName"
                  render={({field: {value}}) => (
                    <TouchableOpacity
                      style={[styles.fieldContainer, styles.rowField]}
                      onPress={() => setActivePicker('supplier')}
                      activeOpacity={0.7}>
                      <View style={styles.floatingLabel}>
                        <AppText variant="caption" color="textMuted" style={styles.labelText}>
                          Supplier/Truck Owner
                        </AppText>
                      </View>
                      <View style={styles.dropdownInput}>
                        <AppText
                          variant="body"
                          style={[styles.inputText, styles.boldInput, !value && styles.placeholderText]}>
                          {value || 'Supplier/Truck Owner'}
                        </AppText>
                        <Icon name="menu-down" size={22} color={colors.textMuted} />
                      </View>
                    </TouchableOpacity>
                  )}
                />
              ) : (
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
              )}
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

            {/* Supplier Billing Section (Shown when Market truck is selected) */}
            {isMarketTruck ? (
              <>
                <View style={styles.billingSection}>
                  <View style={styles.billingHeader}>
                    <AppText variant="body" color="textMuted" style={styles.billingLabel}>
                      Supplier Billing Type
                    </AppText>
                    <Icon name="information-outline" size={16} color={colors.textMuted} />
                  </View>

                  <Controller
                    control={control}
                    name="supplierBillingType"
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
                              key={`supplier-${type}`}
                              style={[
                                styles.billingChip,
                                isSelected && styles.supplierBillingChipSelected,
                              ]}
                              onPress={() => {
                                if (isMore) {
                                  setActivePicker('moreSupplierBilling');
                                } else {
                                  onChange(type);
                                }
                              }}
                              activeOpacity={0.7}>
                              <AppText
                                variant="label"
                                style={[
                                  styles.billingChipText,
                                  isSelected && styles.supplierBillingChipTextSelected,
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

                {/* Dynamic Supplier Billing Rate & Quantity Inputs for Non-Fixed Types */}
                {!isFixedSupplierBilling ? (
                  <View style={styles.row}>
                    {/* Supplier Rate per Unit */}
                    <View style={[styles.fieldContainer, styles.rowField]}>
                      <View style={styles.floatingLabel}>
                        <AppText variant="caption" color="textMuted" style={styles.labelText}>
                          Supplier Rate / {currentSupplierBillingConfig.unitName}
                        </AppText>
                      </View>
                      <View style={styles.inputWithSuffix}>
                        <TextInput
                          value={formValues.supplierBillingRate}
                          onChangeText={handleSupplierRateChange}
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
                          Total {currentSupplierBillingConfig.unitName}s
                        </AppText>
                      </View>
                      <View style={styles.inputWithSuffix}>
                        <TextInput
                          value={formValues.supplierBillingQuantity}
                          onChangeText={handleSupplierQuantityChange}
                          placeholder="0"
                          placeholderTextColor={colors.textMuted}
                          keyboardType="numeric"
                          style={styles.flexInput}
                        />
                      </View>
                    </View>
                  </View>
                ) : null}

                {/* Truck Hire Cost Field */}
                <Controller
                  control={control}
                  name="truckHireCost"
                  render={({field: {value, onChange}}) => (
                    <View style={styles.fieldContainer}>
                      <View style={styles.floatingLabel}>
                        <AppText variant="caption" color="textMuted" style={styles.labelText}>
                          Truck Hire Cost {!isFixedSupplierBilling ? '(Auto-calculated)' : ''}
                        </AppText>
                      </View>
                      <View style={styles.inputWithSuffix}>
                        <TextInput
                          value={value}
                          onChangeText={onChange}
                          placeholder="Truck Hire Cost"
                          placeholderTextColor={colors.textMuted}
                          keyboardType="numeric"
                          style={[styles.flexInput, !isFixedSupplierBilling && styles.autoCalculatedInput]}
                        />
                        <AppText variant="body" color="textMuted" style={styles.currencySymbol}>
                          ₹
                        </AppText>
                      </View>
                    </View>
                  )}
                />
              </>
            ) : null}

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

            {isMarketTruck ? (
              <TouchableOpacity
                style={[styles.checkboxRow, {marginLeft: spacing.md}]}
                onPress={() => setValue('sendSmsToSupplier', !formValues.sendSmsToSupplier)}
                activeOpacity={0.7}>
                <Icon
                  name={formValues.sendSmsToSupplier ? 'checkbox-marked' : 'checkbox-blank-outline'}
                  size={20}
                  color={formValues.sendSmsToSupplier ? '#EA580C' : colors.textMuted}
                />
                <AppText variant="body" style={styles.checkboxLabel}>
                  Supplier
                </AppText>
              </TouchableOpacity>
            ) : null}
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
          onSelect={item => {
            const val = typeof item === 'string' ? item : item.name || item.value;
            const id = typeof item === 'object' ? item.id : null;
            setValue('partyName', val, {shouldValidate: true});
            setValue('partyId', Number(id) || null);
          }}
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
          onSelect={item => {
            const val = typeof item === 'string' ? item : item.value || item.name;
            const id = typeof item === 'object' ? item.id : null;
            const ownershipVal = typeof item === 'object' ? (item.ownership || 'own') : 'own';
            const supplierVal = typeof item === 'object' ? (item.supplierName || item.ownerName || '') : '';
            setValue('truckNumber', val, {shouldValidate: true});
            setValue('truckId', Number(id) || null);
            setValue('ownership', ownershipVal, {shouldValidate: true});
            if (supplierVal) {
              setValue('supplierName', supplierVal, {shouldValidate: true});
            }
          }}
          onClose={() => setActivePicker(null)}
          placeholder="Search or enter truck no..."
        />

        {/* Supplier Modal */}
        <SelectOptionModal
          visible={activePicker === 'supplier'}
          title="Select Supplier / Truck Owner"
          options={supplierOptions}
          selectedValue={formValues.supplierName}
          onSelect={item => {
            const nameVal = typeof item === 'string' ? item : item.value || item.name;
            const id = typeof item === 'object' ? item.id : null;
            setValue('supplierName', nameVal, {shouldValidate: true});
            setValue('supplierId', Number(id) || null);
          }}
          onClose={() => setActivePicker(null)}
          placeholder="Search or enter supplier name..."
        />

        {/* Driver Modal */}
        <SelectOptionModal
          visible={activePicker === 'driver'}
          title="Select Driver"
          options={driverOptions}
          topActions={driverTopActions}
          selectedValue={formValues.driverName}
          onSelect={item => {
            const nameVal = typeof item === 'string' ? item : item.value || item.name;
            const id = typeof item === 'object' ? item.id : null;
            const phoneVal = typeof item === 'object' ? item.phone : '';
            setValue('driverName', nameVal, {shouldValidate: true});
            setValue('driverId', Number(id) || null);
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

        {/* More Supplier Billing Types Modal */}
        <SelectOptionModal
          visible={activePicker === 'moreSupplierBilling'}
          title="Select Supplier Billing Type"
          options={ALL_BILLING_TYPES}
          selectedValue={formValues.supplierBillingType}
          onSelect={type => setValue('supplierBillingType', type, {shouldValidate: true})}
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
          title="Select Trip Start Date"
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
  supplierBillingChipSelected: {
    backgroundColor: '#FFEDD5',
    borderWidth: 1.5,
    borderColor: '#EA580C',
  },
  supplierBillingChipTextSelected: {
    color: '#C2410C',
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
