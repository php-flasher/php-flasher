document.addEventListener('DOMContentLoaded', function() {
    const demoForm = document.getElementById('notification-demo-form');

    if (demoForm) {
        demoForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const type = document.getElementById('notification-type').value;
            const title = document.getElementById('notification-title').value;
            const message = document.getElementById('notification-message').value;
            const position = document.getElementById('notification-position').value;
            const timeout = document.getElementById('notification-timeout').value;

            // Use the PHPFlasher JavaScript API to show the notification
            window.flasher[type](message, {
                title: title,
                position: position,
                timeout: parseInt(timeout, 10)
            });
        });
    }
});
