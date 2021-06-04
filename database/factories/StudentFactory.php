<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->name,
            'age'=>$this->faker->numberBetween(3,100),
            'address'=>$this->faker->address,
            'percentage'=>$this->faker->numberBetween(0.0,100.0),
            'school' => $this->faker->randomElement(array('Pulkit','Ambika','DPS','Excellent'))
        ];
    }
}
