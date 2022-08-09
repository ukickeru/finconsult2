import { NgModule } from '@angular/core';
import type { Routes } from '@angular/router';
import { RouterModule } from '@angular/router';
import { HomeComponent } from '../../pages/home/home.component';
import { LoginComponent } from '../../pages/login/login.component';
import { ProfileComponent } from '../../pages/profile/profile.component';
import { AuthService } from '../security/auth/model/auth.service';

export const HOME_PATH = '';
export const LOGIN_PATH = 'login';
export const REGISTRATION_PATH = 'registration';
export const LOGOUT_PATH = 'logout';
export const PROFILE_PATH = 'profile';

const routes: Routes = [
    { path: LOGIN_PATH, component: LoginComponent },
    { path: LOGOUT_PATH, redirectTo: LOGIN_PATH },
    { path: HOME_PATH, component: HomeComponent, canActivate: [AuthService] },
    { path: PROFILE_PATH, component: ProfileComponent, canActivate: [AuthService] },
    { path: '**', redirectTo: HOME_PATH },
];

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule],
})
export class AppRoutingModule {}
