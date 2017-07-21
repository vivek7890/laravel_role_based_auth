<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Twitter extends Model
{
  /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
  protected $fillable = [
      'user_id', 'nick_name', 'name', 'email','avatar','token','token_secret',
  ];
}
