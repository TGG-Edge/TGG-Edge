import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import fs from "fs";
import path from "path";

// 1. Create a function that automatically finds all CSS files in your "pages" folder
function getPageCssFiles() {
    const cssDir = path.resolve(__dirname, "resources/css/pages");

    // If the folder doesn't exist yet, return an empty array
    if (!fs.existsSync(cssDir)) return [];

    // Read the folder, find .css files, and format them for Vite
    return fs
        .readdirSync(cssDir)
        .filter((file) => file.endsWith(".css"))
        .map((file) => `resources/css/pages/${file}`);
}

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",

                ...getPageCssFiles(),
            ],
            refresh: true,
        }),
    ],
});
