<?php

namespace Modules\Admin\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\factories\OfficeExpenseFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficeExpense extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'expense_type',
        'expense_amount',
        'expense_detail',
        'remark',
    ];
    
    protected static function newFactory(): OfficeExpenseFactory
    {
        //return OfficeExpenseFactory::new();
    }

    public function category()
    {
        return $this->belongsTo('Modules\Admin\app\Models\Category', 'expense_type')->select('id','name');
    }
}
