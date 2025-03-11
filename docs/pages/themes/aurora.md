---
layout: theme
permalink: /theme/aurora/
title: Aurora Theme
subtitle: Elegant glass-like notification system
description: Add elegant glass-like notifications to your application with the Aurora theme for PHPFlasher. Featuring translucent backgrounds, subtle gradients, and modern backdrop blur effects.
theme_name: theme.aurora
theme_name_short: aurora
theme_class: fl-aurora
icon: fa-sparkles
color: blue
has_assets: true

visual_features:
  - Glass-like appearance with translucent backgrounds
  - Subtle gradient overlays for each notification type
  - Modern backdrop blur effect for a frosted glass look
  - Elegant animation combining fade, translation and scale

accessibility_features:
  - Type-specific ARIA roles for screen readers
  - Appropriate aria-live regions based on message importance
  - Reduced motion adaptation for users with motion sensitivity
  - High contrast maintained despite translucent backgrounds
  - Fully keyboard accessible controls

css_variables: |
  :root {
    /* Base appearance */
    --aurora-bg-light: rgba(255, 255, 255, 0.95);  /* Light background */
    --aurora-bg-dark: rgba(20, 20, 28, 0.92);      /* Dark background */
    --aurora-text-light: #1e293b;                  /* Light mode text */
    --aurora-text-dark: #f8fafc;                   /* Dark mode text */
    --aurora-border-radius: 16px;                  /* Corner radius */
    --aurora-blur: 15px;                           /* Blur amount */
    
    /* Type-specific colors */
    --aurora-success: #10b981;                     /* Success color */
    --aurora-info: #3b82f6;                        /* Info color */
    --aurora-warning: #f59e0b;                     /* Warning color */
    --aurora-error: #ef4444;                       /* Error color */
    
    /* Gradient colors */
    --aurora-success-gradient: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(16, 185, 129, 0.2) 100%);
    --aurora-info-gradient: linear-gradient(135deg, rgba(59, 130, 246, 0.08) 0%, rgba(59, 130, 246, 0.2) 100%);
    --aurora-warning-gradient: linear-gradient(135deg, rgba(245, 158, 11, 0.08) 0%, rgba(245, 158, 11, 0.2) 100%);
    --aurora-error-gradient: linear-gradient(135deg, rgba(239, 68, 68, 0.08) 0%, rgba(239, 68, 68, 0.2) 100%);
  }

html_structure: |
  <div class="fl-aurora fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
      <div class="fl-content">
          <div class="fl-message">Message text</div>
          <button class="fl-close" aria-label="Close [type] message">×</button>
      </div>
      <div class="fl-progress-bar">
          <div class="fl-progress"></div>
      </div>
  </div>
---
