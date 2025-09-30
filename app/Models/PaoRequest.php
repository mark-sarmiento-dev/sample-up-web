<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaoRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pao_requests';

    protected $fillable = [
        'office_code_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Department relationship
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * User who created this request
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Groups under this request
     */
    public function groups()
    {
        return $this->hasMany(PaoGroup::class, 'request_id');
    }
}
