<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
  use HasFactory;
  protected $guarded = [];

  public function job()
  {
    return $this->belongsTo('App\Models\Job');
  }

  public function user() {
    return $this->belongsTo('App\Models\User');
  }
}
