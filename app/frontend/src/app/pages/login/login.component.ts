import { OnInit } from '@angular/core';
import { Component, ViewChild } from '@angular/core';
import { PreloaderComponent } from '../../shared/components/preloader/preloader.component';
import { SecurityFacade } from '../../shared/contexts/security/security.facade';
import { HOME_PATH } from '../../root/app-routing.module';
import { Router } from '@angular/router';
import { ModalBuilder } from '../../shared/components/modal/model/modal.builder';
import { ModalInterface } from '../../shared/components/modal/model/modal.interface';

@Component({
    selector: 'app-login',
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.scss'],
})
export class LoginComponent implements OnInit {
    form: LoginForm = new LoginForm();
    loginInProcess = false;
    modal: ModalInterface;
    @ViewChild('preloader', { static: true }) preloader: PreloaderComponent;

    constructor(
        private readonly modalBuilder: ModalBuilder,
        private readonly security: SecurityFacade,
        private readonly router: Router
    ) {
        this.modal = modalBuilder.createDefault();
    }

    ngOnInit(): void {
        if (this.security.isAuthenticated()) {
            this.redirectToHome();
        }

        this.preloader.displayOver();
    }

    login(): void {
        this.loginStarted();

        this.security
            .login(this.form.getEmail(), this.form.getPassword())
            .then(() => this.redirectToHome())
            .catch((error: any) => {
                this.modal.asError().setTitle('Ошибка аутентификации!').setBody(error?.message).show();
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

    getEmail(): string {
        if (this.email === null) {
            throw new Error('Введите email!');
        }

        return this.email;
    }

    getPassword(): string {
        if (this.password === null) {
            throw new Error('Введите пароль!');
        }

        return this.password;
    }
}
