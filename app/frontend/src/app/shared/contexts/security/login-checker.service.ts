import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, Router, RouterStateSnapshot } from '@angular/router';
import { SecurityFacade } from './security.facade';
import { HOME_PATH, LOGIN_PATH, LOGOUT_PATH } from '../../../root/app-routing.module';

@Injectable({
    providedIn: 'root',
})
export class LoginCheckerService implements CanActivate {
    public constructor(private readonly security: SecurityFacade, private readonly router: Router) {}

    public canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
        if (!this.security.isAuthenticated()) {
            if (state.url === LOGOUT_PATH) {
                return false;
            }

            return this.router.parseUrl(LOGIN_PATH);
        }

        if (state.url === LOGIN_PATH) {
            return this.router.parseUrl(HOME_PATH);
        }

        return true;
    }
}
