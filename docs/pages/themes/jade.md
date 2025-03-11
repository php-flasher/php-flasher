---
layout: theme
permalink: /theme/jade/
title: Jade Theme
subtitle: Calm, minimalist notification system
description: Enhance your notifications with the calm, minimalist Jade theme for PHPFlasher. Featuring soft colors, rounded corners, and subtle animations for a soothing user experience.
theme_name: theme.jade
theme_name_short: jade
theme_class: fl-jade
icon: fa-leaf
color: green
has_assets: true

visual_features:
  - Soft, pastel colors with generous padding for a calm appearance
  - Rounded corners (1rem radius) creating a gentle, friendly feel
  - Refined entrance animation combining fade, scaling and movement
  - Clean design that emphasizes content without unnecessary elements

accessibility_features:
  - Type-specific ARIA roles for screen readers
  - Appropriate aria-live regions based on message importance
  - Reduced motion option for users with motion sensitivity
  - High contrast between background and text colors
  - Fully keyboard accessible close button with visual feedback
  - Descriptive aria-labels for interactive elements

css_variables: |
  :root {
    /* Base appearance */
    --jade-text-light: #5f6c7b;                /* Text color in light mode */
    --jade-text-dark: #e2e8f0;                 /* Text color in dark mode */
    --jade-border-radius: 1rem;                /* Corner roundness */
    
    /* Type-specific colors - Light mode */
    --jade-success-bg: #f0fdf4;                /* Success background */
    --jade-success-color: #16a34a;             /* Success text/accent */
    --jade-info-bg: #eff6ff;                   /* Info background */
    --jade-info-color: #3b82f6;                /* Info text/accent */
    --jade-warning-bg: #fffbeb;                /* Warning background */
    --jade-warning-color: #f59e0b;             /* Warning text/accent */
    --jade-error-bg: #fef2f2;                  /* Error background */
    --jade-error-color: #dc2626;               /* Error text/accent */
    
    /* Dark mode backgrounds */
    --jade-success-bg-dark: rgba(22, 163, 74, 0.15);  /* Dark mode success */
    --jade-info-bg-dark: rgba(59, 130, 246, 0.15);    /* Dark mode info */
    --jade-warning-bg-dark: rgba(245, 158, 11, 0.15); /* Dark mode warning */
    --jade-error-bg-dark: rgba(220, 38, 38, 0.15);    /* Dark mode error */
  }

html_structure: |
  <div class="fl-jade fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
      <div class="fl-content">
          <div class="fl-message">Message text</div>
          <button class="fl-close" aria-label="Close [type] message">×</button>
      </div>
      <div class="fl-progress-bar">
          <div class="fl-progress"></div>
      </div>
  </div>
---
