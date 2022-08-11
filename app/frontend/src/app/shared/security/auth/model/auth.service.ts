import { Injectable } from '@angular/core';
import { Apollo } from 'apollo-angular';
import Login from '../infrastructure/api/login.graphql';
import Profile from '../infrastructure/api/profile.graphql';
import { GQLSchema } from '../../../infrastructure/url-generator.service';
import { User } from './user';

@Injectable({
    providedIn: 'root',
})
export class AuthService {
    constructor(private readonly gqlClient: Apollo) {}

    public async getToken(email: string, password: string): Promise<string> {
        return new Promise<string>((resolve, reject) => {
            this.gqlClient
                .use(GQLSchema.Public)
                .watchQuery({
                    query: Login,
                    variables: {
                        email: email,
                        password: password,
                    },
                })
                .valueChanges.subscribe({
                    next: async (data: any) => {
                        try {
                            resolve(data.data.security_login);
                        } catch (error: any) {
                            reject(Error('Во время аутентификации возникла ошибка: ' + error.message));
                        }
                    },
                    error: (error: Error) => {
                        reject(Error('Во время аутентификации возникла ошибка: ' + error.message));
                    },
                });
        });
    }

    public async getUser(): Promise<User> {
        return new Promise<User>((resolve, reject) => {
            this.gqlClient
                .use(GQLSchema.Root)
                .watchQuery({ query: Profile })
                .valueChanges.subscribe({
                    next: (data: any) => {
                        try {
                            resolve(User.fromRawObject(data.data.security_profile));
                        } catch (error: any) {
                            reject(Error('Во время загрузки данных профиля возникла ошибка: ' + error.message));
                        }
                    },
                    error: (error: Error) => {
                        reject(Error('Во время загрузки данных профиля возникла ошибка: ' + error.message));
                    },
                });
        });
    }
}
