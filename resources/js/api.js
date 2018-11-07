export default {
    getSites() {
        return window.axios.get('/nova-vendor/ohdearapp/oh-dear-tool/sites').then(response => response.data);
    },

    getSite(siteId) {
        return window.axios
            .get(`/nova-vendor/ohdearapp/oh-dear-tool/sites/${siteId}`, {headers: {'Cache-Control': 'no-cache'}})
            .then(response => response.data.site);
    },

    getUptime(siteId) {
        return window.axios.get(`/nova-vendor/ohdearapp/oh-dear-tool/uptime/${siteId}`).then(response => response.data);
    },

    getMixedContent(siteId) {
        return window.axios
            .get(`/nova-vendor/ohdearapp/oh-dear-tool/mixed-content/${siteId}`)
            .then(response => response.data);
    },

    getBrokenLinks(siteId) {
        return window.axios
            .get(`/nova-vendor/ohdearapp/oh-dear-tool/broken-links/${siteId}`)
            .then(response => response.data);
    },

    getCertificateHealth(siteId) {
        return window.axios
            .get(`/nova-vendor/ohdearapp/oh-dear-tool/certificate-health/${siteId}`)
            .then(response => response.data);
    },

    requestRunCheck(checkId) {
        return window.axios
            .post(`/nova-vendor/ohdearapp/oh-dear-tool/checks/${checkId}/request-run`)
            .then(response => response.data);
    },

    enableCheck(checkId) {
        return window.axios
            .post(`/nova-vendor/ohdearapp/oh-dear-tool/checks/${checkId}/enable`)
            .then(response => response.data);
    },

    disableCheck(checkId) {
        return window.axios
            .post(`/nova-vendor/ohdearapp/oh-dear-tool/checks/${checkId}/disable`)
            .then(response => response.data);
    }
};
