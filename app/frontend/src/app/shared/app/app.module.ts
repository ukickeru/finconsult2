// Functional imports
import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { GraphQLModule } from '../infrastructure/graphql.module';

// Components
import { AppComponent } from './app.component';
import { SharedModule } from '../shared.module';
import { AppRoutingModule } from './app-routing.module';
import { LoginComponent } from '../../pages/login/login.component';
import { HomeComponent } from '../../pages/home/home.component';
import { ProfileComponent } from '../../pages/profile/profile.component';
import { MatSidenavModule } from '@angular/material/sidenav';
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatIconModule } from '@angular/material/icon';
import { MatButtonModule } from '@angular/material/button';
import { LogoutComponent } from '../../pages/logout/logout.component';
import { MatListModule } from '@angular/material/list';
import { MatExpansionModule } from '@angular/material/expansion';
import { MatTreeModule } from '@angular/material/tree';

@NgModule({
    declarations: [AppComponent, HomeComponent, LoginComponent, LogoutComponent, ProfileComponent],
    imports: [
        BrowserModule,
        BrowserAnimationsModule,
        FormsModule,
        HttpClientModule,
        ReactiveFormsModule,
        GraphQLModule,
        AppRoutingModule,
        SharedModule,
        MatSidenavModule,
        MatToolbarModule,
        MatIconModule,
        MatButtonModule,
        MatListModule,
        MatExpansionModule,
        MatTreeModule,
    ],
    exports: [MatSidenavModule, MatToolbarModule, MatIconModule, MatButtonModule],
    bootstrap: [AppComponent],
})
export class AppModule {}
