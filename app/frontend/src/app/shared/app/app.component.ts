import { Component } from '@angular/core';
import { TokenStorageService } from '../security/auth/infrastructure/token-storage.service';
import { environment } from '../../../environments/environment';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.scss'],
})
export class AppComponent {
    appName = 'App';
    isLoggedIn = false;
    username?: string;

    constructor(private tokenStorageService: TokenStorageService) {
        this.appName = environment.appName;
    }

    ngOnInit(): void {
        this.isLoggedIn = this.tokenStorageService.getToken() != null;

        if (this.isLoggedIn) {
            const user = this.tokenStorageService.getUser();
            this.username = user?.getName();
        }
    }

    logout(): void {
        this.tokenStorageService.signOut();
        window.location.reload();
    }
}
