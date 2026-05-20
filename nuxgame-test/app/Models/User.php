<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $username
 * @property string $phone_number
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property HasOne|Page $page
 * @property HasMany|Collection<Roll> $rolls
 * @mixin Builder //It resolves problem of non-indicating QB methods, such as where(), join() etc.
 * @link https://stackoverflow.com/a/48298989
 */
#[Fillable(['username', 'phone_number', 'created_at', 'updated_at'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'users';

    public function page(): HasOne
    {
        return $this->hasOne(Page::class);
    }

    public function rolls(): HasMany
    {
        return $this->hasMany(Roll::class);
    }
}
