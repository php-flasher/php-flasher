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

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    public function getOption($name, $default = null)
    {
        if (!isset($this->options[$name])) {
            return $default;
        }

        return $this->options[$name];
    }

    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    public function unsetOption($name)
    {
        unset($this->options[$name]);
    }

    public function toArray()
    {
        return array(
            'type' => $this->getType(),
            'message' => $this->getMessage(),
            'options' => $this->getOptions(),
        );
    }
}
