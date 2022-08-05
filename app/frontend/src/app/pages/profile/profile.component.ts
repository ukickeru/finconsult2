import type { OnInit } from '@angular/core';
import { Component } from '@angular/core';
import { type Token, TokenStorageService, type UserPayload } from '../../shared/security/auth/token-storage.service';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css'],
})
export class ProfileComponent implements OnInit {
  token: Token | null;
  user: UserPayload | null;

  constructor(private tokenStorage: TokenStorageService) {
    this.token = tokenStorage.getToken();
    this.user = tokenStorage.getUser();
  }

  ngOnInit(): void {
    // this.user = this.tokenStorage.getUser();
  }
}
