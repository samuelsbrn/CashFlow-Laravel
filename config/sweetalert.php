<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default SweetAlert session keys
    |--------------------------------------------------------------------------
    |
    | Nanti di controller kamu bisa:
    | return back()->with('success', 'Data berhasil disimpan.');
    | lalu di blade kamu cek config ini.
    |
    */

    'session_keys' => [
        'success' => 'success',
        'error'   => 'error',
        'warning' => 'warning',
        'info'    => 'info',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default timer (ms)
    |--------------------------------------------------------------------------
    */

    'timer' => 2000,

    /*
    |--------------------------------------------------------------------------
    | Show confirm button
    |--------------------------------------------------------------------------
    */

    'show_confirm_button' => false,

];
