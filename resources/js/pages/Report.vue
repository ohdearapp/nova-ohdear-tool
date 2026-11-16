<script setup>
import { computed, onUnmounted, ref, watch } from "vue";
import api from "../api";
import { date, safeUrl } from "../format";
import ReportTable from "../components/ReportTable.vue";

const props = defineProps({
    report: { type: String, required: true },
    healthCheckId: { type: Number, default: null },
});
const titles = {
    uptime: "Uptime",
    "broken-links": "Broken links",
    "mixed-content": "Mixed content",
    "certificate-health": "Certificate health",
    "application-health": "Application health",
    "scheduled-tasks": "Scheduled tasks",
};
const data = ref(null);
const title = computed(() =>
    props.healthCheckId ? `${data.value?.healthCheck?.label || "Application health"} history` : titles[props.report],
);
const loading = ref(true);
const error = ref("");
let controller;

async function load() {
    controller?.abort();
    const request = new AbortController();
    controller = request;
    loading.value = true;
    data.value = null;
    error.value = "";

    try {
        data.value = await api.get(
            props.healthCheckId ? `${props.report}/${props.healthCheckId}` : props.report,
            request.signal,
        );
    } catch (exception) {
        if (!request.signal.aborted)
            error.value = exception.response?.data?.message || "Could not load this report. Try again.";
    } finally {
        if (!request.signal.aborted) loading.value = false;
    }
}

function duration(period) {
    const start = new Date(`${period.startedAt.replace(" ", "T").replace(/Z$/, "")}Z`);
    const end = period.endedAt ? new Date(`${period.endedAt.replace(" ", "T").replace(/Z$/, "")}Z`) : new Date();
    const seconds = Math.max(0, Math.round((end - start) / 1000));
    if (seconds < 60) return `${seconds} seconds`;
    if (seconds < 3600) return `${Math.floor(seconds / 60)} minutes`;

    return `${Math.floor(seconds / 3600)} hours ${Math.floor((seconds % 3600) / 60)} minutes`;
}

function healthLabel(status) {
    return (
        { ok: "OK", warning: "Warning", failed: "Failed", crashed: "Crashed", skipped: "Skipped" }[status] ||
        status ||
        "Not reported yet"
    );
}

function healthTone(status) {
    return { ok: "success", warning: "warning", failed: "danger", crashed: "danger" }[status] || "muted";
}

function taskLabel(task) {
    return task.latestResultLabel === "ok" ? "OK" : task.latestResultLabel || task.latestResult || "Not reported yet";
}

watch(() => [props.report, props.healthCheckId], load, { immediate: true });
onUnmounted(() => controller?.abort());
</script>

<template>
    <div class="od-tool">
        <Head :title="`${title} — Oh Dear`" />
        <Link :href="$url(healthCheckId ? '/oh-dear/application-health' : '/oh-dear')" class="od-link od-back">
            {{ healthCheckId ? "← Back to application health" : "← Back to overview" }}
        </Link>
        <header class="od-page-header">
            <Heading>{{ title }}</Heading>
        </header>
        <div v-if="error" class="od-error od-notice" role="alert">
            <p>{{ error }}</p>
            <button type="button" class="od-link" @click="load">Try again</button>
        </div>
        <p v-if="loading" class="od-loading" role="status">Loading {{ title.toLowerCase() }} report…</p>
        <template v-else-if="data">
            <ReportTable
                v-if="report === 'application-health' && !healthCheckId"
                title="Application health checks"
                :columns="['Check', 'Result', 'Details', 'Last updated']"
                :rows="data.healthChecks"
                empty="No application health checks reported yet. Configure application health monitoring in Oh Dear to see individual results here."
            >
                <template #default="{ row }">
                    <td class="od-health-name">
                        <p>{{ row.label || row.name }}</p>
                        <Link
                            :href="$url(`/oh-dear/application-health/${row.id}`)"
                            class="od-link od-history-link"
                            :aria-label="`View ${row.label || row.name} history`"
                            >View history →</Link
                        >
                    </td>
                    <td>
                        <span class="od-status" :class="`od-status-${healthTone(row.status)}`">{{
                            healthLabel(row.status)
                        }}</span>
                        <p v-if="row.snoozed" class="od-muted">Snoozed</p>
                    </td>
                    <td class="od-report-message">
                        <p>{{ row.shortSummary || row.message || "No details reported." }}</p>
                        <p v-if="row.message && row.message !== row.shortSummary && row.shortSummary" class="od-muted">
                            {{ row.message }}
                        </p>
                    </td>
                    <td class="od-number">{{ date(row.updatedAt || row.detectedAt, { timeStyle: "short" }) }}</td>
                </template>
            </ReportTable>
            <ReportTable
                v-if="report === 'application-health' && healthCheckId"
                title="Recorded status history"
                :columns="['Detected at', 'Result', 'Details', 'Last updated']"
                :rows="data.history"
                empty="No history recorded for this application health check yet."
            >
                <template #default="{ row }">
                    <td class="od-number">{{ date(row.detectedAt, { timeStyle: "short" }) }}</td>
                    <td>
                        <span class="od-status" :class="`od-status-${healthTone(row.status)}`">{{
                            healthLabel(row.status)
                        }}</span>
                    </td>
                    <td class="od-report-message">
                        <p>{{ row.shortSummary || row.message || "No details reported." }}</p>
                        <p v-if="row.message && row.message !== row.shortSummary && row.shortSummary" class="od-muted">
                            {{ row.message }}
                        </p>
                    </td>
                    <td class="od-number">{{ date(row.updatedAt, { timeStyle: "short" }) }}</td>
                </template>
            </ReportTable>
            <ReportTable
                v-if="report === 'scheduled-tasks'"
                title="Monitored scheduled tasks"
                :columns="['Task', 'Result', 'Schedule', 'Last ping', 'Grace period']"
                :rows="data.scheduledTasks"
                empty="No scheduled tasks monitored yet. Configure scheduled task monitoring in Oh Dear to see schedules and heartbeat results here."
            >
                <template #default="{ row }">
                    <td class="od-task-name">
                        <p>{{ row.name }}</p>
                        <p v-if="row.description" class="od-muted">{{ row.description }}</p>
                    </td>
                    <td>
                        <span
                            class="od-status"
                            :class="`od-status-${{ green: 'success', red: 'danger', yellow: 'warning', orange: 'warning' }[row.latestResultLabelColor] || 'muted'}`"
                            >{{ taskLabel(row) }}</span
                        >
                        <p v-if="row.snoozed" class="od-muted">Snoozed</p>
                    </td>
                    <td>
                        <p>
                            {{
                                row.humanReadableCronExpression ||
                                row.cronExpression ||
                                (row.frequencyInMinutes ? `Every ${row.frequencyInMinutes} minutes` : "Not reported")
                            }}
                        </p>
                        <p v-if="row.cronExpression && row.humanReadableCronExpression" class="od-muted">
                            {{ row.cronExpression }}
                        </p>
                        <p class="od-muted">{{ row.serverTimezone || "Timezone not reported" }}</p>
                    </td>
                    <td class="od-number">
                        {{ row.latestPingAt ? date(row.latestPingAt, { timeStyle: "short" }) : "Never received" }}
                    </td>
                    <td class="od-number">
                        {{ row.graceTimeInMinutes == null ? "Not reported" : `${row.graceTimeInMinutes} minutes` }}
                    </td>
                </template>
            </ReportTable>
            <template v-if="report === 'uptime'">
                <div class="od-report-grid">
                    <ReportTable
                        title="Uptime in the past 7 days"
                        :columns="['Date (UTC)', 'Uptime']"
                        :rows="[...data.uptimePastWeek].reverse()"
                        empty="No uptime data recorded yet."
                    >
                        <template #default="{ row }"
                            ><td>{{ date(row.datetime, { timeZone: "UTC" }) }}</td>
                            <td class="od-number">{{ row.uptimePercentage }}%</td></template
                        >
                    </ReportTable>
                    <ReportTable
                        title="Uptime in the past year"
                        :columns="['Month (UTC)', 'Uptime']"
                        :rows="[...data.uptimePastYear].reverse()"
                        empty="No uptime data recorded yet."
                    >
                        <template #default="{ row }"
                            ><td>
                                {{
                                    date(row.datetime, {
                                        timeZone: "UTC",
                                        dateStyle: undefined,
                                        month: "long",
                                        year: "numeric",
                                    })
                                }}
                            </td>
                            <td class="od-number">{{ row.uptimePercentage }}%</td></template
                        >
                    </ReportTable>
                </div>
                <ReportTable
                    title="Downtime in the past 7 days"
                    :columns="['Started at', 'Ended at', 'Duration']"
                    :rows="data.downtimePeriods"
                    empty="No downtime recorded in the past 7 days."
                >
                    <template #default="{ row }"
                        ><td>{{ date(row.startedAt, { timeStyle: "short" }) }}</td>
                        <td>{{ row.endedAt ? date(row.endedAt, { timeStyle: "short" }) : "Ongoing" }}</td>
                        <td class="od-number">{{ duration(row) }}</td></template
                    >
                </ReportTable>
            </template>
            <ReportTable
                v-if="report === 'broken-links'"
                title="Broken links found by the latest crawl"
                :columns="['Status', 'Broken link', 'Found on']"
                :rows="data.brokenLinks"
                empty="No broken links found in the latest crawl."
            >
                <template #default="{ row }">
                    <td class="od-number">{{ row.statusCode || "No response" }}</td>
                    <td>
                        <a :href="safeUrl(row.crawledUrl)" class="od-link" target="_blank" rel="noopener noreferrer">{{
                            row.crawledUrl
                        }}</a>
                    </td>
                    <td>
                        <a :href="safeUrl(row.foundOnUrl)" class="od-link" target="_blank" rel="noopener noreferrer">{{
                            row.foundOnUrl
                        }}</a>
                    </td>
                </template>
            </ReportTable>
            <ReportTable
                v-if="report === 'mixed-content'"
                title="Mixed content found by the latest crawl"
                :columns="['Found on', 'Element', 'Insecure URL']"
                :rows="data.mixedContent"
                empty="No mixed content found in the latest crawl."
            >
                <template #default="{ row }">
                    <td>
                        <a :href="safeUrl(row.foundOnUrl)" class="od-link" target="_blank" rel="noopener noreferrer">{{
                            row.foundOnUrl
                        }}</a>
                    </td>
                    <td>{{ row.elementName }}</td>
                    <td>
                        <a
                            :href="safeUrl(row.mixedContentUrl)"
                            class="od-link"
                            target="_blank"
                            rel="noopener noreferrer"
                            >{{ row.mixedContentUrl }}</a
                        >
                    </td>
                </template>
            </ReportTable>
            <template v-if="report === 'certificate-health'">
                <section class="od-report-section">
                    <h2>Certificate details</h2>
                    <Card class="od-details">
                        <dl>
                            <div>
                                <dt>Issuer</dt>
                                <dd>{{ data.certificateHealth.certificateDetails.issuer || "—" }}</dd>
                            </div>
                            <div>
                                <dt>Valid from</dt>
                                <dd>{{ data.certificateHealth.certificateDetails.valid_from || "—" }}</dd>
                            </div>
                            <div>
                                <dt>Valid until</dt>
                                <dd>{{ data.certificateHealth.certificateDetails.valid_until || "—" }}</dd>
                            </div>
                        </dl>
                    </Card>
                </section>
                <ReportTable
                    title="Certificate checks"
                    :columns="['Check', 'Result']"
                    :rows="data.certificateHealth.certificateChecks"
                    empty="No certificate checks recorded yet."
                >
                    <template #default="{ row }"
                        ><td>{{ row.label }}</td>
                        <td>
                            <span class="od-status" :class="row.passed ? 'od-status-success' : 'od-status-danger'">{{
                                row.passed ? "Passed" : "Failed"
                            }}</span>
                        </td></template
                    >
                </ReportTable>
                <section class="od-report-section">
                    <h2>Certificate chain issuers</h2>
                    <Card class="od-details">
                        <ul v-if="data.certificateHealth.certificateChainIssuers.length">
                            <li v-for="(issuer, index) in data.certificateHealth.certificateChainIssuers" :key="index">
                                {{ issuer }}
                            </li>
                        </ul>
                        <p v-else class="od-empty">No certificate chain recorded yet.</p>
                    </Card>
                </section>
            </template>
        </template>
    </div>
</template>
