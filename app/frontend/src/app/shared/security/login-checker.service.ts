import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, Router, RouterStateSnapshot } from '@angular/router';
import { SecurityService } from './security.service';
import { HOME_PATH, LOGIN_PATH } from '../app/app-routing.module';

@Injectable({
    providedIn: 'root',
})
export class LoginCheckerService implements CanActivate {
    public constructor(private readonly security: SecurityService, private readonly router: Router) {}

    public canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
        if (!this.security.isAuthenticated()) {
            return this.router.parseUrl(LOGIN_PATH);
        }

        if (state.url === LOGIN_PATH) {
            return this.router.parseUrl(HOME_PATH);
        }

        return true;
    }
}
