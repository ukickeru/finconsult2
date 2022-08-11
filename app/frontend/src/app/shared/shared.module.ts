import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

// Components
import { ModalComponent } from './components/modal/modal.component';
import { PreloaderComponent } from './components/preloader/preloader.component';

@NgModule({
    exports: [PreloaderComponent, ModalComponent],
    declarations: [PreloaderComponent, ModalComponent],
    imports: [CommonModule],
})
export class SharedModule {}
