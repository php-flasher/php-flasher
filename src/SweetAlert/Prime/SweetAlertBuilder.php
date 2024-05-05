<?php

declare(strict_types=1);

namespace Flasher\SweetAlert\Prime;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\NotificationBuilder;

final class SweetAlertBuilder extends NotificationBuilder
{
    /**
     * Display a question typed alert message.
     *
     * @param array<string, mixed> $options
     */
    public function question(?string $message = null, array $options = []): self
    {
        $this->showCancelButton();

        if ($message) {
            $this->messages($message);
        }

        if ([] === $options) {
            $this->options($options);
        }

        return $this->type('question');
    }

    /**
     * The title of the popup, as HTML.
     */
    public function title(string $title): static
    {
        parent::title($title);

        $this->option('title', $title);

        return $this;
    }

    /**
     * The title of the popup, as text. Useful to avoid HTML injection.
     */
    public function titleText(string $text): self
    {
        $this->option('titleText', $text);

        return $this;
    }

    /**
     * A HTML description for the popup.
     *
     * [Security] SweetAlert2 does NOT sanitize this parameter. It is the developer's responsibility to escape any user
     * input when using the html option, so XSS attacks would be prevented.
     */
    public function html(string $html): self
    {
        $this->option('html', $html);

        return $this;
    }

    /**
     * A description for the popup. If "text" and "html" parameters are provided in the same time, "text" will be used.
     */
    public function text(string $text): self
    {
        $this->option('text', $text);

        return $this;
    }

    public function messages(string $message): self
    {
        parent::message($message);

        return $this->text($message);
    }

    /**
     * The icon of the popup. SweetAlert2 comes with 5 built-in icon which will show a corresponding icon animation:
     * warning, error, success, info, and question. It can either be put in the array under the key "icon" or passed as
     * the third parameter of the function.
     */
    public function icon(string $icon): self
    {
        $this->option('icon', $icon);

        return $this;
    }

    /**
     * Use this to change the color of the icon.
     */
    public function iconColor(string $color): self
    {
        $this->option('iconColor', $color);

        return $this;
    }

    /**
     * The custom HTML content for an icon.
     */
    public function iconHtml(string $html): self
    {
        $this->option('iconHtml', $html);

        return $this;
    }

    /**
     * CSS classes for animations when showing a popup (fade in).
     */
    public function showClass(string $showClass, string $value): self
    {
        $option = $this->getEnvelope()->getOption('showClass', []);
        $option[$showClass] = $value; // @phpstan-ignore-line

        $this->option('showClass', $option);

        return $this;
    }

    /**
     * CSS classes for animations when hiding a popup (fade out).
     */
    public function hideClass(string $hideClass, string $value): self
    {
        $option = $this->getEnvelope()->getOption('hideClass', []);
        $option[$hideClass] = $value; // @phpstan-ignore-line

        $this->option('hideClass', $option);

        return $this;
    }

    /**
     * The footer of the popup. Can be either plain text or HTML.
     */
    public function footer(string $footer): self
    {
        $this->option('footer', $footer);

        return $this;
    }

    /**
     * Whether or not SweetAlert2 should show a full screen click-to-dismiss backdrop. Can be either a boolean or a
     * string which will be assigned to the CSS background property.
     */
    public function backdrop(bool|string $backdrop = true): self
    {
        $this->option('backdrop', $backdrop);

        return $this;
    }

    /**
     * @param "top"|"top-start"|"top-end"|"center"|"center-start"|"center-end"|"bottom"|"bottom-start"|"bottom-end" $position
     *
     * Whether or not an alert should be treated as a toast notification. This option is normally coupled with the
     * position parameter and a timer. Toasts are NEVER autofocused.
     */
    public function toast(bool $toast = true, string $position = 'top-end', bool $showConfirmButton = false): self
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
     */
    public function target(string $target): self
    {
        $this->option('target', $target);

        return $this;
    }

    /**
     * @param "text"|"email"|"password"|"number"|"tel"|"range"|"textarea"|"search"|"url"|"select"|"radio"|"checkbox"|"file"|"date"|"datetime-local"|"time"|"week"|"month" $input
     *
     * Input field type, can be text, email, password, number, tel, range, textarea, select, radio, checkbox, file and
     * url
     */
    public function input(string $input): self
    {
        $this->option('input', $input);

        return $this;
    }

    /**
     * Popup window width, including paddings (box-sizing: border-box). Can be in px or %. The default width is 32rem.
     */
    public function width(string $width): self
    {
        $this->option('width', $width);

        return $this;
    }

    /**
     * Popup window padding. The default padding is 1.25rem.
     */
    public function padding(string $padding): self
    {
        $this->option('padding', $padding);

        return $this;
    }

    /**
     * Popup window background (CSS background property). The default background is '#fff'.
     */
    public function background(string $background): self
    {
        $this->option('background', $background);

        return $this;
    }

    /**
     * @param "top"|"top-start"|"top-end"|"center"|"center-start"|"center-end"|"bottom"|"bottom-start"|"bottom-end" $position
     *
     * Popup window position, can be 'top', 'top-start', 'top-end', 'center', 'center-start', 'center-end', 'bottom',
     * 'bottom-start', or 'bottom-end'
     */
    public function position(string $position): self
    {
        $this->option('position', $position);

        return $this;
    }

    /**
     * @param "row"|"column"|"fullscreen"|false $grow
     *
     * Paired with window position, sets the direction the popup should grow in, can be set to 'row', 'column',
     * 'fullscreen', or false
     */
    public function grow(bool|string $grow): self
    {
        $this->option('grow', $grow);

        return $this;
    }

    /**
     * @param "container"|"popup"|"header"|"title"|"closeButton"|"icon"|"image"|"content"|"input"|"inputLabel"|"validationMessage"|"actions"|"confirmButton"|"denyButton"|"cancelButton"|"loader"|"footer" $customClass
     *
     * A custom CSS class for the popup
     */
    public function customClass(string $customClass, string $value): self
    {
        $option = $this->getEnvelope()->getOption('customClass', []);
        $option[$customClass] = $value; // @phpstan-ignore-line

        $this->option('customClass', $option);

        return $this;
    }

    /**
     * Auto close timer of the popup. Set in ms (milliseconds).
     */
    public function timer(int $timer): self
    {
        $this->option('timer', $timer);

        return $this;
    }

    /**
     * If set to true, the timer will have a progress bar at the bottom of a popup. Mostly, this feature is useful with
     * toasts.
     */
    public function timerProgressBar(bool $timerProgressBar = true): self
    {
        $this->option('timerProgressBar', $timerProgressBar);

        return $this;
    }

    /**
     * By default, SweetAlert2 sets html's and body's CSS height to auto !important. If this behavior isn't compatible
     * with your project's layout, set heightAuto to false.
     */
    public function heightAuto(bool $heightAuto = true): self
    {
        $this->option('heightAuto', $heightAuto);

        return $this;
    }

    /**
     * If set to false, the user can't dismiss the popup by clicking outside it. You can also pass a custom function
     * returning a boolean value, e.g. if you want to disable outside clicks for the loading state of a popup.
     */
    public function allowOutsideClick(bool|string $allowOutsideClick = true): self
    {
        $this->option('allowOutsideClick', $allowOutsideClick);

        return $this;
    }

    /**
     * If set to false, the user can't dismiss the popup by pressing the Esc key. You can also pass a custom function
     * returning a boolean value, e.g. if you want to disable the Esc key for the loading state of a popup.
     */
    public function allowEscapeKey(bool|string $allowEscapeKey = true): self
    {
        $this->option('allowEscapeKey', $allowEscapeKey);

        return $this;
    }

    /**
     * If set to false, the user can't confirm the popup by pressing the Enter or Space keys, unless they manually focus
     * the confirm button. You can also pass a custom function returning a boolean value.
     */
    public function allowEnterKey(bool|string $allowEnterKey = true): self
    {
        $this->option('allowEnterKey', $allowEnterKey);

        return $this;
    }

    /**
     * If set to false, SweetAlert2 will allow keydown events propagation to the document.
     */
    public function stopKeydownPropagation(bool $stop = true): self
    {
        $this->option('stopKeydownPropagation', $stop);

        return $this;
    }

    /**
     * Useful for those who are using SweetAlert2 along with Bootstrap modals. By default keydownListenerCapture is
     * false which means when a user hits Esc, both SweetAlert2 and Bootstrap modals will be closed. Set
     * keydownListenerCapture to true to fix that behavior.
     */
    public function keydownListenerCapture(bool $capture = true): self
    {
        $this->option('keydownListenerCapture', $capture);

        return $this;
    }

    /**
     * If set to false, a "Confirm"-button will not be shown.
     */
    public function showConfirmButton(bool $showConfirmButton = true, ?string $confirmButtonText = null, ?string $confirmButtonColor = null, ?string $confirmButtonAriaLabel = null): self
    {
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
     */
    public function showDenyButton(bool $showDenyButton = true, ?string $denyButtonText = null, ?string $denyButtonColor = null, ?string $denyButtonAriaLabel = null): self
    {
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
     */
    public function showCancelButton(bool $showCancelButton = true, ?string $cancelButtonText = null, ?string $cancelButtonColor = null, ?string $cancelButtonAriaLabel = null): self
    {
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
     */
    public function confirmButtonText(string $confirmButtonText, ?string $confirmButtonColor = null, ?string $confirmButtonAriaLabel = null): self
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
     */
    public function denyButtonText(string $denyButtonText, ?string $denyButtonColor = null, ?string $denyButtonAriaLabel = null): self
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
     */
    public function cancelButtonText(string $cancelButtonText, ?string $cancelButtonColor = null, ?string $cancelButtonAriaLabel = null): self
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
     */
    public function confirmButtonColor(string $confirmButtonColor): self
    {
        $this->option('confirmButtonColor', $confirmButtonColor);

        return $this;
    }

    /**
     * Use this to change the background color of the "Deny"-button. The default color is #dd6b55.
     */
    public function denyButtonColor(string $denyButtonColor): self
    {
        $this->option('denyButtonColor', $denyButtonColor);

        return $this;
    }

    /**
     * Use this to change the background color of the "Cancel"-button. The default color is #aaa.
     */
    public function cancelButtonColor(string $cancelButtonColor): self
    {
        $this->option('cancelButtonColor', $cancelButtonColor);

        return $this;
    }

    /**
     * Use this to change the aria-label for the "Confirm"-button.
     */
    public function confirmButtonAriaLabel(string $label): self
    {
        $this->option('confirmButtonAriaLabel', $label);

        return $this;
    }

    /**
     * Use this to change the aria-label for the "Deny"-button.
     */
    public function denyButtonAriaLabel(string $denyButtonAriaLabel): self
    {
        $this->option('denyButtonAriaLabel', $denyButtonAriaLabel);

        return $this;
    }

    /**
     * Use this to change the aria-label for the "Cancel"-button.
     */
    public function cancelButtonAriaLabel(string $label): self
    {
        $this->option('cancelButtonAriaLabel', $label);

        return $this;
    }

    /**
     * Apply default styling to buttons. If you want to use your own classes (e.g. Bootstrap classes) set this parameter
     * to false.
     */
    public function buttonsStyling(bool $buttonsStyling = true): self
    {
        $this->option('buttonsStyling', $buttonsStyling);

        return $this;
    }

    /**
     * Set to true if you want to invert default buttons positions ("Confirm"-button on the right side).
     */
    public function reverseButtons(bool $reverseButtons = true): self
    {
        $this->option('reverseButtons', $reverseButtons);

        return $this;
    }

    /**
     * Set to false if you want to focus the first element in tab order instead of "Confirm"-button by default.
     */
    public function focusConfirm(bool $focusConfirm = true): self
    {
        $this->option('focusConfirm', $focusConfirm);

        return $this;
    }

    /**
     * Set to true if you want to focus the "Deny"-button by default.
     */
    public function focusDeny(bool $focusDeny = true): self
    {
        $this->option('focusDeny', $focusDeny);

        return $this;
    }

    /**
     * Set to true if you want to focus the "Cancel"-button by default.
     */
    public function focusCancel(bool $focusCancel = true): self
    {
        $this->option('focusCancel', $focusCancel);

        return $this;
    }

    /**
     * Set to true to show close button in top right corner of the popup.
     */
    public function showCloseButton(bool $showCloseButton = true): self
    {
        $this->option('showCloseButton', $showCloseButton);

        return $this;
    }

    /**
     * Use this to change the content of the close button.
     */
    public function closeButtonHtml(string $closeButtonHtml): self
    {
        $this->option('closeButtonHtml', $closeButtonHtml);

        return $this;
    }

    /**
     * Use this to change the aria-label for the close button.
     */
    public function closeButtonAriaLabel(string $closeButtonAriaLabel): self
    {
        $this->option('closeButtonAriaLabel', $closeButtonAriaLabel);

        return $this;
    }

    /**
     * Use this to change the HTML content of the loader.
     */
    public function loaderHtml(string $loaderHtml): self
    {
        $this->option('loaderHtml', $loaderHtml);

        return $this;
    }

    /**
     * Set to true to disable buttons and show that something is loading. Use it in combination with the preConfirm
     * parameter.
     */
    public function showLoaderOnConfirm(bool $showLoaderOnConfirm = true): self
    {
        $this->option('showLoaderOnConfirm', $showLoaderOnConfirm);

        return $this;
    }

    /**
     * Set to false to disable body padding adjustment when the page scrollbar gets hidden while the popup is shown.
     */
    public function scrollbarPadding(bool $scrollbarPadding = true): self
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
     */
    public function preConfirm(bool|string $preConfirm): self
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
     */
    public function preDeny(string $preDeny): self
    {
        $this->option('preDeny', $preDeny);

        return $this;
    }

    /**
     * If you want to return the input value as result.value when denying the popup, set to true. Otherwise, the denying
     * will set result.value to false.
     */
    public function returnInputValueOnDeny(bool $inputValue = true): self
    {
        $this->option('returnInputValueOnDeny', $inputValue);

        return $this;
    }

    public function animation(bool $animation = true): self
    {
        $this->option('animation', $animation);

        return $this;
    }

    public function persistent(bool $showConfirmBtn = true, bool $showCloseBtn = false): self
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
     */
    public function imageUrl(string $imageUrl, ?int $imageWidth = null, ?int $imageHeight = null, ?string $imageAlt = null): self
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
     */
    public function imageWidth(int $imageWidth): self
    {
        $this->option('imageWidth', $imageWidth);

        return $this;
    }

    /**
     * Custom int height in px.
     */
    public function imageHeight(int $imageHeight): self
    {
        $this->option('imageHeight', $imageHeight);

        return $this;
    }

    /**
     * An alternative text for the custom image icon.
     */
    public function imageAlt(string $imageAlt): self
    {
        $this->option('imageAlt', $imageAlt);

        return $this;
    }

    public function image(string $title, string $text, string $imageUrl, int $imageWidth = 400, int $imageHeight = 200, ?string $imageAlt = null): self
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
     */
    public function addImage(string $title, string $text, string $imageUrl, int $imageWidth = 400, int $imageHeight = 200, ?string $imageAlt = null): Envelope
    {
        $this->image($title, $text, $imageUrl, $imageWidth, $imageHeight, $imageAlt);

        return $this->push();
    }

    /**
     * Input field label.
     */
    public function inputLabel(string $inputLabel): self
    {
        $this->option('inputLabel', $inputLabel);

        return $this;
    }

    /**
     * Input field placeholder.
     */
    public function inputPlaceholder(string $inputPlaceholder): self
    {
        $this->option('inputPlaceholder', $inputPlaceholder);

        return $this;
    }

    /**
     * Input field initial value.
     *  - If the input type is select, inputValue will represent the selected <option> tag.
     *  - If the input type is checkbox, inputValue will represent the checked state.
     *  - If the input type is text, email, number, tel or textarea a Promise can be accepted as inputValue.
     */
    public function inputValue(string $inputValue): self
    {
        $this->option('inputValue', $inputValue);

        return $this;
    }

    /**
     * If input parameter is set to "select" or "radio", you can provide options. Can be a Map or a plain object, with
     * keys that represent option values and values that represent option text. You can also provide plain object or Map
     * as values that will represented a group of options, being the label of this <optgroup> the key. Finally, you can
     * also provide a Promise that resolves with one of those types.
     */
    public function inputOptions(string $inputOptions): self
    {
        $this->option('inputOptions', $inputOptions);

        return $this;
    }

    /**
     * Automatically remove whitespaces from both ends of a result string. Set this parameter to false to disable
     * auto-trimming.
     */
    public function inputAutoTrim(bool $inputAutoTrim = true): self
    {
        $this->option('inputAutoTrim', $inputAutoTrim);

        return $this;
    }

    /**
     * HTML input attributes (e.g. min, max, autocomplete, accept), that are added to the input field. Object keys will
     * represent attributes names, object values will represent attributes values.
     */
    public function inputAttributes(string $inputAttributes): self
    {
        $this->option('inputAttributes', $inputAttributes);

        return $this;
    }

    /**
     * Validator for input field, may be async (Promise-returning) or sync.
     * Returned (or resolved) value can be:
     *  - a falsy value (undefined, null, false) for indicating success
     *  - a string value (error message) for indicating failure.
     */
    public function inputValidator(string $inputValidator): self
    {
        $this->option('inputValidator', $inputValidator);

        return $this;
    }

    /**
     * A custom validation message for default validators (email, url).
     */
    public function validationMessage(string $validationMessage): self
    {
        $this->option('validationMessage', $validationMessage);

        return $this;
    }
}
