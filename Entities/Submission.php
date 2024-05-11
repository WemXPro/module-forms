<?php

namespace Modules\Forms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;

class Submission extends Model
{
    protected $table = 'module_forms_submissions';

    protected $fillable = [
        'form_id',
        'user_id',
        'token',
        'guest_email',
        'status',
        'data',
        'ip_address',
        'user_agent',
        'paid',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Set global scope to tenant
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->token = Str::uuid();
        });
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function email()
    {
        return $this->guest_email ?? $this->user->email;
    }
}

