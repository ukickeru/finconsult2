import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { MaterialModule } from '../../shared/material.module';
import { MainShellComponent } from './main-shell/main-shell.component';
import { SidebarComponent } from './sidebar/sidebar.component';
import { SideNavbarComponent } from './side-navbar/side-navbar.component';
import { HeaderComponent } from './header/header.component';

@NgModule({
    declarations: [SidebarComponent, SideNavbarComponent, HeaderComponent, MainShellComponent],
    exports: [SidebarComponent, SideNavbarComponent, HeaderComponent],
    imports: [CommonModule, MaterialModule, RouterModule],
})
export class LayoutFragmentsModule {}
