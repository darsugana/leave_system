<?php

/**
 * Created by PhpStorm.
 * User: developer
 * Date: 14/09/2015
 * Time: 22:49
 */

namespace App\Models\Support;

class LeaveDuration
{
    public static function getDurations()
    {
        return [
            'full day' => 'Full day',
            'half day' => 'Half day',
        ];
    }
}
