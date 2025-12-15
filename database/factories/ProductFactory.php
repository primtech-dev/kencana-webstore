<?php
// database/factories/ProductFactory.php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Nama dari model yang sesuai dengan factory.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Definisikan status default model.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sku' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{4}'), // Contoh: ABC1234
            'name' => $this->faker->words(3, true) . ' ' . $this->faker->colorName() . ' Edition',
            'short_description' => $this->faker->sentence(8),
            'description' => $this->faker->paragraphs(3, true),
            'attributes' => $this->getFakeAttributes(), // Fungsi untuk mendapatkan JSON acak
            'weight_gram' => $this->faker->numberBetween(100, 5000),
            'is_active' => $this->faker->boolean(90), // 90% aktif
        ];
    }

    /**
     * Membuat array asosiatif acak untuk kolom 'attributes'.
     *
     * @return array
     */
    protected function getFakeAttributes(): array
    {
        $attributes = [];
        $attributeNames = ['color', 'size', 'material', 'power_rating', 'warranty'];

        // Pilih 2 hingga 4 atribut untuk produk ini
        $selectedAttributes = $this->faker->randomElements($attributeNames, $this->faker->numberBetween(2, 4));

        foreach ($selectedAttributes as $name) {
            switch ($name) {
                case 'color':
                    $attributes[$name] = $this->faker->safeColorName();
                    break;
                case 'size':
                    $attributes[$name] = $this->faker->randomElement(['S', 'M', 'L', 'XL', 'One Size']);
                    break;
                case 'material':
                    $attributes[$name] = $this->faker->randomElement(['Cotton', 'Polyester', 'Leather', 'Aluminum']);
                    break;
                case 'power_rating':
                    $attributes[$name] = $this->faker->numberBetween(10, 100) . ' Watts';
                    break;
                case 'warranty':
                    $attributes[$name] = $this->faker->numberBetween(1, 5) . ' Year(s)';
                    break;
            }
        }

        return $attributes;
    }
}