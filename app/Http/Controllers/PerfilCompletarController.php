<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Profesor;
use App\Models\Secretaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilCompletarController extends Controller
{
    protected array $rolesConPerfil = ['profesor', 'secretaria', 'estudiante'];

    /**
     * Definición de cada campo del formulario: qué rol(es) lo necesitan,
     * el tipo de input y si es obligatorio.
     */
    protected function definicionCampos(): array
    {
        return [
            'nombres' => ['roles' => ['estudiante', 'profesor', 'secretaria'], 'tipo' => 'text', 'requerido' => true, 'label' => 'Nombres'],
            'apellidos' => ['roles' => ['estudiante', 'profesor', 'secretaria'], 'tipo' => 'text', 'requerido' => true, 'label' => 'Apellidos'],
            'telefono' => ['roles' => ['estudiante', 'profesor', 'secretaria'], 'tipo' => 'text', 'requerido' => true, 'label' => 'Teléfono'],
            'cc' => ['roles' => ['estudiante', 'secretaria'], 'tipo' => 'number', 'requerido' => true, 'label' => 'Cédula'],
            'direccion' => ['roles' => ['estudiante', 'secretaria'], 'tipo' => 'text', 'requerido' => true, 'label' => 'Dirección'],
            'genero' => ['roles' => ['estudiante'], 'tipo' => 'select', 'requerido' => true, 'label' => 'Género', 'opciones' => ['Masculino', 'Femenino', 'Otro']],
            'fecha_nacimiento' => ['roles' => ['secretaria'], 'tipo' => 'date', 'requerido' => true, 'label' => 'Fecha de nacimiento'],
            'contacto_emergencia' => ['roles' => ['estudiante'], 'tipo' => 'number', 'requerido' => false, 'label' => 'Contacto de emergencia'],
            'observaciones' => ['roles' => ['estudiante'], 'tipo' => 'textarea', 'requerido' => false, 'label' => 'Observaciones'],
        ];
    }

    public function show()
    {
        $user = Auth::user();
        $roles = $this->rolesPendientes($user);

        if (empty($roles)) {
            return redirect()->route('admin.home');
        }

        $campos = $this->camposParaRoles($user, $roles);
        $valores = $this->valoresPorDefecto($user);

        return view('perfil.completar', ['roles' => $roles, 'campos' => $campos, 'valores' => $valores]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $roles = $this->rolesPendientes($user);

        if (empty($roles)) {
            return redirect()->route('admin.home');
        }

        $campos = $this->camposParaRoles($user, $roles);
        $data = $request->validate($this->reglasValidacion($campos, $roles));

        // Nombres/apellidos: si ya vienen del usuario (capturados al crearlo), se usan esos;
        // si no, se toman del formulario (usuarios creados antes de este cambio).
        $nombres = $data['nombres'] ?? $user->name;
        $apellidos = $data['apellidos'] ?? $user->apellido;

        if (in_array('estudiante', $roles)) {
            Estudiante::create([
                'nombres' => $nombres,
                'apellidos' => $apellidos,
                'cc' => $data['cc'],
                'genero' => $data['genero'],
                'telefono' => $data['telefono'],
                'direccion' => $data['direccion'],
                'contacto_emergencia' => $data['contacto_emergencia'] ?? null,
                'observaciones' => $data['observaciones'] ?? null,
                'user_id' => $user->id,
            ]);
        }

        if (in_array('profesor', $roles)) {
            Profesor::create([
                'nombres' => $nombres,
                'apellidos' => $apellidos,
                'telefono' => $data['telefono'],
                'user_id' => $user->id,
            ]);
        }

        if (in_array('secretaria', $roles)) {
            Secretaria::create([
                'nombres' => $nombres,
                'apellidos' => $apellidos,
                'cc' => $data['cc'],
                'telefono' => $data['telefono'],
                'fecha_nacimiento' => $data['fecha_nacimiento'],
                'direccion' => $data['direccion'],
                'user_id' => $user->id,
            ]);
        }

        return redirect()->route('admin.home')->with([
            'info' => '¡Perfil completado correctamente!',
            'icon' => 'success',
        ]);
    }

    /**
     * Si el usuario ya tiene algún perfil (por un rol anterior), precarga los
     * campos que se repiten entre roles (teléfono, cédula, dirección) para no
     * pedírselos otra vez. Nombres/apellidos no se precargan aquí porque, si ya
     * existen en el usuario, directamente se excluyen del formulario (ver
     * camposParaRoles).
     */
    private function valoresPorDefecto($user): array
    {
        $valores = [];

        if ($user->estudiante) {
            $valores += [
                'telefono' => $user->estudiante->telefono,
                'cc' => $user->estudiante->cc,
                'direccion' => $user->estudiante->direccion,
            ];
        }

        if ($user->profesor) {
            $valores += [
                'telefono' => $user->profesor->telefono,
            ];
        }

        if ($user->secretaria) {
            $valores += [
                'telefono' => $user->secretaria->telefono,
                'cc' => $user->secretaria->cc,
                'direccion' => $user->secretaria->direccion,
            ];
        }

        return $valores;
    }

    /**
     * Roles que el usuario tiene asignados pero para los que aún no existe
     * su registro en la tabla correspondiente (estudiantes/profesors/secretarias).
     */
    private function rolesPendientes($user): array
    {
        $pendientes = [];
        foreach ($this->rolesConPerfil as $rol) {
            if ($user->hasRole($rol) && !$user->{$rol}) {
                $pendientes[] = $rol;
            }
        }

        return $pendientes;
    }

    /**
     * Une los campos de todos los roles pendientes, sin duplicar ninguno.
     * Si el usuario ya tiene nombres/apellidos guardados (capturados al
     * crear la cuenta), esos dos campos se excluyen del formulario.
     */
    private function camposParaRoles($user, array $roles): array
    {
        $campos = [];
        foreach ($this->definicionCampos() as $nombre => $def) {
            if (!array_intersect($def['roles'], $roles)) {
                continue;
            }

            if (in_array($nombre, ['nombres', 'apellidos']) && $user->name && $user->apellido) {
                continue;
            }

            $campos[$nombre] = $def;
        }

        return $campos;
    }

    private function reglasValidacion(array $campos, array $roles): array
    {
        $reglas = [];

        foreach ($campos as $nombre => $def) {
            $base = $def['requerido'] ? ['required'] : ['nullable'];

            $base[] = match ($def['tipo']) {
                'number' => 'integer',
                'date' => 'date',
                default => 'string',
            };

            if ($nombre === 'cc') {
                // La cédula debe ser única en cada tabla donde se vaya a insertar
                if (in_array('estudiante', $roles)) {
                    $base[] = 'unique:estudiantes,cc';
                }
                if (in_array('secretaria', $roles)) {
                    $base[] = 'unique:secretarias,cc';
                }
            }

            $reglas[$nombre] = $base;
        }

        return $reglas;
    }
}
