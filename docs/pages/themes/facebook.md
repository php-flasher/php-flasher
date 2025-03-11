---
layout: theme
permalink: /theme/facebook/
title: Facebook Theme
subtitle: Familiar social media notification style
description: Add Facebook-style notifications to your application with the Facebook theme for PHPFlasher. Featuring familiar notification cards, circular icons, and Facebook's signature design elements.
theme_name: theme.facebook
theme_name_short: facebook
theme_class: fl-facebook
icon: fa-facebook
color: blue
has_assets: true

visual_features:
  - Rounded notification cards with subtle drop shadows
  - Circular colored icons for each notification type
  - Facebook's signature typography and color scheme
  - Timestamp display showing when notifications were created
  - Interactive elements with familiar hover states

accessibility_features:
  - Type-specific ARIA roles for screen readers
  - Appropriate aria-live regions based on message importance
  - Reduced motion support for users with motion sensitivity
  - Fully keyboard accessible interactive elements
  - Color contrast optimized for readability while maintaining Facebook's look
  - Descriptive aria-labels for all controls

css_variables: |
  :root {
    /* Base colors */
    --fb-bg-light: #ffffff;                  /* Light mode background */
    --fb-bg-dark: #242526;                   /* Dark mode background */
    --fb-text-light: #050505;                /* Light mode primary text */
    --fb-text-secondary-light: #65676b;      /* Light mode secondary text */
    --fb-text-dark: #e4e6eb;                 /* Dark mode primary text */
    --fb-text-secondary-dark: #b0b3b8;       /* Dark mode secondary text */
    --fb-hover-light: #f0f2f5;               /* Light mode hover state */
    --fb-hover-dark: #3a3b3c;                /* Dark mode hover state */
    
    /* Type colors */
    --fb-success: #31a24c;                   /* Success color */
    --fb-info: #1876f2;                      /* Info color (Facebook blue) */
    --fb-warning: #f7b928;                   /* Warning color */
    --fb-error: #e41e3f;                     /* Error color */
  }

html_structure: |
  <div class="fl-facebook fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
      <div class="fl-fb-notification">
          <div class="fl-icon-container">
              <div class="fl-fb-icon fl-fb-icon-[type]">
                  <!-- SVG icon -->
              </div>
          </div>
          <div class="fl-content">
              <div class="fl-message">Message text</div>
              <div class="fl-meta">
                  <span class="fl-time">15:43</span>
              </div>
          </div>
          <div class="fl-actions">
              <button class="fl-button fl-close" aria-label="Close [type] message">
                  <div class="fl-button-icon">
                      <!-- Close SVG icon -->
                  </div>
              </button>
          </div>
      </div>
  </div>
---
