<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function index()
    {
        $categoryCollection = Category::all();
//        return response()->json(["data" => CategoryResource::collection($categoryCollection)]);
        return view('categories', ['categories' => $categoryCollection]);
    }

    public function showEditForm(Category $category)
    {
        return view('category_edit', ['category' => $category]);
    }

    public function create()
    {
    }

    public function showProductCreateForm(Category $category)
    {
        $categories = Category::all();

        return view('product_create', [
            'categories' => $categories,
            'category_id' => $category->id
        ]);
    }

    public function store(Request $request)
    {
        $categoryValidator = validator(request()->all(), [
            "name" => "required|string|max:15|regex:/^[А-ЯЁа-яё\s\-]+$/u",
            "description" => "nullable|string|max:50|regex:/^[А-ЯЁа-яё\s\-.,:;]+$/u",
        ]);

        if ($categoryValidator->fails()) return back()->withInput()->withErrors($categoryValidator->errors());

        Category::create($categoryValidator->validated());

        return back();
    }

    public function showDetails(Category $category)
    {
        $categoryProducts = $category->products()->get();

        return view('category_details', [
            'category' => $category,
            'products' => $categoryProducts,
        ]);
    }

    public function edit(Category $category)
    {
    }

    public function update(Request $request, Category $category)
    {
        $categoryValidator = validator(request()->all(), [
            "name" => "required|string|max:15|regex:/^[А-ЯЁа-яё\s\-]+$/u",
            "description" => "nullable|string|max:50|regex:/^[А-ЯЁа-яё\s\-.,:;]+$/u",
        ]);

        if ($categoryValidator->fails()) return back()->withInput()->withErrors($categoryValidator->errors());

        $category->update($categoryValidator->validated());

        return redirect('/admin/categories')->with('success', '');
    }


    public function destroy(Category $category)
    {
        foreach ($category->products as $product) {
            foreach ($product->images as $productImage) {
                if (file_exists(public_path($productImage->path))) {
                    unlink(public_path($productImage->path));
                }
                $productImage->delete();
            }

            if (file_exists(public_path($product->default_img))) {
                unlink(public_path($product->default_img));
            }

            $product->delete();
        }

        $category->delete();

        return redirect('/admin/categories');
    }
}
