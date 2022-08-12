import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { MaterialModule } from '../../shared/material.module';
import { MainShellComponent } from './main-shell/main-shell.component';
import { SidebarComponent } from './sidebar/sidebar.component';
import { SidebarNavComponent } from './sidebar-nav/sidebar-nav.component';
import { HeaderComponent } from './header/header.component';

@NgModule({
    declarations: [SidebarComponent, SidebarNavComponent, HeaderComponent, MainShellComponent],
    exports: [SidebarComponent, SidebarNavComponent, HeaderComponent],
    imports: [CommonModule, MaterialModule, RouterModule],
})
export class LayoutFragmentsModule {}
