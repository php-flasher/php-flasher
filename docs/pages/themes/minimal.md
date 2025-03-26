---
layout: theme
permalink: /theme/minimal/
title: Minimal Theme
subtitle: Ultra-clean, distraction-free notification system
description: Enhance your application with ultra-clean, distraction-free notifications using the Minimal theme for PHPFlasher. Featuring a translucent design with subtle styling for unobtrusive messaging.
theme_name: theme.minimal
theme_name_short: minimal
theme_class: fl-minimal
icon: fa-duotone fa-circle-minus
color: gray
has_assets: true

visual_features:
  - Ultra-clean design with minimal visual elements
  - Subtle translucent background with frosted glass effect
  - Small colored dot to indicate notification type
  - Compact size and spacing for unobtrusive appearance
  - System fonts for optimal native readability

accessibility_features:
  - Type-specific ARIA roles for screen readers
  - Appropriate aria-live regions based on message importance
  - Reduced motion adaptation for users with motion sensitivity
  - Color indications that don't rely solely on color
  - System fonts that respect user's platform for improved readability
  - Fully keyboard accessible close button

css_variables: |
  :root {
    /* Base appearance */
    --minimal-bg-light: rgba(255, 255, 255, 0.8);  /* Light mode background */
    --minimal-bg-dark: rgba(25, 25, 25, 0.8);      /* Dark mode background */
    --minimal-text-light: #333333;                 /* Light mode text */
    --minimal-text-dark: #f5f5f5;                  /* Dark mode text */
    --minimal-border-radius: 6px;                  /* Corner radius */
    
    /* Type colors */
    --minimal-success: rgba(34, 197, 94, 0.9);     /* Success color */
    --minimal-info: rgba(14, 165, 233, 0.9);       /* Info color */
    --minimal-warning: rgba(245, 158, 11, 0.9);    /* Warning color */
    --minimal-error: rgba(239, 68, 68, 0.9);       /* Error color */
    
    /* Additional customization */
    --minimal-blur: 8px;                          /* Backdrop blur amount */
    --minimal-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); /* Shadow */
  }

html_structure: |
  <div class="fl-minimal fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
      <div class="fl-content">
          <div class="fl-dot"></div>
          <div class="fl-message">Message text</div>
          <button class="fl-close" aria-label="Close [type] message">×</button>
      </div>
      <div class="fl-progress-bar">
          <div class="fl-progress"></div>
      </div>
  </div>
---
