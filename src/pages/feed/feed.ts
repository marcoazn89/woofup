import { Component } from '@angular/core';
import { IonicPage, NavController } from 'ionic-angular';

@IonicPage()
@Component({
  templateUrl: 'feed.html'
})
export class FeedPage {

  constructor(public nav: NavController) {
  }

  login(citizen) {
    this.nav.push('FeedPage', {});
  }
}
