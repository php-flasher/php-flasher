---
layout: theme
permalink: /theme/amazon/
title: Amazon Theme
subtitle: E-commerce inspired notification system
description: Transform your notifications with the Amazon-inspired theme for PHPFlasher. Create clean, minimal notifications that match Amazon's design language with built-in accessibility and dark mode support.
theme_name: theme.amazon
theme_name_short: amazon
theme_class: fl-amazon
icon: fa-store
color: amber
has_assets: true

visual_features:
  - Clean, minimal design inspired by Amazon's UI
  - Distinct colors for each notification type
  - Dark mode support with automatic detection
  - Customizable color scheme

accessibility_features:
  - ARIA roles and live regions for screen readers
  - Keyboard accessible controls
  - High contrast text meeting WCAG 2.1 AA standards
  - Supports reduced motion preferences

css_variables: |
  :root {
    /* Amazon theme colors - Light mode */
    --amazon-success-bg: #f0fff5;       /* Success background */
    --amazon-success-border: #7fda95;   /* Success border */
    --amazon-success-icon: #007600;     /* Success icon color */
    --amazon-info-bg: #f3f9ff;          /* Info background */
    --amazon-info-border: #7fb4da;      /* Info border */
    --amazon-info-icon: #0066c0;        /* Info icon color */
    --amazon-warning-bg: #fffcf3;       /* Warning background */
    --amazon-warning-border: #ffd996;   /* Warning border */
    --amazon-warning-icon: #c45500;     /* Warning icon color */
    --amazon-error-bg: #fff5f5;         /* Error background */
    --amazon-error-border: #ff8f8f;     /* Error border */
    --amazon-error-icon: #c40000;       /* Error icon color */
    
    /* Dark mode colors */
    --amazon-success-bg-dark: #0a3317;
    --amazon-success-border-dark: #2a6e3f;
    --amazon-success-icon-dark: #7fda95;
    --amazon-info-bg-dark: #0a2940;
    --amazon-info-border-dark: #2a5d6e;
    --amazon-info-icon-dark: #7fb4da;
    --amazon-warning-bg-dark: #3d2800;
    --amazon-warning-border-dark: #6e5c2a;
    --amazon-warning-icon-dark: #ffd996;
    --amazon-error-bg-dark: #400a0a;
    --amazon-error-border-dark: #6e2a2a;
    --amazon-error-icon-dark: #ff8f8f;
  }

html_structure: |
  <div class="fl-amazon fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
      <div class="fl-amazon-alert">
          <div class="fl-alert-content">
              <div class="fl-icon-container">
                  <!-- SVG icon -->
              </div>
              <div class="fl-text-content">
                  <div class="fl-alert-title">Title</div>
                  <div class="fl-alert-message">Message</div>
              </div>
          </div>
          <div class="fl-alert-actions">
              <button class="fl-close" aria-label="Close notification">
                  <!-- Close icon -->
              </button>
          </div>
      </div>
  </div>
---
