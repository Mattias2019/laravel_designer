<?php
namespace shopist\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  protected $table = 'roles';
  
  public function users()
  {
    return $this->belongsToMany('shopist\Models\User');
  }
}
