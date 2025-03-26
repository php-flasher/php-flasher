---
layout: theme
permalink: /theme/ruby/
title: Ruby Theme
subtitle: Vibrant gradient notifications with shine effect
description: Add vibrant notifications with rich gradient backgrounds to your application using the Ruby theme for PHPFlasher. Featuring an elegant shine animation, circular icons, and gemstone-like appearance.
theme_name: theme.ruby
theme_name_short: ruby
theme_class: fl-ruby
icon: fa-duotone fa-gem
color: red
has_assets: true

visual_features:
  - Rich diagonal gradient backgrounds in vibrant colors
  - Distinctive shine animation mimicking light reflecting off gemstone surfaces
  - Circular translucent icon containers for clear notification type identification
  - Smooth entrance animation with scale and fade effects
  - Sophisticated shadow treatment for depth and premium feel

accessibility_features:
  - Type-specific ARIA roles for screen readers
  - Appropriate aria-live regions based on message importance
  - Reduced motion option disables shine animation and entrance effects
  - High contrast white text on colored backgrounds
  - Fully keyboard accessible controls with visual feedback
  - Complete RTL language support with directional adjustments

css_variables: |
  :root {
    /* Base appearance */
    --ruby-text: #ffffff;                        /* Text color */
    --ruby-border-radius: 1.125rem;              /* Corner roundness */
    --ruby-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.2); /* Shadow depth */
    
    /* Type-specific gradients */
    --ruby-success-gradient: linear-gradient(135deg, #059669 0%, #10b981 100%); /* Success */
    --ruby-info-gradient: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);    /* Info */
    --ruby-warning-gradient: linear-gradient(135deg, #d97706 0%, #f59e0b 100%); /* Warning */
    --ruby-error-gradient: linear-gradient(135deg, #b91c1c 0%, #ef4444 100%);   /* Error */
  }

html_structure: |
  <div class="fl-ruby fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
      <div class="fl-shine"></div>
      <div class="fl-content">
          <div class="fl-icon-circle">
              <div class="fl-icon"></div>
          </div>
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
