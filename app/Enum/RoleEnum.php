<?php

namespace App\Enum;

enum RoleEnum: string
{
    case Admin = 'admin';
    case Manager = 'manager';
    case Cashier = 'cashier';
}
