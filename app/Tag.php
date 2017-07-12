<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Tag extends Model
{
    use CrudTrait;
    protected $table = 'tags';
    protected $fillable = ['name'];
	  public $timestamps = true;

    /*public function articles()
    {
        return $this->hasMany('App\Models\Article', 'article_tag');
    }*/
}
