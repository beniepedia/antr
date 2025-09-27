<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ConfirmDialog extends Component
{
    public string $title;

    public string $message;

    public string $method;

    public string $confirmText;

    public function __construct(
        $title = 'Konfirmasi',
        $message = 'Apakah Anda yakin?',
        $method = 'delete',
        $confirmText = 'Ya'
    ) {
        $this->title = $title;
        $this->message = $message;
        $this->method = $method;
        $this->confirmText = $confirmText;
    }

    public function render()
    {
        return view('components.confirm-dialog');
    }
}
