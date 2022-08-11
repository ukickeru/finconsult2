import { Component } from '@angular/core';

@Component({
    selector: 'app-modal',
    templateUrl: './modal.component.html',
    styleUrls: ['./modal.component.scss'],
})
export class ModalComponent {
    public state: State | null = null;
}

export class State {
    constructor(public title: string, public body: string) {}
}
