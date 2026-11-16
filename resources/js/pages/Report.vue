<script setup>
import { computed, onUnmounted, ref, watch } from "vue";
import api from "../api";
import { date, safeUrl } from "../format";
import ReportTable from "../components/ReportTable.vue";

const props = defineProps({ report: { type: String, required: true } });
const titles = {
    uptime: "Uptime",
    "broken-links": "Broken links",
    "mixed-content": "Mixed content",
    "certificate-health": "Certificate health",
};
const title = computed(() => titles[props.report]);
const data = ref(null);
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
        data.value = await api.get(props.report, request.signal);
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

watch(() => props.report, load, { immediate: true });
onUnmounted(() => controller?.abort());
</script>

<template>
    <div class="od-tool">
        <Head :title="`${title} — Oh Dear`" />
        <Link :href="$url('/oh-dear')" class="od-link od-back">← Back to overview</Link>
        <header class="od-page-header">
            <Heading>{{ title }}</Heading>
        </header>
        <div v-if="error" class="od-error od-notice" role="alert">
            <p>{{ error }}</p>
            <button type="button" class="od-link" @click="load">Try again</button>
        </div>
        <p v-if="loading" class="od-loading" role="status">Loading {{ title.toLowerCase() }} report…</p>
        <template v-else-if="data">
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
