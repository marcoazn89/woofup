import React from 'react';
import { createSwitchNavigator } from 'react-navigation';

import ProfileNavigator from './ProfileNavigator';
import FeedNavigator from './FeedNavigator';

export default createSwitchNavigator({
  // You could add another route here for authentication.
  // Read more at https://reactnavigation.org/docs/en/auth-flow.html
  //Main: MainTabNavigator,
  Profile: ProfileNavigator,
  Feed: FeedNavigator
});