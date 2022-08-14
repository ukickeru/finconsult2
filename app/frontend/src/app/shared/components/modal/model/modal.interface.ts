import { Content } from './content';
import { Option } from './option';

export interface ModalInterface {
    asNotification(): ModalInterface;
    asWarning(): ModalInterface;
    asError(): ModalInterface;
    addOption(option: Option): ModalInterface;
    setOptions(options: Option[]): ModalInterface;
    unsetOptions(): ModalInterface;
    setTitle(title: string): ModalInterface;
    setBody(body: string): ModalInterface;
    update(content: Content): ModalInterface;
    show(): ModalInterface | any;
    hide(): ModalInterface | any;
}
