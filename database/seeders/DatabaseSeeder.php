<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        // Storage::deleteDirectory('posts');
        // Storage::makeDirectory('posts');
        $this->call([ 
            RoleSeeder::class,
            AdminSeeder::class,
            SecretariaSeeder::class,
            ProfesorSeeder::class,
            CursoSeeder::class,
            HorarioSeeder::class, 
            EstudianteSeeder::class,
            TareaSeeder::class,
            CalendarioEventoSeeder::class,
        ]); 
        // User::factory(9)->create(); // Crea 9 usuarios
        // Tag::factory(8)->create();
        // $this->call(CategorySeeder::class);
        // $this->call(PostSeeder::class);
    }
}
