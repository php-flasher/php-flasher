<?php

declare(strict_types=1);

namespace Flasher\SweetAlert\Prime;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\NotificationBuilder;

/**
 * @phpstan-type NotificationType "success"|"info"|"warning"|"error"|"question"
 * @phpstan-type CustomClassType "container"|"popup"|"header"|"title"|"closeButton"|"icon"|"image"|"content"|"input"|"inputLabel"|"validationMessage"|"actions"|"confirmButton"|"denyButton"|"cancelButton"|"loader"|"footer"
 * @phpstan-type OptionsType array{
 *     title?: string,
 *     titleText?: string,
 *     html?: string,
 *     text?: string,
 *     icon?: string,
 *     iconColor?: string,
 *     iconHtml?: string,
 *     showClass?: mixed,
 *     hideClass?: mixed,
 *     footer?: string,
 *     backdrop?: bool|string,
 *     toast?: bool,
 *     target?: string,
 *     input?: "text"|"email"|"password"|"number"|"tel"|"range"|"textarea"|"search"|"url"|"select"|"radio"|"checkbox"|"file"|"date"|"datetime-local"|"time"|"week"|"month",
 *     width?: string,
 *     padding?: string,
 *     background?: string,
 *     position?: "top"|"top-start"|"top-end"|"center"|"center-start"|"center-end"|"bottom"|"bottom-start"|"bottom-end",
 *     grow?: "column"|"fullscreen"|"row"|false,
 *     customClass?: array<CustomClassType, string>,
 *     timer?: int,
 *     timerProgressBar?: bool,
 *     heightAuto?: bool,
 *     allowOutsideClick?: bool|string,
 *     allowEscapeKey?: bool|string,
 *     allowEnterKey?: bool|string,
 *     stopKeydownPropagation?: bool,
 *     keydownListenerCapture?: bool,
 *     showConfirmButton?: bool,
 *     showDenyButton?: bool,
 *     showCancelButton?: bool,
 *     confirmButtonText?: string,
 *     denyButtonText?: string,
 *     cancelButtonText?: string,
 *     confirmButtonColor?: string,
 *     denyButtonColor?: string,
 *     cancelButtonColor?: string,
 *     confirmButtonAriaLabel?: string,
 *     denyButtonAriaLabel?: string,
 *     cancelButtonAriaLabel?: string,
 *     buttonsStyling?: bool,
 *     reverseButtons?: bool,
 *     focusConfirm?: bool,
 *     focusDeny?: bool,
 *     focusCancel?: bool,
 *     showCloseButton?: bool,
 *     closeButtonHtml?: string,
 *     closeButtonAriaLabel?: string,
 *     loaderHtml?: string,
 *     showLoaderOnConfirm?: bool,
 *     scrollbarPadding?: bool,
 *     preConfirm?: bool|string,
 *     preDeny?: string,
 *     returnInputValueOnDeny?: bool,
 *     animation?: bool,
 *     imageUrl?: string,
 *     imageWidth?: int,
 *     imageHeight?: int,
 *     imageAlt?: string,
 *     inputLabel?: string,
 *     inputPlaceholder?: string,
 *     inputValue?: string,
 *     inputOptions?: string,
 *     inputAutoTrim?: bool,
 *     inputAttributes?: string,
 *     inputValidator?: string,
 *     validationMessage?: string,
 * }
 */
final class SweetAlertBuilder extends NotificationBuilder
{
    /**
     * @phpstan-param NotificationType $type
     */
    public function type(string $type): static
    {
        return parent::type($type);
    }

    /**
     * @phpstan-param OptionsType $options
     */
    public function success(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::success($message, $options, $title);
    }

    /**
     * @phpstan-param OptionsType $options
     */
    public function error(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::error($message, $options, $title);
    }

    /**
     * @phpstan-param OptionsType $options
     */
    public function info(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::info($message, $options, $title);
    }

    /**
     * @phpstan-param OptionsType $options
     */
    public function warning(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::warning($message, $options, $title);
    }

    /**
     * @phpstan-param NotificationType|null $type
     * @phpstan-param OptionsType $options
     */
    public function flash(?string $type = null, ?string $message = null, array $options = [], ?string $title = null): Envelope
    {
        return parent::flash($type, $message, $options, $title);
    }

    /**
     * @phpstan-param OptionsType $options
     */
    public function options(array $options, bool $append = true): static
    {
        return parent::options($options, $append);
    }

    /**
     * @template T of OptionsType
     * @template K of key-of<T>
     *
     * @phpstan-param K $name
     * @phpstan-param T[K] $value
     */
    public function option(string $name, mixed $value): static
    {
        return parent::option($name, $value);
    }

    /**
     * @phpstan-param array<string, mixed> $options
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

    public function title(string $title): static
    {
        parent::title($title);

        $this->option('title', $title);

        return $this;
    }

    public function titleText(string $text): self
    {
        $this->option('titleText', $text);

        return $this;
    }

    public function html(string $html): self
    {
        $this->option('html', $html);

        return $this;
    }

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

    public function icon(string $icon): self
    {
        $this->option('icon', $icon);

        return $this;
    }

    public function iconColor(string $color): self
    {
        $this->option('iconColor', $color);

        return $this;
    }

    public function iconHtml(string $html): self
    {
        $this->option('iconHtml', $html);

        return $this;
    }

    public function showClass(string $showClass, string $value): self
    {
        $option = $this->getEnvelope()->getOption('showClass', []);
        $option[$showClass] = $value; // @phpstan-ignore-line

        $this->option('showClass', $option);

        return $this;
    }

    public function hideClass(string $hideClass, string $value): self
    {
        $option = $this->getEnvelope()->getOption('hideClass', []);
        $option[$hideClass] = $value; // @phpstan-ignore-line

        $this->option('hideClass', $option);

        return $this;
    }

    public function footer(string $footer): self
    {
        $this->option('footer', $footer);

        return $this;
    }

    public function backdrop(bool|string $backdrop = true): self
    {
        $this->option('backdrop', $backdrop);

        return $this;
    }

    /**
     * @param 'top'|'top-start'|'top-end'|'center'|'center-start'|'center-end'|'bottom'|'bottom-start'|'bottom-end' $position
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

    public function target(string $target): self
    {
        $this->option('target', $target);

        return $this;
    }

    /**
     * @phpstan-param OptionsType['input'] $input
     */
    public function input(string $input): self
    {
        $this->option('input', $input);

        return $this;
    }

    public function width(string $width): self
    {
        $this->option('width', $width);

        return $this;
    }

    public function padding(string $padding): self
    {
        $this->option('padding', $padding);

        return $this;
    }

    public function background(string $background): self
    {
        $this->option('background', $background);

        return $this;
    }

    /**
     * @phpstan-param OptionsType['position'] $position
     */
    public function position(string $position): self
    {
        $this->option('position', $position);

        return $this;
    }

    /**
     * @phpstan-param "column"|"fullscreen"|"row"|false $grow
     */
    public function grow(string|false $grow): self
    {
        $this->option('grow', $grow);

        return $this;
    }

    /**
     * @phpstan-param CustomClassType $customClass
     */
    public function customClass(string $customClass, string $value): self
    {
        /** @var OptionsType['customClass'] $option */
        $option = $this->getEnvelope()->getOption('customClass', []);
        $option[$customClass] = $value;

        $this->option('customClass', $option);

        return $this;
    }

    public function timer(int $timer): self
    {
        $this->option('timer', $timer);

        return $this;
    }

    public function timerProgressBar(bool $timerProgressBar = true): self
    {
        $this->option('timerProgressBar', $timerProgressBar);

        return $this;
    }

    public function heightAuto(bool $heightAuto = true): self
    {
        $this->option('heightAuto', $heightAuto);

        return $this;
    }

    public function allowOutsideClick(bool|string $allowOutsideClick = true): self
    {
        $this->option('allowOutsideClick', $allowOutsideClick);

        return $this;
    }

    public function allowEscapeKey(bool|string $allowEscapeKey = true): self
    {
        $this->option('allowEscapeKey', $allowEscapeKey);

        return $this;
    }

    public function allowEnterKey(bool|string $allowEnterKey = true): self
    {
        $this->option('allowEnterKey', $allowEnterKey);

        return $this;
    }

    public function stopKeydownPropagation(bool $stop = true): self
    {
        $this->option('stopKeydownPropagation', $stop);

        return $this;
    }

    public function keydownListenerCapture(bool $capture = true): self
    {
        $this->option('keydownListenerCapture', $capture);

        return $this;
    }

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

    public function confirmButtonColor(string $confirmButtonColor): self
    {
        $this->option('confirmButtonColor', $confirmButtonColor);

        return $this;
    }

    public function denyButtonColor(string $denyButtonColor): self
    {
        $this->option('denyButtonColor', $denyButtonColor);

        return $this;
    }

    public function cancelButtonColor(string $cancelButtonColor): self
    {
        $this->option('cancelButtonColor', $cancelButtonColor);

        return $this;
    }

    public function confirmButtonAriaLabel(string $label): self
    {
        $this->option('confirmButtonAriaLabel', $label);

        return $this;
    }

    public function denyButtonAriaLabel(string $denyButtonAriaLabel): self
    {
        $this->option('denyButtonAriaLabel', $denyButtonAriaLabel);

        return $this;
    }

    public function cancelButtonAriaLabel(string $label): self
    {
        $this->option('cancelButtonAriaLabel', $label);

        return $this;
    }

    public function buttonsStyling(bool $buttonsStyling = true): self
    {
        $this->option('buttonsStyling', $buttonsStyling);

        return $this;
    }

    public function reverseButtons(bool $reverseButtons = true): self
    {
        $this->option('reverseButtons', $reverseButtons);

        return $this;
    }

    public function focusConfirm(bool $focusConfirm = true): self
    {
        $this->option('focusConfirm', $focusConfirm);

        return $this;
    }

    public function focusDeny(bool $focusDeny = true): self
    {
        $this->option('focusDeny', $focusDeny);

        return $this;
    }

    public function focusCancel(bool $focusCancel = true): self
    {
        $this->option('focusCancel', $focusCancel);

        return $this;
    }

    public function showCloseButton(bool $showCloseButton = true): self
    {
        $this->option('showCloseButton', $showCloseButton);

        return $this;
    }

    public function closeButtonHtml(string $closeButtonHtml): self
    {
        $this->option('closeButtonHtml', $closeButtonHtml);

        return $this;
    }

    public function closeButtonAriaLabel(string $closeButtonAriaLabel): self
    {
        $this->option('closeButtonAriaLabel', $closeButtonAriaLabel);

        return $this;
    }

    public function loaderHtml(string $loaderHtml): self
    {
        $this->option('loaderHtml', $loaderHtml);

        return $this;
    }

    public function showLoaderOnConfirm(bool $showLoaderOnConfirm = true): self
    {
        $this->option('showLoaderOnConfirm', $showLoaderOnConfirm);

        return $this;
    }

    public function scrollbarPadding(bool $scrollbarPadding = true): self
    {
        $this->option('scrollbarPadding', $scrollbarPadding);

        return $this;
    }

    public function preConfirm(bool|string $preConfirm): self
    {
        $this->option('preConfirm', $preConfirm);

        return $this;
    }

    public function preDeny(string $preDeny): self
    {
        $this->option('preDeny', $preDeny);

        return $this;
    }

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

    public function imageWidth(int $imageWidth): self
    {
        $this->option('imageWidth', $imageWidth);

        return $this;
    }

    public function imageHeight(int $imageHeight): self
    {
        $this->option('imageHeight', $imageHeight);

        return $this;
    }

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

    public function addImage(string $title, string $text, string $imageUrl, int $imageWidth = 400, int $imageHeight = 200, ?string $imageAlt = null): Envelope
    {
        $this->image($title, $text, $imageUrl, $imageWidth, $imageHeight, $imageAlt);

        return $this->push();
    }

    public function inputLabel(string $inputLabel): self
    {
        $this->option('inputLabel', $inputLabel);

        return $this;
    }

    public function inputPlaceholder(string $inputPlaceholder): self
    {
        $this->option('inputPlaceholder', $inputPlaceholder);

        return $this;
    }

    public function inputValue(string $inputValue): self
    {
        $this->option('inputValue', $inputValue);

        return $this;
    }

    public function inputOptions(string $inputOptions): self
    {
        $this->option('inputOptions', $inputOptions);

        return $this;
    }

    public function inputAutoTrim(bool $inputAutoTrim = true): self
    {
        $this->option('inputAutoTrim', $inputAutoTrim);

        return $this;
    }

    public function inputAttributes(string $inputAttributes): self
    {
        $this->option('inputAttributes', $inputAttributes);

        return $this;
    }

    public function inputValidator(string $inputValidator): self
    {
        $this->option('inputValidator', $inputValidator);

        return $this;
    }

    public function validationMessage(string $validationMessage): self
    {
        $this->option('validationMessage', $validationMessage);

        return $this;
    }
}
