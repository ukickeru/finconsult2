import { ChangeDetectorRef, Component, EventEmitter, OnInit } from '@angular/core';
import { ActivationStart, NavigationEnd, Router } from '@angular/router';
import { filter, startWith } from 'rxjs/operators';
import { SecurityFacade } from '../../../shared/contexts/security/security.facade';

@Component({
    selector: 'app-header',
    templateUrl: './header.component.html',
    styleUrls: ['./header.component.css'],
})
export class HeaderComponent implements OnInit {
    isAuthenticated = false;
    componentTitleChange$: EventEmitter<string>;
    componentTitle: string;

    constructor(
        private readonly security: SecurityFacade,
        private readonly cdRef: ChangeDetectorRef,
        private router: Router
    ) {
        this.isAuthenticated = this.security.isAuthenticated();
        this.componentTitleChange$ = new EventEmitter();

        this.router.events.subscribe((data) => this.routeChanged(data));

        this.router.events.pipe(
            filter((event) => event instanceof NavigationEnd),
            startWith(this.router)
        );
    }

    ngOnInit() {
        this.router.events.subscribe((data) => this.routeChanged(data));
    }

    private authChanged(isAuthenticated: boolean) {
        this.isAuthenticated = isAuthenticated;
        this.cdRef.detectChanges();
    }

    private routeChanged(data: any) {
        if (data instanceof ActivationStart) {
            let title = data.snapshot.data['title'] ?? '';
            this.componentTitle = title;
            this.componentTitleChange$.emit(title);
        }
    }
}
