function __awaiter(thisArg, _arguments, P, generator) {
  function adopt(value) {
    return value instanceof P ? value : new P(function (resolve) {
      resolve(value);
    });
  }
  return new (P || (P = Promise))(function (resolve, reject) {
    function fulfilled(value) {
      try {
        step(generator.next(value));
      } catch (e) {
        reject(e);
      }
    }
    function rejected(value) {
      try {
        step(generator["throw"](value));
      } catch (e) {
        reject(e);
      }
    }
    function step(result) {
      result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected);
    }
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
        if (typeof type === 'object') {
            options = type;
            type = options.type;
            message = options.message;
            title = options.title;
        }
        else if (typeof message === 'object') {
            options = message;
            message = options.message;
            title = options.title;
        }
        else if (typeof title === 'object') {
            options = title;
            title = options.title;
        }
        if (undefined === message) {
            throw new Error('message option is required');
        }
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
            timeout: null,
            timeouts: {
                success: 5000,
                info: 5000,
                error: 5000,
                warning: 5000,
            },
            fps: 30,
            position: 'top-right',
            direction: 'top',
            rtl: false,
            style: {},
            escapeHtml: false,
        };
        this.theme = theme;
    }
    renderEnvelopes(envelopes) {
        const render = () => envelopes.forEach((envelope) => {
            var _a, _b, _c, _d;
            const typeTimeout = (_b = (_a = this.options.timeout) !== null && _a !== void 0 ? _a : this.options.timeouts[envelope.type]) !== null && _b !== void 0 ? _b : 5000;
            const options = Object.assign(Object.assign(Object.assign({}, this.options), envelope.options), { timeout: (_c = envelope.options.timeout) !== null && _c !== void 0 ? _c : typeTimeout, escapeHtml: ((_d = envelope.options.escapeHtml) !== null && _d !== void 0 ? _d : this.options.escapeHtml) });
            this.addToContainer(this.createContainer(options), envelope, options);
        });
        document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', render) : render();
    }
    renderOptions(options) {
        this.options = Object.assign(Object.assign({}, this.options), options);
    }
    createContainer(options) {
        let container = document.querySelector(`.fl-wrapper[data-position="${options.position}"]`);
        if (!container) {
            container = document.createElement('div');
            container.className = 'fl-wrapper';
            container.dataset.position = options.position;
            Object.entries(options.style).forEach(([key, value]) => container.style.setProperty(key, value));
            document.body.appendChild(container);
        }
        container.dataset.turboTemporary = '';
        return container;
    }
    addToContainer(container, envelope, options) {
        var _a;
        if (options.escapeHtml) {
            envelope.title = this.escapeHtml(envelope.title);
            envelope.message = this.escapeHtml(envelope.message);
        }
        const notification = this.stringToHTML(this.theme.render(envelope));
        notification.classList.add(...`fl-container${options.rtl ? ' fl-rtl' : ''}`.split(' '));
        options.direction === 'bottom' ? container.append(notification) : container.prepend(notification);
        requestAnimationFrame(() => notification.classList.add('fl-show'));
        (_a = notification.querySelector('.fl-close')) === null || _a === void 0 ? void 0 : _a.addEventListener('click', (event) => {
            event.stopPropagation();
            this.removeNotification(notification);
        });
        this.addProgressBar(notification, options);
    }
    addProgressBar(notification, { timeout, fps }) {
        if (timeout <= 0 || fps <= 0) {
            return;
        }
        const progressBarContainer = notification.querySelector('.fl-progress-bar');
        if (!progressBarContainer) {
            return;
        }
        const progressBar = document.createElement('span');
        progressBar.classList.add('fl-progress');
        progressBarContainer.append(progressBar);
        const lapse = 1000 / fps;
        let width = 0;
        const updateProgress = () => {
            width += 1;
            const percent = (1 - lapse * (width / timeout)) * 100;
            progressBar.style.width = `${percent}%`;
            if (percent <= 0) {
                clearInterval(intervalId);
                this.removeNotification(notification);
            }
        };
        let intervalId = window.setInterval(updateProgress, lapse);
        notification.addEventListener('mouseout', () => intervalId = window.setInterval(updateProgress, lapse));
        notification.addEventListener('mouseover', () => clearInterval(intervalId));
    }
    removeNotification(notification) {
        notification.classList.remove('fl-show');
        notification.ontransitionend = () => {
            var _a, _b;
            !((_a = notification.parentElement) === null || _a === void 0 ? void 0 : _a.hasChildNodes()) && ((_b = notification.parentElement) === null || _b === void 0 ? void 0 : _b.remove());
            notification.remove();
        };
    }
    stringToHTML(str) {
        const template = document.createElement('template');
        template.innerHTML = str.trim();
        return template.content.firstElementChild;
    }
    escapeHtml(str) {
        if (str == null) {
            return '';
        }
        return str.replace(/[&<>"'`=\/]/g, (char) => {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                '\'': '&#39;',
                '`': '&#96;',
                '=': '&#61;',
                '/': '&#47;',
            }[char];
        });
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
                {
                    urls: resolved.styles,
                    nonce: resolved.context.csp_style_nonce,
                    type: 'style',
                },
                {
                    urls: resolved.scripts,
                    nonce: resolved.context.csp_script_nonce,
                    type: 'script',
                },
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
            this.use(plugin).renderEnvelopes(envelopes);
        });
    }
    renderOptions(options) {
        Object.entries(options).forEach(([plugin, option]) => {
            this.use(plugin).renderOptions(option);
        });
    }
    addPlugin(name, plugin) {
        this.plugins.set(name, plugin);
    }
    addTheme(name, theme) {
        this.themes.set(name, theme);
    }
    use(name) {
        name = this.resolvePluginAlias(name);
        this.resolvePlugin(name);
        const plugin = this.plugins.get(name);
        if (!plugin) {
            throw new Error(`Unable to resolve "${name}" plugin, did you forget to register it?`);
        }
        return plugin;
    }
    create(name) {
        return this.use(name);
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
        const functionRegex = /^function\s*(\w*)\s*\(([^)]*)\)\s*\{([\s\S]*)\}$/;
        const arrowFunctionRegex = /^\s*(\(([^)]*)\)|[^=]+)\s*=>\s*([\s\S]+)$/;
        const match = func.match(functionRegex) || func.match(arrowFunctionRegex);
        if (!match) {
            return func;
        }
        const args = (_b = (_a = match[2]) === null || _a === void 0 ? void 0 : _a.split(',').map((arg) => arg.trim())) !== null && _b !== void 0 ? _b : [];
        let body = match[3].trim();
        if (!body.startsWith('{')) {
            body = `{ return ${body}; }`;
        }
        try {
            return new Function(...args, body);
        }
        catch (e) {
            console.error('Error converting string to function:', e);
            return func;
        }
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
        return alias === 'flasher' ? 'theme.flasher' : alias;
    }
    addAssets(assets) {
        return __awaiter(this, void 0, void 0, function* () {
            for (const { urls, nonce, type } of assets) {
                for (const url of urls) {
                    yield this.loadAsset(url, nonce, type);
                }
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
            if (nonce) {
                element.setAttribute('nonce', nonce);
            }
            document.head.appendChild(element);
            return new Promise((resolve, reject) => {
                element.onload = () => resolve();
                element.onerror = () => reject(new Error(`Failed to load ${url}`));
            });
        });
    }
    addThemeStyles(response, plugin) {
        var _a;
        if (plugin !== 'flasher' && !plugin.includes('theme.')) {
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
        const isAlert = type === 'error' || type === 'warning';
        const role = isAlert ? 'alert' : 'status';
        const ariaLive = isAlert ? 'assertive' : 'polite';
        return `
            <div class="fl-flasher fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-content">
                    <div class="fl-icon"></div>
                    <div>
                        <strong class="fl-title">${title}</strong>
                        <span class="fl-message">${message}</span>
                    </div>
                    <button class="fl-close" aria-label="Close ${type} message">&times;</button>
                </div>
                <span class="fl-progress-bar"></span>
            </div>`;
    },
};

const flasher = new Flasher();
flasher.addTheme('flasher', flasherTheme);

export { flasher as default };
