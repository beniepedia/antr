<?php

use App\Events\QueueCalled;
use Illuminate\Support\Facades\Event;

it('broadcasts queue called event', function () {
    Event::fake();

    broadcast(new QueueCalled(42));

    Event::assertDispatched(QueueCalled::class, function ($event) {
        return $event->queueNumber === 42;
    });
});
