<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function listPage()
    {
        $paginatedProducts = Product::query()->paginate(5);

        return view('products', ['products' => $paginatedProducts]);
    }

    public function listByCategoryApi(Category $category)
    {
        $categoryProducts = $category->products()->get();
        return response()->json(["data" => ProductResource::collection($categoryProducts)]);
    }

    public function create($category_id = null)
    {
    }

    private function storeResizedImage($productId, $uploadedImage)
    {
        $imageExtension = $uploadedImage->getClientOriginalExtension();

        if($imageExtension === "png") $processedImage = imagecreatefrompng($uploadedImage);
        else $processedImage = imagecreatefromjpeg($uploadedImage);

        $thumbnailSize = 300;
        $sourceWidth = imagesx($processedImage);
        $sourceHeight = imagesy($processedImage);

        $resizeRatio = min($sourceWidth / $thumbnailSize, $sourceHeight / $thumbnailSize);
        $targetWidth = (int)($resizeRatio * $sourceWidth);
        $targetHeight = (int)($resizeRatio * $sourceHeight);

        $thumbnailImage = imagecreatetruecolor($targetWidth, $targetHeight);

        imagecopyresized($thumbnailImage, $processedImage, 0, 0, 0, 0, $targetWidth, $targetHeight, $sourceWidth, $sourceHeight);

        $watermarkColor = imagecolorallocate($thumbnailImage, 255, 0, 0);

        imagettftext($thumbnailImage, 15, 0, $targetWidth - 60 ,$targetHeight - 10, $watermarkColor, public_path('assets/fonts/arial.ttf'), 'Shop');

        $imagePath = "images/" . Str::uuid() . '.' . $imageExtension;
        if($imageExtension === "png") imagepng($thumbnailImage, public_path($imagePath));
        else imagejpeg($thumbnailImage, public_path($imagePath));

        ProductImage::create([
            "product_id" => $productId,
            "path" => $imagePath
        ]);
    }

    public function store(Request $request)
    {
        $productValidator = validator($request->all(), [
            "name" => "required|max:20",
            "description" => "nullable|max:50",
            "price" => "required|numeric|min:10",
            "category_id" => "required",
            "images" => "required|array|min:1",
            "images.*" => "image|mimes:jpeg,png,jpg|max:3584",
        ]);

        if ($productValidator->fails()) {
            return back()->withInput()->withErrors($productValidator->errors());
        }

        $images = $request->file('images');
        $defaultImageFile = $images[0];

        $imageExtension = $defaultImageFile->getClientOriginalExtension();

        if($imageExtension === "png") $processedImage = imagecreatefrompng($defaultImageFile);
        else $processedImage = imagecreatefromjpeg($defaultImageFile);

        $thumbnailSize = 300;
        $sourceWidth = imagesx($processedImage);
        $sourceHeight = imagesy($processedImage);

        $resizeRatio = min($sourceWidth / $thumbnailSize, $sourceHeight / $thumbnailSize);
        $targetWidth = (int)($resizeRatio * $sourceWidth);
        $targetHeight = (int)($resizeRatio * $sourceHeight);

        $thumbnailImage = imagecreatetruecolor($targetWidth, $targetHeight);
        imagecopyresized($thumbnailImage, $processedImage, 0, 0, 0, 0, $targetWidth, $targetHeight, $sourceWidth, $sourceHeight);

        $watermarkColor = imagecolorallocate($thumbnailImage, 255, 0, 0);
        imagettftext($thumbnailImage, 15, 0, $targetWidth - 60, $targetHeight - 10, $watermarkColor, public_path('assets/fonts/arial.ttf'), 'Shop');

        $defaultImagePath = "images/" . \Illuminate\Support\Str::uuid() . '.' . $imageExtension;

        if($imageExtension === "png") imagepng($thumbnailImage, public_path($defaultImagePath));
        else imagejpeg($thumbnailImage, public_path($defaultImagePath));

        $createdProduct = Product::create([
            "name" => $request->name,
            "description" => $request->description,
            "price" => $request->price,
            "category_id" => $request->category_id,
            "default_img" => $defaultImagePath
        ]);

        foreach ($images as $key => $img) {
            if ($key === 0) continue;
            if ($key > 4) break;

            $this->storeResizedImage($createdProduct->id, $img);
        }

        return redirect("/admin/categories/$request->category_id");
    }

    public function showApi(Product $product)
    {
        return response()->json(["data" => ProductResource::make($product)]);
    }

    public function showDetails(Product $product)
    {
        $product->load('category');

        return view('product_details', ['product' => $product]);
    }

    public function edit(Product $product)
    {
    }

    public function showEditForm(Product $product)
    {
        $categories = Category::all();
        return view('product_edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $productValidator = validator($request->all(), [
            "name" => "required|max:20",
            "description" => "nullable|max:50",
            "price" => "required|numeric|min:10",
            "default_img" => "nullable|image|mimes:jpeg,png,jpg|max:3584",
            "img2" => "nullable|image|mimes:jpeg,png,jpg|max:3584",
            "img3" => "nullable|image|mimes:jpeg,png,jpg|max:3584",
            "img4" => "nullable|image|mimes:jpeg,png,jpg|max:3584",
            "img5" => "nullable|image|mimes:jpeg,png,jpg|max:3584",
        ]);

        if ($productValidator->fails()) return back()->withInput()->withErrors($productValidator->errors());

        $validatedPayload = $productValidator->safe();

        $defaultImageFile = $validatedPayload["default_img"];

        if($defaultImageFile)
        {
            $imageExtension = $defaultImageFile->getClientOriginalExtension();

            if($imageExtension === "png") $processedImage = imagecreatefrompng($defaultImageFile);
            else $processedImage = imagecreatefromjpeg($defaultImageFile);

            $thumbnailSize = 300;
            $sourceWidth = imagesx($processedImage);
            $sourceHeight = imagesy($processedImage);

            $resizeRatio = min($sourceWidth / $thumbnailSize, $sourceHeight / $thumbnailSize);
            $targetWidth = (int)($resizeRatio * $sourceWidth);
            $targetHeight = (int)($resizeRatio * $sourceHeight);

            $thumbnailImage = imagecreatetruecolor($targetWidth, $targetHeight);

            imagecopyresized($thumbnailImage, $processedImage, 0, 0, 0, 0, $targetWidth, $targetHeight, $sourceWidth, $sourceHeight);

            $watermarkColor = imagecolorallocate($thumbnailImage, 255, 0, 0);

            imagettftext($thumbnailImage, 15, 0, $targetWidth - 60 ,$targetHeight - 10, $watermarkColor, public_path('assets/fonts/arial.ttf'), 'Shop');

            $defaultImagePath = "images/" . Str::uuid() . '.' . $imageExtension;
            if($imageExtension === "png") imagepng($thumbnailImage, public_path($defaultImagePath));
            else imagejpeg($thumbnailImage, public_path($defaultImagePath));

            $validatedPayload['default_img'] = $defaultImagePath;
        }

        $product->update($validatedPayload->except("img2", "img3", "img4", "img5"));

        if($request->img1 || $request->img2 || $request->img3 || $request->img4 || $request->img5)
        {
            foreach ($product->images as $productImage)
            {
                unlink(public_path($productImage->path));
                $productImage->delete();
            }

            if($request->img2) $this->storeResizedImage($product->id, $request->img2);
            if($request->img3) $this->storeResizedImage($product->id, $request->img3);
            if($request->img4) $this->storeResizedImage($product->id, $request->img4);
            if($request->img5) $this->storeResizedImage($product->id, $request->img5);
        }

        return back();
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $productImage)
        {
            unlink(public_path($productImage->path));
            $productImage->delete();
        }

        unlink(public_path($product->default_img));

        $product->delete();

        return redirect()->back();
    }
}
