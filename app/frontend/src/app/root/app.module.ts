// Functional imports
import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { GraphQLModule } from '../shared/layers/infrastructure/graphql/graphql.module';

// Components
import { AppComponent } from './app.component';
import { AppRoutingModule } from './app-routing.module';
import { LayoutFragmentsModule } from './layout-fragments/layout-fragments.module';
import { SharedModule } from '../shared/shared.module';
import { MaterialModule } from '../shared/material.module';
import { HomeComponent } from '../pages/home/home.component';
import { LoginComponent } from '../pages/login/login.component';
import { LogoutComponent } from '../pages/logout/logout.component';
import { ProfileComponent } from '../pages/profile/profile.component';
import { ModalComponent } from '../shared/components/modal/modal.component';

@NgModule({
    declarations: [AppComponent, HomeComponent, LoginComponent, LogoutComponent, ProfileComponent],
    imports: [
        BrowserModule,
        BrowserAnimationsModule,
        LayoutFragmentsModule,
        MaterialModule,
        FormsModule,
        HttpClientModule,
        ReactiveFormsModule,
        GraphQLModule,
        AppRoutingModule,
        SharedModule,
    ],
    exports: [],
    bootstrap: [AppComponent],
})
export class AppModule {}
