<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParentRequest extends Model
{
    protected $table = 'parent_requests';

    protected $fillable = [
        'parent_id',
        'child_id',
        'hospital_id',
        'doctor_id', // 👈 1. Yahan doctor_id ko add kar diya taake form ka data save ho sake
        'vaccine_id',
        'vaccination_schedule_id',
        'preferred_date',
        'preferred_time',
        'message',
        'status',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'preferred_date' => 'date',
        ];
    }

    // 👈 2. Yeh Naya Relation add kiya jo doctor ka data load karega
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class);
    }

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }

    public function vaccine(): BelongsTo
    {
        return $this->belongsTo(Vaccine::class);
    }
}