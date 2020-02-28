<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'due_date', 'title', 'info',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'due_date' => 'date',
    ];

    public function invitees()
    {
        return $this->belongsToMany(User::class, 'appointments_users', 'appointment_id', 'user_id')
            ->withTimestamps()->withPivot('visited_at', 'status');
    }
}
