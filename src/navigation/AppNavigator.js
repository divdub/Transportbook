import React, {useRef} from 'react';
import {createNativeStackNavigator} from '@react-navigation/native-stack';
import MainTabNavigator from './MainTabNavigator';
import PartiesListScreen from '../features/parties/screens/PartiesListScreen';
import AddPartyScreen from '../features/parties/screens/AddPartyScreen';
import SelectStateScreen from '../features/parties/screens/SelectStateScreen';
import QuickActionSheet from '../features/quickActions/components/QuickActionSheet';
import {quickActionSheetController} from '../features/quickActions/quickActionSheetController';
import {routes} from './routeNames';
import {colors} from '../theme';

const Stack = createNativeStackNavigator();

export default function AppNavigator() {
  const sheetRef = useRef(null);

  return (
    <>
      <Stack.Navigator
        screenOptions={{
          headerShadowVisible: false,
          headerStyle: {backgroundColor: colors.background},
          headerTitleStyle: {color: colors.text},
          contentStyle: {backgroundColor: colors.background},
        }}>
        <Stack.Screen
          name={routes.mainTabs}
          component={MainTabNavigator}
          options={{headerShown: false}}
        />
        <Stack.Screen
          name={routes.partiesList}
          component={PartiesListScreen}
          options={{title: 'Parties'}}
        />
        <Stack.Screen
          name={routes.addParty}
          component={AddPartyScreen}
          options={{title: 'Add Party'}}
        />
        <Stack.Screen
          name={routes.selectState}
          component={SelectStateScreen}
          options={{headerShown: false, presentation: 'modal'}}
        />
      </Stack.Navigator>

      <QuickActionSheet
        ref={ref => {
          sheetRef.current = ref;
          quickActionSheetController.register(ref);
        }}
      />
    </>
  );
}