class Check {
    constructor(properties) {
        Object.keys(properties).forEach(name => {
            this[name] = properties[name];
        });
    }

    hasIssues() {
        if (!this.enabled) {
            return false;
        }

        if (this.latest_run_result === 'pending') {
            return false;
        }

        if (this.latest_run_result === 'succeeded') {
            return false;
        }

        return true;
    }

    get latest_run_result_label() {
        if (!this.enabled) {
            return 'Not checked';
        }

        if (this.latest_run_result === 'pending') {
            return 'Pending';
        }

        if (this.latest_run_result === 'succeeded') {
            if (this.type === 'uptime') {
                return 'Site is up';
            }

            if (this.type === 'certificate_health') {
                return 'Healthy';
            }

            if (this.type === 'mixed_content') {
                return 'Secure';
            }

            if (this.type === 'broken_links') {
                return 'No broken links';
            }

            return 'Succeeded';
        }

        if (this.latest_run_result === 'failed') {
            if (this.type === 'uptime') {
                return 'Site is down';
            }

            if (this.type === 'certificate_health') {
                return 'Unhealthy';
            }

            if (this.type === 'mixed_content') {
                return 'Insecure';
            }

            if (this.type === 'broken_links') {
                return 'Broken links found';
            }

            return 'Failed';
        }

        return 'Error running check';
    }

    get latest_run_result_class() {
        if (!this.enabled || !this.latest_run_result) {
            return 'is-disabled';
        }

        return `is-${this.latest_run_result}`;
    }
}

export default Check;
