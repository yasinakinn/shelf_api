<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $addHttpCookie = true;

   protected $except = [
    'user/login',
    'user/register',
    'user/delete',
    'user/updatePassword',
    'user/updateName',
    'user/updateClearance',
    'shelves',
    'shelf/add',
    'shelf/update',
    'shelf/delete',
];
}
