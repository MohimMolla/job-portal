<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Job;
use App\Models\User;
use App\Models\Application;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FrontController extends Controller
{
  public function index()
  {
    //$jobColumns = ['id', 'title', 'type', 'city_id', 'deadline', 'monthly_salary_min', 'monthly_salary_max', 'created_at', 'gender', 'company_name', 'slug'];
    $jobs = Job::latest()->with([
      'applications:applications.job_id,user_id',
      'city:cities.id,name',
      'category:categories.id,name',
      'skills:id,name'
    ])->active()->paginate(10);

    if (Auth::check()) {
      if (Auth::user()->hasRole('user')) {
        return view('auth.landing', compact('jobs'));
      } else {
        return view('admin.landing');
      }
    } else {
      return view('landing');
    }
  }

  public function search(Request $request)
  {
    $city = $request->city;
    $title = $request->title;
    $skills = $request->skill;
    $term = strtolower($request->term);

    if ($title) {
      $jobs = Job::active()->latest()
        ->with([
          'applications:applications.job_id,user_id',
          'city:cities.id,name',
          'category:categories.id,name',
          'skills:id,name'
        ])
        ->where('title', 'like', $title . '%')
        ->orWhere('title', 'like', $term . '%')
        ->paginate(10);
    }

    if ($skills) {
      $jobs = Job::active()->latest()->with([
        'applications:applications.job_id,user_id',
        'city:cities.id,name',
        'category:categories.id,name',
        'skills:id,name'
      ])
        ->whereHas('skills', function ($query) use ($skills, $term) {
          $query->where('name', 'like', $skills . '%')
            ->orWhere('name', 'like', $term . '%');
        })
        ->paginate(10);
    }

    if ($city) {
      $jobs = Job::active()->latest()->with([
        'applications:applications.job_id,user_id',
        'city:cities.id,name',
        'category:categories.id,name',
        'skills:id,name'
      ])
        ->whereHas('city', function ($query) use ($city, $term) {
          $query->where('name', 'like', $city . '%')
            ->where('name', 'like', $term . '%');
        })
        ->paginate(10);
    }
    return view('auth.landing', compact('jobs'));
  }

  public function ajaxSearch(Request $request)
  {
    $title = $request->title;
    $skills = $request->skills;
    $city = $request->city;

    if ($title) {
      $title = strtolower($title);
      if (!$title) abort(404);
      $jobs = Job::active()->latest()->where('title', 'like', $title . '%')
        ->get(['title']);

      return $jobs;
    }

    if ($skills) {
      $skills = strtolower($skills);
      $jobs = Job::active()->latest()->with('skills:id,name')
        ->whereHas('skills', function ($query) use ($skills) {
          $query->where('name', 'like', $skills . '%');
        })
        ->get(['id']);

      // define an empty array
      $searches = [];

      // loop through all jobs
      foreach ($jobs as $job) {
        foreach ($job->skills as $skill) {
          $skill_name = $skill->name;
          $searches[] = strtolower($skill_name);
        }
      }

      $search_data = !empty($searches) ? array_unique($searches) : [];
      // return $search_data;
      if (!empty($search_data)) {
        $searches = [];
        foreach ($search_data as $data) {
          // echo strtolower($data) . "\n";
          if ($data[0] == $skills[0]) {
            $searches[] = Str::limit($data, 20);
          }
        }
      }

      return $searches;
    }

    if ($city) {
      $city = strtolower($request->city);
      $jobs = Job::active()->latest()->with(['city:cities.id,name'])
        ->whereHas('city', function ($query) use ($city) {
          $query->where('name', 'like', $city . '%');
        })
        ->limit(8)->get(['id', 'city_id']);

      // define an empty array
      $searches = [];

      // loop through all jobs
      foreach ($jobs as $job) {
        if (strpos(strtolower($job->city), $city)) {
          $searches[] = $job->city->name;
        }
      }

      $searches = !empty($searches) ? $searches : [];

      return $searches;
    }

    return [];
  }

  public function job(Job $job, Request $request)
  {
    $applicationUserIds = $job->applications->pluck('user_id')->toArray();
    $jobs = Job::active()->with(['applications:applications.job_id,user_id', 'city:cities.id,name', 'category:categories.id,name'])->latest()->paginate(10);
    // return $jobs;
    return view('job.show', compact('job', 'jobs', 'applicationUserIds'));
  }

  public function apply($job_id, User $user, Request $request)
  {

    $application = Application::where(['user_id' => $user->id, 'job_id' => $job_id])->first();

    if ($application) {
      return response()->json(['message' => 'You already applied for this job'], 403);
    }

    $this->validate($request, [
      'email' => ['required', 'email'],
      'phone' => ['required', 'string'],
      'resume' => ['nullable', 'file']
    ]);

    $profile = $user->profile;
    $resume = $request->file('resume');
    $allowed_extensions = ['doc', 'docx', 'pdf', 'jpg', 'jpeg'];

    if ($resume && in_array($resume->getClientOriginalExtension(), $allowed_extensions)) {
      // make the unique name for the image
      $currentDate = Carbon::now()->toDateString();
      $cvName = $currentDate . '-' . uniqid() . '.' . $resume->getClientOriginalExtension();

      if (!Storage::disk('public')->exists('cv')) {
        Storage::disk('public')->makeDirectory('cv');
      }

      if (!Storage::disk('public')->exists('resume')) {
        Storage::disk('public')->makeDirectory('resume');
      }

      // delete old cv
      if (Storage::disk('public')->exists('cv/' . $profile->cv)) {
        Storage::disk('public')->delete('cv/' . $profile->cv);
      }

      if (Storage::disk('public')->exists('resume/' . $profile->cv)) {
        Storage::disk('public')->delete('resume/' . $profile->cv);
      }

      $resume->storeAs('cv', $cvName, 'public');
      $resume->storeAs('resume', $cvName, 'public');
      // Storage::disk('public')->put('cv/' . $cvName, $cv);
    } else {
      $cvName = $profile->cv;
    }

    $profile->cv = $cvName;
    $profile->phone = $request->phone;
    $profile->save();

    $application = new Application();
    $application->user_id = $user->id;
    $application->job_id = $job_id;
    $application->email = $request->email;
    $application->phone = $request->phone;
    $application->resume = $cvName;
    $application->save();

    return response()->json(['success' => true, 'message' => 'Application saved']);
  }
}
