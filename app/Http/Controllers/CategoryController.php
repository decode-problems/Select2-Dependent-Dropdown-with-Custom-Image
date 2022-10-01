<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        return response()->json(['success' => true, 'data' => $categories]);
    }

    public function show(Request $request, $id)
    {
        $services = Service::where('category_id', $id)->get();

        return response()->json(['success' => true, 'data' => $services]);
    }
}
