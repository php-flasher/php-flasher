---
layout: theme
permalink: /theme/flasher/
title: Flasher Theme
subtitle: The default notification system for PHPFlasher
description: The default notification theme for PHPFlasher with a clean design, colored borders, and accessible notifications for your web applications.
theme_name: theme.flasher
theme_name_short: flasher
theme_class: fl
icon: fa-duotone fa-bolt
color: purple
has_assets: false

visual_features:
  - Color-coded borders for quick identification
  - Progress indicator shows remaining display time
  - Responsive design works on all screen sizes

accessibility_features:
  - Semantic ARIA attributes for screen readers
  - Keyboard navigation support
  - RTL language support

css_variables: |
  :root {
    --fl-success: #10b981; /* Green */
    --fl-error: #ef4444;   /* Red */
    --fl-warning: #f59e0b; /* Orange */
    --fl-info: #3b82f6;    /* Blue */
  }

html_structure: |
  <div class="fl-flasher fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
      <div class="fl-content">
          <div class="fl-icon"></div>
          <div>
              <strong class="fl-title">Title text</strong>
              <span class="fl-message">Message text</span>
          </div>
          <button class="fl-close" aria-label="Close">×</button>
      </div>
      <span class="fl-progress-bar">
          <span class="fl-progress"></span>
      </span>
  </div>
---
