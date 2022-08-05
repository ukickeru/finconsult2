import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { type Observable } from 'rxjs';
import { type CanActivate, Router, type RouterStateSnapshot } from '@angular/router';
import { type ActivatedRouteSnapshot } from '@angular/router';
import { TokenStorageService } from './token-storage.service';
import { HOME_PATH, LOGIN_PATH, REGISTRATION_PATH } from '../../app/app-routing.module';
import { UrlGeneratorService } from '../../infrastructure/url-generator.service';

const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' }),
};

@Injectable({
  providedIn: 'root',
})
export class AuthService implements CanActivate {
  constructor(
    private readonly http: HttpClient,
    private readonly tokenStorage: TokenStorageService,
    private readonly urlGenerator: UrlGeneratorService,
    private readonly router: Router
  ) {}

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
    if (this.tokenStorage.getToken() === null) {
      return this.router.parseUrl(LOGIN_PATH);
    }

    if (state.url === LOGIN_PATH || state.url === REGISTRATION_PATH) {
      return this.router.parseUrl(HOME_PATH);
    }

    return true;
  }

  login(email: string, password: string): Observable<any> {
    return this.http.post(
      this.urlGenerator.generateAbsoluteURL(LOGIN_PATH),
      {
        email,
        password,
      },
      httpOptions
    );
  }

  register(email: string, name: string, password: string): Observable<any> {
    return this.http.post(
      this.urlGenerator.generateAbsoluteURL(REGISTRATION_PATH),
      {
        email,
        name,
        password,
      },
      httpOptions
    );
  }
}
