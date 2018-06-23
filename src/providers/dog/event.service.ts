import { HttpClient} from '@angular/common/http';
import { Injectable } from '@angular/core';
import { ENV } from './../../environments/environment';

@Injectable()
export class EventService {
    private url: string;

  constructor(private http: HttpClient) {
    this.url = ENV[ENV.name].endpoints.events;
  }

  getEvents(handle: string) {
    const url: string = `${this.url}/${handle}.json`;
    return this.http.get(url);
}
}