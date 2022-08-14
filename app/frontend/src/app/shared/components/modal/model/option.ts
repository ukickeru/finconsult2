export class Option {
    constructor(
        public readonly title: string,
        public readonly value: any,
        public readonly callback: (value: any) => void
    ) {}

    call(): void {
        this.callback(this.value);
    }
}
