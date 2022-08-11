import { Component, OnInit, ViewChild } from '@angular/core';
import { HeaderComponent } from '../header/header.component';

@Component({
    selector: 'app-sidebar',
    templateUrl: './sidebar.component.html',
    styleUrls: ['./sidebar.component.css'],
})
export class SidebarComponent implements OnInit {
    title = '';
    @ViewChild('header', { static: true }) header: HeaderComponent;

    public ngOnInit(): void {
        this.header.componentTitleChange$.subscribe((title) => (this.title = title));
    }
}
