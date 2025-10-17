<?php

namespace App\Http\Controllers;

use App\Models\Diary;
use App\Models\Direction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DiaryController extends Controller
{

    public function index()
    {
        $diaries = Diary::with('user')->latest()->paginate(10);
        return view('diary.index', compact('diaries'));
    }

    public function create()
    {
        return view('diary.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'difficulty' => ['required', Rule::in(['easy','medium','hard'])],
            'make_time' => 'nullable|string|max:50',
            'ingredients' => 'required|string',
            'note' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
            'directions' => 'required|array|min:1',
            'directions.*' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('diaries', 'public');
        }

        $data['user_id'] = Auth::id();
        $diary = Diary::create($data);

        // store directions
        foreach ($data['directions'] as $i => $desc) {
            $diary->directions()->create([
                'step_number' => $i + 1,
                'description' => $desc,
            ]);
        }

        return redirect()->route('diary.show', $diary)->with('success','Diary entry created.');
    }

    public function show($id)
    {
        // Eager load both directions and user
        $diary = Diary::with(['directions', 'user'])->findOrFail($id);

        return view('diary.show', compact('diary'));
    }


    // public function edit(Diary $diary)
    // {
    //     $this->authorize('update', $diary); // create policy or skip
    //     $diary->load('directions');
    //     return view('diary.edit', compact('diary'));
    // }

    public function update(Request $request, Diary $diary)
    {
        $this->authorize('update', $diary);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'difficulty' => ['required', Rule::in(['easy','medium','hard'])],
            'make_time' => 'nullable|string|max:50',
            'ingredients' => 'required|string',
            'note' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
            'directions' => 'required|array|min:1',
            'directions.*' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('diaries', 'public');
        }

        $diary->update($data);

        // replace directions: delete existing and re-create
        $diary->directions()->delete();
        foreach ($data['directions'] as $i => $desc) {
            $diary->directions()->create([
                'step_number' => $i + 1,
                'description' => $desc,
            ]);
        }

        return redirect()->route('diary.show', $diary)->with('success','Diary updated.');
    }

    public function destroy(Diary $diary)
    {
        $this->authorize('delete', $diary);
        $diary->delete();
        return redirect()->route('diary.index')->with('success','Diary removed.');
    }
}
