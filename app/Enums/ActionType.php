<?php

namespace App\Enums;

enum ActionType: string
{
    case READ = 'read';
    case WRITE = 'write';
    case LIST = 'list';
    case VIEW = 'view';
    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';
    case RESTORE = 'restore';
    case DISABLE = 'disable';
    case ENABLE = 'enable';
    case PRINT = 'print';
}
