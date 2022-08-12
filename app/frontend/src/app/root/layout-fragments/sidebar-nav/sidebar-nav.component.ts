import { ChangeDetectorRef, Component } from '@angular/core';
import { IMenu, IMenuItem } from '../../model/routing/IMenu';

@Component({
    selector: 'app-sidebar-nav',
    templateUrl: './sidebar-nav.component.html',
    styleUrls: ['./sidebar-nav.component.css'],
})
export class SidebarNavComponent {
    // @todo: refactor this
    menuList: IMenu[] = [
        new Menu('First option', 'group', [
            new MenuItem('Login', 'login', '/login'),
            new MenuItem('Logout', 'logout', '/logout'),
        ]),
        new Menu('First option', 'group', [
            new MenuItem('Home', 'home', '/'),
            new MenuItem('Profile', 'person', '/profile'),
        ]),
    ];
}

class Menu implements IMenu {
    public constructor(
        public text: string,
        public icon: string,
        public children: IMenuItem[],
        public routerLink?: string
    ) {}
}

class MenuItem implements IMenuItem {
    public constructor(public text: string, public icon: string, public routerLink: string) {}
}
