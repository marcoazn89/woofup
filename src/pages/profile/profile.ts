import { Component } from '@angular/core';
import { IonicPage, NavController } from 'ionic-angular';

@IonicPage()
@Component({
  templateUrl: 'profile.html'
})
export class ProfilePage {

  constructor(public nav: NavController) {
  }

  next() {
    this.nav.push('MatchingPage', {});
  }
}
