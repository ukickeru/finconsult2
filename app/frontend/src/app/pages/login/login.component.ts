import { OnInit } from '@angular/core';
import { Component, ViewChild } from '@angular/core';
import { AuthService } from '../../shared/security/auth/model/auth.service';
import { Router } from '@angular/router';
import { PreloaderComponent } from '../../shared/components/preloader/preloader.component';
import { MdbModalRef, MdbModalService } from 'mdb-angular-ui-kit/modal';
import { ModalComponent, State } from '../../shared/components/modal/modal.component';

@Component({
    selector: 'app-login',
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.scss'],
})
export class LoginComponent implements OnInit {
    form: LoginForm = new LoginForm();
    loginInProcess = false;
    @ViewChild('preloader', { static: true }) preloader: PreloaderComponent;
    modalRef: MdbModalRef<ModalComponent> | null = null;

    constructor(private authService: AuthService, private router: Router, private modalService: MdbModalService) {}

    public ngOnInit(): void {
        if (this.authService.isAuthenticated()) {
            this.navigateToHome();
        }

        this.preloader.displayOver();
    }

    public login(): void {
        this.loginStarted();

        this.authService
            .login(this.form.getEmail(), this.form.getPassword())
            .then(() => this.navigateToHome())
            .catch((error) => {
                this.modalRef = this.modalService.open(ModalComponent, {
                    data: { state: new State('Ошибка аутентификации!', error.message) },
                });
                this.loginOver();
            });
    }

    private navigateToHome(): void {
        window.location.reload()
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
