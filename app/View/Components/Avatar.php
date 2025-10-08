<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Avatar extends Component
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function render()
    {
        return view('components.avatar');
    }

    public function color(): string
    {
        $colors = [
            'bg-red-400',
            'bg-orange-400',
            'bg-amber-400',
            'bg-lime-400',
            'bg-green-400',
            'bg-emerald-400',
            'bg-teal-400',
            'bg-cyan-400',
            'bg-sky-400',
            'bg-blue-400',
            'bg-indigo-400',
            'bg-violet-400',
            'bg-purple-400',
            'bg-fuchsia-400',
            'bg-pink-400',
            'bg-rose-400',
        ];

        $index = crc32($this->name) % count($colors);
        return $colors[$index];
    }

    public function initial(): string
    {
        return strtoupper(mb_substr($this->name, 0, 1));
    }
}
