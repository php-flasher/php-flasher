---
layout: theme
permalink: /theme/neon/
title: Neon Theme
subtitle: Elegant notifications with subtle glowing accents
description: Add elegant notifications with subtle glowing accents to your application using the Neon theme for PHPFlasher. Featuring frosted glass backgrounds, floating illuminated indicators, and refined typography.
theme_name: theme.neon
theme_name_short: neon
theme_class: fl-neon
icon: fa-lightbulb
color: purple
has_assets: true

visual_features:
  - Distinctive floating indicator with subtle glow effect
  - Frosted glass background with backdrop blur
  - Gentle "breathing" animation for the glowing elements
  - Refined entrance animation combining fade and movement
  - Modern typography with clean, readable font

accessibility_features:
  - Type-specific ARIA roles for screen readers
  - Appropriate aria-live regions based on message importance
  - Reduced motion option disables both entrance and glow animations
  - Fully keyboard accessible close button with visual feedback
  - Both color and position used to indicate notification type
  - Sufficient contrast between text and background

css_variables: |
  :root {
    /* Base appearance */
    --neon-bg-light: rgba(255, 255, 255, 0.9);    /* Light mode background */
    --neon-bg-dark: rgba(15, 23, 42, 0.9);        /* Dark mode background */
    --neon-text-light: #334155;                   /* Light mode text */
    --neon-text-dark: #f1f5f9;                    /* Dark mode text */
    --neon-border-radius: 12px;                   /* Corner roundness */
    
    /* Glow colors */
    --neon-success: #10b981;                      /* Success color */
    --neon-info: #3b82f6;                         /* Info color */
    --neon-warning: #f59e0b;                      /* Warning color */
    --neon-error: #ef4444;                        /* Error color */
    
    /* Glow properties */
    --neon-glow-strength: 10px;                   /* How far the glow extends */
    --neon-blur: 10px;                            /* Backdrop blur amount */
  }

html_structure: |
  <div class="fl-neon fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
      <div class="fl-content">
          <div class="fl-message">Message text</div>
          <button class="fl-close" aria-label="Close [type] message">×</button>
      </div>
      <div class="fl-progress-bar">
          <div class="fl-progress"></div>
      </div>
  </div>
---
