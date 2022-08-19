import { EventEmitter, Injectable } from '@angular/core';
import { TokenStorageService } from './auth/infrastructure/token-storage.service';
import { User } from './auth/model/user';
import { AuthService } from './auth/model/auth.service';

@Injectable({
    providedIn: 'root',
})
export class SecurityFacade {
    public isAuthenticated$: EventEmitter<boolean>;

    constructor(private readonly authService: AuthService, private readonly tokenStorage: TokenStorageService) {
        this.isAuthenticated$ = new EventEmitter();
    }

    isAuthenticated(): boolean {
        return this.tokenStorage.getToken() !== null;
    }

    subscribeOnAuthStatus(f: (isAuthenticated: boolean) => void) {
        this.isAuthenticated$.subscribe((isAuthenticated) => f(isAuthenticated));
    }

    public async login(email: string, password: string): Promise<void> {
        return this.authService.getToken(email, password).then(
            (token) => {
                this.tokenStorage.setToken(token);
                this.getUser().then((user) => {
                    this.isAuthenticated$.emit(true);
                    this.tokenStorage.setUser(user);
                });
            },
            (error) => {
                throw new Error(error?.message ?? 'Ошибка аутентификации!');
            }
        );
    }

    logout(): void {
        this.tokenStorage.logout();
        this.isAuthenticated$.emit(false);
    }

    getToken(): string {
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

            return this.authService.getUser().then(
                (user: User) => {
                    this.tokenStorage.setUser(user);
                    resolve(user);
                },
                (error) => {
                    reject(error);
                }
            );
        });
    }
}
