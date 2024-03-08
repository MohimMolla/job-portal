<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use App\Models\Qualification;
use App\Models\State;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $jobs = Job::latest()->withCount('applications')->with([
      'user:users.id,name',
      'category:categories.id,name'
    ])->get();
    return view('admin.jobs.index', compact('jobs'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $locations = State::with(['city' => function ($query) {
      $query->select(['state_id', 'id', 'name']);
    }])->get(['id', 'name']);

    $qualifications = Qualification::all(['id', 'name']);

    $categories = Category::all(['id', 'name']);
    $skills = Skill::all(['id', 'name']);

    return view('admin.jobs.create', compact('categories', 'locations', 'qualifications', 'skills'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //return $request;

    $request->validate([
      'title' => 'required|string|between:5, 255',
      'category' => 'required|integer',
      'company_name' => 'required|string',
      'type' => 'required|integer',
      'location' => 'required|integer',
      'qualification' => 'required|array',
      'hiring' => 'required|array',
      'deadline' => 'nullable|date',
      'monthly_salary_min' => 'required|integer',
      'monthly_salary_max' => 'required|integer',
      'year_passing_from' => 'nullable|integer',
      'year_passing_to' => 'nullable|integer',
      'experience_from' => 'nullable|integer',
      'experience_to' => 'nullable|integer',
      'skills' => 'nullable|array',
      'gender' => 'nullable|integer',
      'description' => 'required|string|between:100, 5000',
      'description_ql' => 'required|string'
    ]);

    $newJob = new Job();
    $newJob->title = $request->title;
    $newJob->company_name = $request->company_name;
    $newJob->slug = Str::slug($request->title . '__' . $request->company_name);
    $newJob->category_id = $request->category;
    $newJob->user_id = auth()->id();
    $newJob->type = $request->type;
    $newJob->city_id = $request->location;
    $newJob->description = $request->description;
    $newJob->description_ql = $request->description_ql;
    $newJob->deadline = $request->deadline ?? null;
    $newJob->hiring = json_encode($request->hiring);
    $newJob->monthly_salary_min = $request->monthly_salary_min;
    $newJob->monthly_salary_max = $request->monthly_salary_max;

    if (!empty($request->year_passing_from)) {
      $newJob->year_passing_from = $request->year_passing_from;
    }
    if (!empty($request->year_passing_to)) {
      $newJob->year_passing_to = $request->year_passing_to;
    }
    if (!empty($request->experience_from)) {
      $newJob->experience_from = $request->experience_from;
    }
    if (!empty($request->experience_to)) {
      $newJob->experience_to = $request->experience_to;
    }
    if (!empty($request->gender)) {
      $newJob->gender = $request->gender;
    }

    $newJob->save();

    if (!empty($request->skills)) {
      $skills = $request->skills;
      $newskill = [];
      foreach ($skills as $skill) {
        $skillobj = Skill::where('id', '=', $skill)->first();
        if (empty($skillobj)) {
          $updated_skill = Skill::create([
            'name' => $skill
          ]);
          $newskill[] = $updated_skill->id;
        } else {
          array_push($newskill, intval($skill));
        }
      }

      $newJob->skills()->sync($newskill);
    }

    $newJob->qualifications()->sync($request->qualification);

    return redirect()->route('admin.jobs.index')->with(['success' => 'Job created']);
  }

  /**
   * Display the specified resource.
   *
   * @param \App\Models\Job $job
   * @return \Illuminate\Http\Response
   */
  public function show(Job $job)
  {
    return view('admin.jobs.show', compact('job'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param \App\Models\Job $job
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $job = Job::where('id', $id)->with(['skills:id,name', 'qualifications:id'])->first();
    $qualification_ids = $job->qualifications->pluck('id')->toArray();
    $skill_ids = $job->skills->pluck('id')->toArray();

    $locations = State::with('city:cities.state_id,name,id')->get(['id', 'name']);

    $qualifications = Qualification::all(['id', 'name']);

    $categories = Category::all(['id', 'name']);

    $skills = Skill::all(['id', 'name']);

    return view('admin.jobs.edit', compact('job', 'skills', 'qualification_ids', 'skill_ids', 'categories', 'locations', 'qualifications'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Job $job
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Job $job)
  {
    // return $request;
    $request->validate([
      'title' => 'required|string|between:5, 255',
      'category' => 'required|integer',
      'company_name' => 'required|string',
      'type' => 'required|integer',
      'location' => 'required|integer',
      'qualification' => 'required|array',
      'hiring' => 'required|array',
      'deadline' => 'nullable|date',
      'monthly_salary_min' => 'required|integer',
      'monthly_salary_max' => 'required|integer',
      'year_passing_from' => 'nullable|integer',
      'year_passing_to' => 'nullable|integer',
      'experience_from' => 'nullable|integer',
      'experience_to' => 'nullable|integer',
      'skills' => 'nullable|array',
      'gender' => 'nullable|integer',
      'description' => 'required|string|between:100, 5000',
      'description_ql' => 'required|string'
    ]);

    $job->title = $request->title;
    $job->company_name = $request->company_name;
    $job->slug = Str::slug($request->title . '__' . $request->company_name);
    $job->category_id = $request->category;
    $job->user_id = auth()->id();
    $job->type = $request->type;
    $job->city_id = $request->location;
    $job->description = $request->description;
    $job->description_ql = $request->description_ql;
    $job->deadline = $request->deadline ?? null;
    $job->hiring = json_encode($request->hiring);
    $job->monthly_salary_min = $request->monthly_salary_min;
    $job->monthly_salary_max = $request->monthly_salary_max;

    if (!empty($request->year_passing_from)) {
      $job->year_passing_from = $request->year_passing_from;
    }
    if (!empty($request->year_passing_to)) {
      $job->year_passing_to = $request->year_passing_to;
    }
    if (!empty($request->experience_from)) {
      $job->experience_from = $request->experience_from;
    }
    if (!empty($request->experience_to)) {
      $job->experience_to = $request->experience_to;
    }
    if (!empty($request->gender)) {
      $job->gender = $request->gender;
    }

    $job->save();

    if (!empty($request->skills)) {
      $skills = $request->skills;
      $newskill = [];
      foreach ($skills as $skill) {
        $skillobj = Skill::where('id', '=', $skill)->first();
        if (empty($skillobj)) {
          $updated_skill = Skill::create([
            'name' => $skill
          ]);
          $newskill[] = $updated_skill->id;
        } else {
          array_push($newskill, intval($skill));
        }
      }

      $job->skills()->sync($newskill);
    }

    $job->qualifications()->sync($request->qualification);

    return redirect()->route('admin.jobs.index')->with(['success' => 'Job updated']);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param \App\Models\Job $job
   * @return \Illuminate\Http\Response
   */
  public function destroy(Job $job)
  {
    $job->delete();

    return redirect()->route('admin.jobs.index')->with('success', 'Job Deleted');
  }

  public function toggleStatus(Job $job)
  {

    $msg = "";
    if ($job->status) {
      $job->status = 0;
      $msg = "Job deactivated";
    } else {
      $job->status = 1;
      $msg = "Job activated";
    }

    $job->save();

    return redirect()->back()->with('success', $msg);
  }
}
