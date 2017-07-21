<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facebook extends Model
{
  /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
  protected $fillable = [
      'user_id', 'nick_name', 'name', 'email','avatar','token','refresh_token','expires_in',
  ];
}
