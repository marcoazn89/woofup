import React from "react";
import {
    View,
    Text,
    StyleSheet
} from "react-native";
import { createStackNavigator, createAppContainer } from "react-navigation";
import Icon from 'react-native-vector-icons/FontAwesome';
import { Input, Button } from 'react-native-elements';

export default class BasicProfileScreen extends React.Component {
  render() {
    return (
      <View style={styles.container}>
        <Text style={styles.title}>Tell us About Yourself</Text>
        <Text style={styles.description}>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam nec porta tellus. Morbi nec.</Text>

        <View style={{marginTop: 40}}></View>
        <Input
          placeholder='My name'
          leftIcon={{ type: 'font-awesome', name: 'paw'}}
        />

        <Input
          placeholder='My Age'
          leftIcon={{ type: 'font-awesome', name: 'paw'}}
        />

        <Input
          placeholder='My Breed'
          leftIcon={{ type: 'font-awesome', name: 'paw'}}
        />

        <Input
          placeholder='My Weight'
          leftIcon={{ type: 'font-awesome', name: 'paw'}}
        />

        <Button
          title='Next'
          onPress={() => this.props.navigation.navigate('ProfileDetails')}
        />
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