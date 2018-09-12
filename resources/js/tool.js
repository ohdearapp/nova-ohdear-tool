Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'OhDearTool',
            path: '/oh-dear',
            component: require('./components/Overview')
        },
        {
            path: '/oh-dear/uptime/:siteId',
            component: require('./components/Uptime/Overview'),
            props: true
        },
        {
            path: '/oh-dear/mixed-content/:siteId',
            component: require('./components/MixedContent/Overview'),
            props: true
        },
        {
            path: '/oh-dear/broken-links/:siteId',
            component: require('./components/BrokenLinks/Overview'),
            props: true
        }
    ]);
});
