<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'modules' => 'nullable|array',
            'modules.*.title' => 'required_with:modules|string|max:255',
            'modules.*.contents' => 'nullable|array',
            'modules.*.contents.*.title' => 'required_with:modules.*.contents|string|max:255',
            'modules.*.contents.*.type' => 'required_with:modules.*.contents|string|in:text,image,video,link',
        ]);

        DB::beginTransaction();
        try {
            $course = Course::create([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'category' => $validated['category'] ?? null,
            ]);

            if (!empty($validated['modules'])) {
                foreach ($validated['modules'] as $mIndex => $mData) {
                    $module = Module::create([
                        'course_id' => $course->id,
                        'title' => $mData['title'],
                        'position' => $mIndex,
                    ]);

                    if (!empty($mData['contents'])) {
                        foreach ($mData['contents'] as $cIndex => $cData) {
                            Content::create([
                                'module_id' => $module->id,
                                'type' => $cData['type'] ?? 'text',
                                'title' => $cData['title'] ?? null,
                                'body' => $cData['body'] ?? null,
                                'media_url' => $cData['media_url'] ?? null,
                                'position' => $cIndex,
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('courses.create')->with('success', 'Course created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to save course: ' . $e->getMessage()]);
        }
    }
}
