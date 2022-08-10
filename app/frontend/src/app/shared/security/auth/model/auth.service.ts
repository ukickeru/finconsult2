import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { type CanActivate, Router, type RouterStateSnapshot } from '@angular/router';
import { type ActivatedRouteSnapshot } from '@angular/router';
import { TokenStorageService } from '../infrastructure/token-storage.service';
import { HOME_PATH, LOGIN_PATH } from '../../../app/app-routing.module';
import { Apollo } from 'apollo-angular';
import Login from '../infrastructure/api/login.graphql';
import Profile from '../infrastructure/api/profile.graphql';
import { GQLSchema } from '../../../infrastructure/url-generator.service';

@Injectable({
    providedIn: 'root',
})
export class AuthService implements CanActivate {
    constructor(
        private readonly http: HttpClient,
        private readonly tokenStorage: TokenStorageService,
        private readonly router: Router,
        private readonly gqlClient: Apollo
    ) {}

    public canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
        if (this.tokenStorage.getToken() === null) {
            return this.router.parseUrl(LOGIN_PATH);
        }

        if (state.url === LOGIN_PATH) {
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
                .use(GQLSchema.Public)
                .watchQuery({
                    query: Login,
                    variables: {
                        email: email,
                        password: password,
                    },
                })
                .valueChanges
                .subscribe({
                    next: async (token: any) => {
                        this.tokenStorage.setToken(token.data.security_login);
                        await this.getProfile()
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

            this.gqlClient
                .use(GQLSchema.Root)
                .watchQuery({ query: Profile })
                .valueChanges
                .subscribe({
                    next: (data: any) => {
                        this.tokenStorage.setUser(data.data.security_profile);
                        resolve();
                    },
                    error: (error: Error) => {
                        reject(Error('Во время загрузки данных профиля возникла ошибка: ' + error.message));
                    },
                });
        });
    }
}
