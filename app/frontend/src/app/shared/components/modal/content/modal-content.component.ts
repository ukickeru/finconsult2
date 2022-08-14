import { Component, Inject } from '@angular/core';
import { MAT_DIALOG_DATA } from '@angular/material/dialog';
import { Content } from '../model/content';
import { Type } from '../model/type';

@Component({
    selector: 'app-modal-content',
    templateUrl: './modal-content.component.html',
    styleUrls: ['./modal-content.component.scss'],
})
export class ModalContentComponent {
    type = Type;
    constructor(@Inject(MAT_DIALOG_DATA) public content: Content) {}
}
