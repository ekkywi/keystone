<?php

namespace App\Http\Controllers\Infrastructure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stack;
use App\Models\StackVariable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StackController extends Controller
{
    public function index()
    {
        $stacks = Stack::latest()->paginate(10);
        return view('stacks.index', compact('stacks'));
    }

    public function create()
    {
        return view('stacks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'raw_compose_template' => 'required|string',
            'vars' => 'nullable|array',
            'vars.*.label' => 'required|string',
            'vars.*.env_key' => 'required|string|regex:/^[A-Z0-9_]+$/',
            'vars.*.type' => 'required|in:text,number,boolean,select,secret',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $stack = Stack::create([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'description' => $request->description,
                    'type' => $request->type,
                    'raw_compose_template' => $request->raw_compose_template,
                    'is_active' => true
                ]);

                if ($request->has('vars')) {
                    foreach ($request->vars as $var) {
                        $stack->variables()->create([
                            'label' => $var['label'],
                            'env_key' => $var['env_key'],
                            'type' => $var['type'],
                            'default_value' => $var['default_value'] ?? null,
                            'is_required' => true
                        ]);
                    }
                }
            });

            return redirect()->route('stacks.index')->with('success', 'Master stack created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating stack: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Stack $stack)
    {
        $stack->load('variables');
        return view('stacks.edit', compact('stack'));
    }

    public function update(Request $request, Stack $stack)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'raw_compose_template' => 'required|string',
            'vars' => 'nullable|array',
            'vars.*.label' => 'required|string',
            'vars.*.env_key' => 'required|string|regex:/^[A-Z0-9_]+$/',
            'vars.*.type' => 'required|in:text,number,boolean,select,secret',
        ]);

        try {
            DB::transaction(function () use ($request, $stack) {
                $stack->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'description' => $request->description,
                    'type' => $request->type,
                    'raw_compose_template' => $request->raw_compose_template,
                ]);

                $stack->variables()->delete();

                if ($request->has('vars')) {
                    foreach ($request->vars as $var) {
                        $stack->variables()->create([
                            'label' => $var['label'],
                            'env_key' => $var['env_key'],
                            'type' => $var['type'],
                            'default_value' => $var['default_value'] ?? null,
                            'is_required' => true
                        ]);
                    }
                }
            });

            return redirect()->route('stacks.index')->with('success', 'Master stack updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating stack: ' . $e->getMessage())->withInput();
        }
    }
}
