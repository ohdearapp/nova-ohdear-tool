<template>
    <label class="text-sm">
        <input type="checkbox" class="check-toggle" @change="toggleEnabled" :checked="enabled">
    </label>
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
            this.enabled ? api.disableCheck(this.check.id) : api.enableCheck(this.check.id);

            this.enabled = !this.enabled;
        }
    }
};
</script>
