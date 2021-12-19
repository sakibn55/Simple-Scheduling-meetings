<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReminderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'slug' => $this->faker->slug(),
            'description'=>$this->faker->paragraph(),
            'location_title'=>$this->faker->title(),
            'lattitude'=>$this->faker->latitude(),
            'longitude'=>$this->faker->longitude(),
            'status'=>$this->faker->boolean(),
            'range'=>$this->faker->randomNumber,
            'start'=>$this->faker->dateTime(),
            'end'=>$this->faker->dateTime(),
            'repeat_mode'=>$this->faker->boolean(),
        ];
    }
}
