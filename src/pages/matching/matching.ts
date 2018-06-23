import { Component } from '@angular/core';
import { IonicPage, NavController } from 'ionic-angular';

@IonicPage()
@Component({
  templateUrl: 'matching.html'
})
export class MatchingPage {

  constructor(public nav: NavController) {
  }

  setupProfile() {
    //this.nav.push('ProfilePage', {});
  }
}
