---
layout: theme
permalink: /theme/onyx/
title: Onyx Theme
subtitle: Modern, floating notifications with elegant details
description: Add modern, floating notifications to your application with the Onyx theme for PHPFlasher. Featuring elegant shadows, colored corner dots, and smooth animations for a sophisticated appearance.
theme_name: theme.onyx
theme_name_short: onyx
theme_class: fl-onyx
icon: fa-gem
color: black
has_assets: true

visual_features:
  - Sophisticated floating card design with elegant shadows
  - Distinctive colored accent dots in corners to indicate notification type
  - Clean, minimalist appearance focusing on content clarity
  - Refined entrance animation combining fade, movement and focus effects
  - Generous spacing and rounded corners (1rem radius) for a contemporary look

accessibility_features:
  - Type-specific ARIA roles for screen readers
  - Appropriate aria-live regions based on message importance
  - Reduced motion option for users with motion sensitivity
  - Colored dots provide type indication without relying solely on color
  - Fully keyboard accessible close button with visual feedback
  - High contrast between text and background in both light and dark modes

css_variables: |
  :root {
    /* Base appearance */
    --onyx-bg-light: #ffffff;                    /* Light mode background */
    --onyx-bg-dark: #1e1e1e;                     /* Dark mode background */
    --onyx-text-light: #333333;                  /* Light mode text */
    --onyx-text-dark: #f5f5f5;                   /* Dark mode text */
    --onyx-shadow: 0 8px 30px rgba(0, 0, 0, 0.12); /* Light mode shadow */
    --onyx-shadow-dark: 0 8px 30px rgba(0, 0, 0, 0.25); /* Dark mode shadow */
    --onyx-border-radius: 1rem;                  /* Corner roundness */
    
    /* Accent colors */
    --onyx-success: #10b981;                     /* Success color */
    --onyx-info: #3b82f6;                        /* Info color */
    --onyx-warning: #f59e0b;                     /* Warning color */
    --onyx-error: #ef4444;                       /* Error color */
  }

html_structure: |
  <div class="fl-onyx fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
      <div class="fl-content">
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
