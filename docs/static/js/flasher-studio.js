// Current state management
const state = {
    type: "success",
    title: "",
    message: "Your changes have been saved successfully!",
    timeout: "",
    fps: "",
    position: "",
    direction: "",
    rtl: false,
    theme: "",
    closeButton: false,
    escapeHtml: true
};

// Update current time
function updateCurrentTime() {
    document.getElementById("current-time").textContent = "2025-03-11 07:38:23";
}

document.addEventListener("DOMContentLoaded", function() {
    // Initialize particles.js if available
    if (typeof particlesJS !== "undefined") {
        particlesJS("particles-js", {
            particles: {
                number: { value: 24, density: { enable: true, value_area: 800 } },
                color: { value: "#3b82f6" },
                opacity: { value: 0.1, random: true },
                size: { value: 2, random: true },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: "#4b5563",
                    opacity: 0.1,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 0.4,
                    direction: "none",
                    random: true,
                    straight: false,
                    out_mode: "out"
                }
            }
        });
    }

    // Initialize time with user-provided values
    document.getElementById("current-time").textContent = "2025-03-11 07:40:35";

    // Initialize type buttons
    document.querySelectorAll(".type-button").forEach(btn => {
        btn.addEventListener("click", () => {
            // Remove active class from all type buttons
            document.querySelectorAll(".type-button").forEach(b => b.classList.remove("active"));

            // Add active class to clicked button
            btn.classList.add("active");

            // Update state
            state.type = btn.dataset.type;

            // Update code display
            updateCodeDisplay();

            // Update status
            updateStatus(`Type changed to: ${state.type}`);
        });
    });

    // Input event listeners
    document.getElementById("title-input").addEventListener("input", (e) => {
        state.title = e.target.value.trim();
        updateCodeDisplay();
    });

    document.getElementById("message-input").addEventListener("input", (e) => {
        state.message = e.target.value;
        updateCodeDisplay();
    });

    // Select event listeners
    document.getElementById("position-select").addEventListener("change", (e) => {
        state.position = e.target.value;
        updateCodeDisplay();
    });

    document.getElementById("timeout-input").addEventListener("input", (e) => {
        state.timeout = e.target.value ? parseInt(e.target.value) : "";
        updateCodeDisplay();
    });

    document.getElementById("fps-input").addEventListener("input", (e) => {
        state.fps = e.target.value ? parseInt(e.target.value) : "";
        updateCodeDisplay();
    });

    document.getElementById("theme-select").addEventListener("change", (e) => {
        state.theme = e.target.value;
        updateCodeDisplay();
    });

    document.getElementById("direction-select").addEventListener("change", (e) => {
        state.direction = e.target.value;
        updateCodeDisplay();
    });

    // Checkbox event listeners
    document.getElementById("rtl-check").addEventListener("change", (e) => {
        state.rtl = e.target.checked;
        updateCodeDisplay();
    });

    document.getElementById("close-btn-check").addEventListener("change", (e) => {
        state.closeButton = e.target.checked;
        updateCodeDisplay();
    });

    document.getElementById("escape-html-check").addEventListener("change", (e) => {
        state.escapeHtml = e.target.checked;
        updateCodeDisplay();
    });

    // Show notification button - directly execute notifications using the showNotificationsForHandler function
    document.getElementById("show-notification-btn").addEventListener("click", () => {
        // Update status
        updateStatus("Launching notification...");

        // Get current options from state
        const options = {};

        // Only add options that have been explicitly set
        if (state.position) {
            options.position = state.position;
        }
        if (state.timeout !== "") {
            options.timeout = state.timeout;
        }
        if (state.fps !== "") {
            options.fps = state.fps;
        }
        if (state.direction) {
            options.direction = state.direction;
        }
        if (state.rtl) {
            options.rtl = state.rtl;
        }
        if (state.closeButton) {
            options.closeButton = state.closeButton;
        }
        if (!state.escapeHtml) {
            options.escapeHtml = state.escapeHtml;
        }

        // Determine the handler based on theme
        let handler = "flasher"; // Default handler

        if (state.theme) {
            handler = `theme.${state.theme}`;
        }

        // Try to use the direct notification function if it exists, otherwise use the stimulus controller
        if (typeof showNotificationsForHandler === "function") {
            // Create a custom notification based on user selections
            const factory = flasher.use(handler);

            // Configure flasher with options
            if (Object.keys(options).length > 0) {
                factory.options(options);
            }

            // Show the notification
            if (state.title) {
                factory[state.type](state.message, state.title);
            } else {
                factory[state.type](state.message);
            }
        } else {
            console.log(`Would show a ${state.type} notification with message "${state.message}"${state.title ? ` and title "${state.title}"` : ""} using handler "${handler}"`);
            console.log("Notification options:", options);
            console.log("Stimulus controller should be triggered");
        }
    });

    // Code tabs functionality
    document.getElementById("php-tab").addEventListener("click", () => {
        showCodeTab("php");
    });

    document.getElementById("js-tab").addEventListener("click", () => {
        showCodeTab("js");
    });

    function showCodeTab(tab) {
        // Hide all panels
        document.querySelectorAll(".code-panel").forEach(panel => {
            panel.classList.add("hidden");
        });

        // Show the selected panel
        document.getElementById(`${tab}-code-panel`).classList.remove("hidden");

        // Update tab styling
        document.getElementById("php-tab").classList.remove("text-blue-600", "border-b-2", "border-blue-500");
        document.getElementById("js-tab").classList.remove("text-blue-600", "border-b-2", "border-blue-500");
        document.getElementById("php-tab").classList.add("text-gray-600");
        document.getElementById("js-tab").classList.add("text-gray-600");

        document.getElementById(`${tab}-tab`).classList.remove("text-gray-600");
        document.getElementById(`${tab}-tab`).classList.add("text-blue-600", "border-b-2", "border-blue-500");

        // Update code for the selected tab
        updateCodeDisplay();
    }

    // Initialize
    updateCodeDisplay();
});

// Update the status indicator
function updateStatus(message) {
    const statusText = document.getElementById("status-text");
    statusText.textContent = message;

    // Temporarily change color
    statusText.classList.remove("text-emerald-600");
    statusText.classList.add("text-blue-600");

    // Add animation to the dot
    const dot = document.querySelector("#status-indicator div");
    dot.classList.remove("bg-emerald-500");
    dot.classList.add("bg-blue-500");

    // Reset after 2 seconds
    setTimeout(() => {
        statusText.classList.remove("text-blue-600");
        statusText.classList.add("text-emerald-600");
        statusText.textContent = "Ready";

        dot.classList.remove("bg-blue-500");
        dot.classList.add("bg-emerald-500");
    }, 2000);
}

// Update the code display with Prism syntax highlighting
function updateCodeDisplay() {
    const phpCodeDisplay = document.getElementById("php-code-display");
    const jsCodeDisplay = document.getElementById("js-code-display");

    // PHP Code
    let phpCode = `// Display a ${state.type} notification\n`;

    // Handle theme usage
    let useTheme = "";
    if (state.theme) {
        useTheme = `flash()->use('theme.${state.theme}')`;
    } else {
        useTheme = "flash()";
    }

    // Build options object
    let hasOptions = false;
    let phpOptionsCode = "";

    if (state.position || state.timeout !== "" || state.fps !== "" ||
        state.direction || state.rtl ||
        state.closeButton || !state.escapeHtml) {

        hasOptions = true;
        phpOptionsCode = "->options([\n";

        // Add each option that's been explicitly set
        const optionLines = [];
        if (state.position) {
            optionLines.push(`        'position' => '${state.position}'`);
        }
        if (state.timeout !== "") {
            optionLines.push(`        'timeout' => ${state.timeout}`);
        }
        if (state.fps !== "") {
            optionLines.push(`        'fps' => ${state.fps}`);
        }
        if (state.direction) {
            optionLines.push(`        'direction' => '${state.direction}'`);
        }
        if (state.rtl) {
            optionLines.push(`        'rtl' => true`);
        }
        if (state.closeButton) {
            optionLines.push(`        'closeButton' => true`);
        }
        if (!state.escapeHtml) {
            optionLines.push(`        'escapeHtml' => false`);
        }

        phpOptionsCode += optionLines.join(",\n") + "\n    ])";
    }

    // Build the full PHP code
    if (hasOptions) {
        phpCode += `${useTheme}${phpOptionsCode}\n`;

        if (state.title) {
            phpCode += `    ->${state.type}(\n        '${state.message}', \n        '${state.title}'\n    );`;
        } else {
            phpCode += `    ->${state.type}('${state.message}');`;
        }
    } else {
        // Simple call without options
        if (state.title) {
            phpCode += `${useTheme}->${state.type}('${state.message}', '${state.title}');`;
        } else {
            phpCode += `${useTheme}->${state.type}('${state.message}');`;
        }
    }

    // JavaScript Code
    let jsCode = `// Display a ${state.type} notification\n`;

    // Handle theme usage
    let jsUseTheme = "";
    if (state.theme) {
        jsUseTheme = `flasher.use('theme.${state.theme}')`;
    } else {
        jsUseTheme = "flasher";
    }

    // Build options object
    let jsOptionsCode = "";
    if (state.position || state.timeout !== "" || state.fps !== "" ||
        state.direction || state.rtl ||
        state.closeButton || !state.escapeHtml) {

        jsOptionsCode = ".options({\n";

        // Add each option that's been explicitly set
        const optionLines = [];
        if (state.position) {
            optionLines.push(`    position: '${state.position}'`);
        }
        if (state.timeout !== "") {
            optionLines.push(`    timeout: ${state.timeout}`);
        }
        if (state.fps !== "") {
            optionLines.push(`    fps: ${state.fps}`);
        }
        if (state.direction) {
            optionLines.push(`    direction: '${state.direction}'`);
        }
        if (state.rtl) {
            optionLines.push(`    rtl: true`);
        }
        if (state.closeButton) {
            optionLines.push(`    closeButton: true`);
        }
        if (!state.escapeHtml) {
            optionLines.push(`    escapeHtml: false`);
        }

        jsOptionsCode += optionLines.join(",\n") + "\n})";
    }

    // Build the full JavaScript code
    if (jsOptionsCode) {
        jsCode += `${jsUseTheme}${jsOptionsCode}\n`;

        if (state.title) {
            jsCode += `    .${state.type}('${state.message}', '${state.title}');`;
        } else {
            jsCode += `    .${state.type}('${state.message}');`;
        }
    } else {
        // Simple call without options
        if (state.title) {
            jsCode += `${jsUseTheme}.${state.type}('${state.message}', '${state.title}');`;
        } else {
            jsCode += `${jsUseTheme}.${state.type}('${state.message}');`;
        }
    }

    phpCodeDisplay.textContent = phpCode;
    jsCodeDisplay.textContent = jsCode;

    // Re-highlight with Prism
    if (typeof Prism !== "undefined") {
        Prism.highlightElement(phpCodeDisplay);
        Prism.highlightElement(jsCodeDisplay);
    }
}

// Add a custom implementation of showNotificationsForHandler if it doesn't exist
// This helps with preview in environments where the actual function isn't available
if (typeof showNotificationsForHandler === "undefined") {
    window.showNotificationsForHandler = function(handler, options = {}) {
        console.log(`Showing notifications for handler: ${handler}`);
        console.log("Options:", options);

        // Mock the notification display
        console.log("Showing mock notifications sequence...");
    };

    window.flasher = {
        use: function(handler) {
            console.log(`Using handler: ${handler}`);

            return {
                options: function(options) {
                    console.log(`Setting options for ${handler}:`, options);
                    return this;
                },
                success: function(message, title) {
                    console.log(`Success: ${message}${title ? ` (${title})` : ""}`);
                },
                error: function(message, title) {
                    console.log(`Error: ${message}${title ? ` (${title})` : ""}`);
                },
                info: function(message, title) {
                    console.log(`Info: ${message}${title ? ` (${title})` : ""}`);
                },
                warning: function(message, title) {
                    console.log(`Warning: ${message}${title ? ` (${title})` : ""}`);
                }
            };
        },
        options: function(options) {
            console.log("Setting global options:", options);
            return this;
        },
        success: function(message, title) {
            console.log(`Success: ${message}${title ? ` (${title})` : ""}`);
        },
        error: function(message, title) {
            console.log(`Error: ${message}${title ? ` (${title})` : ""}`);
        },
        info: function(message, title) {
            console.log(`Info: ${message}${title ? ` (${title})` : ""}`);
        },
        warning: function(message, title) {
            console.log(`Warning: ${message}${title ? ` (${title})` : ""}`);
        }
    };
}

// Helper function for the Stimulus controller integration
document.addEventListener("DOMContentLoaded", function() {
    // Implement a simple version of Stimulus controller behavior if Stimulus is not available
    const notificationButtons = document.querySelectorAll("[data-controller=\"notification-demo\"]");

    if (typeof Stimulus === "undefined") {
        notificationButtons.forEach(button => {
            if (!button.hasAttribute("data-stimulus-initialized")) {
                button.setAttribute("data-stimulus-initialized", "true");

                // Only wire up the click handler if not already using the event listener above
                if (button.id !== 'show-notification-btn') {
                    button.addEventListener('click', function() {
                        if (typeof showNotificationsForHandler === 'function') {
                            showNotificationsForHandler('notyf');
                        } else {
                            console.log('Would show notifications using Stimulus controller');
                        }
                    });
                }
            }
        });
    }
});
