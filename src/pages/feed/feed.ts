import { Component } from '@angular/core';
import { IonicPage, NavController } from 'ionic-angular';
import { EventService } from '../../providers/dog/event.service';
@IonicPage()
@Component({
  templateUrl: 'feed.html'
})
export class FeedPage {



matchedEvents = [

  {

      "id": 124,

      "title": "Run, Run, Doggie Run",

      "event_picture": "dogplay2.jpg",

      "date": "Sun. Jun 30 9:00 AM",

      "location": "McCarren Park",

      "attendees": [

          {"id": 1, "picture": "picurl"}

      ],

      "pictures": ["url", "url"],

      "tag": "popular"

  },

  {

      "id": 125,

      "title": "We are here! Adopt me!",

      "event_picture": "adoption.jpg",

      "date": "Sun. Jul 7 10:00 AM",

      "location": "Union Square",

      "attendees": [

          {"id": 1, "picture": "picurl"}

      ],

      "pictures": ["url", "url"],

      "tag": "support"

  },

  {

      "id": 126,

      "title": "Husky Woof",

      "event_picture": "dogplay3.jpg",

      "date": "Fri. Jun 29 7:00 PM",

      "location": "Baltic Basketball Court",

      "attendees": [

          {"id": 1, "picture": "picurl"}

      ],

      "pictures": ["url", "url"],

      "tag": "nearby"

  },

  {

      "id": 127,

      "title": "Goldendoodle playtime in Dumbo",

      "event_picture": "dogplay5.png",

      "date": "Sun. Jun 30 3:00 PM",

      "location": "Dumbo",

      "attendees": [

          {"id": 1, "picture": "picurl"}

      ],

      "pictures": ["url", "url"],

      "tag": "match"

  },

];
  
otherEvents = [

  {

      "id": 224,

      "title": "Let's get some Brooklyn energy.",

      "event_picture": "dogplay1.jpg",

      "date": "Sun. Jul 15 11:00 AM",

      "location": "Central Park",

      "attendees": [

          {"id": 1, "picture": "picurl"}

      ],

      "pictures": ["url", "url"]

  },

  {

      "id": 225,

      "title": "Puppy meet-up! Come play!",

      "event_picture": "dogplay4.jpg",

      "date": "Sat. Jul 7 1:00 PM",

      "location": "Fort Greene",

      "attendees": [

          {"id": 1, "picture": "picurl"}

      ],

      "pictures": ["url", "url"]

  },

   {

      "id": 226,

      "title": "Friendly Dogs Gathering",

      "event_picture": "dogplay6.jpg",

      "date": "Sat. Jul 21 10:00 AM",

      "location": "Hillside Dog Park",

      "attendees": [

          {"id": 1, "picture": "picurl"}

      ],

      "pictures": ["url", "url"]

  },

  {

      "id": 227,

      "title": "Meet some new friends!",

      "event_picture": "dogplay7.jpg",

      "date": "Sat. Jun 16 4:00 PM",

      "location": "Madison Square Park",

      "attendees": [

          {"id": 1, "picture": "picurl"}

      ],

      "pictures": ["url", "url"]

  },

  {

      "id": 228,

      "title": "Energetic kiddo play",

      "event_picture": "dogplay8.jpg",

      "date": "Sun. Jul 15 9:00 AM",

      "location": "Dumbo Dog Run",

      "attendees": [

          {"id": 1, "picture": "picurl"}

      ],

      "pictures": ["url", "url"]

  }
]
constructor(public nav: NavController, public eventService: EventService) {
  }

  login(citizen) {
    this.nav.push('FeedPage', {});
  }

  getEventData() {
    console.log(this.eventService.getEvents('events'));
  }

  goToEvent() {
    //console.log('help');
    this.nav.push('EventPage', {});
  }
}
