<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      "name", "status",
  ];

  public $timestamps = false;

  public function state()
  {
    return $this->hasMany('App\Models\State');
  }

  public function city() {
    return $this->hasMany('App\Models\City');
  }
}
