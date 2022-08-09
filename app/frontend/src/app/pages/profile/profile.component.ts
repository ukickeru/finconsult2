import type { OnInit } from '@angular/core';
import { Component } from '@angular/core';
import { TokenStorageService } from '../../shared/security/auth/token-storage.service';
import type { User } from '../../shared/security/auth/types/user';

@Component({
    selector: 'app-profile',
    templateUrl: './profile.component.html',
    styleUrls: ['./profile.component.css'],
})
export class ProfileComponent implements OnInit {
    token: string | null;
    user: User | null;

    constructor(private tokenStorage: TokenStorageService) {
        this.token = tokenStorage.getToken();
        this.user = tokenStorage.getUser();
    }

    ngOnInit(): void {
        // this.user = this.tokenStorage.getUser();
    }
}
