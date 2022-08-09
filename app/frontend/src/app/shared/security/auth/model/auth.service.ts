import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { type CanActivate, Router, type RouterStateSnapshot } from '@angular/router';
import { type ActivatedRouteSnapshot } from '@angular/router';
import { TokenStorageService } from '../token-storage.service';
import { HOME_PATH, LOGIN_PATH, REGISTRATION_PATH } from '../../../app/app-routing.module';
import { UrlGeneratorService } from '../../../infrastructure/url-generator.service';
import { Apollo } from 'apollo-angular';
import Login from '../api/login.graphql';
import Profile from '../api/profile.graphql';

@Injectable({
    providedIn: 'root',
})
export class AuthService implements CanActivate {
    constructor(
        private readonly http: HttpClient,
        private readonly tokenStorage: TokenStorageService,
        private readonly urlGenerator: UrlGeneratorService,
        private readonly router: Router,
        private readonly gqlClient: Apollo
    ) {}

    public canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
        if (this.tokenStorage.getToken() === null) {
            return this.router.parseUrl(LOGIN_PATH);
        }

        if (state.url === LOGIN_PATH || state.url === REGISTRATION_PATH) {
            return this.router.parseUrl(HOME_PATH);
        }

        return true;
    }

    public isAuthenticated(): boolean {
        return this.tokenStorage.getToken() !== null;
    }

    public async login(email: string, password: string): Promise<void> {
        if (this.isAuthenticated()) {
            return;
        }

        return new Promise<void>((resolve, reject) => {
            this.gqlClient
                .watchQuery({
                    query: Login,
                    variables: {
                        email: email,
                        password: password,
                    },
                })
                .valueChanges.subscribe({
                    next: async (token: any) => {
                        this.tokenStorage.setToken(token);
                        // await this.getProfile()
                        resolve();
                    },
                    error: (error: Error) => {
                        reject(Error('Во время аутентификации возникла ошибка: ' + error.message));
                    },
                });
        });
    }

    public async getProfile(): Promise<void> {
        return new Promise<void>((resolve, reject) => {
            if (!this.isAuthenticated()) {
                reject(Error('Авторизуйтесь для загрузки данных профиля!'));
            }

            this.gqlClient.watchQuery({ query: Profile }).valueChanges.subscribe({
                next: (data: object) => {
                    this.tokenStorage.setUser(data);
                    resolve();
                },
                error: (error: Error) => {
                    reject(Error('Во время загрузки данных профиля возникла ошибка: ' + error.message));
                },
            });
        });
    }
}
