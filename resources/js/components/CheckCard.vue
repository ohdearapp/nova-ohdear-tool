<script setup>
import { computed, ref } from "vue";
import api from "../api";
import { date } from "../format";

const props = defineProps({ check: { type: Object, required: true } });
const emit = defineEmits(["updated"]);
const busy = ref(false);
const error = ref("");
const report = computed(
    () =>
        ({
            uptime: "uptime",
            broken_links: "broken-links",
            mixed_content: "mixed-content",
            certificate_health: "certificate-health",
            application_health: "application-health",
            cron: "scheduled-tasks",
        })[props.check.type],
);
const status = computed(() => {
    if (!props.check.enabled) return "Disabled";
    if (props.check.type === "certificate_transparency") return "Always running";

    return (
        {
            succeeded: "Last run passed",
            failed: "Last run failed",
            warning: "Last run warning",
            pending: "Pending",
            "errored-or-timed-out": "Last run errored",
        }[props.check.latest_run_result] || "Not checked yet"
    );
});
const tone = computed(() => {
    if (!props.check.enabled) return "muted";
    if (props.check.latest_run_result === "succeeded") return "success";
    if (["failed", "errored-or-timed-out"].includes(props.check.latest_run_result)) return "danger";
    if (props.check.latest_run_result === "warning") return "warning";

    return "muted";
});

async function update(action) {
    if (busy.value) return;
    busy.value = true;
    error.value = "";

    try {
        await api.updateCheck(props.check.id, action);
        Nova.success(action === "request-run" ? "A new check run was requested." : "Check updated.");
        emit("updated");
    } catch (exception) {
        error.value = exception.response?.data?.message || "Could not update this check. Try again.";
    } finally {
        busy.value = false;
    }
}
</script>

<template>
    <Card class="od-check">
        <div class="od-check-body">
            <div class="od-check-title">
                <h2>{{ check.label }}</h2>
                <span class="od-status" :class="`od-status-${tone}`">{{ status }}</span>
            </div>
            <p class="od-summary">
                {{
                    check.summary ||
                    (check.enabled ? "Waiting for the next check result." : "This check is not monitoring your site.")
                }}
            </p>
            <p v-if="check.latest_run_ended_at" class="od-muted od-last-checked">
                Last checked
                <time :datetime="check.latest_run_ended_at">{{
                    date(check.latest_run_ended_at, { timeStyle: "short" })
                }}</time>
            </p>
            <Link v-if="report" :href="$url(`/oh-dear/${report}`)" class="od-link od-report-link"
                >View report <span aria-hidden="true">→</span></Link
            >
        </div>
        <div v-if="error" class="od-error od-check-error" role="alert">{{ error }}</div>
        <footer class="od-check-actions">
            <label class="od-checkbox">
                <input
                    type="checkbox"
                    :checked="check.enabled"
                    :disabled="busy"
                    :aria-label="`Enable ${check.label}`"
                    @click.prevent="update(check.enabled ? 'disable' : 'enable')"
                />
                Enabled
            </label>
            <button
                v-if="check.type !== 'certificate_transparency'"
                type="button"
                class="od-link"
                :disabled="busy || !check.enabled"
                @click="update('request-run')"
            >
                {{ busy ? "Updating…" : "Request new run" }}
            </button>
        </footer>
    </Card>
</template>
