import { ChangeDetectorRef, Component, ViewChild } from '@angular/core';
import { ActivationStart, Router } from '@angular/router';
import { SecurityFacade } from '../../../shared/contexts/security/security.facade';
import { MatSidenav } from '@angular/material/sidenav';

@Component({
    selector: 'app-sidebar',
    templateUrl: './sidebar.component.html',
    styleUrls: ['./sidebar.component.scss'],
})
export class SidebarComponent {
    title = '';
    isAuthenticated: boolean;
    @ViewChild('sidenav', { static: true }) sidenav: MatSidenav;

    constructor(
        private readonly security: SecurityFacade,
        private readonly cdRef: ChangeDetectorRef,
        private readonly router: Router
    ) {
        this.isAuthenticated = security.isAuthenticated();
        security.subscribeOnAuthStatus((isAuthenticated) => this.authChanged(isAuthenticated));
        this.router.events.subscribe((data) => this.updateTitle(data));
    }

    private updateTitle(data: any) {
        if (data instanceof ActivationStart) {
            if (this.security.isAuthenticated()) {
                this.title = data.snapshot.data['title'] ?? '';
                this.cdRef.detectChanges();
            } else {
                this.title = '';
                this.sidenav.close();
            }
        }
    }

    private authChanged(isAuthenticated: boolean): void {
        this.isAuthenticated = isAuthenticated;
        this.cdRef.detectChanges();
    }
}
