---
layout: theme
permalink: /theme/google/
title: Google Theme
subtitle: Material Design-inspired notifications
description: Add Material Design-inspired notifications to your application with the Google theme for PHPFlasher. Featuring Google's card-based layout, typography, and interactive elements like ripple effects.
theme_name: theme.google
theme_name_short: google
theme_class: fl-google
icon: fa-brands fa-google
color: red
has_assets: true

visual_features:
  - Material Design elevation with three-component shadow system
  - Card-based layout with Google's signature typography
  - Interactive ripple effect for tactile button feedback
  - Progress bar showing time until auto-dismiss
  - Responsive design that adapts to different screen sizes

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
  <div class="fl-google fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
      <div class="fl-md-card">
          <div class="fl-content">
              <div class="fl-icon-wrapper">
                  <!-- SVG icon -->
              </div>
              <div class="fl-text-content">
                  <div class="fl-title">Title (if provided)</div>
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
