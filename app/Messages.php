<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
  /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
  protected $fillable = [
      'from_name', 'message','from_email',
  ];
}
