<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\User;
use Illuminate\Database\Seeder;

class EstudianteSeeder extends Seeder
{
    public function run(): void
    {
        // --------------------------------------------]
        // -------------[ Estudiante ]----------------------
        User::create([
            'name' => 'Estudiante',
            'email' => 'estudiante@email.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123123123'),
        ])->assignRole('estudiante');

        $estudiante = Estudiante::create([
            'nombres' => 'Estudiante',
            'apellidos' => 'alracona',
            'cc' => '12312753',
            'genero' => 'M',
            'telefono' => '12395113',
            'direccion' => 'Cll 9 oeste',
            'contacto_emergencia' => '65495113',
            'observaciones' => 'le irrita estar cerca del povo',
            'user_id' => '9',
        ]);
        // Relacionar con los cursos (asumiendo que los cursos ya existen)
        $cursos = Curso::whereIn('id', [1])->get(); // Obtener curso con ID 1
        $estudiante->cursos()->attach($cursos); // Crear las relaciones

        User::create([
            'name' => 'Fancisco Antonio Grijalba',
            'email' => 'francisco.grijalba@email.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123123123'),
        ])->assignRole('estudiante');
        $estudiante = Estudiante::create([
            'nombres' => 'Fancisco Antonio',
            'apellidos' => 'Grijalba',
            'cc' => '23548965',
            'genero' => 'M',
            'telefono' => '987654321',
            'direccion' => 'Cll 7 oeste',
            'contacto_emergencia' => '65495113',
            'observaciones' => 'migrana',
            'user_id' => '10',
        ]);
        // Relacionar con los cursos (asumiendo que los cursos ya existen)
        $cursos = Curso::whereIn('id', [2])->get(); // Obtener los cursos con ID 2
        $estudiante->cursos()->attach($cursos); // Crear las relaciones

        User::create([
            'name' => 'ARGEMIRO ESCOBAR GUTIERRES',
            'email' => 'argemiro.escobar@email.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123123123'),
        ])->assignRole('estudiante');

        $estudiante = Estudiante::create([
            'nombres' => 'ARGEMIRO',
            'apellidos' => 'ESCOBAR',
            'cc' => '2354765',
            'genero' => 'M',
            'telefono' => '987654321',
            'direccion' => 'Cll 7 oeste',
            'contacto_emergencia' => '65495113',
            'observaciones' => 'migrana',
            'user_id' => '11',
        ]);
        $cursos = Curso::whereIn('id', [3])->get(); // Obtener los cursos con ID 3
        $estudiante->cursos()->attach($cursos); // Crear las relaciones

        User::create([
            'name' => 'Gaspar',
            'email' => 'gaspar@email.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123123123'),
        ])->assignRole('estudiante');

        $estudiante = Estudiante::create([
            'nombres' => 'Gaspar',
            'apellidos' => 'Ijaji',
            'cc' => '23547657',
            'genero' => 'M',
            'telefono' => '987654321',
            'direccion' => 'Cll 7 oeste',
            'contacto_emergencia' => '65495113',
            'observaciones' => 'migrana',
            'user_id' => '12',
        ]);

        $cursos = Curso::whereIn('id', [2])->get(); // Obtener los cursos con ID 1 y 2
        $estudiante->cursos()->attach($cursos); // Crear las relaciones
        User::create([
            'name' => 'Juan David Grijalba Osorio',
            'email' => 'juandavidgo1997@email.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123123123'),
        ])->assignRole('estudiante');

        $estudiante = Estudiante::create([
            'nombres' => 'Juan David',
            'apellidos' => 'Grijalba Osorio',
            'cc' => '357986644',
            'genero' => 'M',
            'telefono' => '314756832',
            'direccion' => 'Cll 7 oeste',
            'contacto_emergencia' => '65495113',
            'observaciones' => 'migrana',
            'user_id' => '12',
        ])->assignRole('estudiante');
        $cursos = Curso::whereIn('id', [1])->get(); // Obtener los cursos con ID 1
        $estudiante->cursos()->attach($cursos); // Crear las relaciones

        // Estudaiante adicional sin curso
        User::create([
            'name' => 'Edward',
            'email' => 'sin@email.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123123123'),
        ])->assignRole('estudiante');
        Estudiante::create([
            'nombres' => 'Edward',
            'apellidos' => 'Sin Curso',
            'cc' => '456789123',
            'genero' => 'M',
            'telefono' => '321654987',
            'direccion' => 'Cll 10 norte',
            'contacto_emergencia' => '65495113',
            'observaciones' => 'Ninguna',
            'user_id' => '13',
        ]);
        User::create([
            'name' => 'carmen',
            'email' => 'carmen@email.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123123123'),
        ])->assignRole('estudiante');
        Estudiante::create([
            'nombres' => 'carmen',
            'apellidos' => 'Dos',
            'cc' => '456789124',
            'genero' => 'M',
            'telefono' => '321654988',
            'direccion' => 'Cll 10 norte',
            'contacto_emergencia' => '65495114',
            'observaciones' => 'Ninguna',
            'user_id' => '14',
        ]);

        User::create([
            'name' => 'laura',
            'email' => 'laura@email.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123123123'),
        ])->assignRole('estudiante');
        Estudiante::create([
            'nombres' => 'laura',
            'apellidos' => 'Dos',
            'cc' => '456789125',
            'genero' => 'F',
            'telefono' => '321654989',
            'direccion' => 'Cll 10 norte',
            'contacto_emergencia' => '65495115',
            'observaciones' => 'Ninguna',
            'user_id' => '15',
        ]);

        User::create([
            'name' => 'andres',
            'email' => 'andres@email.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123123123'),
        ])->assignRole('estudiante');
        Estudiante::create([
            'nombres' => 'andres',
            'apellidos' => 'Dos',
            'cc' => '456789126',
            'genero' => 'M',
            'telefono' => '321654990',
            'direccion' => 'Cll 10 norte',
            'contacto_emergencia' => '65495116',
            'observaciones' => 'Ninguna',
            'user_id' => '16',
        ]);
        User::create([
            'name' => 'maria',
            'email' => 'maria@email.com',   
            'email_verified_at' => now(),
            'password' => bcrypt('123123123'),
        ])->assignRole('estudiante');
        Estudiante::create([
            'nombres' => 'maria',
            'apellidos' => 'Dos',
            'cc' => '456789127',
            'genero' => 'F',
            'telefono' => '321654991',
            'direccion' => 'Cll 10 norte',      
            'contacto_emergencia' => '65495117',
            'observaciones' => 'Ninguna',
            'user_id' => '17',
        ]);

        // -------------[ USUARIOS ]----------------]

        //         User::factory()->create([
        //             'name' => 'Test User',
        //             'email' => 'test@email.com',
        //             'password' => bcrypt('123123123'),
        //         ])->assignRole('usuario');

        //         User::factory()->create([
        //             'name' => 'user',
        //             'email' => 'user@email.com',
        //             'password' => bcrypt('123123123'),
        //         ])->assignRole('usuario');

        //         Curso::create([
        //             'nombre' => 'Curso B1',
        //             'descripcion' => 'Curso de conducción para obtener licencia tipo B1.',
        //             'horas_requeridas' => '11',
        //             'estado' => 'A',
        //         ]);

        //         User::factory(9)->create();
    }
}
