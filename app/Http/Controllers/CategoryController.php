<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $categories = Category::query()
            ->when(\request('status'), function ($q) {
                $q->where('status', \request('status'));
            })->latest()->get();

        return Inertia::render('Category/Index', props: [
            'categories' => $categories,
            'categoryStatus' => ['active', 'inactive'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Category/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        Category::create($request->validated());

        return redirect(route('categories.index'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): Response
    {
        return Inertia::render('Category/Edit', props: [
            'category' => $category,
            'active' => 'active',
            'inactive' => 'inactive',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, Category $category): Application|Redirector|RedirectResponse
    {
        $category->update($request->validated());

        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): Application|Redirector|RedirectResponse
    {
        $category->delete();
        return redirect(route('categories.index'));
    }
}
