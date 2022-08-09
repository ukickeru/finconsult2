import { Component } from '@angular/core';
import { MdbModalRef } from 'mdb-angular-ui-kit/modal';

@Component({
    selector: 'app-modal',
    templateUrl: './modal.component.html',
    styleUrls: ['./modal.component.scss'],
})
export class ModalComponent {
    public state: State | null = null;

    constructor(public modalRef: MdbModalRef<ModalComponent>) {}
}

export class State {
    constructor(public title: string, public body: string) {}
}
