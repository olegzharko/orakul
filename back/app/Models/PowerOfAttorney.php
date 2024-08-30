<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PowerOfAttorney extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'trustor_id',
        'agent_id',
        'template_id',
        'document_number',
        'issue_date',
        'expiry_date',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'issue_date' => 'datetime',
        'expiry_date' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Получить шаблон доверенности
     *
     * @return BelongsTo
     */
    public function template()
    {
        return $this->belongsTo(PowerOfAttorneyTemplate::class, 'template_id');
    }

    /**
     * Получить данные о доверители
     *
     * @return BelongsTo
     */
    public function trustor()
    {
        return $this->belongsTo(Client::class, 'trustor_id');
    }

    /**
     * Получить данные о доверенном лице
     *
     * @return BelongsTo
     */
    public function agent()
    {
        return $this->belongsTo(Client::class, 'agent_id');
    }

    /**
     * Получить данные о предмете доверенности
     *
     * @return HasOne
     */
    public function general_car(): HasOne
    {
        return $this->hasOne(PowerOfAttorneyGeneralCar::class, 'power_of_attorney_id', 'id');
    }
}
