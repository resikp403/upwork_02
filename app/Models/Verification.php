<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    protected $guarded = [
        'id',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

//    0 => Pending
//    1 => Sent
//    2 => Completed
//    3 => Canceled

//    0 => Phone
//    1 => E-mail
}
