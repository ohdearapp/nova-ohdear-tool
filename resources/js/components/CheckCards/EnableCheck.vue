<template>
    <checkbox :checked="check.enabled" @input="toggleEnabled"></checkbox>
</template>

<script>
import api from '../../api';

export default {
    props: ['check'],

    inject: ['refreshSite'],

    methods: {
        toggleEnabled() {
            this.check.enabled ? this.disableCheck() : this.enableCheck();

            this.refreshSite();
        },

        enableCheck() {
            this.$toasted.show(`The ${this.check.label.toLowerCase()} check has been enabled`, { type: 'success' });

            api.enableCheck(this.check.id);
        },

        disableCheck() {
            this.$toasted.show(`The ${this.check.label.toLowerCase()} check has been disabled`, { type: 'success' });

            api.disableCheck(this.check.id);
        }
    }
};
</script>
