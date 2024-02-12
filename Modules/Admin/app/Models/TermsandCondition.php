<?php

namespace Modules\Admin\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\factories\TermsandConditionFactory;

class TermsandCondition extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected $table = "terms_and_conditions";
    
    protected static function newFactory(): TermsandConditionFactory
    {
        //return TermsandConditionFactory::new();
    }

    protected $casts = [
        'id' => 'string',
    ];
}
