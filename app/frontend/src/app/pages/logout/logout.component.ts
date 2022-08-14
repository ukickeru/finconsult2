import { OnInit } from '@angular/core';
import { Component } from '@angular/core';
import { SecurityFacade } from '../../shared/contexts/security/security.facade';
import { Router } from '@angular/router';
import { LOGIN_PATH } from '../../root/app-routing.module';

@Component({
    selector: 'app-logout',
    templateUrl: './logout.component.html',
    styleUrls: ['./logout.component.scss'],
})
export class LogoutComponent implements OnInit {
    constructor(private readonly security: SecurityFacade, private readonly router: Router) {}

    ngOnInit(): void {
        this.security.logout();
        this.router.navigate([LOGIN_PATH]);
    }
}
