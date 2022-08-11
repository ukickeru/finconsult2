import { OnInit } from '@angular/core';
import { Component, ViewChild } from '@angular/core';
import { SecurityService } from '../../shared/security/security.service';
import { Router } from '@angular/router';
import { LOGIN_PATH } from '../../shared/app/app-routing.module';

@Component({
    selector: 'app-logout',
    templateUrl: './logout.component.html',
    styleUrls: ['./logout.component.scss'],
})
export class LogoutComponent implements OnInit {
    constructor(private readonly security: SecurityService, private readonly router: Router) {}

    public ngOnInit(): void {
        this.security.logout();
        this.router.navigate([LOGIN_PATH]);
    }
}
