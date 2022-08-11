import { Component } from '@angular/core';
import type { User } from '../../shared/contexts/security/auth/model/user';
import { SecurityFacade } from '../../shared/contexts/security/security.facade';

@Component({
    selector: 'app-profile',
    templateUrl: './profile.component.html',
    styleUrls: ['./profile.component.scss'],
})
export class ProfileComponent {
    token: string | null;
    user: User | null;

    constructor(private security: SecurityFacade) {
        this.token = security.getToken();
        security.getUser().then((user) => (this.user = user));
    }
}
