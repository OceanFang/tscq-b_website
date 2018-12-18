<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'admin/manage',
        'admin/del',
        'admin/lock-modify',
        'admin/group/destroy',
        'login',

        'tool/imageUpload/act',
        'tool/upload/delParent',
        'tool/upload/delSub',

    ];
}
