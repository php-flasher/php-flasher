<?php

namespace  {
    exit("This file should not be included, only analyzed by your IDE");
}

namespace Flasher\Prime\Notification {
    interface NotificationBuilderInterface {
        public function livewire(array $context = []): self;
    }
}

namespace Flasher\SweetAlert\Prime {
    class SweetAlertFactory {
        public function livewire(array $context = []): self { }
    }
}

namespace Flasher\Toastr\Prime {
    class ToastrFactory {
        public function livewire(array $context = []): self { }
    }
}

namespace Flasher\Noty\Prime {
    class NotyFactory {
        public function livewire(array $context = []): self { }
    }
}

namespace Flasher\Notyf\Prime {
    class NotyfFactory {
        public function livewire(array $context = []): self { }
    }
}

namespace Flasher\Pnotify\Prime {
    class PnotifyFactory {
        public function livewire(array $context = []): self { }
    }
}
