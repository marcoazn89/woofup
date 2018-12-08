import React from "react";
import {
    View,
    Text,
    TextInput,
    StyleSheet
} from "react-native";
import { createStackNavigator, createAppContainer } from "react-navigation";

export default class BasicProfileScreen extends React.Component {
  render() {
    return (
      <View style={styles.container}>
        <Text>Tell us About Yourself</Text>
        <Text>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam nec porta tellus. Morbi nec.</Text>
        <Text>Basic Profile Screen</Text>
        <TextInput placeholder="My Name"></TextInput>
      </View>
    );
  }
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        alignItems: "center"
    },
    searchIcon: {
        padding: 10,
    }
});