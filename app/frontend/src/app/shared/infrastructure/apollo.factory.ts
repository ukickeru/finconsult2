import { HttpLink } from 'apollo-angular/http';
import { ApolloClientOptions, ApolloLink, InMemoryCache } from '@apollo/client/core';
import { setContext } from '@apollo/client/link/context';
import { TokenStorageService } from '../security/auth/infrastructure/token-storage.service';
import { GQLSchema, UrlGeneratorService } from './url-generator.service';

export function createApollo(httpLink: HttpLink, tokenStorage: TokenStorageService, urlGenerator: UrlGeneratorService) {
    const factory = new ApolloFactory(tokenStorage, urlGenerator);
    return factory.createApollo(httpLink);
}

class ApolloFactory {
    public constructor(private tokenStorage: TokenStorageService, private urlGenerator: UrlGeneratorService) {}

    public createApollo(httpLink: HttpLink) {
        return {
            root: this.forRootSchema(httpLink),
            public: this.forPublicSchema(httpLink),
        };
    }

    private forRootSchema(httpLink: HttpLink): ApolloClientOptions<any> {
        return {
            cache: new InMemoryCache(),
            link: ApolloLink.from([
                this.getBaseOptions(),
                this.getAuthOptions(),
                httpLink.create({
                    uri: this.urlGenerator.getGQLSchemaUrl(GQLSchema.Root),
                }),
            ]),
        };
    }

    private forPublicSchema(httpLink: HttpLink): ApolloClientOptions<any> {
        return {
            cache: new InMemoryCache(),
            link: ApolloLink.from([
                this.getBaseOptions(),
                httpLink.create({
                    uri: this.urlGenerator.getGQLSchemaUrl(GQLSchema.Public),
                }),
            ]),
        };
    }

    private getBaseOptions(): ApolloLink {
        return setContext((operation, context) => ({
            headers: {
                Accept: 'charset=utf-8',
            },
        }));
    }

    private getAuthOptions(): ApolloLink {
        return setContext((operation, context) => {
            const token = this.tokenStorage.getToken();

            if (token === null) {
                return {};
            } else {
                return {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                };
            }
        });
    }
}
