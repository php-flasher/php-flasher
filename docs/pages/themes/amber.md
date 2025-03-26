---
layout: theme
permalink: /theme/amber/
title: Amber Theme
subtitle: Modern, elegant notification system
description: Transform your notifications with the elegant Amber theme for PHPFlasher. Featuring a modern, minimalist design with subtle animations and comprehensive dark mode support.
theme_name: theme.amber
theme_name_short: amber
theme_class: fl-amber
icon: fa-duotone fa-sun
color: amber
has_assets: true

visual_features:
  - Modern, minimalist design with clean aesthetics
  - Subtle animations and transitions for a refined feel
  - Visual progress bar indicating time before auto-dismiss
  - Automatic dark mode support with elegant color shifts

accessibility_features:
  - Proper ARIA roles for different notification types
  - Live regions with appropriate assertiveness levels
  - Respects user's reduced motion preferences
  - Fully keyboard accessible controls
  - High contrast text meeting WCAG 2.1 AA standards
  - Descriptive aria-labels for screen readers

css_variables: |
  :root {
    /* Base appearance */
    --amber-bg-light: #ffffff;          /* Light mode background */
    --amber-bg-dark: #1e293b;           /* Dark mode background */
    --amber-text-light: #4b5563;        /* Light mode text */
    --amber-text-dark: #f1f5f9;         /* Dark mode text */
    --amber-shadow: 0 5px 15px rgba(0, 0, 0, 0.08); /* Light mode shadow */
    --amber-border-radius: 0.4rem;      /* Border radius */

    /* Type-specific colors */
    --amber-success: #10b981;           /* Success color */
    --amber-info: #3b82f6;              /* Info color */
    --amber-warning: #f59e0b;           /* Warning color */
    --amber-error: #ef4444;             /* Error color */
    
    /* Dark mode shadows */
    --amber-shadow-dark: 0 5px 15px rgba(0, 0, 0, 0.25);
  }

html_structure: |
  <div class="fl-amber fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
      <div class="fl-content">
          <div class="fl-icon"></div>
          <div class="fl-text">
              <div class="fl-message">Message text</div>
          </div>
          <button class="fl-close" aria-label="Close [type] message">×</button>
      </div>
      <div class="fl-progress-bar">
          <div class="fl-progress"></div>
      </div>
  </div>
---
