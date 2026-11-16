<script setup>
defineProps({
    title: { type: String, required: true },
    columns: { type: Array, required: true },
    empty: { type: String, required: true },
    rows: { type: Array, required: true },
});
</script>

<template>
    <section class="od-report-section">
        <h2>{{ title }}</h2>
        <Card class="od-table-card">
            <div class="od-table-scroll" role="region" :aria-label="title" tabindex="0">
                <table class="od-table">
                    <caption class="sr-only">
                        {{
                            title
                        }}
                    </caption>
                    <thead>
                        <tr>
                            <th v-for="column in columns" :key="column" scope="col">{{ column }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in rows" :key="index">
                            <slot :row="row" />
                        </tr>
                        <tr v-if="rows.length === 0">
                            <td :colspan="columns.length" class="od-empty">{{ empty }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </Card>
    </section>
</template>
