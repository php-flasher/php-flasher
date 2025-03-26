---
layout: theme
permalink: /theme/ios/
title: iOS Theme
subtitle: Apple-style notification system
description: Add Apple iOS-style notifications to your application with the iOS theme for PHPFlasher. Featuring frosted glass effects, app icons, and animations that mimic native iOS notifications.
theme_name: theme.ios
theme_name_short: ios
theme_class: fl-ios
icon: fa-brands fa-apple
color: slate
has_assets: true

visual_features:
  - Apple's signature frosted glass backdrop effect
  - App icon design with colored backgrounds
  - Real-time timestamp display in iOS format
  - Smooth entrance and content expansion animations
  - Adaptive design that matches iOS light and dark mode

accessibility_features:
  - Type-specific ARIA roles for screen readers
  - Appropriate aria-live regions based on message importance
  - Reduced motion option for motion-sensitive users
  - High contrast text that adapts to light and dark modes
  - Fully keyboard accessible close button
  - Mobile-optimized responsive layout

css_variables: |
  :root {
    /* Base appearance */
    --ios-bg-light: rgba(255, 255, 255, 0.85);  /* Light mode background */
    --ios-bg-dark: rgba(30, 30, 30, 0.85);      /* Dark mode background */
    --ios-text-light: #000000;                  /* Light mode text */
    --ios-text-secondary-light: #6e6e6e;        /* Light mode secondary text */
    --ios-text-dark: #ffffff;                   /* Dark mode text */
    --ios-text-secondary-dark: #a0a0a0;         /* Dark mode secondary text */
    --ios-border-radius: 13px;                  /* Corner radius */
    --ios-blur: 30px;                           /* Backdrop blur amount */
    
    /* Type colors - based on iOS system colors */
    --ios-success: #34c759;                     /* iOS green */
    --ios-info: #007aff;                        /* iOS blue */
    --ios-warning: #ff9500;                     /* iOS orange */
    --ios-error: #ff3b30;                       /* iOS red */
  }

html_structure: |
  <div class="fl-ios fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
      <div class="fl-ios-notification">
          <div class="fl-header">
              <div class="fl-app-icon">
                  <!-- SVG icon -->
              </div>
              <div class="fl-app-info">
                  <div class="fl-app-name">App Name/Title</div>
                  <div class="fl-time">2025-03-10 00:14:11</div>
              </div>
          </div>
          <div class="fl-content">
              <div class="fl-message">Message text</div>
          </div>
          <button class="fl-close" aria-label="Close [type] message">
              <span aria-hidden="true">×</span>
          </button>
      </div>
  </div>
---
