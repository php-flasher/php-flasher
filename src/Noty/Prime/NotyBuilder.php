<?php

declare(strict_types=1);

namespace Flasher\Noty\Prime;

use Flasher\Prime\Notification\NotificationBuilder;

final class NotyBuilder extends NotificationBuilder
{
    /**
     * This string can contain HTML too. But be careful and don't pass user inputs to this parameter.
     */
    public function text(string $text): self
    {
        return $this->message($text);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function alert(?string $message = null, ?string $title = null, array $options = []): self
    {
        $this->type('alert');

        if ($message) {
            $this->message($message);
        }

        if ($title) {
            $this->title($title);
        }

        if ([] !== $options) {
            $this->options($options);
        }

        return $this;
    }

    /**
     * @param "top"|"topLeft"|"topCenter"|"topRight"|"center"|"centerLeft"|"centerRight"|"bottom"|"bottomLeft"|"bottomCenter"|"bottomRight" $layout
     *
     * - ClassName generator uses this value → noty_layout__${layout}
     */
    public function layout(string $layout): self
    {
        $this->option('layout', $layout);

        return $this;
    }

    /**
     * @param "relax"|"mint"|"metroui" $theme
     *
     * ClassName generator uses this value → noty_theme__${theme}
     */
    public function theme(string $theme): self
    {
        $this->option('theme', $theme);

        return $this;
    }

    /**
     * false, 1000, 3000, 3500, etc. Delay for closing event in milliseconds (ms). Set 'false' for sticky notifications.
     */
    public function timeout(bool|int $timeout): self
    {
        $this->option('timeout', $timeout);

        return $this;
    }

    /**
     * true, false - Displays a progress bar if timeout is not false.
     */
    public function progressBar(bool $progressBar = false): self
    {
        $this->option('progressBar', $progressBar);

        return $this;
    }

    /**
     * click, button.
     *
     * @param string|string[] $closeWith
     */
    public function closeWith(string|array $closeWith): self
    {
        $this->option('closeWith', (array) $closeWith);

        return $this;
    }

    /**
     * @param "open"|"close"                                  $animation
     * @param "noty_effects_open"|"noty_effects_close"|string $effect
     *
     * If string, assumed to be CSS class name. If null, no animation at all. If function, runs the function. (v3.0.1+)
     * You can use animate.css class names or your custom css animations as well.
     */
    public function animation(string $animation, string $effect): self
    {
        $this->option('animation.'.$animation, $effect);

        return $this;
    }

    /**
     * @param "sources"|"volume"|"conditions" $option
     */
    public function sounds(string $option, mixed $value): self
    {
        $this->option('sounds.'.$option, $value);

        return $this;
    }

    /**
     * @param "conditions"|string $option
     */
    public function docTitle(string $option, string $docTitle): self
    {
        $this->option('docTitle'.$option, $docTitle);

        return $this;
    }

    public function modal(bool $modal = true): self
    {
        $this->option('modal', $modal);

        return $this;
    }

    /**
     * You can use this id with querySelectors. Generated automatically if false.
     */
    public function id(bool|string $id): self
    {
        $this->option('id', $id);

        return $this;
    }

    /**
     * DOM insert method depends on this parameter. If false uses append, if true uses prepend.
     */
    public function force(bool $force = true): self
    {
        $this->option('force', $force);

        return $this;
    }

    public function queue(string $queue): self
    {
        $this->option('queue', $queue);

        return $this;
    }

    /**
     * If true closes all visible notifications and shows itself. If string(queueName) closes all visible notification
     * on this queue and shows itself.
     */
    public function killer(bool|string $killer): self
    {
        $this->option('killer', $killer);

        return $this;
    }

    /**
     * Custom container selector string. Like '.my-custom-container'. Layout parameter will be ignored.
     */
    public function container(bool|string $container): self
    {
        $this->option('container', $container);

        return $this;
    }

    /**
     * An array of Noty.button, for creating confirmation dialogs.
     *
     * @param string[] $buttons
     */
    public function buttons(array $buttons): self
    {
        $this->option('buttons', $buttons);

        return $this;
    }

    /**
     * If true Noty uses PageVisibility API to handle timeout. To ensure that users do not miss their notifications.
     */
    public function visibilityControl(bool $visibilityControl): self
    {
        $this->option('visibilityControl', $visibilityControl);

        return $this;
    }
}
