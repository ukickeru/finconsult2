import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

// Components
import { MaterialModule } from './material.module';
import { ModalComponent } from './components/modal/modal.component';
import { PreloaderComponent } from './components/preloader/preloader.component';
import { ModalContentComponent } from './components/modal/content/modal-content.component';

@NgModule({
    exports: [PreloaderComponent, ModalComponent],
    declarations: [PreloaderComponent, ModalComponent, ModalContentComponent],
    imports: [CommonModule, MaterialModule],
    providers: [ModalComponent],
})
export class SharedModule {}
