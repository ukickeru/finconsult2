import { Component, Inject, OnInit } from '@angular/core';
import { MAT_DIALOG_DATA } from '@angular/material/dialog';
import { Content } from '../content';

@Component({
    selector: 'app-modal-content',
    templateUrl: './modal-content.component.html',
    styleUrls: ['./modal-content.component.scss'],
})
export class ModalContentComponent {
    constructor(@Inject(MAT_DIALOG_DATA) public content: Content) {}
}
