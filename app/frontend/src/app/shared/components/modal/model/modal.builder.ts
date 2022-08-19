import { Injectable } from '@angular/core';
import { ModalInterface } from './modal.interface';
import { Option } from './option';
import { Type } from './type';
import { MatDialog } from '@angular/material/dialog';
import { ModalComponent } from './modal.component';
import { Content } from './content';

@Injectable({
    providedIn: 'any',
})
export class ModalBuilder {
    private type: Type | null = null;
    private options: Option[] = [];
    private title: string | null = null;
    private body: string | null = null;

    constructor(private modalDialog: MatDialog) {}

    asNotification(): ModalBuilder {
        this.type = Type.notification;
        return this;
    }

    asWarning(): ModalBuilder {
        this.type = Type.warning;
        return this;
    }

    asError(): ModalBuilder {
        this.type = Type.error;
        return this;
    }

    addOption(title: string, value: any, callback: (value: any) => void): ModalBuilder {
        try {
            this.options.push(new Option(title, value, callback));
        } catch (error: any) {
            throw new Error('Во время добавления опции модального окна, возникла ошибка: ' + error?.message);
        }
        return this;
    }

    addOptions(options: Option[]): ModalBuilder {
        this.options = options;
        return this;
    }

    withTitle(title: string) {
        this.title = title;
        return this;
    }

    withBody(body: string) {
        this.body = body;
        return this;
    }

    reset(): ModalBuilder {
        this.type = this.title = this.body = null;
        this.options = [];
        return this;
    }

    build(): ModalInterface {
        if (this.type === null || this.title === null || this.body === null) {
            throw new Error('Для создания модального окна обязательно укажите его тип, заголовок и текст!');
        }

        try {
            return new ModalComponent(new Content(this.type, this.title, this.body, this.options), this.modalDialog);
        } catch (error: any) {
            throw new Error('Во время создания модального окна возникла ошибка: ' + error?.message);
        }
    }

    createDefault(): ModalInterface {
        return new ModalComponent(
            new Content(Type.notification, 'Шаблон модального окна', 'Шаблон текста окна'),
            this.modalDialog
        );
    }
}
