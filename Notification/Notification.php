<?php

namespace Flasher\Prime\Notification;

class Notification implements NotificationInterface
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $type = self::TYPE_SUCCESS;

    /**
     * @var array<string, mixed>
     */
    protected $options = array();

    /**
     * @param string|null $message
     * @param string|null $type
     * @param array       $options
     */
    public function __construct($message = null, $type = self::TYPE_SUCCESS, array $options = array())
    {
        $this->message = $message;
        $this->type    = $type;
        $this->options = $options;
    }

    /**
     * @inheritDoc
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @inheritDoc
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @inheritDoc
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @inheritDoc
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @inheritDoc
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @inheritDoc
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * @inheritDoc
     */
    public function getOption($name, $default = null)
    {
        if (!isset($this->options[$name])) {
            return $default;
        }

        return $this->options[$name];
    }

    /**
     * @inheritDoc
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     * @inheritDoc
     */
    public function unsetOption($name)
    {
        unset($this->options[$name]);
    }
}
