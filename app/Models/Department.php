<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'department_code',
        'department_name',
    ];

    /**
     * A department can have many employees.
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
