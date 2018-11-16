<template>
    <label class="flex items-end text-90">
        <checkbox
            :checked="check.enabled"
            @input="toggleEnabled"
            class="mr-2"
        ></checkbox>
        Enabled
    </label>
</template>

<script>
import api from '../../api';

export default {
    props: ['check'],

    inject: ['refreshSite'],

    methods: {
        async toggleEnabled() {
            this.check.enabled ? await this.disableCheck() : await this.enableCheck();

            this.refreshSite();
        },

        async enableCheck() {
            await api.enableCheck(this.check.id);

            this.$toasted.show(`The ${this.check.label.toLowerCase()} check has been enabled`, { type: 'success' });
        },

        async disableCheck() {
            await api.disableCheck(this.check.id);

            this.$toasted.show(`The ${this.check.label.toLowerCase()} check has been disabled`, { type: 'success' });

        }
    }
};
</script>
