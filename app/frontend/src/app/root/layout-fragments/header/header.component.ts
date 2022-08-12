import { ChangeDetectorRef, Component } from '@angular/core';
import { SecurityFacade } from '../../../shared/contexts/security/security.facade';

@Component({
    selector: 'app-header',
    templateUrl: './header.component.html',
    styleUrls: ['./header.component.scss'],
})
export class HeaderComponent {
    isAuthenticated: boolean;

    constructor(private readonly security: SecurityFacade, private readonly cdRef: ChangeDetectorRef) {
        this.isAuthenticated = security.isAuthenticated();
        security.subscribeOnAuthStatus((isAuthenticated) => this.authChanged(isAuthenticated));
    }

    private authChanged(isAuthenticated: boolean): void {
        this.isAuthenticated = isAuthenticated;
        this.cdRef.detectChanges();
    }
}
