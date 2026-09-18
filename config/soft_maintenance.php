<?php

return [
    'enabled' => env('SOFT_MAINTENANCE', 0),
    'retry_after' => env('SOFT_MAINTENANCE_RETRY', 60),
];
