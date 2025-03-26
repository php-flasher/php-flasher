---
layout: theme
permalink: /theme/crystal/
title: Crystal Theme
subtitle: Clean, monochromatic notification system
description: Enhance your notifications with the elegant Crystal theme for PHPFlasher. Featuring a clean, monochromatic design with colored text and subtle animation effects.
theme_name: theme.crystal
theme_name_short: crystal
theme_class: fl-crystal
icon: fa-duotone fa-diamond
color: indigo
has_assets: true

visual_features:
  - Monochromatic design with type-specific colored text
  - Subtle entrance animation with smooth slide-in and fade effects
  - Gentle pulsing shadow on hover creates a "breathing" effect
  - Clean, minimalist interface focused on content clarity

accessibility_features:
  - Type-appropriate ARIA roles for screen readers
  - Optimized aria-live regions based on message importance
  - Reduced motion adaptation for motion-sensitive users
  - High contrast text for optimal readability
  - Fully keyboard accessible with visual feedback
  - Descriptive aria-labels for interactive elements

css_variables: |
  :root {
    /* Base appearance */
    --crystal-bg-light: #ffffff;                  /* Light mode background */
    --crystal-bg-dark: rgba(30, 30, 30, 0.95);    /* Dark mode background */
    --crystal-text-light: #2c3e50;                /* Light mode text */
    --crystal-text-dark: rgba(255, 255, 255, 0.95); /* Dark mode text */
    --crystal-shadow: rgba(0, 0, 0, 0.08);        /* Light mode shadow */
    --crystal-shadow-dark: rgba(0, 0, 0, 0.25);   /* Dark mode shadow */
    
    /* Type colors (uses default PHPFlasher colors) */
    --fl-success: #10b981;                        /* Success color */
    --fl-info: #3b82f6;                           /* Info color */
    --fl-warning: #f59e0b;                        /* Warning color */
    --fl-error: #ef4444;                          /* Error color */
  }

html_structure: |
  <div class="fl-crystal fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
      <div class="fl-content">
          <div class="fl-text">
              <p class="fl-message">Message text</p>
          </div>
          <button class="fl-close" aria-label="Close [type] message">×</button>
      </div>
      <div class="fl-progress-bar">
          <div class="fl-progress"></div>
      </div>
  </div>
---
