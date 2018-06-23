import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { DogService } from '../../providers';
import { FormBuilder, FormGroup } from '@angular/forms';

@IonicPage()
@Component({
  templateUrl: 'profile.html'
})
export class ProfilePage {

  public profile: any = {
      name: null,
      gender: null,
      age: null,
      breed: null,
      weight: null
  };

  public matchSettings: any = {
      size: null
  };

  constructor(private nav: NavController, private params: NavParams, private dogService: DogService, public formBuilder: FormBuilder) {
  }

  ionViewDidLoad() {
    // Build an empty form for the template to render
    this.profile = this.formBuilder.group({});
  }

  saveProfile() {
      console.log(this.dog);
  }

  next() {
    this.nav.push('FeedPage', {});
  }
}
