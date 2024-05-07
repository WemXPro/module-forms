<?php

namespace Modules\Forms\Entities;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table = 'module_forms';

    protected $fillable = [
        'name',
        'title',
        'description',
        'slug',
        'notification_email',
        'max_submissions',
        'max_submissions_per_user',
        'recaptcha',
        'guest',
        'can_view_submission',
        'can_respond',
        'active',
    ];

    public function fields()
    {
        return $this->hasMany(FormField::class);
    }
}
