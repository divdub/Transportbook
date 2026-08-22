/* eslint-env jest */

jest.mock('react-native-worklets', () =>
  require('react-native-worklets/src/mock'),
);

jest.mock('react-native-reanimated', () => {
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
    },
    useAnimatedStyle: updater => updater(),
    useSharedValue: initialValue => ({value: initialValue}),
    withTiming: identity,
  };
});
