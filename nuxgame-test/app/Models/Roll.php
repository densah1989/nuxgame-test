<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @property int $id
 * @property int $user_id
 * @property int $number
 * @property Carbon $created_at
 * @property BelongsTo $user
 * @mixin Builder //It resolves problem of non-indicating QB methods, such as where(), join() etc.
 * @link https://stackoverflow.com/a/48298989
 */
#[Fillable(['user_id', 'number', 'created_at'])]
class Roll extends Model
{
    protected $table = 'rolls';

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
