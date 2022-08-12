import { Component } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { Content } from './content';
import { ModalContentComponent } from './content/modal-content.component';

@Component({
    selector: 'app-modal',
    templateUrl: './modal.component.html',
    styleUrls: ['./modal.component.scss'],
})
export class ModalComponent {
    public constructor(private dialog: MatDialog) {}

    public open(content: Content) {
        this.dialog.open(ModalContentComponent, { data: content });
    }

    public hide() {
        this.dialog.closeAll();
    }
}
