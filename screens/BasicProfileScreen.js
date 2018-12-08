import React from "react";
import {
    View,
    Text,
    TextInput,
    StyleSheet
} from "react-native";
import { createStackNavigator, createAppContainer } from "react-navigation";
import { Ionicons } from '@expo/vector-icons';

export default class BasicProfileScreen extends React.Component {
  render() {
    return (
      <View style={styles.container}>
        <Text style={styles.title}>Tell us About Yourself</Text>
        <Text style={styles.description}>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam nec porta tellus. Morbi nec.</Text>
        <View style={styles.inputContainer}>
            <Ionicons name="md-checkmark-circle"style={styles.icon} size={20} color="green" />
            <TextInput style={styles.input} placeholder="My Name"></TextInput>
        </View>
        <View style={styles.inputContainer}>
            <Ionicons name="md-checkmark-circle"style={styles.icon} size={20} color="green" />
            <TextInput style={styles.input} placeholder="My Name"></TextInput>
        </View>
        <View style={styles.inputContainer}>
            <Ionicons name="md-checkmark-circle"style={styles.icon} size={20} color="green" />
            <TextInput style={styles.input} placeholder="My Name"></TextInput>
        </View>
      </View>
    );
  }
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        flexDirection: 'column',
        alignItems: "center",
        backgroundColor: '#fff'
    },
    title: {
        textAlign: 'center',
        fontSize: 30,
        fontWeight: 'bold'
    },
    description: {
        textAlign: 'center'
    },
    inputContainer: {
        flexDirection: 'row',
        justifyContent: 'center',
        marginTop: 40
    },
    icon: {
        padding: 10,
    },
    input: {
        flex: 1,
        paddingTop: 10,
        paddingRight: 10,
        paddingBottom: 10,
        paddingLeft: 0,
        backgroundColor: '#fff',
        color: '#424242',
    }
});