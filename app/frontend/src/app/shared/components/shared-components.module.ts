import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

// Components
import { PreloaderComponent } from './preloader/preloader.component';
import { ModalComponent } from './modal/modal.component';

@NgModule({
    exports: [PreloaderComponent, ModalComponent],
    declarations: [PreloaderComponent, ModalComponent],
    imports: [CommonModule],
})
export class SharedComponentsModule {}
