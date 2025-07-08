<?php

namespace App\Core\Notification;

enum NotifyStatus: string
{
    case SUCCESS = 'success';
    case PENDING = 'pending';
    case AWAIT = 'await';
    case TIMEOUT = 'timeout';
    case FAIL = 'fail';
    case UNHANDLED_ERROR = 'error';
}
