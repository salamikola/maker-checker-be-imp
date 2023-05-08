<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MakerCheckerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'checkable_type' => User::class,
            'checkable_id' => null,
            'request_type' => 'create-user',
            'request_data' => json_encode(['first_name'=>$this->faker->name,'last_name'=>$this->faker->name,'email'=>$this->faker->email]),
            'status'=>'pending',
            'maker_id' => 1
        ];
    }
}
