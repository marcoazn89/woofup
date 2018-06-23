import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { FeedPage } from './feed';
import {EventService} from '../../providers/dog/event.service';

@NgModule({
  declarations: [
    FeedPage
  ],
  imports: [
    IonicPageModule.forChild(FeedPage)
  ],
  exports: [
    FeedPage
  ],
  providers: [
    EventService
  ]
})
export class FeedPageModule {}