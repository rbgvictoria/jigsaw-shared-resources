// source/_shared/js/main.js

import hljs from 'highlight.js/lib/core';
import 'highlight.js/styles/github.css';

// Essential Languages Only
import php from 'highlight.js/lib/languages/php';
import javascript from 'highlight.js/lib/languages/javascript';
import typescript from 'highlight.js/lib/languages/typescript';
import json from 'highlight.js/lib/languages/json';
import bash from 'highlight.js/lib/languages/bash';
import sql from 'highlight.js/lib/languages/sql';
import xml from 'highlight.js/lib/languages/xml'; // for HTML
import turtle from './highlightjs/languages/turtle';

const languages = { php, javascript, typescript, json, bash, sql, turtle, html: xml };
Object.entries(languages).forEach(([name, lang]) => hljs.registerLanguage(name, lang));

window.hljs = hljs;

/**
 * SHARED UTILITIES
 */
export const highlightAll = () => {
    document.querySelectorAll('pre code:not(.hljs)').forEach((block) => {
        hljs.highlightElement(block);
    });
};

// Common Blade helpers
window.copyCode = function(targetId, btn) {
    const codeElement = document.getElementById(targetId);
    if (!codeElement) return;
    navigator.clipboard.writeText(codeElement.innerText.trim()).then(() => {
        btn.classList.add('text-emerald-600', 'dark:text-emerald-400');
        setTimeout(() => btn.classList.remove('text-emerald-600', 'dark:text-emerald-400'), 2000);
    });
};

window.toggleMobileMenu = function() {
    const menu = document.getElementById('mobile-menu');
    if (menu) {
        menu.classList.toggle('hidden');
        document.body.classList.toggle('overflow-hidden');
    }
};

// Auto-init Highlighting on load
document.addEventListener('DOMContentLoaded', () => {
    highlightAll();
    new MutationObserver(highlightAll).observe(document.body, { childList: true, subtree: true });
});