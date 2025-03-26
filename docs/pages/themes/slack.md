---
layout: theme
permalink: /theme/slack/
title: Slack Theme
subtitle: Familiar workspace messaging style
description: Add Slack-style notifications to your application with the Slack theme for PHPFlasher. Featuring message bubbles with colored avatars, clean typography, and interactive hover effects.
theme_name: theme.slack
theme_name_short: slack
theme_class: fl-slack
icon: fa-brands fa-slack
color: purple
has_assets: true

visual_features:
  - Message bubble design with subtle borders and shadow effects
  - Colored square avatars with notification type symbols
  - Clean typography mimicking Slack's font styling
  - Interactive close button that appears on hover
  - Consistent styling between notification types with color-coded avatars

accessibility_features:
  - Type-specific ARIA roles for screen readers
  - Appropriate aria-live regions based on message importance
  - Reduced motion option for users with motion sensitivity
  - Fully keyboard accessible close button
  - Multiple indicators (color and symbol) for notification types
  - High contrast text in both light and dark modes
  - Complete RTL language support with properly flipped layout

css_variables: |
  :root {
    /* Base appearance */
    --slack-bg-light: #ffffff;                  /* Light mode background */
    --slack-bg-dark: #1a1d21;                   /* Dark mode background */
    --slack-text-light: #1d1c1d;                /* Light mode text */
    --slack-text-dark: #e0e0e0;                 /* Dark mode text */
    --slack-border-light: #e0e0e0;              /* Light mode border */
    --slack-border-dark: #393a3e;               /* Dark mode border */
    --slack-avatar-size: 36px;                  /* Avatar size */
    
    /* Type colors */
    --slack-success: #2bac76;                   /* Success avatar color */
    --slack-info: #1264a3;                      /* Info avatar color */
    --slack-warning: #e8912d;                   /* Warning avatar color */
    --slack-error: #e01e5a;                     /* Error avatar color */
  }

html_structure: |
  <div class="fl-slack fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
      <div class="fl-slack-message">
          <div class="fl-avatar">
              <div class="fl-type-icon fl-[type]-icon">[Symbol]</div>
          </div>
          <div class="fl-message-content">
              <div class="fl-message-text">Message text</div>
          </div>
          <div class="fl-actions">
              <button class="fl-close" aria-label="Close [type] message">
                  <svg><!-- Close icon --></svg>
              </button>
          </div>
      </div>
  </div>
---
