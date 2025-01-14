<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => '',
    'title_prefix' => '',
    'title_postfix' => ' | TYRSAWES-ADMIN',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>TYRSAWES</b>-ADMIN',
    'logo_img' => 'vendor/img/logo.svg',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'TYRSA CONSORCIO S.A. DE C.V.',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
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
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
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
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
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
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas s fa-co',
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
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'admin/administrador',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
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
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type' => 'navbar-search',
            'text' => 'search',
            'topnav_right' => false,
        ],
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => false,
        ],

        [
            'header' => 'CONFIGURACIÓN',
            'can' => 'CATALOGOS',
        ],
        [
            'text' => 'CATÁLOGOS',
            'icon' => 'fas fa-list fa-fw',
            'submenu' => [
                [
                    'text' => ' ROLES',
                    'icon' => 'fas fa-user-lock fa-fw',
                    'route'  => 'roles.index',
                    'can'  => 'VER ROLES',
                ],
                [
                    'text' => ' USUARIOS',
                    'icon' => 'fas fa-users fa-fw',
                    'route'  => 'users.index',
                    'can'  => 'VER USUARIOS',
                ],
                [
                    'text' => ' EMPRESA',
                    'icon' => 'fas fa-industry fa-fw',
                    'route'  => 'company_profiles.index',
                    'can'  => 'VER EMPRESAS',
                ],
                [
                    'text' => ' CONFIGURACIÓN',
                    'icon' => 'fas fa-cogs fa-fw',
                    'route'  => 'settings.index',
                    'can'  => 'VER CONFIGURACIONES',
                ],
                [
                    'text' => ' BANCOS',
                    'icon' => 'fas fa-bank fa-fw',
                    'route'  => 'banks.index',
                    'can'  => 'VER BANCOS',
                ],
                [
                    'text' => ' MONEDAS',
                    'icon' => 'fas fa-money-bill-1 fa-fw',
                    'route'  => 'coins.index',
                    'can'  => 'VER MONEDAS',
                ],
                [
                    'text' => ' CATEGORIAS',
                    'icon' => 'fas fa-list-alt fa-fw',
                    'route'  => 'categories',
                    'can'  => 'VER CATEGORIAS',
                ],
                [
                    'text' => 'PRODUCTOS',
                    'icon' => 'fas fa-list-alt fa-fw',
                    'route'  => 'report_product.index',
                    'can'  => 'VER MONEDAS',
                ],
                [
                    'text' => 'MARCAS',
                    'icon' => 'fas fa-list-alt fa-fw',
                    'route'  => 'marcas.index',
                    'can'  => 'VER MONEDAS',
                ],
                [
                    'text' => 'MEDIOS DE VENTA',
                    'icon' => 'fas fa-list-alt fa-fw',
                    'route'  => 'medios.index',
                    'can'  => 'VER MONEDAS',
                ],
                [
                    'text' => 'CLIENTES',
                    'icon' => 'fas fa-users-cog fa-fw',
                    'route'  => 'customers.index',
                    'can'  => 'VER CLIENTES',
                ],
                [
                    'text' => 'UNIDADES DE MEDIDA',
                    'icon' => 'fas fa-ruler fa-fw',
                    'route'  => 'units.index',
                    'can'  => 'VER UNIDADES',
                ],
                [
                    'text' => 'FAMILIAS',
                    'icon' => 'fas fa-people-roof fa-fw',
                    'route'  => 'families.index',
                    'can'  => 'VER FAMILIAS',
                ],
                [
                    'text' => 'NIVEL AUTORIZACIÓN',
                    'icon' => 'fas fa-fingerprint fa-fw',
                    'route'  => 'authorizations.index',
                    'can'  => 'VER AUTORIZACIONES',
                ],
                // [
                //     'text' => 'CONTACTOS',
                //     'icon' => 'fas fa-user-tie fa-fw',
                //     'route'  => 'customer_contacts.index',
                //     'can'  => 'VER CONTACTOS',
                // ],
                [
                    'text' => 'VENDEDORES',
                    'icon' => 'fas fa-user-tag fa-fw',
                    'route'  => 'sellers.index',
                    'can'  => 'VER VENDEDORES',
                ],
                // [
                //     'text' => ' DGI',
                //     'icon' => 'fas fa-user-tag fa-fw',
                //     'route'  => 'dgi_com.index',
                //     'can'  => 'VER DGI',
                // ],
            ],
            'can' => 'CATALOGOS',
        ],
        [
            'header' => '===================',
        ],
        [
            'header' => 'PEDIDOS INTERNOS',
            'can' => 'PEDIDOS',
        ],
        [
            'text' => 'PEDIDO INTERNO',
            'icon' => 'fas fa-clipboard-check fa-fw',
            'route'  => 'internal_orders.index',
            'can'  => 'VER PEDIDOS',
        ],
        [
            'header' => '===================',
        ],
        [
            'header' => 'CONTABILIDAD',
            'can' => 'CONTABILIDAD',
        ],
        // [
        //     'text' => 'CUENTAS POR COBRAR',
        //     'icon' => 'fas fa-money-check',
        //     'url' => 'cuentas_cobrar',
        //     'route'  => 'cuentas_cobrar',
        //     'can' => 'VER CUENTAS X COBRAR',
        // ],
        [
            'text' => 'FACTURAS',
            'icon' => 'fas fa-file',
            'url' => 'factures',
            'route'  => 'factures',
            'can' => 'VER FACTURAS',
        ],
        [
            'text' => 'NOTAS DE CREDITO ',
            'icon' => 'fas fa-file ',
            'url' => 'credit_notes',
            'route'  => 'credit_notes',
            'can' => 'VER NOTAS',
        ],
        [
            'text' => 'COBROS',
            'icon' => 'fa fa-money ',
            'url' => 'cobros',
            'route'  => 'cobros',
            'can' => 'VER COBROS',
        ],
       
        
        // [
        //     'text' => 'CUENTAS COBRADAS',
        //     'icon' => 'fas fa-money-check fa-fw',
            
        //     'route'  => 'payed_accounts',
        //     'can' => 'VER APLICACIONES DE PAGO',
        // ],
        
        [
            'text' => 'INTERFASE ASPEL COI',
            'icon' => 'fas fa-money-check fa-fw',
            
            'route'  => 'payed_accounts',
            'can' => 'VER APLICACIONES DE PAGO',
        ],
        // [
        //     'text' => 'VISUALZIACION DE DATOS',
        //     'icon' => 'fas fa-bar-chart fa-fw',
            
        //     'route'  => 'visualizacion',
        //     'can' => 'VER PEDIDOS',
        // ],
        
        [
            'header' => '===============',
            //'can' => 'Reportes',
        ],
        [
            'text' => 'REPORTES ADMINISTRATIVOS',
            'icon' => 'fas fa-list fa-fw',
            'submenu' => [
                [
                    'text' => ' CONTRAPORTADA',
                    'icon' => 'fas fa-file fa-fw',
                    'route'  => 'reportes.contraportada',
                    'can'  => 'DESCARGAR CONTRAPORTADA',
                ],
                [
                    'text' => ' CUENTAS POR COBRAR',
                    'icon' => 'fas fa-file fa-fw',
                    'route'  => 'reportes.cuentas_cobrar',
                    'can'  => 'DESCARGAR CXC',
                ],
                [
                    'text' => ' CONSECUTIVO DE PEDIDOS INTERNOS',
                    'icon' => 'fas fa-file fa-fw',
                    'route'  => 'payments.consecutivo_pedido',
                    'can'  => 'DESCARGAR CONSECUTIVO PI',
                ],
                [
                    'text' => ' FACTURA RESUMIDA',
                    'icon' => 'fas fa-file fa-fw',
                    'route'  => 'reportes.factura_resumida',
                    'can'  => 'DESCARGAR FACTURA RESUMIDA',
                ],
                [
                    'text' => ' CONSECUTIVO DE FACTURAS',
                    'icon' => 'fas fa-file fa-fw',
                    'route'  => 'reportes.consecutivo_factura',
                    'can'  => 'DESCARGAR CONSECUTIVO FACTURAS',
                ],
                [
                    'text' => ' COMPROBANTE DE INGRESOS VENTAS',
                    'icon' => 'fas fa-file fa-fw',
                    'route'  => 'reportes.comprobante_ingresos',
                    'can'  => 'DESCARGAR RESUMEN COMPROBANTE',
                ],
                [
                    'text' => ' CONSECUTIVO DE COMPROBANTES DE INGRESOS',
                    'icon' => 'fas fa-file fa-fw',
                    'route'  => 'reportes.consecutivo_comprobante',
                    'can'  => 'DESCARGAR CONSECUTIVO COMPROBANTE',
                ],
                
        ],
    ],
    [
        'text' => 'REPORTES DE VENTAS',
        'icon' => 'fas fa-list fa-fw',
        'submenu' => [
            
            [
                'text' => ' OBJETIVOS Y RESULTADOS GENERALES',
                'icon' => 'fas fa-file fa-fw',
                'url'  => '/reportes/objetivo/PEDIDO',
                'can'  => 'DESCARGAR OBJETIVOS PI',
            ],
            [
                'text' => ' OBJETIVOS Y RESULTADOS POR MONTO ',
                'icon' => 'fas fa-file fa-fw',
                'url'  => 'reportes/objetivo/MONTO',
                'can'  => 'DESCARGAR OBJETIVOS MONTO',
            ],
            // [
            //     'text' => ' RANGO DE VENTAS POR CLIENTE',
            //     'icon' => 'fas fa-file fa-fw',
            //     'route'  => 'reportes.rango_ventas',
            //     'can'  => 'DESCARGAR RANGO VENTAS',
            // ],
            [
                'text' => ' RANGO DE VENTAS POR PI',
                'icon' => 'fas fa-file fa-fw',
                'route'  => 'reportes.rango_ventas_pi',
                'can'  => 'DESCARGAR RANGO VENTAS',
            ],
            
            [
                'text' => 'KILOS VENDIDOS',
                'icon' => 'fas fa-file fa-fw',
                'url'  => '/reportes/kilos',
                'can'  => 'DESCARGAR OBJETIVOS PI',
            ],
            [
                'text' => ' VENTAS POR FABRICACION POR MARCA',
                'icon' => 'fas fa-file fa-fw',
                'url'  => '/reportes/fabricacion/PEDIDO',
                'can'  => 'DESCARGAR OBJETIVOS PI',
            ],
            [
                'text' => ' PRESUPUESTO DE FABRICACION PRO MARCA',
                'icon' => 'fas fa-file fa-fw',
                'url'  => 'reportes/fabricacion/MONTO',
                'can'  => 'DESCARGAR OBJETIVOS MONTO',
            ],
            [
                'text' => 'PROSPECTOS DE VENTAS POR MEDIO',
                'icon' => 'fas fa-file fa-fw',
                'url'  => 'reportes/medios',
                'can'  => 'DESCARGAR OBJETIVOS MONTO',
            ],
            
    ],
],
[
    'text' => 'REPORTES DGI',
    'icon' => 'fas fa-list fa-fw',
    'submenu' => [
        [
            'text' => ' DGI',
            'icon' => 'fas fa-file fa-fw',
            'route'  => 'reportes.dgi',
            'can'  => 'VER DGI',
        ],

    ],
]
],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
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
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
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
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
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
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
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
    |
    */

    'livewire' => false,
];
