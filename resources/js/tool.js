Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'OhDearTool',
            path: '/oh-dear',
            component: require('./components/OhdearTool'),
        },
    ]);
});
