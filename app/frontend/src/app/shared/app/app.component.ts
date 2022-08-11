import { AfterViewInit, ChangeDetectorRef, Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { environment } from '../../../environments/environment';
import { SecurityService } from '../security/security.service';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.scss'],
})
export class AppComponent {
    appName = environment.appName;
    isAuthenticated = false;
    isSidenavOpened = false;
    username?: string;

    constructor(private readonly security: SecurityService, private readonly cdRef: ChangeDetectorRef) {
        this.isAuthenticated = this.security.isAuthenticated();
        security.isAuthenticated$.subscribe((isAuthenticated) => this.authChanged(isAuthenticated));

        if (this.isAuthenticated) {
            this.security.getUser().then((user) => (this.username = user.getName()));
        }
    }

    public authChanged(isAuthenticated: boolean) {
        this.isAuthenticated = isAuthenticated;
        this.cdRef.detectChanges();
    }
}
