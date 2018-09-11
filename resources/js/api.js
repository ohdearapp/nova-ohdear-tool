export default {
    getSites() {
        return window.axios
            .get('/nova-vendor/ohdearapp/oh-dear-tool/sites')
            .then(response => response.data);
    },

    getSite(siteId) {
        return window.axios
            .get(`/nova-vendor/ohdearapp/oh-dear-tool/sites/${siteId}`)
            .then(response => response.data);
    },

    getUptime(siteId) {
        return window.axios
            .get(`/nova-vendor/ohdearapp/oh-dear-tool/uptime/${siteId}`)
            .then(response => response.data);
    }
};
