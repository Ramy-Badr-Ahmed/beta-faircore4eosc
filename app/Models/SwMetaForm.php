<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\SwMetaForm
 *
 * @property int $id
 * @property string|null $codeMetaJson
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SwMetaForm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SwMetaForm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SwMetaForm query()
 * @method static \Illuminate\Database\Eloquent\Builder|SwMetaForm whereCodeMetaJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SwMetaForm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SwMetaForm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SwMetaForm whereUpdatedAt($value)
 * @property int|null $createdBy_id
 * @property-read \App\Models\User|null $createdBy
 * @method static \Illuminate\Database\Eloquent\Builder|SwMetaForm whereCreatedById($value)
 * @mixin \Eloquent
 */
class SwMetaForm extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'codeMetaJSON' => 'array',
    ];

    const CREATION_META_PROPERTIES = [
        'codeMetaJson'
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'createdBy_id');
    }

    public function add2DB($codeMeta): void
    {
        foreach(self::CREATION_META_PROPERTIES as $property) {
            $this->{$property} = $codeMeta;
        }
        $this->createdBy_id = Auth::user()->id;
        $this->save();
    }

}
