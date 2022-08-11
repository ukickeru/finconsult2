import { OnInit } from '@angular/core';
import { Component, ViewChild } from '@angular/core';
import { PreloaderComponent } from '../../shared/components/preloader/preloader.component';
import { SecurityService } from '../../shared/security/security.service';
import { HOME_PATH } from '../../shared/app/app-routing.module';
import { Router } from '@angular/router';

@Component({
    selector: 'app-login',
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.scss'],
})
export class LoginComponent implements OnInit {
    form: LoginForm = new LoginForm();
    loginInProcess = false;
    @ViewChild('preloader', { static: true }) preloader: PreloaderComponent;

    constructor(private readonly security: SecurityService, private readonly router: Router) {}

    public ngOnInit(): void {
        if (this.security.isAuthenticated()) {
            this.redirectToHome();
        }

        this.preloader.displayOver();
    }

    public login(): void {
        this.loginStarted();

        this.security
            .login(this.form.getEmail(), this.form.getPassword())
            .then(() => this.redirectToHome())
            .catch((error) => {
                window.alert('Ошибка аутентификации!\n\n' + error.message);
                this.loginOver();
            });
    }

    private redirectToHome(): void {
        this.router.navigate([HOME_PATH]);
    }

    private loginStarted(): void {
        this.loginInProcess = true;
        this.preloader.show();
    }

    private loginOver(): void {
        this.loginInProcess = false;
        this.preloader.hide();
    }
}

class LoginForm {
    public email: string | null = null;
    public password: string | null = null;

    public getEmail(): string {
        if (this.email === null) {
            throw new Error('Введите email!');
        }

        return this.email;
    }

    public getPassword(): string {
        if (this.password === null) {
            throw new Error('Введите пароль!');
        }

        return this.password;
    }
}
