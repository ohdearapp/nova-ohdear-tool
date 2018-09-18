<template>
    <div class="text-xs text-grey">
        <button v-if="! disabled" @click="requestRun()" class="outline-none hover:underline">Request new run</button>
        <span v-else>Run requested</span>
    </div>
</template>

<script>
import { sortBy, reject } from 'lodash';
import api from '../../api';

export default {
    props: ['check'],

    data() {
        return {
            disabled: false,
        };
    },

    methods: {
        async requestRun() {
            await api.requestCheckRun(this.check.id);

            this.$toasted.show('New run scheduled', { type: 'success'});

            this.disabled = true;
        },
    },
};
</script>
