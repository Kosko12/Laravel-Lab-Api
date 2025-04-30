<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Product",
 *     type="object",
 *     required={"name", "price", "delivery_days"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID produktu",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nazwa produktu",
 *         example="Badanie krwi"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="number",
 *         description="Cena produktu",
 *         example=199.99
 *     ),
 *     @OA\Property(
 *         property="delivery_days",
 *         type="integer",
 *         description="Czas realizacji w dniach",
 *         example=5
 *     ),
 *     @OA\Property(
 *         property="active",
 *         type="boolean",
 *         description="Dostępność produktu",
 *         example=true
 *     )
 * )
 */
class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'delivery_days',
        'active',
    ];
    
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
