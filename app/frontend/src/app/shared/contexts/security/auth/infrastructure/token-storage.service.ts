import { Injectable } from '@angular/core';
import { User } from '../model/user';

const TOKEN = 'auth.token';
const USER = 'auth.user';

@Injectable({
    providedIn: 'root',
})
export class TokenStorageService {
    getToken(): string | null {
        return window.sessionStorage.getItem(TOKEN);
    }

    setToken(token: string): void {
        window.sessionStorage.removeItem(TOKEN);
        window.sessionStorage.setItem(TOKEN, token);
    }

    getUser(): User | null {
        const user = window.sessionStorage.getItem(USER);

        if (user) {
            try {
                return User.fromRawObject(JSON.parse(user));
            } catch (error: any) {
                throw new Error('При загрузке учётной записи пользователя возникла ошибка: ' + error?.message);
            }
        }

        return null;
    }

    setUser(user: User | object): void {
        if (typeof user === 'object') {
            try {
                user = User.fromRawObject(user);
            } catch (error: any) {
                throw new Error('При валидации учётной записи пользователя возникла ошибка: ' + error?.message);
            }
        }

        window.sessionStorage.setItem(USER, JSON.stringify(user));
    }

    logout(): void {
        window.sessionStorage.removeItem(TOKEN);
        window.sessionStorage.removeItem(USER);
    }
}
