/* eslint-env jest */

jest.mock(
  'react-native-gesture-handler',
  () => {
    const View = require('react-native').View;
    return {
      GestureHandlerRootView: View,
      PanGestureHandler: View,
      State: {},
      Directions: {},
    };
  },
  {virtual: true},
);

jest.mock(
  '@gorhom/bottom-sheet',
  () => {
    const React = require('react');
    const View = require('react-native').View;
    const BottomSheet = React.forwardRef(({children}, ref) => {
      React.useImperativeHandle(ref, () => ({
        expand: jest.fn(),
        close: jest.fn(),
        snapToIndex: jest.fn(),
      }));
      return <View>{children}</View>;
    });
    return {
      __esModule: true,
      default: BottomSheet,
      BottomSheetModal: BottomSheet,
      BottomSheetModalProvider: ({children}) => children,
      BottomSheetView: View,
    };
  },
  {virtual: true},
);

jest.mock('react-native-vector-icons/MaterialCommunityIcons', () => 'Icon', {
  virtual: true,
});

jest.mock('lottie-react-native', () => 'LottieView', {
  virtual: true,
});

jest.mock(
  'react-native-worklets',
  () => {
    try {
      return require('react-native-worklets/src/mock');
    } catch {
      return {};
    }
  },
  {virtual: true},
);

jest.mock(
  'react-native-reanimated',
  () => {
    const {View} = require('react-native');
    const identity = value => value;

    return {
      __esModule: true,
      default: {
        View,
        createAnimatedComponent: component => component,
      },
      Easing: {
        cubic: identity,
        out: identity,
        back: identity,
        inOut: identity,
      },
      FadeIn: {
        duration: () => ({}),
      },
      FadeOut: {
        duration: () => ({}),
      },
      useAnimatedStyle: updater => updater(),
      useSharedValue: initialValue => ({value: initialValue}),
      withTiming: identity,
      withSpring: identity,
      withDelay: identity,
    };
  },
  {virtual: true},
);
