<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    // Aapki table ka naam 'doctors' hai
    protected $table = 'doctors'; 

    // In columns ka fillable hona zaroori hai taake mass assignment chal sake
    protected $fillable = [
        'name',
        'specialization',
        'google_meet_link',
        'is_online',
        'hospital_id',
        'phone',
    ];

    /**
     * Doctor ki parent requests ke sath relation
     */
    public function parentRequests(): HasMany
    {
        return $this->hasMany(ParentRequest::class, 'doctor_id');
    }
}