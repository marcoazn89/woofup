import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { DogService } from '../../providers';
import { FormBuilder, FormGroup } from '@angular/forms';
import { trigger,state,style,transition,animate,keyframes } from '@angular/animations';

@IonicPage()
@Component({
  templateUrl: 'profile.html',
  animations: [
    trigger('toggle', [
      state('open', style({ height: '200px' })),
      state('closed', style({ height: '*' })),
      transition('open <=> closed', animate('200ms ease-in-out'))
    ])
  ]
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

  public state: string = "closed";

  public prop: any = {
    name: false,
    gender: false,
    age: false,
    breed: false,
    weight: false,
    size: false,
    breed_match: false,
    distance: false
  };

  constructor(private nav: NavController, private params: NavParams, private dogService: DogService, public formBuilder: FormBuilder) {
  }

  ionViewDidLoad() {
    // Build an empty form for the template to render
    this.profile = this.formBuilder.group({});
  }

  saveProfile() {
      console.log(this.profile);
  }

  viewFeed() {
    this.nav.push('FeedPage', {});
  }

  toggle(prop) {
    for (let key in this.prop)  {
      console.log(key, prop);
      if (key == prop) {
        this.prop[key] = true;
      } else {
        this.prop[key] = false;
      }
    }
  }
}
