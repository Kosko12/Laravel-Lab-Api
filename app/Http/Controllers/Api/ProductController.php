<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

class ProductController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Lista wszystkich produktów",
     *     tags={"Products"},
     *     @OA\Response(
     *         response=200,
     *         description="Zwraca listę produktów",
     *         @OA\Schema(ref="#/components/schemas/Product")
     *     )
     * )
     */
    public function index()
    {
        return Product::with('categories')->get();
    }

    /**
     * @OA\Post(
     *      path="/api/products",
     *      summary="Dodanie produktu",
     *      tags={"Products"},
     *     @OA\RequestBody(
     *         required=true,
     *              @OA\MediaType(
     *               mediaType="application/json",
     *               @OA\Schema(
     *                   schema="Product",
     *                   type="object",
     *                   @OA\Property(
     *                       property="name",
     *                       type="string",
     *                       description="Nazwa produktu",
     *                       example="Badanie krwi"
     *                   ),
     *                   @OA\Property(
     *                       property="price",
     *                       type="number",
     *                       description="Cena produktu",
     *                       example=199.99
     *                   ),
     *                   @OA\Property(
     *                       property="delivery_days",
     *                       type="integer",
     *                       description="Czas realizacji w dniach",
     *                       example=5
     *                   ),
     *                   @OA\Property(
     *                       property="active",
     *                       type="boolean",
     *                       description="Dostępność produktu",
     *                       example=true
     *                   )
     *               )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produkt utworzony",
     *         @OA\Schema(ref="#/components/schemas/Product")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'delivery_days' => 'required|numeric',
            'category_ids' => 'array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        $product = Product::create($validated);
        $product->categories()->sync($validated['category_ids'] ?? []);

        return response()->json($product->load('categories'), 201);
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Pobranie pojedyńczegp produktu",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Zwraca szukany produkt",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Brak szukanego produktu",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ), 
     * )
     */
    public function show(Product $product)
    {
        return $product->load('categories');
    }

     /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     summary="Zaktualizowanie pojedyńczego produktu",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *              @OA\MediaType(
     *               mediaType="application/json",
     *               @OA\Schema(
     *                   schema="Product",
     *                   type="object",
     *                   @OA\Property(
     *                       property="name",
     *                       type="string",
     *                       description="Nazwa produktu",
     *                       example="Badanie krwi"
     *                   ),
     *                   @OA\Property(
     *                       property="price",
     *                       type="number",
     *                       description="Cena produktu",
     *                       example=199.99
     *                   ),
     *                   @OA\Property(
     *                       property="delivery_days",
     *                       type="integer",
     *                       description="Czas realizacji w dniach",
     *                       example=5
     *                   ),
     *                   @OA\Property(
     *                       property="active",
     *                       type="boolean",
     *                       description="Dostępność produktu",
     *                       example=true
     *                   ),
     *                   @OA\Property(
     *                       property="category_ids",
     *                       type="array",
     *                       @OA\Items(type="number"),
     *                       example={1, 2}  
     *                   )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Aktualizacja produktu powiodła się",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Aktualizacja nie powiodła się, sprawdź poprawność danych"
     *     )
     * )
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'category_ids' => 'sometimes|array',
            'delivery_days' => 'sometimes|numeric',
            'category_ids.*' => 'exists:categories,id',
        ]);

        $product->update($validated);

        if (isset($validated['category_ids'])) {
            $product->categories()->sync($validated['category_ids']);
        }

        return response()->json($product->load('categories'));
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Usunięcie pojedyńczego produktu",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usunięto produkt",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     * )
     */
    public function destroy(Product $product)
    {
        $product->categories()->detach();
        $product->delete();

        return response()->noContent();
    }
}
