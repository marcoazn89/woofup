import React from 'react';
import { Platform } from 'react-native';
import { createStackNavigator} from 'react-navigation';
import FeedScreen from '../screens/FeedScreen';

export default createStackNavigator({
  Feed: FeedScreen
});
