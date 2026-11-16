export function date(value, options = {}) {
    if (!value) return "—";

    const iso = value.replace(" ", "T");
    const timestamp = /(?:Z|[+-]\d{2}:?\d{2})$/.test(iso) ? iso : `${iso}Z`;

    return new Intl.DateTimeFormat(undefined, {
        timeZone: Nova.config("userTimezone") || Nova.config("timezone") || "UTC",
        dateStyle: "medium",
        ...options,
    }).format(new Date(timestamp));
}

export function safeUrl(value) {
    return /^https?:\/\//i.test(value || "") ? value : null;
}
