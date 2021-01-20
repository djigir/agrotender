<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '*/admin_dev/adv_torg_posts/dependent-select/topic_id/*',
        '*/admin_dev/adv_torg_post_companies/dependent-select/topic_id/*',
    ];
}
