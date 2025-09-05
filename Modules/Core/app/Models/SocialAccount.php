<?php

namespace Modules\Core\app\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property User $user
 */
class SocialAccount extends Model
{

  /**
   * The attributes that are mass assignable.
   */
  protected $fillable = [
    'user_id',
    'provider',
    'provider_user_id',
    'token',
    'refresh_token',
    'expires_in'
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

}
