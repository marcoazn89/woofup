import React from 'react';
import { Platform } from 'react-native';
import { createStackNavigator} from 'react-navigation';
import BasicProfileScreen from '../screens/BasicProfileScreen';
import ProfileDetailsScreen from '../screens/BasicProfileScreen';
import MatchingCriteriaScreen from '../screens/BasicProfileScreen';

export default createStackNavigator({
  BasicProfile: BasicProfileScreen,
  ProfileDetails: ProfileDetailsScreen,
  MatchingCriteria: MatchingCriteriaScreen
});
