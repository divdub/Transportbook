import React, {useMemo, useState} from 'react';
import {
  FlatList,
  Modal,
  Platform,
  StyleSheet,
  TextInput,
  TouchableOpacity,
  View,
} from 'react-native';
import {SafeAreaView} from 'react-native-safe-area-context';
import Icon from 'react-native-vector-icons/MaterialCommunityIcons';
import {AppText} from '../../../components/common/AppText';
import {INDIAN_STATES} from '../../parties/constants/indianStates';
import {useCitiesQuery} from '../../cities/hooks/useCitiesQuery';
import {colors, radius, spacing} from '../../../theme';

// Map of major cities per state for quick cascading selection
const CITIES_BY_STATE = {
  'Andhra Pradesh': ['Visakhapatnam', 'Vijayawada', 'Guntur', 'Nellore', 'Kurnool', 'Tirupati', 'Kakinada', 'Rajahmundry', 'Anantapur', 'Eluru'],
  'Arunachal Pradesh': ['Itanagar', 'Naharlagun', 'Pasighat', 'Tawang', 'Ziro'],
  'Assam': ['Guwahati', 'Silchar', 'Dibrugarh', 'Jorhat', 'Nagaon', 'Tinsukia', 'Tezpur'],
  'Bihar': ['Patna', 'Gaya', 'Bhagalpur', 'Muzaffarpur', 'Purnia', 'Darbhanga', 'Arrah', 'Begusarai'],
  'Chandigarh': ['Chandigarh', 'Industrial Area Ph 1', 'Industrial Area Ph 2'],
  'Chhattisgarh': ['Raipur', 'Bhilai', 'Bilaspur', 'Korba', 'Rajnandgaon', 'Raigarh', 'Jagdalpur'],
  'Delhi (NCT)': ['Delhi NCR', 'New Delhi', 'North Delhi', 'South Delhi', 'Okhla', 'Narela', 'Sanjay Gandhi Transport Nagar'],
  'Goa': ['Panaji', 'Margao', 'Vasco da Gama', 'Mapusa', 'Ponda'],
  'Gujarat': ['Ahmedabad', 'Surat', 'Vadodara', 'Rajkot', 'Bhavnagar', 'Jamnagar', 'Gandhinagar', 'Ankleshwar', 'Vapi', 'Morbi', 'Kandla'],
  'Haryana': ['Gurugram', 'Faridabad', 'Panipat', 'Ambala', 'Yamunanagar', 'Rohtak', 'Hisar', 'Karnal', 'Sonipat'],
  'Himachal Pradesh': ['Shimla', 'Dharamshala', 'Mandi', 'Solan', 'Baddi', 'Kullu', 'Bilaspur'],
  'Jammu and Kashmir': ['Srinagar', 'Jammu', 'Anantnag', 'Baramulla', 'Kathua', 'Udhampur'],
  'Jharkhand': ['Ranchi', 'Jamshedpur', 'Dhanbad', 'Bokaro', 'Deoghar', 'Hazaribagh', 'Giridih'],
  'Karnataka': ['Bangalore', 'Mysuru', 'Hubballi', 'Mangaluru', 'Belagavi', 'Davangere', 'Bellary', 'Shivamogga', 'Tumakuru', 'Hospet'],
  'Kerala': ['Thiruvananthapuram', 'Kochi', 'Kozhikode', 'Thrissur', 'Kollam', 'Palakkad', 'Kannur', 'Alappuzha'],
  'Madhya Pradesh': ['Indore', 'Bhopal', 'Jabalpur', 'Gwalior', 'Ujjain', 'Sagar', 'Dewas', 'Satna', 'Ratlam', 'Rewa'],
  'Maharashtra': ['Mumbai', 'Pune', 'Nagpur', 'Thane', 'Nashik', 'Aurangabad', 'Solapur', 'Amravati', 'Navi Mumbai', 'Kolhapur', 'Bhiwandi'],
  'Manipur': ['Imphal', 'Churachandpur', 'Thoubal'],
  'Meghalaya': ['Shillong', 'Tura', 'Jowai'],
  'Mizoram': ['Aizawl', 'Lunglei', 'Champhai'],
  'Nagaland': ['Dimapur', 'Kohima', 'Mokokchung'],
  'Odisha': ['Bhubaneswar', 'Cuttack', 'Rourkela', 'Berhampur', 'Sambalpur', 'Balasore', 'Jharsuguda'],
  'Puducherry': ['Puducherry', 'Karaikal', 'Yanam', 'Mahe'],
  'Punjab': ['Ludhiana', 'Amritsar', 'Jalandhar', 'Patiala', 'Bathinda', 'Mohali', 'Pathankot'],
  'Rajasthan': ['Jaipur', 'Jodhpur', 'Kota', 'Bikaner', 'Ajmer', 'Udaipur', 'Bhilwara', 'Alwar', 'Sikar'],
  'Sikkim': ['Gangtok', 'Namchi', 'Geyzing'],
  'Tamil Nadu': ['Chennai', 'Coimbatore', 'Madurai', 'Tiruchirappalli', 'Salem', 'Tiruppur', 'Erode', 'Vellore', 'Tuticorin'],
  'Telangana': ['Hyderabad', 'Warangal', 'Nizamabad', 'Karimnagar', 'Ramagundam', 'Khammam'],
  'Tripura': ['Agartala', 'Dharmanagar', 'Udaipur'],
  'Uttar Pradesh': ['Lucknow', 'Kanpur', 'Ghaziabad', 'Agra', 'Varanasi', 'Meerut', 'Noida', 'Prayagraj', 'Bareilly', 'Aligarh', 'Moradabad', 'Gorakhpur'],
  'Uttarakhand': ['Dehradun', 'Haridwar', 'Roorkee', 'Haldwani', 'Rudrapur', 'Rishikesh'],
  'West Bengal': ['Kolkata', 'Howrah', 'Siliguri', 'Durgapur', 'Asansol', 'Haldia', 'Kharagpur'],
};

const COMMON_DEFAULT_CITIES = [
  'Bangalore', 'Hyderabad', 'Mumbai', 'Delhi NCR', 'Pune', 'Chennai',
  'Ahmedabad', 'Kolkata', 'Jaipur', 'Indore', 'Surat', 'Nagpur', 'Lucknow',
];

export function StateCityPickerModal({
  visible,
  title = 'Select Location',
  onSelectLocation,
  onClose,
}) {
  const {data: apiCities} = useCitiesQuery();
  const [selectedState, setSelectedState] = useState(null);
  const [search, setSearch] = useState('');

  const step = selectedState ? 'city' : 'state';

  const filteredStates = useMemo(() => {
    if (!search.trim()) return INDIAN_STATES;
    const q = search.trim().toLowerCase();
    return INDIAN_STATES.filter(st => st.toLowerCase().includes(q));
  }, [search]);

  // Cities come from the backend (cityid + cityname + statename), falling
  // back to the hardcoded list when the endpoint is unavailable. Duplicate
  // (name, state) pairs are collapsed.
  const cityEntries = useMemo(() => {
    const source = (apiCities && apiCities.length > 0 ? apiCities : []).map(c => ({
      id: c.id,
      name: c.name,
      stateName: c.stateName,
    }));
    const seen = new Set();
    const unique = [];
    for (const c of source) {
      const key = `${c.name}|${c.stateName || ''}`;
      if (seen.has(key)) continue;
      seen.add(key);
      unique.push(c);
    }
    return unique;
  }, [apiCities]);

  // Fallback when there is no backend data to drive the picker.
  const fallbackCities = useMemo(() => {
    if (cityEntries.length > 0) return [];
    return COMMON_DEFAULT_CITIES.map(name => ({id: null, name, stateName: ''}));
  }, [cityEntries]);

  const citiesForState = useMemo(() => {
    if (cityEntries.length > 0) {
      if (!selectedState) return cityEntries;
      return cityEntries.filter(c => c.stateName && c.stateName === selectedState);
    }
    if (!selectedState) return fallbackCities;
    return (CITIES_BY_STATE[selectedState] || COMMON_DEFAULT_CITIES).map(name => ({
      id: null,
      name,
      stateName: selectedState,
    }));
  }, [cityEntries, fallbackCities, selectedState]);

  const filteredCities = useMemo(() => {
    if (!search.trim()) return citiesForState;
    const q = search.trim().toLowerCase();
    return citiesForState.filter(ct => ct.name.toLowerCase().includes(q));
  }, [citiesForState, search]);

  const handleSelectState = state => {
    setSelectedState(state);
    setSearch('');
  };

  const handleSelectCity = cityEntry => {
    const formatted = cityEntry.stateName
      ? `${cityEntry.name}, ${cityEntry.stateName}`
      : cityEntry.name;
    onSelectLocation({cityname: formatted, cityid: cityEntry.id});
    resetAndClose();
  };

  const handleCustomCity = () => {
    if (search.trim()) {
      const city = search.trim();
      const formatted = selectedState ? `${city}, ${selectedState}` : city;
      onSelectLocation({cityname: formatted, cityid: null});
      resetAndClose();
    }
  };

  const resetAndClose = () => {
    setSelectedState(null);
    setSearch('');
    onClose();
  };

  const isExactCityMatch = filteredCities.some(
    ct => ct.name.toLowerCase() === search.trim().toLowerCase(),
  );

  return (
    <Modal
      visible={visible}
      animationType="slide"
      transparent={false}
      onRequestClose={resetAndClose}>
      <SafeAreaView style={styles.safeArea}>
        <View style={styles.container}>
          {/* Header */}
          <View style={styles.header}>
            <TouchableOpacity
              onPress={() => {
                if (step === 'city') {
                  setSelectedState(null);
                  setSearch('');
                } else {
                  resetAndClose();
                }
              }}
              style={styles.closeBtn}
              accessibilityLabel="Back">
              <Icon name="arrow-left" size={24} color={colors.text} />
            </TouchableOpacity>
            <View style={styles.titleContainer}>
              <AppText variant="heading" style={styles.headerTitle}>
                {step === 'state' ? `Select State (${title})` : `Select City in ${selectedState}`}
              </AppText>
              {selectedState ? (
                <TouchableOpacity onPress={() => setSelectedState(null)}>
                  <AppText variant="caption" style={styles.changeStateBtn}>
                    Change State
                  </AppText>
                </TouchableOpacity>
              ) : null}
            </View>
            <View style={styles.headerSpacer} />
          </View>

          {/* Search Bar */}
          <View style={styles.searchContainer}>
            <View style={styles.searchField}>
              <Icon name="map-marker-search-outline" size={20} color={colors.textMuted} />
              <TextInput
                value={search}
                onChangeText={setSearch}
                placeholder={step === 'state' ? 'Search State...' : `Search City in ${selectedState}...`}
                placeholderTextColor={colors.textMuted}
                style={styles.searchInput}
                autoFocus={Platform.OS !== 'ios'}
                returnKeyType="done"
              />
              {search ? (
                <TouchableOpacity onPress={() => setSearch('')}>
                  <Icon name="close-circle" size={18} color={colors.textMuted} />
                </TouchableOpacity>
              ) : null}
            </View>
          </View>

          {/* Step 1: Select State */}
          {step === 'state' ? (
            <FlatList
              data={filteredStates}
              keyExtractor={item => item}
              keyboardShouldPersistTaps="handled"
              ItemSeparatorComponent={Separator}
              contentContainerStyle={styles.listContent}
              renderItem={({item}) => (
                <TouchableOpacity
                  style={styles.rowItem}
                  onPress={() => handleSelectState(item)}
                  activeOpacity={0.7}>
                  <Icon name="map-marker-outline" size={20} color={colors.primary} />
                  <AppText variant="body" style={styles.rowText}>
                    {item}
                  </AppText>
                  <Icon name="chevron-right" size={20} color={colors.textMuted} />
                </TouchableOpacity>
              )}
            />
          ) : (
            /* Step 2: Select City */
            <FlatList
              data={filteredCities}
              keyExtractor={(item, index) => item.id || `${item.name}-${index}`}
              keyboardShouldPersistTaps="handled"
              ItemSeparatorComponent={Separator}
              contentContainerStyle={styles.listContent}
              ListHeaderComponent={
                search.trim().length > 0 && !isExactCityMatch ? (
                  <TouchableOpacity
                    style={styles.customCityRow}
                    onPress={handleCustomCity}>
                    <Icon name="plus-circle" size={20} color={colors.primary} />
                    <AppText variant="body" style={styles.customCityText}>
                      Use "{search.trim()}, {selectedState}"
                    </AppText>
                  </TouchableOpacity>
                ) : null
              }
              renderItem={({item}) => (
                <TouchableOpacity
                  style={styles.rowItem}
                  onPress={() => handleSelectCity(item)}
                  activeOpacity={0.7}>
                  <Icon name="city-variant-outline" size={20} color={colors.textMuted} />
                  <AppText variant="body" style={styles.rowText}>
                    {item.name}
                  </AppText>
                  <AppText variant="caption" color="textMuted">
                    {item.stateName || selectedState}
                  </AppText>
                </TouchableOpacity>
              )}
            />
          )}
        </View>
      </SafeAreaView>
    </Modal>
  );
}

function Separator() {
  return <View style={styles.separator} />;
}

const styles = StyleSheet.create({
  safeArea: {
    flex: 1,
    backgroundColor: colors.surface,
  },
  container: {
    flex: 1,
    backgroundColor: colors.surface,
  },
  header: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.md,
    borderBottomWidth: 1,
    borderBottomColor: colors.border,
  },
  closeBtn: {
    padding: spacing.xs,
  },
  titleContainer: {
    alignItems: 'center',
    flex: 1,
  },
  headerTitle: {
    fontSize: 16,
    fontWeight: '700',
    color: colors.text,
    textAlign: 'center',
  },
  changeStateBtn: {
    color: colors.primary,
    fontWeight: '600',
    marginTop: 2,
  },
  headerSpacer: {
    width: 24,
  },
  searchContainer: {
    padding: spacing.md,
  },
  searchField: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: spacing.sm,
    backgroundColor: colors.surfaceSubtle,
    borderWidth: 1,
    borderColor: colors.border,
    borderRadius: radius.md,
    paddingHorizontal: spacing.md,
    height: 46,
  },
  searchInput: {
    flex: 1,
    color: colors.text,
    padding: 0,
    fontSize: 14,
  },
  listContent: {
    paddingHorizontal: spacing.md,
    paddingBottom: spacing.xl,
  },
  rowItem: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: spacing.md,
    paddingVertical: spacing.md,
  },
  rowText: {
    flex: 1,
    fontSize: 15,
    color: colors.text,
  },
  customCityRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: spacing.sm,
    backgroundColor: colors.primarySoft,
    borderRadius: radius.md,
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.md,
    marginBottom: spacing.sm,
  },
  customCityText: {
    fontWeight: '700',
    color: colors.primary,
  },
  separator: {
    height: 1,
    backgroundColor: colors.border,
  },
});
