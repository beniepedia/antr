<?php

namespace App\trait;

trait WithNotyf
{
    public function notyf(string $message, string $type = 'success')
    {
        $this->dispatch('notify', type: $type, message: $message);
    }
}
