<?php

namespace Modules\Forms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;

class Message extends Model
{
    protected $table = 'module_forms_submissions_messages';

    protected $fillable = [
        'submission_id',
        'user_id',
        'guest_email',
        'ip_address',
        'user_agent',
        'message',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
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

