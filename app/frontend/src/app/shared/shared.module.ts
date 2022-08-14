import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

// Components
import { MaterialModule } from './material.module';
import { PreloaderComponent } from './components/preloader/preloader.component';
import { ModalContentComponent } from './components/modal/content/modal-content.component';

@NgModule({
    exports: [PreloaderComponent],
    declarations: [PreloaderComponent, ModalContentComponent],
    imports: [CommonModule, MaterialModule],
})
export class SharedModule {}
