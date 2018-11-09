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

        if (this.type === 'certificate_transparency') {
            return false;
        }

        if (this.latestRunResult === 'pending') {
            return false;
        }

        if (this.latestRunResult === 'succeeded') {
            return false;
        }

        return true;
    }

    get color() {
        if (!this.enabled) {
            return '60';
        }

        if (this.hasIssues()) {
            return 'danger';
        }

        return 'success';
    }

    get latestRunResultLabel() {
        if (!this.enabled) {
            return 'Not checked';
        }

        if (this.latestRunResult === 'pending') {
            return 'Pending';
        }

        if (this.latestRunResult === 'succeeded') {
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

        if (this.latestRunResult === 'failed') {
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

    get latestRunResultClass() {
        if (!this.enabled || !this.latestRunResult) {
            return 'is-disabled';
        }

        return `is-${this.latestRunResult}`;
    }
}

export default Check;
