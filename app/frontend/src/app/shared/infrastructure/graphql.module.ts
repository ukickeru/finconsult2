import { NgModule } from '@angular/core';
import { ApolloModule, APOLLO_OPTIONS } from 'apollo-angular';
import type { ApolloClientOptions } from '@apollo/client/core';
import { InMemoryCache } from '@apollo/client/core';
import { HttpLink } from 'apollo-angular/http';

const uri = 'https://localhost:8080/api/graphql/public';
export function createApollo(httpLink: HttpLink): ApolloClientOptions<object> {
    return {
        link: httpLink.create({ uri }),
        cache: new InMemoryCache(),
        headers: {
            'Access-Control-Allow-Origin': '*',
        },
    };
}

@NgModule({
    exports: [ApolloModule],
    providers: [
        {
            provide: APOLLO_OPTIONS,
            useFactory: createApollo,
            deps: [HttpLink],
        },
    ],
})
export class GraphQLModule {}
