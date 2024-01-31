(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports) :
    typeof define === 'function' && define.amd ? define(['exports'], factory) :
    (global = typeof globalThis !== 'undefined' ? globalThis : global || self, factory(global.flasher = {}));
})(this, (function (exports) { 'use strict';

    /******************************************************************************
    Copyright (c) Microsoft Corporation.

    Permission to use, copy, modify, and/or distribute this software for any
    purpose with or without fee is hereby granted.

    THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH
    REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY
    AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT,
    INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM
    LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR
    OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR
    PERFORMANCE OF THIS SOFTWARE.
    ***************************************************************************** */
    /* global Reflect, Promise, SuppressedError, Symbol */


    function __awaiter(thisArg, _arguments, P, generator) {
        function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
        return new (P || (P = Promise))(function (resolve, reject) {
            function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
            function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
            function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
            step((generator = generator.apply(thisArg, _arguments || [])).next());
        });
    }

    typeof SuppressedError === "function" ? SuppressedError : function (error, suppressed, message) {
        var e = new Error(message);
        return e.name = "SuppressedError", e.error = error, e.suppressed = suppressed, e;
    };

    class AbstractPlugin {
        success(message, title, options) {
            this.flash('success', message, title, options);
        }
        error(message, title, options) {
            this.flash('error', message, title, options);
        }
        info(message, title, options) {
            this.flash('info', message, title, options);
        }
        warning(message, title, options) {
            this.flash('warning', message, title, options);
        }
        flash(type, message, title, options) {
            const envelope = {
                type,
                message,
                title: title || type,
                options: options || {},
                metadata: {
                    plugin: '',
                },
            };
            this.renderOptions(options || {});
            this.renderEnvelopes([envelope]);
        }
    }

    class FlasherPlugin extends AbstractPlugin {
        constructor(theme) {
            super();
            this.options = {
                timeout: 5000,
                fps: 30,
                position: 'top-right',
                direction: 'top',
                rtl: false,
                style: {},
                darkMode: 'media',
            };
            this.theme = theme;
        }
        renderEnvelopes(envelopes) {
            const onContainerReady = (envelopes) => {
                envelopes.forEach((envelope) => {
                    const options = Object.assign(Object.assign({}, this.options), envelope.options);
                    const container = this.createContainer(options);
                    this.addToContainer(container, envelope, options);
                });
            };
            if (['interactive', 'complete'].includes(document.readyState)) {
                onContainerReady(envelopes);
            }
            else {
                document.addEventListener('DOMContentLoaded', () => onContainerReady(envelopes));
            }
        }
        renderOptions(options) {
            this.options = Object.assign(Object.assign({}, this.options), options);
            this.applyDarkMode();
        }
        createContainer(options) {
            let container = document.querySelector(`.fl-main-container[data-position="${options.position}"]`);
            if (container) {
                container.dataset.turboCache = 'false';
                return container;
            }
            container = document.createElement('div');
            container.classList.add('fl-main-container');
            container.dataset.position = options.position;
            container.dataset.turboCache = 'false';
            Object.keys(options.style).forEach((key) => {
                container.style.setProperty(key, options.style[key]);
            });
            document.body.append(container);
            return container;
        }
        addToContainer(container, envelope, options) {
            const template = this.stringToHTML(this.theme.render(envelope));
            template.classList.add('fl-container');
            this.appendNotification(container, template, options);
            this.renderProgressBar(template, options);
            this.handleClick(template);
        }
        appendNotification(container, template, options) {
            if (options.direction === 'bottom') {
                container.append(template);
            }
            else {
                container.prepend(template);
            }
            if (options.rtl) {
                template.classList.add('fl-rtl');
            }
            requestAnimationFrame(() => template.classList.add('fl-show'));
        }
        removeNotification(template) {
            const container = template.parentElement;
            template.classList.remove('fl-show');
            template.addEventListener('transitionend', () => {
                template.remove();
                if (!container.hasChildNodes()) {
                    container.remove();
                }
            });
        }
        handleClick(template) {
            template.addEventListener('click', () => this.removeNotification(template));
        }
        renderProgressBar(template, { timeout, fps }) {
            var _a;
            if (!timeout || timeout <= 0) {
                return;
            }
            const progressBar = document.createElement('span');
            progressBar.classList.add('fl-progress');
            (_a = template.querySelector('.fl-progress-bar')) === null || _a === void 0 ? void 0 : _a.append(progressBar);
            const increment = 100 / (timeout / (1000 / fps));
            let width = 0;
            const showProgress = () => {
                width += increment;
                progressBar.style.width = `${width}%`;
                if (width >= 100) {
                    clearInterval(interval);
                    this.removeNotification(template);
                }
            };
            let interval;
            const startProgress = () => {
                interval = window.setInterval(showProgress, 1000 / fps);
            };
            const stopProgress = () => {
                clearInterval(interval);
            };
            template.addEventListener('mouseover', stopProgress);
            template.addEventListener('mouseout', startProgress);
            startProgress();
        }
        applyDarkMode() {
            const [mode, className = 'dark'] = [].concat(this.options.darkMode);
            const shouldApplyDarkMode = (mode === 'media' &&
                window.matchMedia &&
                window.matchMedia('(prefers-color-scheme: dark)').matches) ||
                (mode === 'class' && document.body.classList.contains(className));
            document.body.classList.toggle('fl-dark', shouldApplyDarkMode);
        }
        stringToHTML(str) {
            const dom = document.createElement('div');
            dom.innerHTML = str.trim();
            return dom.firstElementChild;
        }
    }

    class Flasher extends AbstractPlugin {
        constructor() {
            super(...arguments);
            this.defaultPlugin = 'flasher';
            this.plugins = new Map();
            this.themes = new Map();
        }
        render(response) {
            return __awaiter(this, void 0, void 0, function* () {
                const resolved = this.resolveResponse(response);
                yield Promise.all([
                    this.addStyles(resolved.styles),
                    this.addScripts(resolved.scripts),
                ]);
                this.renderOptions(resolved.options);
                this.renderEnvelopes(resolved.envelopes);
            });
        }
        renderEnvelopes(envelopes) {
            const map = {};
            envelopes.forEach((envelope) => {
                const plugin = this.resolvePluginAlias(envelope.metadata.plugin);
                map[plugin] = map[plugin] || [];
                map[plugin].push(envelope);
            });
            Object.entries(map).forEach(([plugin, envelopes]) => {
                this.create(plugin).renderEnvelopes(envelopes);
            });
        }
        renderOptions(options) {
            Object.entries(options).forEach(([plugin, option]) => {
                this.create(plugin).renderOptions(option);
            });
        }
        addPlugin(name, plugin) {
            this.plugins.set(name, plugin);
        }
        addTheme(name, theme) {
            this.themes.set(name, theme);
        }
        setDefault(name) {
            this.defaultPlugin = name;
            return this;
        }
        create(name) {
            name = this.resolvePluginAlias(name);
            this.resolvePlugin(name);
            const plugin = this.plugins.get(name);
            if (!plugin) {
                throw new Error(`Unable to resolve "${name}" plugin, did you forget to register it?`);
            }
            return plugin;
        }
        addStyles(urls) {
            return __awaiter(this, void 0, void 0, function* () {
                yield this.addAssets(urls, 'link', 'href', 'stylesheet');
            });
        }
        addScripts(urls) {
            return __awaiter(this, void 0, void 0, function* () {
                yield this.addAssets(urls, 'script', 'src', 'text/javascript');
            });
        }
        resolveResponse(response) {
            const resolved = Object.assign({ envelopes: [], options: {}, scripts: [], styles: [], context: {} }, response);
            Object.entries(resolved.options).forEach(([plugin, options]) => {
                resolved.options[plugin] = this.resolveOptions(options);
            });
            resolved.envelopes.forEach((envelope) => {
                envelope.metadata = envelope.metadata || {};
                envelope.metadata.plugin = this.resolvePluginAlias(envelope.metadata.plugin);
                this.addThemeStyles(resolved, envelope.metadata.plugin);
                envelope.options = this.resolveOptions(envelope.options);
            });
            return resolved;
        }
        resolveOptions(options) {
            Object.entries(options).forEach(([key, value]) => {
                options[key] = this.resolveFunction(value);
            });
            return options;
        }
        resolveFunction(func) {
            var _a, _b;
            if (typeof func !== 'string') {
                return func;
            }
            const match = func.match(/^function(?:.+)?(?:\s+)?\((.+)?\)(?:\s+|\n+)?{(?:\s+|\n+)?((?:.|\n)+)}$/m);
            if (!match) {
                return func;
            }
            const args = (_b = (_a = match[1]) === null || _a === void 0 ? void 0 : _a.split(',').map((arg) => arg.trim())) !== null && _b !== void 0 ? _b : [];
            const body = match[2];
            return new Function(...args, body);
        }
        resolvePlugin(alias) {
            const factory = this.plugins.get(alias);
            if (factory || !alias.includes('theme.')) {
                return;
            }
            const view = this.themes.get(alias.replace('theme.', ''));
            if (!view) {
                return;
            }
            this.addPlugin(alias, new FlasherPlugin(view));
        }
        resolvePluginAlias(alias) {
            alias = alias || this.defaultPlugin;
            return 'flasher' === alias ? 'theme.flasher' : alias;
        }
        addAssets(urls, tagName, attrName, attrValue) {
            return __awaiter(this, void 0, void 0, function* () {
                const assetsPromise = urls.map((url) => {
                    return new Promise((resolve) => {
                        if (document.querySelector(`${tagName}[${attrName}="${url}"]`) !== null) {
                            resolve();
                            return;
                        }
                        const tag = document.createElement(tagName);
                        tag[attrName] = url;
                        if (tagName === 'link') {
                            tag.rel = attrValue;
                        }
                        else if (tagName === 'script') {
                            tag.type = attrValue;
                        }
                        tag.onload = () => resolve();
                        document.head.appendChild(tag);
                    });
                });
                yield Promise.all(assetsPromise);
            });
        }
        addThemeStyles(response, plugin) {
            var _a;
            if ('flasher' !== plugin && !plugin.includes('theme.')) {
                return;
            }
            plugin = plugin.replace('theme.', '');
            const styles = ((_a = this.themes.get(plugin)) === null || _a === void 0 ? void 0 : _a.styles) || [];
            response.styles = Array.from(new Set([...response.styles, ...styles]));
        }
    }

    const theme = {
        render: (envelope) => {
            const { type, title, message } = envelope;
            return `
      <div class="fl-flasher fl-${type}">
        <div class="fl-content">
          <div class="fl-icon"></div>
          <div>
            <strong class="fl-title">${title}</strong>
            <span class="fl-message">${message}</span>
          </div>
        </div>
        <span class="fl-progress-bar"></span>
      </div>`;
        },
    };

    const flasher = new Flasher();
    flasher.addTheme('flasher', theme);
    window.flash = flasher;

    exports.AbstractPlugin = AbstractPlugin;
    exports.flasher = flasher;

}));
//# sourceMappingURL=flasher.js.map
