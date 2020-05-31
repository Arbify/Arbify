<?php

return [
    // Middleware to be used for FilePond routes.
    'middleware' => [
        \Illuminate\Cookie\Middleware\EncryptCookies::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ],
    // Directory where FilePond uploaded files will be temporarily stored.
    'upload_temporary_dir' => realpath(sys_get_temp_dir()),
];
