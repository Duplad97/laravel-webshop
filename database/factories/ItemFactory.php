<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Storage;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->paragraph(5, true),
            'price' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 100),
            'image_url' => $this->faker->image(Storage::path('public') . '/images', 200, 200, 'food', false)
        ];
    }
}
