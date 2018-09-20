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
            disabled: false,
        }),

        methods: {
            async requestRun() {
                await api.requestRunCheck(this.check.id);

                this.$toasted.show('New run scheduled', {type: 'success'});

                this.disabled = true;
            }
        }
    };
</script>
