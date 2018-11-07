<template>
    <div>
        <button v-if="!disabled" @click="requestRun" class="text-primary dim no-underline">Request new run</button>
        <span v-else class="text-80">Run requested</span>
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
            this.$toasted.show(`A new run of the ${this.check.label.toLowerCase()} check has been scheduled!`, {
                type: 'success'
            });

            this.disabled = true;

            await api.requestRunCheck(this.check.id);

            setTimeout(() => (this.disabled = false), 1000 * 30);
        }
    }
};
</script>
