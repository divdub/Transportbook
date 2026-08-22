import React from 'react';
import {ScrollView, StyleSheet, View} from 'react-native';
import {SafeAreaView} from 'react-native-safe-area-context';
import {colors, spacing} from '../../theme';

export function AppScreen({children, scroll = true, style, contentStyle}) {
  const Container = scroll ? ScrollView : View;

  return (
    <SafeAreaView style={[styles.safeArea, style]}>
      <Container
        contentContainerStyle={scroll ? [styles.content, contentStyle] : null}
        style={!scroll ? [styles.content, contentStyle] : null}>
        {children}
      </Container>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  safeArea: {
    flex: 1,
    backgroundColor: colors.background,
  },
  content: {
    flexGrow: 1,
    padding: spacing.xl,
  },
});
