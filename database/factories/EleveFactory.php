<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Eleve>
 */
class EleveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->lastName(), // Nom de famille aléatoire
            'prenom' => $this->faker->firstName(), // Prénom aléatoire
            'sexe' => $this->faker->randomElement(['M', 'F']), // Sexe aléatoire, M ou F
            'datenais' => $this->faker->date(), // Date de naissance aléatoire
            'phoneeleve' => $this->faker->phoneNumber(), // Numéro de téléphone aléatoire
            'nompar' => $this->faker->lastName(), // Nom du parent aléatoire
            'prenpar' => $this->faker->firstName(), // Prénom du parent aléatoire
            'profespar' => $this->faker->jobTitle(), // Profession aléatoire
            'phonepar' => $this->faker->phoneNumber(), // Numéro de téléphone du parent aléatoire
        ];
    }
}
