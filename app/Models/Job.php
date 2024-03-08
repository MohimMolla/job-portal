<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
  use HasFactory;

  const FULL_TIME = 1;
  const PART_TIME = 2;
  const CONTRACT = 3;
  const INTERNSHIP = 4;
  const OFFICE = 5;

  const FACE_TO_FACE = 1;
  const WRITTEN_TEST = 2;
  const TELEPHONIC = 3;
  const GROUP_DISCUSSION = 4;
  const WALK_IN = 5;

  const MALE = 1;
  const FEMALE = 2;
  const BOTH = 3;

  public function category()
  {
    return $this->belongsTo('App\Models\Category');
  }
  public function user()
  {
    return $this->belongsTo('App\Models\User');
  }

  public function qualifications()
  {
    return $this->belongsToMany('App\Models\Qualification');
  }

  public function skills()
  {
    return $this->belongsToMany('App\Models\Skill');
  }

  public function city()
  {
    return $this->belongsTo('App\Models\City');
  }

  public function applications()
  {
    return $this->hasMany('App\Models\Application');
  }

  public function scopeActive($query)
  {
    return $query->whereStatus(true);
  }
}
