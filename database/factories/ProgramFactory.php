<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $minAge = rand(3, 12);
        $maxAge = $minAge + rand(1, 5);

        return [
            'organization_id' => $this->faker->numberBetween(1, config('seeding.count_organizations')),
            'name' => $this->generateProgramName(),
            'descriprion' => $this->generateDescription(),
            'age_from' => $minAge,
            'age_to' => $maxAge,
        ];
    }

    private function generateProgramName(): string
    {
        $prefixes = [
            'Детский',
            'Летний',
            'Зимний',
            'Спортивный',
            'Творческий',
            'Образовательный',
            'Развивающий',
            'Приключенческий'
        ];

        $types = ['лагерь', 'курс', 'интенсив', 'программа', 'клуб', 'проект', 'марафон'];

        $themes = [
            '"Радуга"',
            '"Познайка"',
            '"Старт"',
            '"Гений"',
            '"Лидер"',
            '"Смайлик"',
            '"Класс"',
            '"Вектор"'
        ];

        return $this->faker->randomElement($prefixes) . ' ' .
            $this->faker->randomElement($types) . ' ' .
            $this->faker->randomElement($themes);
    }

    private function generateDescription(): string
    {
        $intros = [
            'Уникальная программа для детей, направленная на',
            'Замечательная возможность для вашего ребенка',
            'Интересные занятия, которые помогут детям',
            'Программа, разработанная опытными педагогами для',
        ];

        $activities = [
            'развитие творческих способностей и воображения.',
            'улучшение коммуникативных навыков и работы в команде.',
            'изучение основ программирования и робототехники.',
            'физическое развитие и укрепление здоровья.',
            'знакомство с окружающим миром и природой.',
            'развитие лидерских качеств и уверенности в себе.',
            'подготовку к школе и развитие познавательных процессов.',
            'обучение английскому языку в игровой форме.',
        ];

        $details = [
            ' Занятия проводятся в игровой форме.',
            ' В программе используются современные методики обучения.',
            ' Группы формируются по возрасту и уровню подготовки.',
            ' Предусмотрены перерывы на отдых и питание.',
            ' Программа включает экскурсии и мастер-классы.',
            ' По окончании выдается сертификат.',
        ];

        return $this->faker->randomElement($intros) . ' ' .
            $this->faker->randomElement($activities) .
            $this->faker->randomElement($details);
    }
}
