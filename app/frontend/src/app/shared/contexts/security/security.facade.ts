import { EventEmitter, Injectable } from '@angular/core';
import { TokenStorageService } from './auth/infrastructure/token-storage.service';
import { User } from './auth/model/user';
import { AuthService } from './auth/model/auth.service';

@Injectable({
    providedIn: 'root',
})
export class SecurityFacade {
    public isAuthenticated$: EventEmitter<boolean>;

    public constructor(private readonly authService: AuthService, private readonly tokenStorage: TokenStorageService) {
        this.isAuthenticated$ = new EventEmitter();
    }

    public isAuthenticated(): boolean {
        return this.tokenStorage.getToken() !== null;
    }

    public async login(email: string, password: string): Promise<void> {
        return this.authService.getToken(email, password).then((token) => {
            try {
                this.tokenStorage.setToken(token);
                this.getUser().then((user) => this.tokenStorage.setUser(user));
                this.isAuthenticated$.emit(true);
            } catch (error: any) {
                throw new Error('Ошибка аутентификации: ' + error.message);
            }
        });
    }

    public logout(): void {
        this.tokenStorage.logout();
        this.isAuthenticated$.emit(false);
    }

    public getToken(): string {
        let token = this.tokenStorage.getToken();
        if (typeof token === 'string') {
            return token;
        }

        throw new Error('Авторизуйтесь для загрузки данных профиля!');
    }

    public async getUser(): Promise<User> {
        return new Promise<User>((resolve, reject) => {
            if (!this.isAuthenticated()) {
                reject(Error('Авторизуйтесь для загрузки данных профиля!'));
            }

            let existingUser = this.tokenStorage.getUser();
            if (existingUser instanceof User) {
                resolve(existingUser);
            }

            return this.authService.getUser().then((user) => {
                this.tokenStorage.setUser(user);
                return user;
            });
        });
    }
}