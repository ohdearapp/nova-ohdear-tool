const base = "/nova-vendor/ohdearapp/oh-dear-tool";

export default {
    async get(report, signal) {
        const response = await Nova.request().get(`${base}/${report}`, { signal });

        return response.data;
    },

    async updateCheck(id, action) {
        await Nova.request().post(`${base}/checks/${id}/${action}`);
    },
};
