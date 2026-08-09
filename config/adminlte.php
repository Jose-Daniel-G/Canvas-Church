<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    */

    'title' => 'Campus Virtual',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    */

    'use_ico_only' => true,
    'use_full_favicon' => true,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    */

    'logo' => '<b>Campus Virtual</b>LTE',
    'logo_img' => 'vendor/adminlte/dist/img/hatLogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'JDeveloper',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/Hebron.png',
            'alt' => 'Auth Logo',
            'class' => 'brand-image img-circle elevation-3', // 'class' => '',// JD
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    */

    'preloader' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/HEBRON.png',
            'alt' => 'Campus Virtual',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    */

    // 'use_route_url' => false,
    // 'dashboard_url' => '/admin',
    // 'logout_url' => 'logout',
    // 'login_url' => 'login',
    // 'register_url' => false,//'register',
    // 'password_reset_url' => 'forgot-password',
    // 'password_email_url' => 'password/email',
    // 'profile_url' => false,

    'use_route_url' => true,
    'dashboard_url' => 'admin.index',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => false, // 'register',
    'password_reset_url' => 'forgot-password',
    'password_email_url' => 'password.email',
    // 'password_reset_url' => 'forgot-password',
    // 'password_email_url' => 'password/email',
    'profile_url' => false,
    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    */

    'menu' => [
        /* ================= DASHBOARD ================= */
        [
            'text' => 'Dashboard',
            'route' => 'admin.home',
            'icon' => 'fas fa-home',
        ],

        /* ============================================================
        | ADMINISTRACIÓN GENERAL
        ============================================================ */
        ['header' => 'ADMINISTRADOR', 'can' => 'admin.estudiantes.index'],

        [
            'text' => 'Gestión de Cursos',
            'icon' => 'fas fa-fw fa-graduation-cap',
            'route' => 'admin.cursos.index',
            'can' => 'admin.cursos.index',
        ],
        ['header' => 'GESTIÓN ACADÉMICA', 'can' => 'profesor.calificaciones.index'],
        [
            // 'text' => 'Calificar', 
            // 'icon' => 'fas fa-edit',
            // 'can'  => 'profesor.calificaciones.index', // Permiso para el profesor
            // 'submenu' => [
            //     [
                    'text' => 'Calificar Tareas',
                    'route'  => 'admin.profesor.calificaciones.index',
                    'icon' => 'fas fa-edit',
                    'can'  => 'profesor.calificaciones.index', // Permiso para el profesor
            //     ],
            //     [
            //         'text' => 'visual Example',
            //         'icon' => 'far fa-circle fa-xs',
            //         'route' => 'admin.profesor.calificaciones.visual', // Asegúrate que esta ruta exista en web.php
            //     ],
            // ],
        ],
        /* ============================================================
        | ESTUDIANTE
        ============================================================ */
        ['header' => 'ESTUDIANTE', 'can' => 'estudiante.cursos.index'],
        [
            'text' => 'Curso',
            'icon' => 'fas fa-book', //'fas fa-book-open'
            'can' => 'estudiante.cursos.index',
            'submenu' => [
                [
                    'text' => 'Presentacion',
                    'icon' => 'far fa-circle fa-xs',
                    'route' => 'admin.mi-curso', // Asegúrate que esta ruta exista en web.php
                ],
                [
                    'text' => 'Modulo 1',
                    'icon' => 'fa-solid fa-circle-dot fa-xs text-success',
                    'route' => 'estudiante.tareas.index',
                ],
                [
                    'text' => 'Modulo 2',
                    'icon' => 'fa-solid fa-circle-dot fa-xs text-success',
                    'url' => '#',
                ],
                // [
                //     'text' => 'Modulo 3',
                //     'icon' => 'fa-solid fa-circle-dot fa-xs text-success',
                //     'submenu' => [
                //         [
                //             'text' => 'Contenido',
                //             'icon' => 'far fa-circle fa-xs',
                //             'url' => '#',
                //         ],
                //     ],
                // ],
            ],
        ],
        [
            'text' => 'Horarios',
            'icon' => 'fas fa-calendar-alt',
            'can' => 'admin.horarios.index',
            'submenu' => [
                [
                    'text' => 'Crear horarios',
                    'icon' => 'nav-icon far fa-circle text-warning', // fas fa-plus-circle
                    'route' => 'admin.horarios.create',
                ],
                [
                    'text' => 'Listado de horarios',
                    'icon' => 'nav-icon far fa-circle text-warning', // fas fa-list
                    'route' => 'admin.horarios.index',
                ],
            ],
        ],
        [
            'text' => 'Inscripciones',
            'icon' => 'fas fa-user-plus',
            'route' => 'admin.inscripciones.index',
            'can' => 'admin.estudiantes.index',
        ],
        [
            'text' => 'Asistencias',
            'icon' => 'fas fa-clipboard-check',
            'route' => 'asistencias.index',
            'can' => 'asistencias.index',
        ],

        /* ================= ESTADÍSTICAS / REPORTES ================= */
        // [
        //     'text' => 'Reportes Académicos',
        //     'icon' => 'fas fa-chart-bar',
        //     'can' => 'admin.reportes.index',
        //     'submenu' => [
        //         [
        //             'text' => 'Cursos',
        //             'icon' => 'fas fa-chart-line',
        //             'url' => '#',
        //             // 'route' => 'admin.reportes.cursos',
        //             'can' => 'admin.reportes.cursos',
        //         ],
        //         [
        //             'text' => 'Estudiantes',
        //             'icon' => 'fas fa-user-chart',
        //             'url' => '#',
        //             // 'route' => 'admin.reportes.estudiantes',
        //             'can' => 'admin.reportes.estudiantes',
        //         ],
        //         [
        //             'text' => 'Asistencias',
        //             'icon' => 'fas fa-calendar-check',
        //             'url' => '#',
        //             // 'route' => 'admin.asistencias.estadisticas',
        //             'can' => 'admin.asistencias.estadisticas',
        //         ],
        //     ],
        // ],

        /* ============================================================
        | PROFESOR
        ============================================================ */
        ['header' => 'PROFESOR', 'can' => 'admin.profesor.tareas.index'],
        [
            'text' => 'Tareas',
            'icon' => 'fas fa-tasks', //     'icon' => 'fas fa-book-reader',
            // 'submenu' => [
            //     [
            //         'text' => 'Ver tareas',
            //         'icon' => 'nav-icon far fa-circle text-primary', // fas fa-eye
                    'route' => 'admin.profesor.tareas.index',
                    'can' => 'admin.profesor.tareas.index',
            //     ],
            //     [
            //         'text' => 'Crear tarea',
            //         'icon' => 'nav-icon far fa-circle text-primary', // fas fa-plus
            //         'route' => 'admin.profesor.tareas.create',
            //         'can' => 'admin.profesor.tareas.create',
            //     ],
            // ],
        ],

        // [
        //     'text' => 'Reportes',
        //     'icon' => 'fas fa-chart-pie',
        //     'can' => 'profesor.reportes.cursos',
        //     'submenu' => [
        //         [
        //             'text' => 'Asistencias',
        //             'icon' => 'fas fa-clipboard-list',
        //             'url' => '#',
        //             // 'route' => 'profesor.reportes.asistencias',
        //         ],
        //         [
        //             'text' => 'Tareas',
        //             'icon' => 'fas fa-file-alt',
        //             'url' => '#',
        //             // 'route' => 'profesor.reportes.tareas',
        //         ],
        //     ],
        // ],



        [
            'text' => 'Tareas',
            'icon' => 'fas fa-tasks',
            'url' => '#',
            'route' => 'estudiante.tareas.index',
            'can' => 'estudiante.tareas.index',
        ],

        // [
        //     'text' => 'Estadísticas',
        //     'icon' => 'fas fa-chart-line',
        //     'can' => 'estudiante.estadisticas.index',
        //     'submenu' => [
                // [
                //     'text' => 'Asistencias',
                //     'icon' => 'fas fa-calendar-check',
                //     'url' => '#',
                //     // 'route' => 'estudiante.estadisticas.asistencias',
                // ],
                // [
                //     'text' => 'Cursos',
                //     'icon' => 'fas fa-graduation-cap',
                //     'url' => '#',
                //     // 'route' => 'estudiante.estadisticas.cursos',
                // ],
                [
                    'text' => 'Mis Calificaciones',
                    'route' => 'estudiante.calificaciones.index',
                    'icon' => 'fas fa-star',
                    'can' => 'estudiante.calificaciones.index',
                ],
                // [
                //     'text' => 'Resultados',
                //     'route' => 'admin.cursos.completados',
                //     'icon' => 'fas fa-chart-bar',
                // ],
            // ],
        // ],

        /* ============================================================
        | CONFIGURACIÓN (SOLO SUPERADMIN)
        ============================================================ */
        ['header' => 'CONFIGURACIÓN', 'can' => 'admin.config.index'],

        [
            'text' => 'Sistema',
            'icon' => 'fas fa-cogs',
            'can' => 'admin.config.index',
            'submenu' => [
                [
                    'text' => 'Usuarios',
                    'route' => 'admin.users.index',
                    'icon' => 'fas fa-users fa-fw ',
                    'can' => 'admin.users.index',
                ],
                [
                    'text' => 'Roles',
                    'icon' => 'fas fa-id-badge',
                    'route' => 'admin.roles.index',
                    'can' => 'admin.roles.index',
                ],
                [
                    'text' => 'Permisos',
                    'icon' => 'fas fa-key',
                    'route' => 'admin.permissions.index',
                    'can' => 'permissions.index',
                ],
            ],
        ],
        [
            'text' => 'Configuración',
            'icon' => 'fas fa-sliders-h',
            'route' => 'admin.config.index',
            'can' => 'admin.config.index',
        ],
        //               [
        //     'text' => 'attempt',
        //     'icon' => 'fas fa-sliders-h', 
        // ],
        // ['text'=> 'Clase','route' => 'admin.users.index','icon' => 'fas fa-envelope',],
        // ['text' => 'information','icon_color' => 'cyan','url' => '#', ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    */

    'plugins' => [
        'FontAwesome' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css',
                ],
            ],
        ],
        'Datatables' => [
            'active' => true,
            'files' => [
                // 1. CORE - DataTables base (PRIMERO)
                ['type' => 'js', 'asset' => true, 'location' => '//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js'],
                ['type' => 'js', 'asset' => true, 'location' => '//cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js'],

                // 2. LIBRERÍAS NECESARIAS (jszip, pdfmake)
                ['type' => 'js', 'asset' => true, 'location' => '//cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js'],
                ['type' => 'js', 'asset' => true, 'location' => '//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js'],
                ['type' => 'js', 'asset' => true, 'location' => '//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js'],

                // 3. BUTTONS (después de jszip y pdfmake)
                ['type' => 'js', 'asset' => true, 'location' => '//cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js'],
                ['type' => 'js', 'asset' => true, 'location' => '//cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js'],
                ['type' => 'js', 'asset' => true, 'location' => '//cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js'],
                ['type' => 'js', 'asset' => true, 'location' => '//cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js'],
                ['type' => 'js', 'asset' => true, 'location' => '//cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js'],

                // 4. RESPONSIVE (opcional)
                ['type' => 'js', 'asset' => true, 'location' => '//cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js'],
                ['type' => 'js', 'asset' => true, 'location' => '//cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js'],

                // 5. CSS (al final)
                ['type' => 'css', 'asset' => true, 'location' => '//cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css'],
                ['type' => 'css', 'asset' => true, 'location' => '//cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css'],
                ['type' => 'css', 'asset' => true, 'location' => '//cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css'],
                ['type' => 'css', 'asset' => true, 'location' => '//cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css'],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@11',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        'toastr' => [ // it isnt working
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    */

    'livewire' => true,
];
