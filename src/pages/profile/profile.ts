import { Component } from '@angular/core';
import { IonicPage, NavController } from 'ionic-angular';
import { DogService } from '../../providers';

@IonicPage()
@Component({
  templateUrl: 'profile.html'
})
export class ProfilePage {

  constructor(private nav: NavController, private params: NavParams, private dogService: DogService) {
  }

  next() {
    this.nav.push('FeedPage', {});
  }
}
