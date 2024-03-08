<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      "country_id", "name", "status",
  ];

  public $timestamps = false;

  public function country()
  {
    return $this->belongsTo('App\Models\Country');
  }

  public function city()
  {
    return $this->hasMany('App\Models\City');
  }

  public function getCityNameAndId()
  {
    return $this->hasMany('App\Models\City')->select(['id', 'name']);
  }
}
