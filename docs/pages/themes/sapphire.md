---
layout: theme
permalink: /theme/sapphire/
title: Sapphire Theme
subtitle: Modern, glassmorphic notification system
description: Add modern, glassmorphic notifications to your application with the Sapphire theme for PHPFlasher. Featuring a blurred backdrop effect, minimal interface, and subtle animations.
theme_name: theme.sapphire
theme_name_short: sapphire
theme_class: fl-sapphire
icon: fa-gem
color: blue
has_assets: true

visual_features:
  - Frosted glass effect with semi-transparent backgrounds and backdrop blur
  - Ultra-minimal interface without close buttons or icons
  - Distinctive bounce animation for a more dynamic entrance
  - Type-specific colored backgrounds with consistent visual language
  - Progress bar showing time until auto-dismissal

accessibility_features:
  - Type-specific ARIA roles for screen readers
  - Appropriate aria-live regions based on message importance
  - Reduced motion option for users with motion sensitivity
  - High contrast between text and all background colors
  - Complete RTL language support
  - Auto-dismissal with visual progress indicator

css_variables: |
  :root {
    /* Base appearance */
    --sapphire-bg-base: rgba(30, 30, 30, 0.9);    /* Base background color */
    --sapphire-text: #f0f0f0;                     /* Text color */
    --sapphire-shadow: rgba(0, 0, 0, 0.15);       /* Shadow color */
    --sapphire-border-radius: 12px;               /* Corner roundness */
    --sapphire-blur: 12px;                        /* Backdrop blur amount */
    
    /* Progress bar colors */
    --sapphire-progress-bg: rgba(255, 255, 255, 0.2);  /* Progress background */
    --sapphire-progress-fill: rgba(255, 255, 255, 0.9); /* Progress fill */
    
    /* Notification type colors */
    --sapphire-success: rgba(16, 185, 129, 0.95); /* Success color */
    --sapphire-error: rgba(239, 68, 68, 0.95);    /* Error color */
    --sapphire-warning: rgba(245, 158, 11, 0.95); /* Warning color */
    --sapphire-info: rgba(59, 130, 246, 0.95);    /* Info color */
  }

html_structure: |
  <div class="fl-sapphire fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
      <div class="fl-content">
          <span class="fl-message">Message text</span>
      </div>
      <div class="fl-progress-bar">
          <div class="fl-progress"></div>
      </div>
  </div>
---
