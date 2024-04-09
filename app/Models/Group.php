<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // Ensure this is included for the base Model
use Botble\Member\Models\Member;

class Group extends Model // Ensure correct spelling and case for "extends"
{
    protected $table = 'groups'; // This is optional if your table name follows Laravel's naming convention

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description' // Added 'description' to the fillable attributes
    ];

    /**
     * The members that belong to the group.
     */
    public function members()
    {
        return $this->belongsToMany(Member::class);
    }
}
