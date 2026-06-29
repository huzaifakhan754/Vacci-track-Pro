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
