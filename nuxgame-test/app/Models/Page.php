<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property string $route
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $expires_at
 * @property Carbon $deleted_at
 * @property BelongsTo|User $user
 * @mixin Builder //It resolves problem of non-indicating QB methods, such as where(), join() etc.
 * @link https://stackoverflow.com/a/48298989
 */
#[Fillable(['user_id', 'route', 'expires_at', 'deleted_at', 'created_at', 'updated_at'])]
class Page extends Model
{
    use SoftDeletes;

    protected $table = 'pages';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
