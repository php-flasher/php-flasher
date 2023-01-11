<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\SweetAlert\Prime;

use Flasher\Prime\Notification\NotificationBuilder;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
final class SweetAlertBuilder extends NotificationBuilder
{
    /**
     * {@inheritdoc}
     */
    public function type($type, $message = null, $title = null, array $options = array())
    {
        $this->icon($type);

        return parent::type($type, $message, $title, $options);
    }

    /**
     * Display a question typed alert message.
     *
     * @param string               $message
     * @param array<string, mixed> $options
     *
     * @return SweetAlertBuilder
     */
    public function question($message = null, array $options = array())
    {
        $this->showCancelButton();

        return $this->type('question', $message, $options);
    }

    /**
     * The title of the popup, as HTML.
     *
     * @param string $title
     *
     * @return static
     */
    public function title($title)
    {
        $this->option('title', $title);

        return $this;
    }

    /**
     * The title of the popup, as text. Useful to avoid HTML injection.
     *
     * @param string $titleText
     *
     * @return static
     */
    public function titleText($titleText)
    {
        $this->option('titleText', $titleText);

        return $this;
    }

    /**
     * A HTML description for the popup.
     *
     * [Security] SweetAlert2 does NOT sanitize this parameter. It is the developer's responsibility to escape any user
     * input when using the html option, so XSS attacks would be prevented.
     *
     * @param string $html
     *
     * @return static
     */
    public function html($html)
    {
        $this->option('html', $html);

        return $this;
    }

    /**
     * A description for the popup. If "text" and "html" parameters are provided in the same time, "text" will be used.
     *
     * @param string $text
     *
     * @return static
     */
    public function text($text)
    {
        $this->option('text', $text);

        return $this;
    }

    public function message($message)
    {
        parent::message($message);

        return $this->text($message);
    }

    /**
     * The icon of the popup. SweetAlert2 comes with 5 built-in icon which will show a corresponding icon animation:
     * warning, error, success, info, and question. It can either be put in the array under the key "icon" or passed as
     * the third parameter of the function.
     *
     * @param string $icon
     *
     * @return static
     */
    public function icon($icon)
    {
        $this->option('icon', $icon);

        return $this;
    }

    /**
     * Use this to change the color of the icon.
     *
     * @param string $iconColor
     *
     * @return static
     */
    public function iconColor($iconColor)
    {
        $this->option('iconColor', $iconColor);

        return $this;
    }

    /**
     * The custom HTML content for an icon.
     *
     * @param string $iconHtml
     *
     * @return static
     */
    public function iconHtml($iconHtml)
    {
        $this->option('iconHtml', $iconHtml);

        return $this;
    }

    /**
     * CSS classes for animations when showing a popup (fade in).
     *
     * @param string $showClass
     * @param string $value
     *
     * @return static
     */
    public function showClass($showClass, $value)
    {
        $option = $this->getEnvelope()->getOption('showClass', array());
        $option[$showClass] = $value; // @phpstan-ignore-line

        $this->option('showClass', $option);

        return $this;
    }

    /**
     * CSS classes for animations when hiding a popup (fade out).
     *
     * @param string $hideClass
     * @param string $value
     *
     * @return static
     */
    public function hideClass($hideClass, $value)
    {
        $option = $this->getEnvelope()->getOption('hideClass', array());
        $option[$hideClass] = $value; // @phpstan-ignore-line

        $this->option('hideClass', $option);

        return $this;
    }

    /**
     * The footer of the popup. Can be either plain text or HTML.
     *
     * @param string $footer
     *
     * @return static
     */
    public function footer($footer)
    {
        $this->option('footer', $footer);

        return $this;
    }

    /**
     * Whether or not SweetAlert2 should show a full screen click-to-dismiss backdrop. Can be either a boolean or a
     * string which will be assigned to the CSS background property.
     *
     * @param bool|string $backdrop
     *
     * @return static
     */
    public function backdrop($backdrop = true)
    {
        $this->option('backdrop', $backdrop);

        return $this;
    }

    /**
     * Whether or not an alert should be treated as a toast notification. This option is normally coupled with the
     * position parameter and a timer. Toasts are NEVER autofocused.
     *
     * @param bool   $toast
     * @param string $position
     * @param bool   $showConfirmButton
     *
     * @return static
     */
    public function toast($toast = true, $position = 'top-end', $showConfirmButton = false)
    {
        $this->option('toast', $toast);
        $this->position($position);
        $this->showConfirmButton($showConfirmButton);

        if (null === $this->getEnvelope()->getOption('title')) {
            $this->title(' ');
        }

        return $this;
    }

    /**
     * The container element for adding popup into.
     *
     * @param string $target
     *
     * @return static
     */
    public function target($target)
    {
        $this->option('target', $target);

        return $this;
    }

    /**
     * Input field type, can be text, email, password, number, tel, range, textarea, select, radio, checkbox, file and
     * url.
     *
     * @param string $input
     *
     * @return static
     */
    public function input($input)
    {
        $this->option('input', $input);

        return $this;
    }

    /**
     * Popup window width, including paddings (box-sizing: border-box). Can be in px or %. The default width is 32rem.
     *
     * @param string $width
     *
     * @return static
     */
    public function width($width)
    {
        $this->option('width', $width);

        return $this;
    }

    /**
     * Popup window padding. The default padding is 1.25rem.
     *
     * @param string $padding
     *
     * @return static
     */
    public function padding($padding)
    {
        $this->option('padding', $padding);

        return $this;
    }

    /**
     * Popup window background (CSS background property). The default background is '#fff'.
     *
     * @param string $background
     *
     * @return static
     */
    public function background($background)
    {
        $this->option('background', $background);

        return $this;
    }

    /**
     * Popup window position, can be 'top', 'top-start', 'top-end', 'center', 'center-start', 'center-end', 'bottom',
     * 'bottom-start', or 'bottom-end'.
     *
     * @param string $position
     *
     * @return static
     */
    public function position($position)
    {
        $this->option('position', $position);

        return $this;
    }

    /**
     * Paired with window position, sets the direction the popup should grow in, can be set to 'row', 'column',
     * 'fullscreen', or false.
     *
     * @param bool|string $grow
     *
     * @return static
     */
    public function grow($grow)
    {
        $this->option('grow', $grow);

        return $this;
    }

    /**
     * A custom CSS class for the popup.
     *
     * @param string $customClass
     * @param string $value
     *
     * @return static
     */
    public function customClass($customClass, $value)
    {
        $option = $this->getEnvelope()->getOption('customClass', array());
        $option[$customClass] = $value; // @phpstan-ignore-line

        $this->option('customClass', $option);

        return $this;
    }

    /**
     * Auto close timer of the popup. Set in ms (milliseconds).
     *
     * @param int $timer
     *
     * @return static
     */
    public function timer($timer)
    {
        $this->option('timer', $timer);

        return $this;
    }

    /**
     * If set to true, the timer will have a progress bar at the bottom of a popup. Mostly, this feature is useful with
     * toasts.
     *
     * @param bool $timerProgressBar
     *
     * @return static
     */
    public function timerProgressBar($timerProgressBar = true)
    {
        $this->option('timerProgressBar', $timerProgressBar);

        return $this;
    }

    /**
     * By default, SweetAlert2 sets html's and body's CSS height to auto !important. If this behavior isn't compatible
     * with your project's layout, set heightAuto to false.
     *
     * @param bool $heightAuto
     *
     * @return static
     */
    public function heightAuto($heightAuto = true)
    {
        $this->option('heightAuto', $heightAuto);

        return $this;
    }

    /**
     * If set to false, the user can't dismiss the popup by clicking outside it. You can also pass a custom function
     * returning a boolean value, e.g. if you want to disable outside clicks for the loading state of a popup.
     *
     * @param bool|string $allowOutsideClick
     *
     * @return static
     */
    public function allowOutsideClick($allowOutsideClick = true)
    {
        $this->option('allowOutsideClick', $allowOutsideClick);

        return $this;
    }

    /**
     * If set to false, the user can't dismiss the popup by pressing the Esc key. You can also pass a custom function
     * returning a boolean value, e.g. if you want to disable the Esc key for the loading state of a popup.
     *
     * @param bool|string $allowEscapeKey
     *
     * @return static
     */
    public function allowEscapeKey($allowEscapeKey = true)
    {
        $this->option('allowEscapeKey', $allowEscapeKey);

        return $this;
    }

    /**
     * If set to false, the user can't confirm the popup by pressing the Enter or Space keys, unless they manually focus
     * the confirm button. You can also pass a custom function returning a boolean value.
     *
     * @param bool|string $allowEnterKey
     *
     * @return static
     */
    public function allowEnterKey($allowEnterKey = true)
    {
        $this->option('allowEnterKey', $allowEnterKey);

        return $this;
    }

    /**
     * If set to false, SweetAlert2 will allow keydown events propagation to the document.
     *
     * @param bool $stop
     *
     * @return static
     */
    public function stopKeydownPropagation($stop = true)
    {
        $this->option('stopKeydownPropagation', $stop);

        return $this;
    }

    /**
     * Useful for those who are using SweetAlert2 along with Bootstrap modals. By default keydownListenerCapture is
     * false which means when a user hits Esc, both SweetAlert2 and Bootstrap modals will be closed. Set
     * keydownListenerCapture to true to fix that behavior.
     *
     * @param bool $capture
     *
     * @return static
     */
    public function keydownListenerCapture($capture = true)
    {
        $this->option('keydownListenerCapture', $capture);

        return $this;
    }

    /**
     * If set to false, a "Confirm"-button will not be shown.
     *
     * @param bool   $showConfirmButton
     * @param string $confirmButtonText
     * @param string $confirmButtonColor
     * @param string $confirmButtonAriaLabel
     *
     * @return static
     *
     * @SuppressWarnings(PHPMD.LongVariable)
     */
    public function showConfirmButton(
        $showConfirmButton = true,
        $confirmButtonText = null,
        $confirmButtonColor = null,
        $confirmButtonAriaLabel = null
    ) {
        $this->option('showConfirmButton', $showConfirmButton);

        if (null !== $confirmButtonText) {
            $this->confirmButtonText($confirmButtonText);
        }

        if (null !== $confirmButtonColor) {
            $this->confirmButtonColor($confirmButtonColor);
        }

        if (null !== $confirmButtonAriaLabel) {
            $this->confirmButtonAriaLabel($confirmButtonAriaLabel);
        }

        return $this;
    }

    /**
     * If set to true, a "Deny"-button will be shown. It can be useful when you want a popup with 3 buttons.
     *
     * @param bool   $showDenyButton
     * @param string $denyButtonText
     * @param string $denyButtonColor
     * @param string $denyButtonAriaLabel
     *
     * @return static
     */
    public function showDenyButton(
        $showDenyButton = true,
        $denyButtonText = null,
        $denyButtonColor = null,
        $denyButtonAriaLabel = null
    ) {
        $this->option('showDenyButton', $showDenyButton);

        if (null !== $denyButtonText) {
            $this->denyButtonText($denyButtonText);
        }

        if (null !== $denyButtonColor) {
            $this->denyButtonColor($denyButtonColor);
        }

        if (null !== $denyButtonAriaLabel) {
            $this->denyButtonAriaLabel($denyButtonAriaLabel);
        }

        return $this;
    }

    /**
     * If set to true, a "Cancel"-button will be shown, which the user can click on to dismiss the modal.
     *
     * @param bool   $showCancelButton
     * @param string $cancelButtonText
     * @param string $cancelButtonColor
     * @param string $cancelButtonAriaLabel
     *
     * @return static
     *
     * @SuppressWarnings(PHPMD.LongVariable)
     */
    public function showCancelButton(
        $showCancelButton = true,
        $cancelButtonText = null,
        $cancelButtonColor = null,
        $cancelButtonAriaLabel = null
    ) {
        $this->option('showCancelButton', $showCancelButton);

        if (null !== $cancelButtonText) {
            $this->cancelButtonText($cancelButtonText);
        }

        if (null !== $cancelButtonColor) {
            $this->cancelButtonColor($cancelButtonColor);
        }

        if (null !== $cancelButtonAriaLabel) {
            $this->cancelButtonAriaLabel($cancelButtonAriaLabel);
        }

        return $this;
    }

    /**
     * Use this to change the text on the "Confirm"-button.
     *
     * @param string $confirmButtonText
     * @param string $confirmButtonColor
     * @param string $confirmButtonAriaLabel
     *
     * @return static
     *
     * @SuppressWarnings(PHPMD.LongVariable)
     */
    public function confirmButtonText($confirmButtonText, $confirmButtonColor = null, $confirmButtonAriaLabel = null)
    {
        $this->option('confirmButtonText', $confirmButtonText);

        if (null !== $confirmButtonColor) {
            $this->confirmButtonColor($confirmButtonColor);
        }

        if (null !== $confirmButtonAriaLabel) {
            $this->confirmButtonAriaLabel($confirmButtonAriaLabel);
        }

        return $this;
    }

    /**
     * Use this to change the text on the "Deny"-button.
     *
     * @param string $denyButtonText
     * @param string $denyButtonColor
     * @param string $denyButtonAriaLabel
     *
     * @return static
     */
    public function denyButtonText($denyButtonText, $denyButtonColor = null, $denyButtonAriaLabel = null)
    {
        $this->option('denyButtonText', $denyButtonText);

        if (null !== $denyButtonColor) {
            $this->denyButtonColor($denyButtonColor);
        }

        if (null !== $denyButtonAriaLabel) {
            $this->denyButtonAriaLabel($denyButtonAriaLabel);
        }

        return $this;
    }

    /**
     * Use this to change the text on the "Cancel"-button.
     *
     * @param string $cancelButtonText
     * @param string $cancelButtonColor
     * @param string $cancelButtonAriaLabel
     *
     * @return static
     *
     * @SuppressWarnings(PHPMD.LongVariable)
     */
    public function cancelButtonText($cancelButtonText, $cancelButtonColor = null, $cancelButtonAriaLabel = null)
    {
        $this->option('cancelButtonText', $cancelButtonText);

        if (null !== $cancelButtonColor) {
            $this->cancelButtonColor($cancelButtonColor);
        }

        if (null !== $cancelButtonAriaLabel) {
            $this->cancelButtonAriaLabel($cancelButtonAriaLabel);
        }

        return $this;
    }

    /**
     * Use this to change the background color of the "Confirm"-button. The default color is #3085d6.
     *
     * @param string $confirmButtonColor
     *
     * @return static
     */
    public function confirmButtonColor($confirmButtonColor)
    {
        $this->option('confirmButtonColor', $confirmButtonColor);

        return $this;
    }

    /**
     * Use this to change the background color of the "Deny"-button. The default color is #dd6b55.
     *
     * @param string $denyButtonColor
     *
     * @return static
     */
    public function denyButtonColor($denyButtonColor)
    {
        $this->option('denyButtonColor', $denyButtonColor);

        return $this;
    }

    /**
     * Use this to change the background color of the "Cancel"-button. The default color is #aaa.
     *
     * @param string $cancelButtonColor
     *
     * @return static
     */
    public function cancelButtonColor($cancelButtonColor)
    {
        $this->option('cancelButtonColor', $cancelButtonColor);

        return $this;
    }

    /**
     * Use this to change the aria-label for the "Confirm"-button.
     *
     * @param string $label
     *
     * @return static
     */
    public function confirmButtonAriaLabel($label)
    {
        $this->option('confirmButtonAriaLabel', $label);

        return $this;
    }

    /**
     * Use this to change the aria-label for the "Deny"-button.
     *
     * @param string $denyButtonAriaLabel
     *
     * @return static
     */
    public function denyButtonAriaLabel($denyButtonAriaLabel)
    {
        $this->option('denyButtonAriaLabel', $denyButtonAriaLabel);

        return $this;
    }

    /**
     * Use this to change the aria-label for the "Cancel"-button.
     *
     * @param string $label
     *
     * @return static
     */
    public function cancelButtonAriaLabel($label)
    {
        $this->option('cancelButtonAriaLabel', $label);

        return $this;
    }

    /**
     * Apply default styling to buttons. If you want to use your own classes (e.g. Bootstrap classes) set this parameter
     * to false.
     *
     * @param bool $buttonsStyling
     *
     * @return static
     */
    public function buttonsStyling($buttonsStyling = true)
    {
        $this->option('buttonsStyling', $buttonsStyling);

        return $this;
    }

    /**
     * Set to true if you want to invert default buttons positions ("Confirm"-button on the right side).
     *
     * @param bool $reverseButtons
     *
     * @return static
     */
    public function reverseButtons($reverseButtons = true)
    {
        $this->option('reverseButtons', $reverseButtons);

        return $this;
    }

    /**
     * Set to false if you want to focus the first element in tab order instead of "Confirm"-button by default.
     *
     * @param bool $focusConfirm
     *
     * @return static
     */
    public function focusConfirm($focusConfirm = true)
    {
        $this->option('focusConfirm', $focusConfirm);

        return $this;
    }

    /**
     * Set to true if you want to focus the "Deny"-button by default.
     *
     * @param bool $focusDeny
     *
     * @return static
     */
    public function focusDeny($focusDeny = true)
    {
        $this->option('focusDeny', $focusDeny);

        return $this;
    }

    /**
     * Set to true if you want to focus the "Cancel"-button by default.
     *
     * @param bool $focusCancel
     *
     * @return static
     */
    public function focusCancel($focusCancel = true)
    {
        $this->option('focusCancel', $focusCancel);

        return $this;
    }

    /**
     * Set to true to show close button in top right corner of the popup.
     *
     * @param bool $showCloseButton
     *
     * @return static
     */
    public function showCloseButton($showCloseButton = true)
    {
        $this->option('showCloseButton', $showCloseButton);

        return $this;
    }

    /**
     * Use this to change the content of the close button.
     *
     * @param string $closeButtonHtml
     *
     * @return static
     */
    public function closeButtonHtml($closeButtonHtml)
    {
        $this->option('closeButtonHtml', $closeButtonHtml);

        return $this;
    }

    /**
     * Use this to change the aria-label for the close button.
     *
     * @param string $closeButtonAriaLabel
     *
     * @return static
     */
    public function closeButtonAriaLabel($closeButtonAriaLabel)
    {
        $this->option('closeButtonAriaLabel', $closeButtonAriaLabel);

        return $this;
    }

    /**
     * Use this to change the HTML content of the loader.
     *
     * @param string $loaderHtml
     *
     * @return static
     */
    public function loaderHtml($loaderHtml)
    {
        $this->option('loaderHtml', $loaderHtml);

        return $this;
    }

    /**
     * Set to true to disable buttons and show that something is loading. Use it in combination with the preConfirm
     * parameter.
     *
     * @param bool $showLoaderOnConfirm
     *
     * @return static
     */
    public function showLoaderOnConfirm($showLoaderOnConfirm = true)
    {
        $this->option('showLoaderOnConfirm', $showLoaderOnConfirm);

        return $this;
    }

    /**
     * Set to false to disable body padding adjustment when the page scrollbar gets hidden while the popup is shown.
     *
     * @param bool $scrollbarPadding
     *
     * @return static
     */
    public function scrollbarPadding($scrollbarPadding = true)
    {
        $this->option('scrollbarPadding', $scrollbarPadding);

        return $this;
    }

    /**
     * Function to execute before confirming, may be async (Promise-returning) or sync.
     * Returned (or resolved) value can be:
     *  - false to prevent a popup from closing
     *  - anything else to pass that value as the result.value of Swal.fire()
     *  - undefined to keep the default result.value.
     *
     * @param bool|string $preConfirm
     *
     * @return static
     */
    public function preConfirm($preConfirm)
    {
        $this->option('preConfirm', $preConfirm);

        return $this;
    }

    /**
     * Function to execute before denying, may be async (Promise-returning) or sync.
     * Returned (or resolved) value can be:
     *  - false to prevent a popup from closing
     *  - anything else to pass that value as the result.value of Swal.fire()
     *  - undefined to keep the default result.value.
     *
     * @param string $preDeny
     *
     * @return static
     */
    public function preDeny($preDeny)
    {
        $this->option('preDeny', $preDeny);

        return $this;
    }

    /**
     * If you want to return the input value as result.value when denying the popup, set to true. Otherwise, the denying
     * will set result.value to false.
     *
     * @param bool $inputValue
     *
     * @return static
     */
    public function returnInputValueOnDeny($inputValue = true)
    {
        $this->option('returnInputValueOnDeny', $inputValue);

        return $this;
    }

    /**
     * @param bool $animation
     *
     * @return static
     */
    public function animation($animation = true)
    {
        $this->option('animation', $animation);

        return $this;
    }

    /**
     * @param bool $showConfirmBtn
     * @param bool $showCloseBtn
     *
     * @return static
     */
    public function persistent($showConfirmBtn = true, $showCloseBtn = false)
    {
        $this->allowEscapeKey(false);
        $this->allowOutsideClick(false);
        $this->timer(0);
        $this->showConfirmButton($showConfirmBtn);
        $this->showCloseButton($showCloseBtn);

        return $this;
    }

    /**
     * Add a customized icon for the popup. Should contain a string with the path or URL to the image.
     *
     * @param string $imageUrl
     * @param int    $imageWidth
     * @param int    $imageHeight
     * @param string $imageAlt
     *
     * @return static
     */
    public function imageUrl($imageUrl, $imageWidth = null, $imageHeight = null, $imageAlt = null)
    {
        $this->option('imageUrl', $imageUrl);

        if (null !== $imageWidth) {
            $this->imageWidth($imageWidth);
        }

        if (null !== $imageHeight) {
            $this->imageHeight($imageHeight);
        }

        if (null !== $imageAlt) {
            $this->imageAlt($imageAlt);
        }

        return $this;
    }

    /**
     * If imageUrl is set, you can specify imageWidth to describes image width in px.
     *
     * @param int $imageWidth
     *
     * @return static
     */
    public function imageWidth($imageWidth)
    {
        $this->option('imageWidth', $imageWidth);

        return $this;
    }

    /**
     * Custom int height in px.
     *
     * @param int $imageHeight
     *
     * @return static
     */
    public function imageHeight($imageHeight)
    {
        $this->option('imageHeight', $imageHeight);

        return $this;
    }

    /**
     * An alternative text for the custom image icon.
     *
     * @param string $imageAlt
     *
     * @return static
     */
    public function imageAlt($imageAlt)
    {
        $this->option('imageAlt', $imageAlt);

        return $this;
    }

    /**
     * @param string $title
     * @param string $text
     * @param string $imageUrl
     * @param int    $imageWidth
     * @param int    $imageHeight
     * @param string $imageAlt
     *
     * @return static
     */
    public function image($title, $text, $imageUrl, $imageWidth = 400, $imageHeight = 200, $imageAlt = null)
    {
        $this->title($title);
        $this->text($text);
        $this->imageUrl($imageUrl);
        $this->imageWidth($imageWidth);
        $this->imageHeight($imageHeight);
        $this->animation(false);

        if (null !== $imageAlt) {
            $this->imageAlt($imageAlt);
        } else {
            $this->imageAlt($title);
        }

        return $this;
    }

    /**
     * Shortcut to add and flush an image.
     *
     * @param string $title
     * @param string $text
     * @param string $imageUrl
     * @param int    $imageWidth
     * @param int    $imageHeight
     * @param string $imageAlt
     *
     * @return \Flasher\Prime\Notification\Envelope
     */
    public function addImage($title, $text, $imageUrl, $imageWidth = 400, $imageHeight = 200, $imageAlt = null)
    {
        $this->image($title, $text, $imageUrl, $imageWidth, $imageHeight, $imageAlt);

        return $this->push();
    }

    /**
     * Input field label.
     *
     * @param string $inputLabel
     *
     * @return static
     */
    public function inputLabel($inputLabel)
    {
        $this->option('inputLabel', $inputLabel);

        return $this;
    }

    /**
     * Input field placeholder.
     *
     * @param string $inputPlaceholder
     *
     * @return static
     */
    public function inputPlaceholder($inputPlaceholder)
    {
        $this->option('inputPlaceholder', $inputPlaceholder);

        return $this;
    }

    /**
     * Input field initial value.
     *  - If the input type is select, inputValue will represent the selected <option> tag.
     *  - If the input type is checkbox, inputValue will represent the checked state.
     *  - If the input type is text, email, number, tel or textarea a Promise can be accepted as inputValue.
     *
     * @param string $inputValue
     *
     * @return static
     */
    public function inputValue($inputValue)
    {
        $this->option('inputValue', $inputValue);

        return $this;
    }

    /**
     * If input parameter is set to "select" or "radio", you can provide options. Can be a Map or a plain object, with
     * keys that represent option values and values that represent option text. You can also provide plain object or Map
     * as values that will represented a group of options, being the label of this <optgroup> the key. Finally, you can
     * also provide a Promise that resolves with one of those types.
     *
     * @param string $inputOptions
     *
     * @return static
     */
    public function inputOptions($inputOptions)
    {
        $this->option('inputOptions', $inputOptions);

        return $this;
    }

    /**
     * Automatically remove whitespaces from both ends of a result string. Set this parameter to false to disable
     * auto-trimming.
     *
     * @param bool $inputAutoTrim
     *
     * @return static
     */
    public function inputAutoTrim($inputAutoTrim = true)
    {
        $this->option('inputAutoTrim', $inputAutoTrim);

        return $this;
    }

    /**
     * HTML input attributes (e.g. min, max, autocomplete, accept), that are added to the input field. Object keys will
     * represent attributes names, object values will represent attributes values.
     *
     * @param string $inputAttributes
     *
     * @return static
     */
    public function inputAttributes($inputAttributes)
    {
        $this->option('inputAttributes', $inputAttributes);

        return $this;
    }

    /**
     * Validator for input field, may be async (Promise-returning) or sync.
     * Returned (or resolved) value can be:
     *  - a falsy value (undefined, null, false) for indicating success
     *  - a string value (error message) for indicating failure.
     *
     * @param string $inputValidator
     *
     * @return static
     */
    public function inputValidator($inputValidator)
    {
        $this->option('inputValidator', $inputValidator);

        return $this;
    }

    /**
     * A custom validation message for default validators (email, url).
     *
     * @param string $validationMessage
     *
     * @return static
     */
    public function validationMessage($validationMessage)
    {
        $this->option('validationMessage', $validationMessage);

        return $this;
    }
}
