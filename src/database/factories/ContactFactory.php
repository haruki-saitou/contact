<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => $this->faker->numberBetween(1, 5), // 1〜5のIDをランダムに選択
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'gender' => $this->faker->numberBetween(1, 3), // 1:男性, 2:女性, 3:その他
            'email' => $this->faker->unique()->safeEmail,
            'tel' => $this->faker->phoneNumber, // DB保存時には tel1+tel2+tel3 の形式になっている想定
            'address' => $this->faker->address,
            'building' => $this->faker->secondaryAddress, // 建物名として適当なデータ
            'detail' => $this->faker->realText(100), // 100文字程度のランダムなテキスト
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
