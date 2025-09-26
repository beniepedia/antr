<?php

namespace App\Enums;

enum PositionEnum: string
{
    case Operator = 'operator';
    case Supervisor = 'supervisor';
    case Manager = 'manager';

    public function label(): string
    {
        return match ($this) {
            self::Operator => 'Operator',
            self::Supervisor => 'Supervisor',
            self::Manager => 'Manager',
        };
    }

    public static function options(): array
    {
        return [
            self::Operator->value => self::Operator->label(),
            self::Supervisor->value => self::Supervisor->label(),
            self::Manager->value => self::Manager->label(),
        ];
    }
}
