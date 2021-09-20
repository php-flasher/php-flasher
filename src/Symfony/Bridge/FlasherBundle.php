<?php

namespace Flasher\Symfony\Bridge;

if (Bridge::isLegacy()) {
    class_alias('Flasher\Symfony\Bridge\Legacy\FlasherBundle', 'Flasher\Symfony\Bridge\FlasherBundle');
} else {
    class_alias('Flasher\Symfony\Bridge\Typed\FlasherBundle', 'Flasher\Symfony\Bridge\FlasherBundle');
}

if (false) {
    abstract class FlasherBundle {}
}
