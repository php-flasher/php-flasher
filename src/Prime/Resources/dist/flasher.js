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

    function addProgressBar(notification, { timeout, fps, progressBar }, callback) {
        if (timeout <= 0 || fps <= 0 || progressBar === false)
            return;
        let barConfig = typeof progressBar === 'object' ? progressBar : {};
        barConfig = Object.assign({ top: false, right: false, bottom: true, left: false }, barConfig);
        const totalTime = timeout;
        let elapsedTime = 0;
        const activeSides = ['top', 'right', 'bottom', 'left'].filter(side => barConfig[side]);
        const bars = [];
        let totalLength = 0;
        activeSides.forEach(side => {
            let barContainer = notification.querySelector(`.fl-progress-${side}`);
            if (!barContainer) {
                barContainer = document.createElement('div');
                barContainer.className = `fl-progress-${side}`;
                notification.appendChild(barContainer);
            }
            let bar = barContainer.querySelector('.fl-progress');
            if (!bar) {
                bar = document.createElement('div');
                bar.className = 'fl-progress';
                barContainer.appendChild(bar);
            }
            bars.push(bar);
            if (side === 'top' || side === 'bottom') {
                totalLength += notification.offsetWidth;
            }
            else {
                totalLength += notification.offsetHeight;
            }
        });
        const segmentDuration = totalTime / activeSides.length;
        let currentBarIndex = 0;
        let segmentElapsedTime = 0;
        const updateProgress = () => {
            elapsedTime += 1000 / fps;
            segmentElapsedTime += 1000 / fps;
            const currentSide = activeSides[currentBarIndex];
            const progressPercentage = Math.min(1, segmentElapsedTime / segmentDuration) * 100;
            if (currentSide === 'top' || currentSide === 'bottom') {
                bars[currentBarIndex].style.width = `${progressPercentage}%`;
            }
            else if (currentSide === 'right' || currentSide === 'left') {
                bars[currentBarIndex].style.height = `${progressPercentage}%`;
            }
            if (segmentElapsedTime >= segmentDuration) {
                segmentElapsedTime = 0;
                currentBarIndex++;
                if (currentBarIndex >= activeSides.length) {
                    currentBarIndex = 0;
                }
            }
            if (elapsedTime >= totalTime) {
                bars.forEach((bar, index) => {
                    const side = activeSides[index];
                    if (side === 'top' || side === 'bottom') {
                        bar.style.width = '100%';
                    }
                    else if (side === 'right' || side === 'left') {
                        bar.style.height = '100%';
                    }
                });
                clearInterval(intervalId);
                if (typeof callback === 'function') {
                    callback();
                }
            }
        };
        let intervalId = window.setInterval(updateProgress, 1000 / fps);
        notification.addEventListener('mouseover', () => clearInterval(intervalId));
        notification.addEventListener('mouseout', () => {
            if (elapsedTime < totalTime) {
                intervalId = window.setInterval(updateProgress, 1000 / fps);
            }
        });
    }

    class FlasherPlugin extends AbstractPlugin {
        constructor(theme) {
            super();
            this.options = {
                timeout: 5000,
                timeouts: {
                    error: 0,
                    warning: 0,
                },
                fps: 30,
                position: 'top-right',
                direction: 'top',
                rtl: false,
                style: {},
                progressBar: {
                    top: false,
                    right: false,
                    bottom: true,
                    left: false,
                },
            };
            this.theme = theme;
        }
        renderEnvelopes(envelopes) {
            const render = () => envelopes.forEach(envelope => {
                var _a, _b;
                const typeTimeout = (_a = this.options.timeouts[envelope.type]) !== null && _a !== void 0 ? _a : this.options.timeout;
                const options = Object.assign(Object.assign(Object.assign({}, this.options), envelope.options), { timeout: (_b = envelope.options.timeout) !== null && _b !== void 0 ? _b : typeTimeout });
                this.addToContainer(this.createContainer(options), envelope, options);
            });
            document.readyState === 'loading'
                ? document.addEventListener('DOMContentLoaded', render)
                : render();
        }
        renderOptions(options) {
            this.options = Object.assign(Object.assign({}, this.options), options);
        }
        createContainer(options) {
            let container = document.querySelector(`.fl-main-container[data-position="${options.position}"]`);
            if (!container) {
                container = document.createElement('div');
                container.className = 'fl-main-container';
                container.dataset.position = options.position;
                Object.entries(options.style).forEach(([key, value]) => container.style.setProperty(key, value));
                document.body.appendChild(container);
            }
            container.dataset.turboCache = 'false';
            return container;
        }
        addToContainer(container, envelope, options) {
            var _a;
            const notification = this.stringToHTML(this.theme.render(envelope));
            notification.classList.add('fl-container' + (options.rtl ? ' fl-rtl' : ''));
            options.direction === 'bottom' ? container.append(notification) : container.prepend(notification);
            requestAnimationFrame(() => notification.classList.add('fl-show'));
            (_a = notification.querySelector('.fl-close')) === null || _a === void 0 ? void 0 : _a.addEventListener('click', (event) => {
                event.stopPropagation();
                this.removeNotification(notification);
            });
            addProgressBar(notification, options, () => this.removeNotification(notification));
        }
        removeNotification(notification) {
            notification.classList.remove('fl-show');
            notification.ontransitionend = () => {
                var _a, _b;
                if (!((_a = notification.parentElement) === null || _a === void 0 ? void 0 : _a.hasChildNodes())) {
                    (_b = notification.parentElement) === null || _b === void 0 ? void 0 : _b.remove();
                }
                notification.remove();
            };
        }
        stringToHTML(str) {
            const template = document.createElement('template');
            template.innerHTML = str.trim();
            return template.content.firstElementChild;
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
                yield this.addAssets([
                    { urls: resolved.styles, nonce: resolved.context.csp_style_nonce, type: 'style' },
                    { urls: resolved.scripts, nonce: resolved.context.csp_script_nonce, type: 'script' },
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
        create(name) {
            name = this.resolvePluginAlias(name);
            this.resolvePlugin(name);
            const plugin = this.plugins.get(name);
            if (!plugin) {
                throw new Error(`Unable to resolve "${name}" plugin, did you forget to register it?`);
            }
            return plugin;
        }
        resolveResponse(response) {
            const resolved = Object.assign({ envelopes: [], options: {}, scripts: [], styles: [], context: {} }, response);
            Object.entries(resolved.options).forEach(([plugin, options]) => {
                resolved.options[plugin] = this.resolveOptions(options);
            });
            resolved.context.csp_style_nonce = resolved.context.csp_style_nonce || '';
            resolved.context.csp_script_nonce = resolved.context.csp_script_nonce || '';
            resolved.envelopes.forEach((envelope) => {
                envelope.metadata = envelope.metadata || {};
                envelope.metadata.plugin = this.resolvePluginAlias(envelope.metadata.plugin);
                this.addThemeStyles(resolved, envelope.metadata.plugin);
                envelope.options = this.resolveOptions(envelope.options);
                envelope.context = response.context;
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
        addAssets(assets) {
            return __awaiter(this, void 0, void 0, function* () {
                for (const { urls, nonce, type } of assets) {
                    yield Promise.all(urls.map(url => this.loadAsset(url, nonce, type)));
                }
            });
        }
        loadAsset(url, nonce, type) {
            return __awaiter(this, void 0, void 0, function* () {
                if (document.querySelector(`${type === 'style' ? 'link' : 'script'}[src="${url}"]`)) {
                    return;
                }
                const element = document.createElement(type === 'style' ? 'link' : 'script');
                if (type === 'style') {
                    element.rel = 'stylesheet';
                    element.href = url;
                }
                else {
                    element.type = 'text/javascript';
                    element.src = url;
                }
                if (nonce)
                    element.setAttribute('nonce', nonce);
                document.head.appendChild(element);
                return new Promise((resolve, reject) => {
                    element.onload = () => resolve();
                    element.onerror = () => reject(new Error(`Failed to load ${url}`));
                });
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

    const flasherTheme = {
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
                    <button class="fl-close">&times;</button>
                </div>
            </div>`;
        },
    };

    const flasher = new Flasher();
    flasher.addTheme('flasher', flasherTheme);
    window.flash = flasher;

    exports.AbstractPlugin = AbstractPlugin;
    exports.flasher = flasher;

}));
