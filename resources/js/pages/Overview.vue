<script setup>
import { onMounted, onUnmounted, ref } from "vue";
import api from "../api";
import CheckCard from "../components/CheckCard.vue";
import { safeUrl } from "../format";

const monitor = ref(null);
const loading = ref(true);
const error = ref("");
const controller = new AbortController();
let poller;

async function refresh() {
    if (controller.signal.aborted) return;

    try {
        const response = await api.get("monitor", controller.signal);
        monitor.value = response.monitor;
        error.value = "";
    } catch (exception) {
        if (!controller.signal.aborted) {
            error.value = exception.response?.data?.message || "Could not load your monitor. Try again.";
        }
    } finally {
        loading.value = false;
    }
}

onMounted(() => {
    refresh();
    poller = window.setInterval(() => {
        if (!document.hidden) refresh();
    }, 60000);
});

onUnmounted(() => {
    controller.abort();
    window.clearInterval(poller);
});
</script>

<template>
    <div class="od-tool">
        <Head title="Oh Dear" />
        <header class="od-page-header">
            <div>
                <Heading>Oh Dear</Heading>
                <p v-if="monitor" class="od-muted od-subtitle">{{ monitor.label || monitor.url }}</p>
                <p v-else class="od-muted od-subtitle">Your website’s monitoring checks</p>
            </div>
            <a
                v-if="monitor"
                href="https://ohdear.app/monitors"
                target="_blank"
                rel="noopener noreferrer"
                class="od-link"
                >Open Oh Dear <span aria-hidden="true">↗</span></a
            >
        </header>
        <div v-if="error" class="od-error od-notice" role="alert">
            <p>{{ error }}</p>
            <button type="button" class="od-link" @click="refresh">Try again</button>
        </div>
        <p v-if="loading" class="od-loading" role="status">Loading monitoring checks…</p>
        <template v-else-if="monitor">
            <div v-if="monitor.checks.length" class="od-check-grid">
                <CheckCard v-for="check in monitor.checks" :key="check.id" :check="check" @updated="refresh" />
            </div>
            <Card v-else class="od-empty">
                <h2>No monitoring checks yet</h2>
                <p>Enable checks for this monitor in Oh Dear to see their results here.</p>
                <a href="https://ohdear.app/monitors" class="od-link" target="_blank" rel="noopener noreferrer"
                    >Configure your monitor ↗</a
                >
            </Card>
            <p class="od-muted od-footnote">
                Results refresh every minute.
                <a :href="safeUrl(monitor.url)" target="_blank" rel="noopener noreferrer" class="od-link"
                    >Visit monitored website ↗</a
                >
            </p>
        </template>
    </div>
</template>
