import React, {useState} from 'react';
import {
  ActivityIndicator,
  Alert,
  ScrollView,
  StyleSheet,
  TouchableOpacity,
  View,
} from 'react-native';
import {useNavigation, useRoute} from '@react-navigation/native';
import Icon from 'react-native-vector-icons/MaterialCommunityIcons';
import {AppButton} from '../../../components/common/AppButton';
import {AppScreen} from '../../../components/common/AppScreen';
import {AppText} from '../../../components/common/AppText';
import {TripStatusStepper} from '../components/TripStatusStepper';
import {AddAdvanceSheet} from '../sheets/AddAdvanceSheet';
import {AddDriverBalanceSheet} from '../sheets/AddDriverBalanceSheet';
import {useTripDetailsQuery} from '../hooks/useTripDetailsQuery';
import {useUpdateTripStatusMutation} from '../hooks/useUpdateTripStatusMutation';
import {useAddAdvanceMutation} from '../hooks/useAddAdvanceMutation';
import {useAddDriverBalanceMutation} from '../hooks/useAddDriverBalanceMutation';
import {routes} from '../../../navigation/routeNames';
import {colors, radius, spacing} from '../../../theme';

const TABS = ['Party', 'Profit', 'Driver', 'More'];

export default function TripDetailsScreen() {
  const navigation = useNavigation();
  const route = useRoute();
  const {tripId} = route.params || {};

  const [activeTab, setActiveTab] = useState('Party');
  const [advanceSheetVisible, setAdvanceSheetVisible] = useState(false);
  const [driverBalanceVisible, setDriverBalanceVisible] = useState(false);

  const {data: trip, isLoading, isError, refetch} = useTripDetailsQuery(tripId || 'TRIP-1001');
  const {mutateAsync: updateStatus, isPending: isUpdatingStatus} = useUpdateTripStatusMutation();
  const {mutateAsync: addAdvance, isPending: isAddingAdvance} = useAddAdvanceMutation();
  const {mutateAsync: addDriverBalance, isPending: isAddingDriverBalance} = useAddDriverBalanceMutation();

  if (isLoading) {
    return (
      <AppScreen style={styles.centerContainer}>
        <ActivityIndicator size="large" color={colors.primary} />
        <AppText variant="body" color="textMuted" style={styles.loadingText}>
          Loading trip details...
        </AppText>
      </AppScreen>
    );
  }

  if (isError || !trip) {
    return (
      <AppScreen style={styles.centerContainer}>
        <Icon name="alert-circle-outline" size={48} color={colors.danger} />
        <AppText variant="body" color="danger">
          Could not load trip details.
        </AppText>
        <AppButton title="Retry" onPress={() => refetch()} style={styles.retryBtn} />
      </AppScreen>
    );
  }

  const handleNextStatus = async () => {
    const sequence = ['Started', 'Completed', 'POD Received', 'POD Submitted', 'Settled'];
    const currentIdx = sequence.indexOf(trip.status);
    if (currentIdx < sequence.length - 1) {
      const next = sequence[currentIdx + 1];
      await updateStatus({id: trip.id, status: next});
    }
  };

  const handleSaveAdvance = async data => {
    await addAdvance({id: trip.id, ...data});
    setAdvanceSheetVisible(false);
  };

  const handleSaveDriverBalance = async data => {
    await addDriverBalance({id: trip.id, ...data});
    setDriverBalanceVisible(false);
  };

  // Calculations for Profit Tab
  const totalRevenue = (trip.freightAmount || 0) + (trip.chargesAmount || 0);
  const totalExpenses = (trip.expenses || []).reduce((acc, exp) => acc + (exp.amount || 0), 0);
  const netProfit = totalRevenue - totalExpenses;

  return (
    <AppScreen scroll={false} style={styles.screen} contentStyle={styles.screenContent}>
      {/* Top Header */}
      <View style={styles.header}>
        <View style={styles.headerLeft}>
          <TouchableOpacity
            onPress={() => navigation.goBack()}
            style={styles.iconBtn}
            accessibilityLabel="Back">
            <Icon name="arrow-left" size={24} color={colors.text} />
          </TouchableOpacity>
          <AppText variant="heading" style={styles.headerTitle}>
            Trip Details
          </AppText>
        </View>

        <View style={styles.headerRight}>
          <TouchableOpacity
            style={styles.editBtn}
            onPress={() => navigation.navigate(routes.addTrip, {trip})}
            accessibilityLabel="Edit Trip">
            <AppText variant="label" style={styles.editText}>
              Edit
            </AppText>
          </TouchableOpacity>

          <TouchableOpacity style={styles.iconBtn} accessibilityLabel="Help Video">
            <Icon name="youtube" size={24} color="#FF0000" />
          </TouchableOpacity>

          <TouchableOpacity style={styles.iconBtn} accessibilityLabel="More Options">
            <Icon name="dots-vertical" size={24} color={colors.text} />
          </TouchableOpacity>
        </View>
      </View>

      {/* Vehicle Card Banner */}
      <View style={styles.vehicleBanner}>
        <View style={styles.vehicleRow}>
          <Icon name="truck" size={20} color={colors.text} />
          <AppText variant="body" style={styles.truckNumber}>
            {trip.truckNumber}
          </AppText>
          {trip.driverName ? (
            <AppText variant="caption" color="textMuted" style={styles.driverSubText}>
              • {trip.driverName}
            </AppText>
          ) : null}
        </View>
      </View>

      {/* Tabs Header */}
      <View style={styles.tabsContainer}>
        {TABS.map(tab => {
          const isSelected = activeTab === tab;
          return (
            <TouchableOpacity
              key={tab}
              style={[styles.tabItem, isSelected && styles.tabItemSelected]}
              onPress={() => setActiveTab(tab)}
              activeOpacity={0.7}>
              <AppText
                variant="label"
                style={[styles.tabText, isSelected && styles.tabTextSelected]}>
                {tab}
              </AppText>
              {isSelected ? <View style={styles.tabIndicator} /> : null}
            </TouchableOpacity>
          );
        })}
      </View>

      {/* Tab Content */}
      <ScrollView
        showsVerticalScrollIndicator={false}
        contentContainerStyle={styles.scrollContent}>
        
        {/* ================= PARTY TAB ================= */}
        {activeTab === 'Party' && (
          <View style={styles.tabPane}>
            
            {/* Customer & Route Card */}
            <View style={styles.card}>
              {/* Customer Header */}
              <View style={styles.customerRow}>
                <View style={styles.customerNameBlock}>
                  <Icon name="account-circle" size={22} color={colors.primary} />
                  <AppText variant="body" style={styles.customerName}>
                    {trip.partyName}
                  </AppText>
                </View>
                <View style={styles.amountPill}>
                  <AppText variant="label" style={styles.amountPillText}>
                    ₹{trip.freightAmount.toLocaleString('en-IN')}
                  </AppText>
                </View>
              </View>

              {/* Route Display */}
              <View style={styles.routeSection}>
                <View style={styles.routeCitiesRow}>
                  <View style={styles.cityBlock}>
                    <AppText variant="body" style={styles.cityName}>
                      {trip.origin}
                    </AppText>
                    <AppText variant="caption" color="textMuted">
                      {trip.tripDate}
                    </AppText>
                  </View>

                  <View style={styles.centerArrowBlock}>
                    <View style={styles.arrowLine} />
                    <View style={styles.arrowCircle}>
                      <Icon name="arrow-right" size={16} color={colors.text} />
                    </View>
                    <View style={styles.arrowLine} />
                  </View>

                  <View style={[styles.cityBlock, styles.cityBlockRight]}>
                    <AppText variant="body" style={styles.cityName}>
                      {trip.destination}
                    </AppText>
                    {trip.lrNumber ? (
                      <AppText variant="caption" color="textMuted">
                        #{trip.lrNumber}
                      </AppText>
                    ) : null}
                  </View>
                </View>
              </View>

              {/* Status Stepper */}
              <TripStatusStepper
                currentStatus={trip.status}
                timeline={trip.statusTimeline}
                onPress={() => navigation.navigate(routes.tripProgress, {tripId: trip.id})}
              />

              {/* Action Buttons */}
              <View style={styles.cardActionsRow}>
                <TouchableOpacity
                  style={styles.completeTripBtn}
                  onPress={handleNextStatus}
                  disabled={isUpdatingStatus}
                  activeOpacity={0.7}>
                  <AppText variant="label" style={styles.completeTripText}>
                    {isUpdatingStatus
                      ? 'Updating...'
                      : trip.status === 'Started'
                      ? 'Complete Trip'
                      : trip.status === 'Completed'
                      ? 'POD Received'
                      : trip.status === 'POD Received'
                      ? 'Submit POD'
                      : trip.status === 'POD Submitted'
                      ? 'Mark Settled'
                      : 'Trip Settled'}
                  </AppText>
                </TouchableOpacity>

                <TouchableOpacity
                  style={styles.viewBillBtn}
                  onPress={() =>
                    Alert.alert(
                      'Trip Bill Summary',
                      `Freight: ₹${trip.freightAmount}\nPending: ₹${trip.pendingBalance}\nStatus: ${trip.status}`,
                    )
                  }
                  activeOpacity={0.7}>
                  <AppText variant="label" style={styles.viewBillText}>
                    View Bill
                  </AppText>
                </TouchableOpacity>
              </View>
            </View>

            {/* Financial Details Card */}
            <View style={styles.card}>
              <View style={styles.financialRow}>
                <AppText variant="body" style={styles.financialLabel}>
                  Freight Amount
                </AppText>
                <View style={styles.freightEditRow}>
                  <AppText variant="body" style={styles.financialValue}>
                    ₹{trip.freightAmount.toLocaleString('en-IN')}
                  </AppText>
                  <Icon name="pencil" size={16} color={colors.primary} />
                </View>
              </View>

              {/* (-) Advance */}
              <View style={styles.financialSection}>
                <View style={styles.financialRow}>
                  <AppText variant="body" color="textMuted">
                    (-) Advance
                  </AppText>
                  <AppText variant="body" style={styles.financialValue}>
                    ₹{(trip.advanceAmount || 0).toLocaleString('en-IN')}
                  </AppText>
                </View>
                <TouchableOpacity
                  onPress={() => setAdvanceSheetVisible(true)}
                  style={styles.actionLinkBtn}>
                  <AppText variant="label" style={styles.actionLinkText}>
                    Add Advance
                  </AppText>
                </TouchableOpacity>
              </View>

              {/* (+) Charges */}
              <View style={styles.financialSection}>
                <View style={styles.financialRow}>
                  <AppText variant="body" color="textMuted">
                    (+) Charges
                  </AppText>
                  <AppText variant="body" style={styles.financialValue}>
                    ₹{(trip.chargesAmount || 0).toLocaleString('en-IN')}
                  </AppText>
                </View>
                <TouchableOpacity
                  onPress={() =>
                    Alert.alert('Add Charges', 'Charge adjustment added to freight.')
                  }
                  style={styles.actionLinkBtn}>
                  <AppText variant="label" style={styles.actionLinkText}>
                    Add Charges
                  </AppText>
                </TouchableOpacity>
              </View>

              {/* (-) Payments */}
              <View style={styles.financialSection}>
                <View style={styles.financialRow}>
                  <AppText variant="body" color="textMuted">
                    (-) Payments
                  </AppText>
                  <AppText variant="body" style={styles.financialValue}>
                    ₹{(trip.paymentsAmount || 0).toLocaleString('en-IN')}
                  </AppText>
                </View>
                <TouchableOpacity
                  onPress={() =>
                    Alert.alert('Add Payment', 'Record customer settlement payment.')
                  }
                  style={styles.actionLinkBtn}>
                  <AppText variant="label" style={styles.actionLinkText}>
                    Add Payment
                  </AppText>
                </TouchableOpacity>
              </View>

              {/* Dashed Separator */}
              <View style={styles.dashedDivider} />

              {/* Pending Balance */}
              <View style={styles.financialRow}>
                <AppText variant="heading" style={styles.pendingBalanceLabel}>
                  Pending Balance
                </AppText>
                <AppText variant="heading" style={styles.pendingBalanceValue}>
                  ₹{(trip.pendingBalance || 0).toLocaleString('en-IN')}
                </AppText>
              </View>

              {/* Note & Request Money Action Row */}
              <View style={styles.bottomFinancialActions}>
                <TouchableOpacity
                  style={styles.noteBtn}
                  onPress={() => Alert.alert('Trip Notes', trip.notes || 'No note added.')}>
                  <Icon name="plus" size={16} color={colors.primary} />
                  <AppText variant="label" style={styles.noteBtnText}>
                    Note
                  </AppText>
                </TouchableOpacity>

                <TouchableOpacity
                  style={styles.requestMoneyBtn}
                  onPress={() =>
                    Alert.alert(
                      'Request Money',
                      `Payment reminder of ₹${trip.pendingBalance} sent to ${trip.partyName}.`,
                    )
                  }>
                  <AppText variant="label" style={styles.requestMoneyText}>
                    Request Money
                  </AppText>
                </TouchableOpacity>
              </View>
            </View>

            {/* Add Load to this Trip Card */}
            <TouchableOpacity
              style={styles.addLoadCard}
              onPress={() => navigation.navigate(routes.addLoad, {parentTrip: trip})}
              activeOpacity={0.7}>
              <AppText variant="label" style={styles.addLoadText}>
                Add load to this Trip
              </AppText>
              <Icon name="chevron-right" size={20} color={colors.primary} />
            </TouchableOpacity>

          </View>
        )}

        {/* ================= PROFIT TAB ================= */}
        {activeTab === 'Profit' && (
          <View style={styles.tabPane}>
            {/* Revenue Card */}
            <View style={styles.card}>
              <View style={styles.profitSectionHeader}>
                <AppText variant="heading" style={styles.revenueTitle}>
                  (+) Revenue
                </AppText>
              </View>

              <View style={styles.financialRow}>
                <AppText variant="body" color="textMuted">
                  Customer: {trip.partyName}
                </AppText>
                <AppText variant="body" style={styles.financialValue}>
                  ₹{trip.freightAmount.toLocaleString('en-IN')}
                </AppText>
              </View>

              <View style={styles.financialRow}>
                <AppText variant="body" color="textMuted">
                  Extra Charges
                </AppText>
                <AppText variant="body" style={styles.financialValue}>
                  ₹{(trip.chargesAmount || 0).toLocaleString('en-IN')}
                </AppText>
              </View>

              <View style={styles.dashedDivider} />

              <View style={styles.financialRow}>
                <AppText variant="label" style={styles.boldText}>
                  Total Revenue
                </AppText>
                <AppText variant="label" style={[styles.boldText, {color: colors.success}]}>
                  ₹{totalRevenue.toLocaleString('en-IN')}
                </AppText>
              </View>
            </View>

            {/* Expenses Card */}
            <View style={styles.card}>
              <View style={styles.profitSectionHeader}>
                <AppText variant="heading" style={styles.expenseTitle}>
                  (-) Expenses
                </AppText>
              </View>

              {trip.expenses && trip.expenses.length > 0 ? (
                trip.expenses.map((exp, idx) => (
                  <View key={exp.id || idx} style={styles.financialRow}>
                    <AppText variant="body" color="textMuted">
                      {exp.type} ({exp.date})
                    </AppText>
                    <AppText variant="body" style={styles.financialValue}>
                      ₹{exp.amount.toLocaleString('en-IN')}
                    </AppText>
                  </View>
                ))
              ) : (
                <AppText variant="caption" color="textMuted" style={styles.noDataText}>
                  No trip expenses recorded yet.
                </AppText>
              )}

              <View style={styles.dashedDivider} />

              <View style={styles.financialRow}>
                <AppText variant="label" style={styles.boldText}>
                  Total Expenses
                </AppText>
                <AppText variant="label" style={[styles.boldText, {color: colors.danger}]}>
                  ₹{totalExpenses.toLocaleString('en-IN')}
                </AppText>
              </View>
            </View>

            {/* Net Profit Summary Card */}
            <View style={[styles.card, styles.profitSummaryCard]}>
              <View style={styles.profitBanner}>
                <View>
                  <AppText variant="caption" color="textMuted">
                    ESTIMATED NET PROFIT
                  </AppText>
                  <AppText variant="title" style={[styles.profitAmount, {color: netProfit >= 0 ? colors.success : colors.danger}]}>
                    ₹{netProfit.toLocaleString('en-IN')}
                  </AppText>
                </View>
                <View style={[styles.profitIconCircle, {backgroundColor: netProfit >= 0 ? colors.successSoft : colors.dangerSoft}]}>
                  <Icon
                    name={netProfit >= 0 ? 'trending-up' : 'trending-down'}
                    size={28}
                    color={netProfit >= 0 ? colors.success : colors.danger}
                  />
                </View>
              </View>
              <AppText variant="caption" color="textMuted" style={styles.profitFormula}>
                Profit = Revenue (₹{totalRevenue.toLocaleString('en-IN')}) - Expenses (₹{totalExpenses.toLocaleString('en-IN')})
              </AppText>
            </View>
          </View>
        )}

        {/* ================= DRIVER TAB ================= */}
        {activeTab === 'Driver' && (
          <View style={styles.tabPane}>
            {/* Driver Profile Card */}
            <View style={styles.card}>
              <View style={styles.driverHeaderRow}>
                <View style={styles.driverAvatar}>
                  <Icon name="account-tie" size={28} color={colors.surface} />
                </View>
                <View style={styles.driverMeta}>
                  <AppText variant="heading" style={styles.driverName}>
                    {trip.driverName || 'Unassigned Driver'}
                  </AppText>
                  <AppText variant="caption" color="textMuted">
                    {trip.driverPhone ? `+91 ${trip.driverPhone}` : 'No phone linked'}
                  </AppText>
                </View>
                <View style={styles.onTripBadge}>
                  <AppText variant="caption" style={styles.onTripText}>
                    On Trip
                  </AppText>
                </View>
              </View>

              <View style={styles.divider} />

              <View style={styles.financialRow}>
                <AppText variant="body" color="textMuted">
                  Current Driver Balance
                </AppText>
                <AppText variant="heading" style={styles.driverBalanceAmt}>
                  ₹{(trip.driverBalance || 0).toLocaleString('en-IN')}
                </AppText>
              </View>

              <TouchableOpacity
                style={styles.addDriverBalanceBtn}
                onPress={() => setDriverBalanceVisible(true)}
                activeOpacity={0.7}>
                <Icon name="plus" size={18} color={colors.surface} />
                <AppText variant="label" style={styles.addDriverBalanceText}>
                  Add Driver Balance
                </AppText>
              </TouchableOpacity>
            </View>

            {/* Advances / Transactions History */}
            <View style={styles.card}>
              <AppText variant="heading" style={styles.cardSubtitle}>
                Driver Advances & Settlements
              </AppText>

              {trip.advances && trip.advances.length > 0 ? (
                trip.advances.map(adv => (
                  <View key={adv.id} style={styles.driverTxRow}>
                    <View>
                      <AppText variant="body" style={styles.boldText}>
                        Advance ({adv.paymentMode})
                      </AppText>
                      <AppText variant="caption" color="textMuted">
                        {adv.date} • {adv.receivedByDriver ? 'Received by Driver' : 'Direct Payment'}
                      </AppText>
                    </View>
                    <AppText variant="body" style={styles.financialValue}>
                      ₹{adv.amount.toLocaleString('en-IN')}
                    </AppText>
                  </View>
                ))
              ) : (
                <AppText variant="caption" color="textMuted" style={styles.noDataText}>
                  No advances recorded for this trip.
                </AppText>
              )}
            </View>
          </View>
        )}

        {/* ================= MORE TAB ================= */}
        {activeTab === 'More' && (
          <View style={styles.tabPane}>
            <View style={styles.card}>
              <AppText variant="heading" style={styles.cardSubtitle}>
                Additional Trip Information
              </AppText>

              <View style={styles.metaRow}>
                <AppText variant="caption" color="textMuted">
                  Trip ID
                </AppText>
                <AppText variant="body" style={styles.boldText}>
                  {trip.id}
                </AppText>
              </View>

              <View style={styles.metaRow}>
                <AppText variant="caption" color="textMuted">
                  LR Number
                </AppText>
                <AppText variant="body" style={styles.boldText}>
                  {trip.lrNumber || 'Not provided'}
                </AppText>
              </View>

              <View style={styles.metaRow}>
                <AppText variant="caption" color="textMuted">
                  Material
                </AppText>
                <AppText variant="body" style={styles.boldText}>
                  {trip.material || 'General Freight'}
                </AppText>
              </View>

              <View style={styles.metaRow}>
                <AppText variant="caption" color="textMuted">
                  Start KM
                </AppText>
                <AppText variant="body" style={styles.boldText}>
                  {trip.startKm ? `${trip.startKm} KM` : 'Not recorded'}
                </AppText>
              </View>

              <View style={styles.metaRow}>
                <AppText variant="caption" color="textMuted">
                  Billing Type
                </AppText>
                <AppText variant="body" style={styles.boldText}>
                  {trip.billingType}
                </AppText>
              </View>

              {trip.notes ? (
                <View style={styles.notesBlock}>
                  <AppText variant="caption" color="textMuted">
                    Notes
                  </AppText>
                  <AppText variant="body" style={styles.notesText}>
                    {trip.notes}
                  </AppText>
                </View>
              ) : null}
            </View>
          </View>
        )}

      </ScrollView>

      {/* Add Advance Modal */}
      <AddAdvanceSheet
        visible={advanceSheetVisible}
        onSave={handleSaveAdvance}
        onClose={() => setAdvanceSheetVisible(false)}
        isPending={isAddingAdvance}
      />

      {/* Add Driver Balance Modal */}
      <AddDriverBalanceSheet
        visible={driverBalanceVisible}
        driverName={trip.driverName}
        onConfirm={handleSaveDriverBalance}
        onClose={() => setDriverBalanceVisible(false)}
        isPending={isAddingDriverBalance}
      />
    </AppScreen>
  );
}

const styles = StyleSheet.create({
  screen: {
    flex: 1,
    backgroundColor: colors.background,
  },
  screenContent: {
    padding: 0,
  },
  centerContainer: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
    gap: spacing.md,
  },
  loadingText: {
    marginTop: spacing.xs,
  },
  retryBtn: {
    minWidth: 140,
  },
  header: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.sm,
    backgroundColor: colors.surface,
  },
  headerLeft: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: spacing.sm,
  },
  headerTitle: {
    fontSize: 18,
    fontWeight: '700',
    color: colors.text,
  },
  headerRight: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: spacing.sm,
  },
  iconBtn: {
    padding: 4,
  },
  editBtn: {
    borderWidth: 1,
    borderColor: colors.border,
    borderRadius: radius.sm,
    paddingHorizontal: spacing.md,
    paddingVertical: 5,
  },
  editText: {
    color: colors.primary,
    fontWeight: '600',
    fontSize: 13,
  },
  vehicleBanner: {
    backgroundColor: colors.surface,
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.sm,
    borderBottomWidth: 1,
    borderBottomColor: colors.border,
  },
  vehicleRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: spacing.sm,
  },
  truckNumber: {
    fontWeight: '700',
    fontSize: 15,
    color: colors.text,
    letterSpacing: 0.5,
  },
  driverSubText: {
    fontWeight: '500',
  },
  tabsContainer: {
    flexDirection: 'row',
    backgroundColor: colors.surface,
    borderBottomWidth: 1,
    borderBottomColor: colors.border,
  },
  tabItem: {
    flex: 1,
    alignItems: 'center',
    paddingVertical: spacing.md,
    position: 'relative',
  },
  tabItemSelected: {},
  tabText: {
    fontSize: 14,
    fontWeight: '600',
    color: colors.textMuted,
  },
  tabTextSelected: {
    color: colors.primary,
    fontWeight: '700',
  },
  tabIndicator: {
    position: 'absolute',
    bottom: 0,
    left: spacing.lg,
    right: spacing.lg,
    height: 3,
    backgroundColor: colors.primary,
    borderTopLeftRadius: 3,
    borderTopRightRadius: 3,
  },
  scrollContent: {
    padding: spacing.md,
    paddingBottom: spacing['3xl'],
  },
  tabPane: {
    gap: spacing.md,
  },
  card: {
    backgroundColor: colors.surface,
    borderRadius: radius.md + 2,
    borderWidth: 1,
    borderColor: colors.border,
    padding: spacing.md,
    gap: spacing.md,
  },
  customerRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
  },
  customerNameBlock: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: spacing.xs,
  },
  customerName: {
    fontWeight: '700',
    fontSize: 16,
    color: colors.primary,
  },
  amountPill: {
    backgroundColor: colors.surfaceMuted,
    paddingHorizontal: spacing.md,
    paddingVertical: 4,
    borderRadius: radius.round,
  },
  amountPillText: {
    fontWeight: '700',
    fontSize: 14,
    color: colors.text,
  },
  routeSection: {
    paddingVertical: spacing.xs,
  },
  routeCitiesRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
  },
  cityBlock: {
    flex: 1,
  },
  cityBlockRight: {
    alignItems: 'flex-end',
  },
  cityName: {
    fontWeight: '700',
    fontSize: 15,
    color: colors.text,
  },
  centerArrowBlock: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 4,
    paddingHorizontal: spacing.sm,
  },
  arrowLine: {
    width: 28,
    height: 1,
    backgroundColor: colors.border1,
  },
  arrowCircle: {
    width: 26,
    height: 26,
    borderRadius: radius.round,
    borderWidth: 1,
    borderColor: colors.border1,
    alignItems: 'center',
    justifyContent: 'center',
  },
  cardActionsRow: {
    flexDirection: 'row',
    gap: spacing.md,
    marginTop: spacing.xs,
  },
  completeTripBtn: {
    flex: 1,
    borderWidth: 1.5,
    borderColor: colors.success,
    borderRadius: radius.md,
    height: 44,
    alignItems: 'center',
    justifyContent: 'center',
  },
  completeTripText: {
    color: colors.success,
    fontWeight: '700',
    fontSize: 13,
  },
  viewBillBtn: {
    flex: 1,
    backgroundColor: colors.primary,
    borderRadius: radius.md,
    height: 44,
    alignItems: 'center',
    justifyContent: 'center',
  },
  viewBillText: {
    color: colors.surface,
    fontWeight: '700',
    fontSize: 13,
  },
  financialRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
  },
  financialLabel: {
    fontWeight: '600',
    color: colors.text,
  },
  financialValue: {
    fontWeight: '700',
    color: colors.text,
  },
  freightEditRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 6,
  },
  financialSection: {
    gap: 2,
  },
  actionLinkBtn: {
    alignSelf: 'flex-start',
  },
  actionLinkText: {
    color: colors.primary,
    fontWeight: '600',
    fontSize: 12,
  },
  dashedDivider: {
    height: 1,
    borderWidth: 1,
    borderColor: colors.border,
    borderStyle: 'dashed',
    marginVertical: spacing.xs,
  },
  divider: {
    height: 1,
    backgroundColor: colors.border,
  },
  pendingBalanceLabel: {
    fontSize: 16,
    fontWeight: '700',
    color: colors.text,
  },
  pendingBalanceValue: {
    fontSize: 16,
    fontWeight: '700',
    color: colors.primary,
  },
  bottomFinancialActions: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingTop: spacing.xs,
  },
  noteBtn: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 4,
  },
  noteBtnText: {
    color: colors.text,
    fontWeight: '600',
  },
  requestMoneyBtn: {
    borderWidth: 1,
    borderColor: colors.primary,
    borderRadius: radius.md,
    paddingHorizontal: spacing.md,
    paddingVertical: 7,
  },
  requestMoneyText: {
    color: colors.primary,
    fontWeight: '600',
    fontSize: 13,
  },
  addLoadCard: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    backgroundColor: colors.surface,
    borderRadius: radius.md,
    borderWidth: 1,
    borderColor: colors.border,
    paddingHorizontal: spacing.lg,
    paddingVertical: spacing.md,
  },
  addLoadText: {
    color: colors.primary,
    fontWeight: '600',
    fontSize: 14,
  },
  profitSectionHeader: {
    marginBottom: spacing.xs,
  },
  revenueTitle: {
    fontSize: 16,
    color: colors.success,
  },
  expenseTitle: {
    fontSize: 16,
    color: colors.danger,
  },
  boldText: {
    fontWeight: '700',
  },
  noDataText: {
    fontStyle: 'italic',
    paddingVertical: 4,
  },
  profitSummaryCard: {
    backgroundColor: colors.surfaceSubtle,
    borderColor: colors.border,
  },
  profitBanner: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
  },
  profitAmount: {
    fontSize: 24,
    fontWeight: '800',
    marginTop: 2,
  },
  profitIconCircle: {
    width: 48,
    height: 48,
    borderRadius: radius.round,
    alignItems: 'center',
    justifyContent: 'center',
  },
  profitFormula: {
    marginTop: spacing.xs,
    fontSize: 11,
  },
  driverHeaderRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: spacing.md,
  },
  driverAvatar: {
    width: 44,
    height: 44,
    borderRadius: radius.round,
    backgroundColor: colors.primary,
    alignItems: 'center',
    justifyContent: 'center',
  },
  driverMeta: {
    flex: 1,
    gap: 2,
  },
  driverName: {
    fontSize: 16,
  },
  onTripBadge: {
    backgroundColor: colors.successSoft,
    paddingHorizontal: spacing.sm,
    paddingVertical: 3,
    borderRadius: radius.sm,
  },
  onTripText: {
    color: colors.success,
    fontWeight: '700',
    fontSize: 11,
  },
  driverBalanceAmt: {
    fontSize: 18,
    color: colors.primary,
  },
  addDriverBalanceBtn: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    gap: spacing.xs,
    backgroundColor: colors.primary,
    borderRadius: radius.md,
    height: 44,
  },
  addDriverBalanceText: {
    color: colors.surface,
    fontWeight: '700',
  },
  cardSubtitle: {
    fontSize: 15,
    marginBottom: spacing.xs,
  },
  driverTxRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingVertical: spacing.xs,
    borderBottomWidth: 1,
    borderBottomColor: colors.surfaceSubtle,
  },
  metaRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingVertical: 4,
  },
  notesBlock: {
    marginTop: spacing.xs,
    gap: 4,
    backgroundColor: colors.surfaceSubtle,
    padding: spacing.sm,
    borderRadius: radius.sm,
  },
  notesText: {
    fontSize: 13,
  },
});
