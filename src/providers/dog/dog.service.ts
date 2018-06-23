import { HttpClient} from '@angular/common/http';
import { Injectable } from '@angular/core';
import { ENV } from './../../environments/environment';

@Injectable()
export class DogService {
  private url: string;

  constructor(private http: HttpClient) {
    this.url = ENV[ENV.name].endpoints.dog;
  }

  saveProfile(profileData: any) {
      return this.http.post(url, profileData);
  }
 
  saveMatchPreferences(matchData: any) {
      return 4this.http.post(url, matchData);
  }
}
