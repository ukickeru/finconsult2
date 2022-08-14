import { Component } from '@angular/core';

@Component({
    selector: 'shared-component-preloader',
    templateUrl: './preloader.component.html',
    styleUrls: ['./preloader.component.scss'],
})
export class PreloaderComponent {
    public isShown = false;
    public isDisplayOver = false;

    show(): PreloaderComponent {
        this.isShown = true;
        return this;
    }

    hide(): PreloaderComponent {
        this.isShown = false;
        return this;
    }

    displayOver(): PreloaderComponent {
        this.isDisplayOver = true;
        return this;
    }

    displayNormal(): PreloaderComponent {
        this.isDisplayOver = false;
        return this;
    }
}
