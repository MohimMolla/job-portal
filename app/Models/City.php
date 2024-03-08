<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      "country_id", "state_id", "name", "status",
  ];

  public function getthis()
  {
    return $this->name;
  }

  public function country()
  {
    return $this->belongsTo('App\Models\Country');
  }
  public function state()
  {
    return $this->belongsTo('App\Models\State');
  }

  public $timestamps = false;
}
