import { NgModule } from '@angular/core';
import type { Routes } from '@angular/router';
import { RouterModule } from '@angular/router';
import { HomeComponent } from '../pages/home/home.component';
import { LoginComponent } from '../pages/login/login.component';
import { ProfileComponent } from '../pages/profile/profile.component';
import { LogoutComponent } from '../pages/logout/logout.component';
import { LoginCheckerService } from '../shared/contexts/security/login-checker.service';
import { MainShellComponent } from './layout-fragments/main-shell/main-shell.component';

export const HOME_PATH = '';
export const LOGIN_PATH = 'login';
export const LOGOUT_PATH = 'logout';
export const PROFILE_PATH = 'profile';

const routes: Routes = [
    {
        path: HOME_PATH,
        component: MainShellComponent,
        canActivate: [LoginCheckerService],
        children: [
            { path: '', pathMatch: 'full', component: HomeComponent, data: { title: 'Главная' } },
            { path: LOGIN_PATH, component: LoginComponent, data: { title: 'Вход' } },
            { path: LOGOUT_PATH, component: LogoutComponent },
            {
                path: PROFILE_PATH,
                component: ProfileComponent,
                canActivate: [LoginCheckerService],
                data: { title: 'Профиль' },
            },
        ],
    },
    { path: '**', redirectTo: HOME_PATH },
];

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule],
})
export class AppRoutingModule {}
