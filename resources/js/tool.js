Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'OhDearTool',
            path: '/oh-dear',
            component: require('./components/Overview'),
        },
        {
            path: '/oh-dear/uptime/:siteId',
            component: require('./components/Uptime/Overview'),
            props: true
        },
    ]);
});
