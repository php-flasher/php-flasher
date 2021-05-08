<?php
    switch ($envelope->getType()) {
        case 'success':
            $title = 'Success';
            $alertClass = 'alert-success';
            $progressBackgroundColor = '#155724';
            break;
        case 'error':
            $title = 'Error';
            $alertClass = 'alert-danger';
            $progressBackgroundColor = '#721c24';
            break;
        case 'warning':
            $title = 'Warning';
            $alertClass = 'alert-warning';
            $progressBackgroundColor = '#856404';
            break;
        case 'info':
        default:
            $title = 'Info';
            $alertClass = 'alert-info';
            $progressBackgroundColor = '#0c5460';
            break;
    }
?>

<div style="margin-top: 0.5rem;cursor: pointer;">
    <div class="alert <?= $alertClass ?> alert-dismissible fade in show" role="alert" style="border-top-left-radius: 0;border-bottom-left-radius: 0;border: unset;border-left: 6px solid <?= $progressBackgroundColor ?>">
        <strong><?= $title ?></strong>
        <?= $envelope->getMessage() ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="this.parentElement.remove()">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="d-flex" style="height: .125rem;margin-top: -1rem;">
        <span class="flasher-progress" style="background-color: <?= $progressBackgroundColor ?>"></span>
    </div>
</div>
