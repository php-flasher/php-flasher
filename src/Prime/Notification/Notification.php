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
    protected $type = self::TYPE_INFO;

    /**
     * @var array<string, mixed>
     */
    protected $options = array();

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

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array(
            'type'    => $this->getType(),
            'message' => $this->getMessage(),
            'options' => $this->getOptions(),
        );
    }
}
