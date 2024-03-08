<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function show(User $user) {
    $skills = Skill::all(['id', 'name']);
    $locations = City::all(['id', 'name']);
    return view('admin.user.show', compact('user', 'skills', 'locations'));
  }
}
