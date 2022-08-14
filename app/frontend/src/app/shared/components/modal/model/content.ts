import { Type } from './type';
import { Option } from './option';

export class Content {
    constructor(public type: Type, public title: string, public body: string, public options: Option[] = []) {}

    asNotification(): void {
        this.type = Type.notification;
    }

    asWarning(): void {
        this.type = Type.warning;
    }

    asError(): void {
        this.type = Type.error;
    }

    setTitle(title: string): void {
        this.title = title;
    }

    setBody(body: string): void {
        this.body = body;
    }

    addOption(option: Option) {
        this.options.push(option);
    }

    setOptions(options: Option[]): void {
        this.options = options;
    }

    unsetOptions(): void {
        this.options = [];
    }
}
