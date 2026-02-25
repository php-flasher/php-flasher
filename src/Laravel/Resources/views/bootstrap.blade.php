@php
    use Flasher\Prime\Notification\Envelope;

    /** @var Envelope $envelope */

    $type = $envelope->getType();
    $message = $envelope->getMessage();

    $alertClass = match($type) {
        'success' => 'alert-success',
        'error' => 'alert-danger',
        'warning' => 'alert-warning',
        default => 'alert-info',
    };

    $progressBgColor = match($type) {
        'success' => '#155724',
        'error' => '#721c24',
        'warning' => '#856404',
        default => '#0c5460',
    };
@endphp

<div style="margin-top: 0.5rem;cursor: pointer;">
    <div class="alert {{ $alertClass }} alert-dismissible fade in show" role="alert" style="border-top-left-radius: 0;border-bottom-left-radius: 0;border: unset;border-left: 6px solid {{ $progressBgColor }}">
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="this.parentElement.remove()">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="d-flex" style="height: .125rem;margin-top: -1rem;">
        <span class="flasher-progress" style="background-color: {{ $progressBgColor }}"></span>
    </div>
</div>
