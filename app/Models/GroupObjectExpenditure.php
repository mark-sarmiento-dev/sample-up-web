<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupObjectExpenditure extends Model
{
    use SoftDeletes;

    protected $fillable = ['group_name'];

    public function objectExpenditures()
    {
        return $this->hasMany(ObjectExpenditure::class, 'group_id');
    }
}