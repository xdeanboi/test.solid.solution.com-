<?php

return [
    '~^$~' => [\Test\Controllers\MainController::class, 'main'],
    '~^add$~' => [\Test\Controllers\MainController::class, 'firstAdd'],
    '~^add/(\d+)$~' => [\Test\Controllers\MainController::class, 'add'],
    '~^delete/(\d+)$~' => [\Test\Controllers\MainController::class, 'delete'],
];