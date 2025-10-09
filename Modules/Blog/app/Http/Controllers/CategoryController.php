<?php

namespace Modules\Blog\Http\Controllers;

use App\Enum\Pagination;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Blog\Models\BlogCategory;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = BlogCategory::query()->paginate(Pagination::PAG->value);
        return view('blog::category.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog::category.create');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('blog::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('blog::category.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}
}
