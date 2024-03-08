<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
  public function search(Request $request)
  {
    $term = $request->term; {
      $data = Skill::where('name', 'LIKE', "%{$term}%")->limit(6)->get(['id as value', 'name as tag']);

      return response()->json([
        'suggestions' => $data
      ]);
    }
  }

  public function index()
  {
    return view('admin.skills.index');
  }

  public function paginate(Request $request)
  {
    return $request->ajax() ? Skill::latest()->paginate(10) : abort(404);
  }

  public function store(Request $request)
  {
    $request->validate([
        'name' => 'required|string|unique:skills|max:255',
        'description' => 'nullable|string'
    ]);

    $skill = new Skill();
    $skill->name = $request->name;
    $skill->description = $request->description;
    $skill->save();

    return response()->json(['success' =>true, 'message' => 'Category created']);
  }

  public function show(Skill $skill)
  {
    return response()->json($skill);
  }

  public function update(Request $request, Skill $skill)
  {
    $request->validate([
      'name' => 'required|string|unique:skills,name,' . $skill->id . '|max:255',
      'description' => 'nullable|string'
    ]);

    $skill->name = $request->name;
    $skill->description = $request->description;
    $skill->save();

    return response()->json(['success' => true, 'message' => 'Skill updated']);
  }

  public function destroy(Skill $skill)
  {
    if(auth()->user()->hasRole('superadmin')) {
      $skill->delete();
      return response()->json(['message' => 'Category deleted', 'success' => true]);
    }
    else {
      return response()->json(['success' => false, 'message' => 'You are not allowed to access this page'], 403);
    }
  }
}
