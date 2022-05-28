<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Notification;

class Notification implements NotificationInterface
{
    /**
     * @var string|null
     */
    protected $message;

    /**
     * @var string|null
     */
    protected $type;

    /**
     * @var array<string, mixed>
     */
    protected $options = array();

    /**
     * @var string|null
     */
    private $title;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * {@inheritdoc}
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(array $options)
    {
        $this->options = array_replace($this->options, $options);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOption($name, $default = null)
    {
        if (!isset($this->options[$name])) {
            return $default;
        }

        return $this->options[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function unsetOption($name)
    {
        unset($this->options[$name]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return array(
            'type' => $this->getType(),
            'message' => $this->getMessage(),
            'title' => $this->getTitle(),
            'options' => $this->getOptions(),
        );
    }
}
