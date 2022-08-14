import { MatDialog } from '@angular/material/dialog';
import { Content } from '../model/content';
import { ModalContentComponent } from '../content/modal-content.component';
import { ModalInterface } from '../model/modal.interface';
import { Option } from '../model/option';

export class ModalComponent implements ModalInterface {
    constructor(private content: Content, private dialog: MatDialog) {}

    asNotification(): ModalInterface {
        this.content.asNotification();
        return this;
    }

    asWarning(): ModalInterface {
        this.content.asWarning();
        return this;
    }

    asError(): ModalInterface {
        this.content.asError();
        return this;
    }

    setTitle(title: string): ModalInterface {
        this.content.setTitle(title);
        return this;
    }

    setBody(body: string): ModalInterface {
        this.content.setBody(body);
        return this;
    }

    addOption(option: Option): ModalInterface {
        this.content.addOption(option);
        return this;
    }

    setOptions(options: Option[]): ModalInterface {
        this.content.setOptions(options);
        return this;
    }

    unsetOptions(): ModalInterface {
        this.content.unsetOptions();
        return this;
    }

    update(content: Content): ModalInterface {
        this.content = content;
        return this;
    }

    show(): void {
        this.dialog.open(ModalContentComponent, { data: this.content });
    }

    hide(): void {
        this.dialog.closeAll();
    }
}
