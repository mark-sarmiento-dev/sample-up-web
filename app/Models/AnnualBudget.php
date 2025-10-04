<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnnualBudget extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'year',
        'annual_budget',
    ];

    /**
     * Get the office code allocations for this annual budget.
     */
    public function officeCodeBudgets(): HasMany
    {
        return $this->hasMany(OfficeCodeBudget::class);
    }
}