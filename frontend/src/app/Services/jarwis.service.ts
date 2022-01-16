import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class JarwisService {

  private baseUrl = 'http://localhost:8000/api/';

  constructor(private http: HttpClient) { }

  signup(data: any) {
    return this.http.post('http://localhost:8000/api/signup', data)
  }

  login(data: any) {
    return this.http.post('http://localhost:8000/api/login', data)
  }

  sendPaswordResetLink(data: any) {
    return this.http.post('http://localhost:8000/api/sendPasswordResetLink', data);
  }
}
