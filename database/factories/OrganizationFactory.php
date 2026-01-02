<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $forms = [
            'ООО',
            'ПАО',
            'ЗАО',
            'ИП',
        ];

        $organisations = [
            'Совёнок',
            'Хоббвиль',
            'Талант-клуб Сквирел',
            'Праздников',
            'Ninja kids',
            'Grek Land',
            'Bananapark',
            'Saturn',
            'Домми',
            'Электроникум',
            'Гравитация',
            'Место без адреса',
            'Fancy Fox',
            'Superkids',
            'FamilyDay',
            'WowLand',
            'SoVa',
            'Мадагаскар',
            'Джунгли',
            'Папа, мама, я!',
        ];

        $streest = [
            'ул. Академгородок',
            'ул. Можайского',
            'ул. Красноярский рабочий',
            'пр. Карла Маркса',
            'пр. им. Ленина',
            'пр. Свободный',
            'ул. п. Железняка',
            'ул. Бограда',
            'ул. Робеспьера',
            'ул. Академика Киренского',
            'ул. Водопьяново',
            'ул. Ястынская',
            'ул. Глинки',
            'ул. Лесопарковая',
            'ул. Ветлужанки',
            'ул. Воронова',
            'ул. Краснодарская',
            'ул. Ломоносова',
            'ул. Львовская',
            'ул. Кутузова',
        ];

        $name = $this->faker->unique()->randomElement($organisations);

        return [
            'short_name' => $name,
            'name' => $this->faker->randomElement($forms) . ' ' . $name,
            'address' => $this->faker->randomElement($streest) . ', ' . $this->faker->numberBetween(1, 100),
            'city_id' => 1,
            'district_id' => $this->faker->numberBetween(1, 7),
        ];
    }
}
