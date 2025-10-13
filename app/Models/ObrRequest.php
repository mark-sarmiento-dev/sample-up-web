<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ObrRequest extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'obr_request';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'request_id',
        'obr_no',
        'office_address',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Get the PAO request that owns this OBR.
     */
    public function paoRequest(): BelongsTo
    {
        // Assuming PaoRequest model exists and is correctly named
        return $this->belongsTo(PaoRequest::class, 'request_id');
    }

    /**
     * Get the expenditure objects associated with this OBR.
     */
    public function obrObjects(): HasMany
    {
        return $this->hasMany(ObrObject::class, 'obr_id');
    }
}