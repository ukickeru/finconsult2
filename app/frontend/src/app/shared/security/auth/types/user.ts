export class User {
    public constructor(private email: string, private name: string, private role: string) {
        if (name.length === 0 || email.length === 0 || role.length === 0) {
            throw new Error(
                'При загрузке учётной записи возникла ошибка: имя, email и роль пользователя не могут быть пустыми!'
            );
        }
    }

    public getEmail(): string {
        return this.email;
    }

    public getName(): string {
        return this.name;
    }

    public getRole(): string {
        return this.role;
    }

    public static fromRawObject(user: any): User {
        if (user.email === undefined || user.name === undefined || user.role === undefined) {
            throw new Error(
                'При создании учётной записи возникла ошибка: обязательно должны быть указаны имя, email и роль пользователя!'
            );
        }

        return new User(user.email, user.name, user.role);
    }
}
