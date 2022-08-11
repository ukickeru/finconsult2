import { environment } from '../../../environments/environment';
import { Injectable } from '@angular/core';

@Injectable({
    providedIn: 'root',
})
export class UrlGeneratorService {
    public generateAbsoluteURL(relativePath: string): string {
        return environment.api.baseUrl + '/' + relativePath;
    }

    public getGQLSchemaUrl(schema: GQLSchema): string {
        const schemas = environment.api.gqlSchemas;
        type ObjectKey = keyof typeof schemas;
        const schemaName = schema as ObjectKey;

        if (typeof schemas[schemaName] !== 'string') {
            throw new Error('Не удалось определить URL для схемы "' + schema + '" API!');
        }

        return schemas[schemaName];
    }
}

export enum GQLSchema {
    Root = 'root',
    Public = 'public',
}
