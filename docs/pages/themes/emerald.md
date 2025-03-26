---
layout: theme
permalink: /theme/emerald/
title: Emerald Theme
subtitle: Elegant glass-like notifications with bounce effect
description: Enhance your notifications with the elegant Emerald theme for PHPFlasher. Featuring a glass-like appearance with bounce animation and minimalist design for a modern, polished user experience.
theme_name: theme.emerald
theme_name_short: emerald
theme_class: fl-emerald
icon: fa-duotone fa-gem
color: emerald
has_assets: true

visual_features:
  - Distinctive bounce animation for eye-catching entrance
  - Glass-like translucent background with blur effect
  - Minimalist design focusing on content clarity
  - Colored text indicators instead of backgrounds for elegance

accessibility_features:
  - Type-specific ARIA roles for screen readers
  - Appropriate aria-live regions based on message importance
  - Reduced motion option for users with motion sensitivity
  - Relative text sizing that respects user preferences
  - Fully keyboard accessible controls with descriptive labels

css_variables: |
  :root {
    /* Base colors */
    --emerald-bg-light: rgba(255, 255, 255, 0.9);  /* Light background */
    --emerald-bg-dark: rgba(30, 30, 30, 0.9);      /* Dark background */
    --emerald-text-light: #333333;                 /* Light mode text */
    --emerald-text-dark: rgba(255, 255, 255, 0.9); /* Dark mode text */
    --emerald-shadow: rgba(0, 0, 0, 0.1);          /* Shadow color */
    --emerald-blur: 8px;                           /* Blur amount */
    
    /* Type colors */
    --emerald-success: #16a085;                    /* Success color */
    --emerald-error: #e74c3c;                      /* Error color */
    --emerald-warning: #f39c12;                    /* Warning color */
    --emerald-info: #3498db;                       /* Info color */
  }

html_structure: |
  <div class="fl-emerald fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
      <div class="fl-content">
          <div class="fl-message">Message text</div>
          <button class="fl-close" aria-label="Close [type] message">×</button>
      </div>
  </div>
---
