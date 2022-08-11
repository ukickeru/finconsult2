export const environment = {
    production: true,
    appName: 'Finconsult',
    api: {
        baseUrl: 'https://localhost:8080',
        gqlSchemas: {
            root: 'https://localhost:8080/api/graphql/root',
            public: 'https://localhost:8080/api/graphql/public',
        },
    },
};
