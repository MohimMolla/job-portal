<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  public function index()
  {
    $jobCount = Job::active()->count();
    $applicationsCount = Application::count();
    $userRole = Role::withCount('users')->whereName('user')->first();
    $superAdminRole = Role::withCount('users')->whereName(['superadmin'])->first();
    $adminRole = Role::withCount('users')->whereName(['admin'])->first();
    $userCount = $userRole->users_count;
    $superAdminCount = $superAdminRole->users_count;
    $adminCount = $adminRole->users_count;
    $adminCount += $superAdminCount;
    return view('admin.index', compact('jobCount', 'applicationsCount', 'userCount', 'adminCount'));
  }
}
