import React from "react";
import {
    View,
    Text,
    StyleSheet
} from "react-native";
import { createStackNavigator, createAppContainer } from "react-navigation";
import Icon from 'react-native-vector-icons/FontAwesome';
import { Constants } from 'expo';
import { Input, Button, ButtonGroup } from 'react-native-elements';

export default class MatchingCriteriaScreen extends React.Component {
  state = {
    index: 0
  }

  updateIndex = (index) => {
    this.setState({index})
  }
  render() {
    return (
      <View style={styles.container}>
        <Text style={styles.title}>I'm looking for ...</Text>
        <Text style={styles.description}>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam nec porta tellus. Morbi nec.</Text>

        <View style={{marginTop: 40}}></View>
        <ButtonGroup
        selectedBackgroundColor="pink"
        onPress={this.updateIndex}
        selectedIndex={this.state.index}
        buttons={['Small', 'Medium', 'Large']}
        containerStyle={{height: 30}} />

        <ButtonGroup
        selectedBackgroundColor="pink"
        onPress={this.updateIndex}
        selectedIndex={this.state.index}
        buttons={['Calm', 'Energetic']}
        containerStyle={{height: 30}} />

        <Input
          placeholder='Type in a breed'
          leftIcon={{ type: 'font-awesome', name: 'paw'}}
        />

        <Button
          title='Next'
          onPress={() => this.props.navigation.navigate('Feed')}
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