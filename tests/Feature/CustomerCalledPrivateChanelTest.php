<?php

use App\Events\CustomerQueueCalled;
use App\Models\User;
use Illuminate\Support\Facades\Event;

it('broadcasts private event to a specific user', function () {
    Event::fake();

    $user = User::factory()->create();
    $queueNumber = 99;

    $this->actingAs($user, 'customer');

    broadcast(new CustomerQueueCalled($queueNumber, $user->id));

    Event::assertDispatched(CustomerQueueCalled::class, function ($event) use ($user, $queueNumber) {
        return $event->queueNumber === $queueNumber
            && $event->userId === $user->id;
    });
});
