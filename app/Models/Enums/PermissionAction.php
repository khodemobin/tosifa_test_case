<?php

namespace App\Models\Enums;

enum PermissionAction: int
{
    case CREATE = 1;
    case UPDATE = 2;
    case VIEW = 3;
    case DELETE = 4;
}
