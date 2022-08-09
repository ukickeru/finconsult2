import { environment } from '../../../environments/environment';
import { Injectable } from '@angular/core';

@Injectable({
    providedIn: 'root',
})
export class UrlGeneratorService {
    public generateAbsoluteURL(relativePath: string): string {
        return environment.baseUrl + '/' + relativePath;
    }
}
