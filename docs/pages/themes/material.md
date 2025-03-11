---
layout: theme
permalink: /theme/material/
title: Material Theme
subtitle: Minimalist Material Design notifications
description: Add minimalist Material Design notifications to your application with the Material theme for PHPFlasher. Featuring clean cards, proper elevation, and interactive elements following Material guidelines.
theme_name: theme.material
theme_name_short: material
theme_class: fl-material
icon: fa-square
color: indigo
has_assets: true

visual_features:
  - Clean card design with proper Material Design elevation
  - Minimalist appearance focusing entirely on message content
  - Interactive elements with signature Material ripple effect
  - Progress bar showing time until auto-dismiss
  - Subtle slide-up entrance animation with Material motion curve

accessibility_features:
  - ARIA roles specific to each notification type
  - Appropriate aria-live regions based on message importance
  - Reduced motion option for users with motion sensitivity
  - High contrast text meeting WCAG 2.1 AA standards
  - Fully keyboard accessible with clear focus indicators
  - Descriptive aria-labels for interactive elements

css_variables: |
  :root {
    /* Base appearance */
    --md-bg-light: #ffffff;              /* Light mode background */
    --md-bg-dark: #2d2d2d;               /* Dark mode background */
    --md-text-light: rgba(0, 0, 0, 0.87); /* Primary text in light mode */
    --md-text-secondary-light: rgba(0, 0, 0, 0.6); /* Secondary text in light mode */
    --md-text-dark: rgba(255, 255, 255, 0.87); /* Primary text in dark mode */
    --md-text-secondary-dark: rgba(255, 255, 255, 0.6); /* Secondary text in dark mode */
    --md-elevation: 0 3px 5px -1px rgba(0,0,0,0.2), 0 6px 10px 0 rgba(0,0,0,0.14), 0 1px 18px 0 rgba(0,0,0,0.12); /* Card shadow */
    --md-border-radius: 4px;             /* Card corner radius */
    
    /* Type colors - based on Material palette */
    --md-success: #43a047;               /* Green 600 */
    --md-info: #1e88e5;                  /* Blue 600 */
    --md-warning: #fb8c00;               /* Orange 600 */
    --md-error: #e53935;                 /* Red 600 */
    
    /* Animation timing */
    --md-animation-duration: 0.3s;       /* Entrance animation duration */
    --md-ripple-duration: 0.6s;          /* Button ripple effect duration */
  }

html_structure: |
  <div class="fl-material fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
      <div class="fl-md-card">
          <div class="fl-content">
              <div class="fl-text-content">
                  <div class="fl-message">Message text</div>
              </div>
          </div>
          <div class="fl-actions">
              <button class="fl-action-button fl-close" aria-label="Close [type] message">
                  DISMISS
              </button>
          </div>
      </div>
      <div class="fl-progress-bar">
          <div class="fl-progress"></div>
      </div>
  </div>
---
