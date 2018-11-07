<template>
    <checkbox
        :checked="enabled"
        @input="toggleEnabled"
    ></checkbox>
</template>

<script>
import api from '../../api';

export default {
    props: ['check'],

    data() {
        return {
            enabled: this.check.enabled
        };
    },

    methods: {
        toggleEnabled() {
            this.enabled ? this.disableCheck() : this.enableCheck();

            this.enabled = !this.enabled;
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
