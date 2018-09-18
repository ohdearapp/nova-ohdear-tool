<template>
    <label class="text-sm">
        <input type="checkbox" class="check-toggle" @change="toggleEnabled" :checked="enabled">
    </label>
</template>

<script>
import { enableCheck, disableCheck } from '../api';
import Echo from '../mixins/Echo';

export default {
    props: ['check'],

    data() {
        return {
            enabled: this.check.enabled,
        };
    },

    methods: {
        toggleEnabled() {
            this.enabled ? disableCheck(this.check.id) : enableCheck(this.check.id);

            this.enabled = !this.enabled;
        },
    },
};
</script>
