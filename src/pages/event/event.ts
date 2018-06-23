import { Component } from '@angular/core';
import { IonicPage, NavController } from 'ionic-angular';

@IonicPage()
@Component({
  templateUrl: 'event.html'
})
export class EventPage {

  constructor(public nav: NavController) {
  }

  login(citizen) {
    this.nav.push('EventPage', {});
  }
}
