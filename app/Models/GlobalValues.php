<?php

/**
 * @Author: Ramy-Badr-Ahmed
 * @Desc: SWH API Client
 * @Repo: https://github.com/Ramy-Badr-Ahmed/beta-faircore4eosc
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GlobalValues
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalValues newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalValues newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalValues query()
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalValues whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalValues whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalValues whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalValues whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalValues whereValue($value)
 * @mixin \Eloquent
 */
class GlobalValues extends Model
{
    use HasFactory;

}
