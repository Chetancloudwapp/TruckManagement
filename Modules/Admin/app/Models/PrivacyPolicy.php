<?php

namespace Modules\Admin\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\factories\PrivacyPolicyFactory;

class PrivacyPolicy extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): PrivacyPolicyFactory
    {
        //return PrivacyPolicyFactory::new();
    }

    protected $casts = [
        'id' => 'string',
    ];
}
