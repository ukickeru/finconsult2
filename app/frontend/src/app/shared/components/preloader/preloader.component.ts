import { Component } from '@angular/core';

@Component({
    selector: 'shared-component-preloader',
    templateUrl: './preloader.component.html',
    styleUrls: ['./preloader.component.scss'],
})
export class PreloaderComponent {
    public isShown = false;
    public isDisplayOver = false;

    public show(): PreloaderComponent {
        this.isShown = true;
        return this;
    }

    public hide(): PreloaderComponent {
        this.isShown = false;
        return this;
    }

    public displayOver(): PreloaderComponent {
        this.isDisplayOver = true;
        return this;
    }

    public displayNormal(): PreloaderComponent {
        this.isDisplayOver = false;
        return this;
    }
}
