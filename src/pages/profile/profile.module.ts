import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { ProfilePage } from './profile';
import { DogService } from '../../providers';

@NgModule({
  declarations: [
    ProfilePage
  ],
  imports: [
    IonicPageModule.forChild(ProfilePage)
  ],
  exports: [
    ProfilePage
  ],
  providers: [
    DogService
  ]
})
export class ProfilePageModule {}