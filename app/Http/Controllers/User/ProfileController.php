<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Skill;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $skills = Skill::all(['id', 'name as text']);
    $locations = City::all(['id', 'name as text']);
    return view('user.profile.index', compact('skills', 'locations'));
  }

  public function showProfile(Request $request)
  {
    $user = User::whereId(auth()->id())->with('profile')->first();
    return response()->json($user);
    if ($request->ajax()) {
    } else {
      abort(404);
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    abort(404);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // return $request;
    $this->validate($request, [
      'name' => 'required|string',
      'about' => 'nullable|string',
      'cv' => ['nullable', 'file', 'mimes:jpeg,pdf,docx,doc,jpg', 'max:1024'], // 1MB
      //'image' => 'nullable|file|mimes:|max:1024', // 1MB
      'image' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,bmp', 'max:1024'], // 1MB
      'job_type' => 'nullable|integer',
      'jobrole' => 'nullable|string',
      'phone' => 'nullable|string',
      'location' => 'nullable|string',
      'skills' => 'nullable|string',
      'education' => 'nullable|string',
      'experience' => 'nullable|integer',
    ]);

    $user = User::whereId(auth()->id())->first();
    $profile = $user->profile;

    $image = $request->file('image');
    // $allowed_extensions = ['jpeg', 'jpg', 'png', 'gif'];

    if ($image) {
      // make the unique name for the image
      $currentDate = Carbon::now()->toDateString();
      $imageName = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

      if (!Storage::disk('public')->exists('avatar')) {
        Storage::disk('public')->makeDirectory('avatar');
      }

      // delete the old avatar image
      // delete old avatar image
      if (Storage::disk('public')->exists('avatar/' . $profile->image)) {
        Storage::disk('public')->delete('avatar/' . $profile->image);
      }

      // $imagePath = '/avatar/' . $imageName;
      // Storage::disk('public')->put($imageName, $image, 'avatar');
      $filepath = $image->storeAs('avatar', $imageName, 'public');
    } else {
      $imageName = $profile->image;
    }


    $cv = $request->file('cv');
    // $allowed_extensions = ['doc', 'docx', 'pdf', 'jpg', 'jpeg'];

    if ($cv) {
      // make the unique name for the image
      $currentDate = Carbon::now()->toDateString();
      $cvName = $currentDate . '-' . uniqid() . '.' . $cv->getClientOriginalExtension();

      if (!Storage::disk('public')->exists('cv')) {
        Storage::disk('public')->makeDirectory('cv');
      }

      // delete the old cv image
      // delete old cv image
      if (Storage::disk('public')->exists('cv/' . $profile->cv)) {
        Storage::disk('public')->delete('cv/' . $profile->cv);
      }

      $filepath = $cv->storeAs('cv', $cvName, 'public');
      // Storage::disk('public')->put('cv/' . $cvName, $cv);
    } else {
      $cvName = $profile->cv;
    }

    $user->name = $request->name;
    $user->update();

    $profile->jobrole = $request->jobrole;
    $profile->phone = $request->phone;
    $profile->image = $imageName;
    $profile->cv = $cvName;
    $profile->education = $request->education;
    $profile->location = json_encode(explode(',', $request->location));
    $profile->skills = json_encode(explode(',', $request->skills));
    $profile->job_type = $request->job_type;
    $profile->about = $request->about;
    $profile->experience = $request->experience;
    $profile->save();

    return response()->json(['success' => true, 'message' => 'Profile updated']);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    abort(404);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    abort(404);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    // return $request;
    abort(404);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    abort(404);
  }

  public function changePassword(Request $request)
  {
    if ($request->ajax()) {
      $request->validate([
        'password' => 'required|string|min:6|confirmed'
      ]);

      $id = auth()->id();
      $user = User::whereKey($id)->first();
      $user->password = bcrypt($request->password);
      $user->update();

      return response()->json(['success' => true, 'message' => "Password changed"]);
    }
  }
}
