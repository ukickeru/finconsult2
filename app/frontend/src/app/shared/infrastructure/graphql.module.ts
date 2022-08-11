import { NgModule } from '@angular/core';
import { APOLLO_NAMED_OPTIONS, ApolloModule } from 'apollo-angular';
import { HttpLink } from 'apollo-angular/http';
import { HttpClientModule } from '@angular/common/http';
import { TokenStorageService } from '../security/auth/infrastructure/token-storage.service';
import { createApollo } from './apollo.factory';
import { UrlGeneratorService } from './url-generator.service';

@NgModule({
    imports: [ApolloModule, HttpClientModule],
    providers: [
        {
            provide: APOLLO_NAMED_OPTIONS,
            useFactory: createApollo,
            deps: [HttpLink, TokenStorageService, UrlGeneratorService],
        },
    ],
})
export class GraphQLModule {}
