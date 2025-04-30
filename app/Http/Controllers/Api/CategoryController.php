<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Lista wszystkich kategorii",
     *     tags={"Categories"},
     *     @OA\Response(
     *         response=200,
     *         description="Zwraca listę kategorii",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     )
     * )
     */
    public function index()
    {
        return Category::with('products')->get();
    }

    /**
     * @OA\Post(
     *      path="/api/categories",
     *      summary="Dodanie kategorii",
     *      tags={"Categories"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Alergologia")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Kategoria utworzona",
     *         @OA\Schema(ref="#/components/schemas/Category")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories',
        ]);

        return Category::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/categories/{id}",
     *     summary="Pobranie pojedyńczej kategorii",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Zwraca szukaną kategorię",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Brak szukanej kategorii",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     ), 
     * )
     */
    public function show(Category $category)
    {
        return $category->load('products');
    }

    /**
     * @OA\Put(
     *     path="/api/categories/{id}",
     *     summary="Zaktualizowanie pojedyńczej kategorii",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Alergologia")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Aktualizacja powiodła się",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     )
     * )
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|unique:categories,name,' . $category->id,
        ]);

        $category->update($validated);
        return $category;
    }

    /**
     * @OA\Delete(
     *     path="/api/categories/{id}",
     *     summary="Usunięcie pojedyńczej kategorii",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usunięto kategorię",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     * )
     */
    public function destroy(Category $category)
    {
        $category->products()->detach();
        $category->delete();

        return response()->noContent();
    }

    /**
     * @OA\Get(
     *     path="/api/categories/{id}/products",
     *     summary="Lista wszystkich produktów dla danej kategorii",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ) ,
     *     @OA\Response(
     *         response=200,
     *         description="Zwraca listę produktów",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Brak produktów dla danej kategorii",
     *     ),
     * )
     */
    public function products($id)
    {
        $category = Category::with('products')->findOrFail($id);

        return response()->json($category->products);
    }
    
}
