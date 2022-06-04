<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Laravel\Component;

use Flasher\Prime\FlasherInterface;
use Illuminate\View\Component;

class FlasherComponent extends Component
{
    /**
     * @var array<string, mixed>
     */
    public $criteria;

    /**
     * @var array<string, mixed>
     */
    public $context;

    /**
     * @var FlasherInterface
     */
    private $flasher;

    /**
     * @param array<string, mixed> $criteria
     * @param array<string, mixed> $context
     */
    public function __construct(FlasherInterface $flasher, $criteria = null, $context = null)
    {
        $this->flasher = $flasher;
        $this->criteria = $criteria;
        $this->context = $context;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $criteria = json_decode($this->criteria, true) ?: array();
        $context = json_decode($this->context, true) ?: array();

        return $this->flasher->render($criteria, 'html', $context);
    }
}
