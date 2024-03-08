<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [FrontController::class, 'index'])->name('welcome');
Route::get('/search', [FrontController::class, 'search'])
  ->name('search')
  ->middleware(['auth', 'role:user']);
Route::get('/ajax/search', [FrontController::class, 'ajaxSearch'])
  ->name('ajax.job.search');
Route::get('/job/{job:slug}', [FrontController::class, 'job'])
  ->name('job.view')
  ->middleware(['auth', 'role:user']);
Route::post('/job/appy/{id}/user/{user:id}', [FrontController::class, 'apply'])
  ->name('job.apply')
  ->middleware(['auth', 'role:user']);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group([
  'as' => 'admin.',
  'prefix' => 'admin',
  'namespace' => 'Admin',
  'middleware' => [
    'auth', 'role:superadmin|admin'
  ]
], function () {
  Route::get(
    '/',
    function () {
      return redirect()->route('admin.dashboard');
    }
  );
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

  Route::get('/categories/paginate', [CategoryController::class, 'paginate'])->name('categories.paginate');
  Route::resource('/categories', CategoryController::class);

  Route::get('/skills/paginate', [SkillController::class, 'paginate'])->name('skills.paginate');
  Route::resource('/skills', SkillController::class);
  Route::get('/skills/search', [SkillController::class, 'search'])->name('skills.search');

  Route::put('/jobs/toggle-status/{job}', [JobController::class, 'toggleStatus'])->name('jobs.toggle-status');
  Route::resource('/jobs', JobController::class);
  Route::get('/admin/users/show/{user}', [UserController::class, 'show'])
    ->name('user.show');
});

Route::group([
  'as' => 'user.',
  'prefix' => 'user',
  'namespace' => 'User',
  'middleware' => [
    'auth', 'role:user'
  ]
], function () {
  Route::get(
    '/',
    function () {
      return redirect()->route('user.dashboard');
    }
  );
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
  Route::get('/settings/profile/show-profile', [ProfileController::class, 'showProfile'])->name('profile.showProfile');
  Route::put('/settings/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
  Route::resource('/settings/profile', ProfileController::class);
});
