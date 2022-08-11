import type { OnInit } from '@angular/core';
import { Component } from '@angular/core';
import type { User } from '../../shared/security/auth/model/user';
import { SecurityService } from '../../shared/security/security.service';

@Component({
    selector: 'app-profile',
    templateUrl: './profile.component.html',
    styleUrls: ['./profile.component.scss'],
})
export class ProfileComponent implements OnInit {
    token: string | null;
    user: User | null;

    constructor(private security: SecurityService) {
        this.token = security.getToken();
        security.getUser().then((user) => (this.user = user));
    }

    ngOnInit(): void {
        // this.user = this.security.getUser();
    }
}
