/**
 * @package PHPFlasher
 * @author Younes ENNAJI
 * @license MIT
 */
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
        let normalizedType;
        let normalizedMessage;
        let normalizedTitle;
        let normalizedOptions = {};
        if (typeof type === 'object') {
            normalizedOptions = Object.assign({}, type);
            normalizedType = normalizedOptions.type;
            normalizedMessage = normalizedOptions.message;
            normalizedTitle = normalizedOptions.title;
            delete normalizedOptions.type;
            delete normalizedOptions.message;
            delete normalizedOptions.title;
        }
        else if (typeof message === 'object') {
            normalizedOptions = Object.assign({}, message);
            normalizedType = type;
            normalizedMessage = normalizedOptions.message;
            normalizedTitle = normalizedOptions.title;
            delete normalizedOptions.message;
            delete normalizedOptions.title;
        }
        else {
            normalizedType = type;
            normalizedMessage = message;
            if (title === undefined || title === null) {
                normalizedTitle = undefined;
                normalizedOptions = options || {};
            }
            else if (typeof title === 'string') {
                normalizedTitle = title;
                normalizedOptions = options || {};
            }
            else if (typeof title === 'object') {
                normalizedOptions = Object.assign({}, title);
                if ('title' in normalizedOptions) {
                    normalizedTitle = normalizedOptions.title;
                    delete normalizedOptions.title;
                }
                else {
                    normalizedTitle = undefined;
                }
                if (options && typeof options === 'object') {
                    normalizedOptions = Object.assign(Object.assign({}, normalizedOptions), options);
                }
            }
        }
        if (!normalizedType) {
            throw new Error('Type is required for notifications');
        }
        if (normalizedMessage === undefined || normalizedMessage === null) {
            throw new Error('Message is required for notifications');
        }
        if (normalizedTitle === undefined || normalizedTitle === null) {
            normalizedTitle = normalizedType.charAt(0).toUpperCase() + normalizedType.slice(1);
        }
        const envelope = {
            type: normalizedType,
            message: normalizedMessage,
            title: normalizedTitle,
            options: normalizedOptions,
            metadata: {
                plugin: '',
            },
        };
        this.renderOptions({});
        this.renderEnvelopes([envelope]);
    }
}

class FlasherPlugin extends AbstractPlugin {
    constructor(theme) {
        super();
        this.options = {
            timeout: null,
            timeouts: {
                success: 10000,
                info: 10000,
                error: 10000,
                warning: 10000,
            },
            fps: 30,
            position: 'top-right',
            direction: 'top',
            rtl: false,
            style: {},
            escapeHtml: false,
        };
        if (!theme) {
            throw new Error('Theme is required');
        }
        if (typeof theme.render !== 'function') {
            throw new TypeError('Theme must have a render function');
        }
        this.theme = theme;
    }
    renderEnvelopes(envelopes) {
        if (!(envelopes === null || envelopes === void 0 ? void 0 : envelopes.length)) {
            return;
        }
        const render = () => {
            envelopes.forEach((envelope) => {
                var _a, _b, _c, _d;
                try {
                    const typeTimeout = (_b = (_a = this.options.timeout) !== null && _a !== void 0 ? _a : this.options.timeouts[envelope.type]) !== null && _b !== void 0 ? _b : 10000;
                    const mergedOptions = Object.assign(Object.assign(Object.assign({}, this.options), envelope.options), { timeout: this.normalizeTimeout((_c = envelope.options.timeout) !== null && _c !== void 0 ? _c : typeTimeout), escapeHtml: ((_d = envelope.options.escapeHtml) !== null && _d !== void 0 ? _d : this.options.escapeHtml) });
                    const container = this.createContainer(mergedOptions);
                    const containerOptions = {
                        direction: mergedOptions.direction,
                        timeout: Number(mergedOptions.timeout || 0),
                        fps: mergedOptions.fps,
                        rtl: mergedOptions.rtl,
                        escapeHtml: mergedOptions.escapeHtml,
                    };
                    this.addToContainer(container, envelope, containerOptions);
                }
                catch (error) {
                    console.error('PHPFlasher: Error rendering envelope', error, envelope);
                }
            });
        };
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', render);
        }
        else {
            render();
        }
    }
    renderOptions(options) {
        if (!options) {
            return;
        }
        this.options = Object.assign(Object.assign({}, this.options), options);
    }
    createContainer(options) {
        let container = document.querySelector(`.fl-wrapper[data-position="${options.position}"]`);
        if (!container) {
            container = document.createElement('div');
            container.className = 'fl-wrapper';
            container.dataset.position = options.position;
            Object.entries(options.style).forEach(([key, value]) => {
                if (value !== undefined && value !== null) {
                    container.style.setProperty(key, String(value));
                }
            });
            document.body.appendChild(container);
        }
        container.dataset.turboTemporary = '';
        return container;
    }
    addToContainer(container, envelope, options) {
        if (options.escapeHtml) {
            envelope.title = this.escapeHtml(envelope.title);
            envelope.message = this.escapeHtml(envelope.message);
        }
        const notification = this.stringToHTML(this.theme.render(envelope));
        notification.classList.add('fl-container');
        if (options.rtl) {
            notification.classList.add('fl-rtl');
        }
        if (options.direction === 'bottom') {
            container.append(notification);
        }
        else {
            container.prepend(notification);
        }
        requestAnimationFrame(() => notification.classList.add('fl-show'));
        const closeButton = notification.querySelector('.fl-close');
        if (closeButton) {
            closeButton.addEventListener('click', (event) => {
                event.stopPropagation();
                this.removeNotification(notification);
            });
        }
        if (options.timeout > 0) {
            this.addTimer(notification, options);
        }
        else {
            notification.classList.add('fl-sticky');
            const progressBarContainer = notification.querySelector('.fl-progress-bar');
            if (progressBarContainer) {
                const progressBar = document.createElement('span');
                progressBar.classList.add('fl-progress', 'fl-sticky-progress');
                progressBar.style.width = '100%';
                progressBarContainer.append(progressBar);
            }
        }
    }
    normalizeTimeout(timeout) {
        if (timeout === false || (typeof timeout === 'number' && timeout < 0)) {
            return 0;
        }
        if (timeout == null) {
            return 0;
        }
        return Number(timeout) || 0;
    }
    addTimer(notification, { timeout, fps }) {
        if (timeout <= 0) {
            return;
        }
        const lapse = 1000 / fps;
        let elapsed = 0;
        let intervalId;
        const updateTimer = () => {
            elapsed += lapse;
            const progressBarContainer = notification.querySelector('.fl-progress-bar');
            if (progressBarContainer) {
                let progressBar = progressBarContainer.querySelector('.fl-progress');
                if (!progressBar) {
                    progressBar = document.createElement('span');
                    progressBar.classList.add('fl-progress');
                    progressBarContainer.append(progressBar);
                }
                const percent = (1 - elapsed / timeout) * 100;
                progressBar.style.width = `${Math.max(0, percent)}%`;
            }
            if (elapsed >= timeout) {
                clearInterval(intervalId);
                this.removeNotification(notification);
            }
        };
        intervalId = window.setInterval(updateTimer, lapse);
        notification.addEventListener('mouseout', () => {
            clearInterval(intervalId);
            intervalId = window.setInterval(updateTimer, lapse);
        });
        notification.addEventListener('mouseover', () => clearInterval(intervalId));
    }
    removeNotification(notification) {
        if (!notification) {
            return;
        }
        notification.classList.remove('fl-show');
        notification.ontransitionend = () => {
            const parent = notification.parentElement;
            notification.remove();
            if (parent && !parent.hasChildNodes()) {
                parent.remove();
            }
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
        const htmlEscapes = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            '\'': '&#39;',
            '`': '&#96;',
            '=': '&#61;',
            '/': '&#47;',
        };
        return str.replace(/[&<>"'`=/]/g, (char) => htmlEscapes[char] || char);
    }
}

class Flasher extends AbstractPlugin {
    constructor() {
        super(...arguments);
        this.defaultPlugin = 'flasher';
        this.plugins = new Map();
        this.themes = new Map();
        this.loadedAssets = new Set();
    }
    render(response) {
        return __awaiter(this, void 0, void 0, function* () {
            const resolved = this.resolveResponse(response);
            try {
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
            }
            catch (error) {
                console.error('PHPFlasher: Error rendering notifications', error);
            }
        });
    }
    renderEnvelopes(envelopes) {
        if (!(envelopes === null || envelopes === void 0 ? void 0 : envelopes.length)) {
            return;
        }
        const groupedByPlugin = {};
        envelopes.forEach((envelope) => {
            const plugin = this.resolvePluginAlias(envelope.metadata.plugin);
            groupedByPlugin[plugin] = groupedByPlugin[plugin] || [];
            groupedByPlugin[plugin].push(envelope);
        });
        Object.entries(groupedByPlugin).forEach(([pluginName, pluginEnvelopes]) => {
            try {
                this.use(pluginName).renderEnvelopes(pluginEnvelopes);
            }
            catch (error) {
                console.error(`PHPFlasher: Error rendering envelopes for plugin "${pluginName}"`, error);
            }
        });
    }
    renderOptions(options) {
        if (!options) {
            return;
        }
        Object.entries(options).forEach(([plugin, option]) => {
            try {
                this.use(plugin).renderOptions(option);
            }
            catch (error) {
                console.error(`PHPFlasher: Error applying options for plugin "${plugin}"`, error);
            }
        });
    }
    addPlugin(name, plugin) {
        if (!name || !plugin) {
            throw new Error('Both plugin name and instance are required');
        }
        this.plugins.set(name, plugin);
    }
    addTheme(name, theme) {
        if (!name || !theme) {
            throw new Error('Both theme name and definition are required');
        }
        this.themes.set(name, theme);
    }
    use(name) {
        const resolvedName = this.resolvePluginAlias(name);
        this.resolvePlugin(resolvedName);
        const plugin = this.plugins.get(resolvedName);
        if (!plugin) {
            throw new Error(`Unable to resolve "${resolvedName}" plugin, did you forget to register it?`);
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
        if (!options) {
            return {};
        }
        const resolved = Object.assign({}, options);
        Object.entries(resolved).forEach(([key, value]) => {
            resolved[key] = this.resolveFunction(value);
        });
        return resolved;
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
            console.error('PHPFlasher: Error converting string to function:', e);
            return func;
        }
    }
    resolvePlugin(alias) {
        const factory = this.plugins.get(alias);
        if (factory || !alias.includes('theme.')) {
            return;
        }
        const themeName = alias.replace('theme.', '');
        const theme = this.themes.get(themeName);
        if (!theme) {
            return;
        }
        this.addPlugin(alias, new FlasherPlugin(theme));
    }
    resolvePluginAlias(alias) {
        alias = alias || this.defaultPlugin;
        return alias === 'flasher' ? 'theme.flasher' : alias;
    }
    addAssets(assets) {
        return __awaiter(this, void 0, void 0, function* () {
            try {
                const styleAssets = assets.filter((asset) => asset.type === 'style');
                const stylePromises = [];
                for (const { urls, nonce, type } of styleAssets) {
                    if (!(urls === null || urls === void 0 ? void 0 : urls.length)) {
                        continue;
                    }
                    for (const url of urls) {
                        if (!url || this.loadedAssets.has(url)) {
                            continue;
                        }
                        stylePromises.push(this.loadAsset(url, nonce, type));
                        this.loadedAssets.add(url);
                    }
                }
                yield Promise.all(stylePromises);
                const scriptAssets = assets.filter((asset) => asset.type === 'script');
                for (const { urls, nonce, type } of scriptAssets) {
                    if (!(urls === null || urls === void 0 ? void 0 : urls.length)) {
                        continue;
                    }
                    for (const url of urls) {
                        if (!url || this.loadedAssets.has(url)) {
                            continue;
                        }
                        yield this.loadAsset(url, nonce, type);
                        this.loadedAssets.add(url);
                    }
                }
            }
            catch (error) {
                console.error('PHPFlasher: Error loading assets', error);
            }
        });
    }
    loadAsset(url, nonce, type) {
        if (document.querySelector(`${type === 'style' ? 'link' : 'script'}[src="${url}"]`)) {
            return Promise.resolve();
        }
        return new Promise((resolve, reject) => {
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
            element.onload = () => resolve();
            element.onerror = () => reject(new Error(`Failed to load ${url}`));
            document.head.appendChild(element);
        });
    }
    addThemeStyles(response, plugin) {
        if (plugin !== 'flasher' && !plugin.includes('theme.')) {
            return;
        }
        const themeName = plugin.replace('theme.', '');
        const theme = this.themes.get(themeName);
        if (!(theme === null || theme === void 0 ? void 0 : theme.styles)) {
            return;
        }
        const themeStyles = Array.isArray(theme.styles) ? theme.styles : [theme.styles];
        response.styles = Array.from(new Set([...response.styles, ...themeStyles]));
    }
}

const flasherTheme = {
    render: (envelope) => {
        const { type, title, message } = envelope;
        const isAlert = type === 'error' || type === 'warning';
        const role = isAlert ? 'alert' : 'status';
        const ariaLive = isAlert ? 'assertive' : 'polite';
        const displayTitle = title || type.charAt(0).toUpperCase() + type.slice(1);
        return `
            <div class="fl-flasher fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-content">
                    <div class="fl-icon"></div>
                    <div>
                        <strong class="fl-title">${displayTitle}</strong>
                        <span class="fl-message">${message}</span>
                    </div>
                    <button class="fl-close" aria-label="Close ${type} message">&times;</button>
                </div>
                <span class="fl-progress-bar">
                    <span class="fl-progress"></span>
                </span>
            </div>`;
    },
};

const flasher = new Flasher();
flasher.addTheme('flasher', flasherTheme);
if (typeof window !== 'undefined') {
    window.flasher = flasher;
}

export { flasher as default };
