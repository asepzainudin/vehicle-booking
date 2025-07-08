<?php

return [
    'obscure' => [
        'enable' => (bool) env('KFN_VIEW_OBSCURE', false),
        'text' => env('KFN_VIEW_OBSCURE_TEXT', '*****'),
    ],
];
