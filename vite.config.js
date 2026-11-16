import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [vue()],
    build: {
        outDir: "dist",
        lib: {
            entry: "resources/js/tool.js",
            name: "OhDearTool",
            formats: ["iife"],
            fileName: () => "js/tool.js",
            cssFileName: "css/tool",
        },
        rollupOptions: {
            external: ["vue"],
            output: { globals: { vue: "Vue" } },
        },
    },
});
