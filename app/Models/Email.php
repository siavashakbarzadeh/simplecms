<?php

namespace App\Models;

use Botble\Member\Models\Member;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable=[
        'user_id',
        'subject',
        'reply_to',
        'body',
        'mailer',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class);
    }
}
