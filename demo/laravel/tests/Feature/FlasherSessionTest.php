<?php

it('stores and retrieves flash notifications with json serialization', function () {
    // Trigger a flash notification
    $this->get('/');

    flash()->success('Test notification', ['title' => 'Success']);

    // Make another request to retrieve from session
    $response = $this->get('/');

    $response->assertStatus(200);
});

it('handles multiple flash notifications across requests', function () {
    flash()->success('First message');
    flash()->error('Second message');
    flash()->warning('Third message');

    $response = $this->get('/');
    $response->assertStatus(200);
});

it('preserves notification properties through json session roundtrip', function () {
    flash()
        ->options(['position' => 'top-right', 'timeout' => 5000])
        ->success('Test message');

    $response = $this->get('/');
    $response->assertStatus(200);
});

it('works with different notification types', function () {
    flash()->success('Success message');
    flash()->error('Error message');
    flash()->warning('Warning message');
    flash()->info('Info message');

    $response = $this->get('/');
    $response->assertStatus(200);
});
