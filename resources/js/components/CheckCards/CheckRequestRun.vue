<template>
    <div class="text-xs text-grey">
        <button v-if="! disabled" @click="requestRun()" class="outline-none hover:underline">Request new run</button>
        <span v-else>Run requested</span>
    </div>
</template>

<script>
import api from '../../api';

export default {
    props: ['check'],

    data: () => ({
        disabled: false
    }),

    methods: {
        async requestRun() {
            this.$toasted.show(`A new run of the ${this.check.label.toLowerCase()} check has been scheduled!`, { type: 'success' });

            await api.requestRunCheck(this.check.id);

            this.disabled = true;

            setTimeout(() => this.disabled = false, 1000 * 30);
        }
    }
};
</script>
