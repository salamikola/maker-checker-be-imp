<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MakerChecker
 *
 * @property int $id
 * @property string $checkable_type
 * @property int $checkable_id
 * @property mixed|null $request_data
 * @property string $request_type
 * @property string $status
 * @property int $maker_id
 * @property int|null $checker_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MakerChecker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MakerChecker newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MakerChecker query()
 * @method static \Illuminate\Database\Eloquent\Builder|MakerChecker whereCheckableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakerChecker whereCheckableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakerChecker whereCheckerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakerChecker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakerChecker whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakerChecker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakerChecker whereMakerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakerChecker whereRequestData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakerChecker whereRequestType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakerChecker whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakerChecker whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MakerChecker extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $hidden = ['maker_id', 'checker_id', 'created_at', 'updated_at', 'deleted_at', 'checkable_type', 'checkable_id'];

    public function getRequestDataAttribute($value)
    {
        return json_decode($value, true);
    }
}
