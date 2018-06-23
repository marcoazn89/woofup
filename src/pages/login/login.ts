import { Component } from '@angular/core';
import { IonicPage, NavController } from 'ionic-angular';

@IonicPage()
@Component({
  templateUrl: 'login.html'
})
export class LoginPage {

  constructor(public nav: NavController) {
  }

  setupProfile(citizen) {
    this.nav.push('SetupProfilePage', {});
  }
}
