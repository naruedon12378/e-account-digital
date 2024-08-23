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

    'title' => 'AdminLTE 3',
    'title_prefix' => '',
    'title_postfix' => '',

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

    'use_ico_only' => true,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Admin</b>LTE',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Admin Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

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
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-white',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => true,

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
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
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

    'classes_auth_card' => 'card-outline card-danger shadow',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => 'fa-lg text-danger',
    'classes_auth_btn' => 'btn-danger',

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

    'classes_body' => 'text-sm',
    'classes_brand' => 'shadow-custom',
    'classes_brand_text' => '',
    'classes_content_wrapper' => 'bg-white-custom',
    'classes_content_header' => '',
    'classes_content' => 'bg-white-custom text-sm',
    'classes_sidebar' => 'sidebar-light-white-custom shadow-custom fixed',
    'classes_sidebar_nav' => 'nav-child-indent text-sm',
    'classes_topnav' => 'navbar-white navbar-light shadow-custom',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',
    'classes_card' => [
        'theme' => 'card-primary card-outline p-2 px-md-5 pb-md-5 pt-md-3',
    ],
    'classes_button' => [
        'btn-primary' => 'btn-primary',
        'btn-outline-primary' => 'btn-outline-primary',
        'btn-success' => 'btn-success',
        'btn-outline-success' => 'btn-outline-success',
        'btn-danger' => 'btn-danger',
        'btn-outline-danger' => 'btn-outline-danger',
    ],
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

    'sidebar_mini' => NULL,
    'sidebar_collapse' => NULL,
    'sidebar_collapse_auto_size' => 1024,
    'sidebar_collapse_remember' => true,
    'sidebar_collapse_remember_no_transition' => false,
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
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => '/dashboard',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => true,

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
        [
            'text'    => 'Navbar Menu Example',
            'icon'    => 'fas fa-fw fa-share',
            'topnav' => true,
            'submenu' => [
                [
                    'text' => 'child 1',
                    'url'  => 'menu/child1',
                    'shift'   => 'ml-3',
                ],
                [
                    'text' => 'child 2',
                    'url'  => 'menu/child2',
                    'shift'   => 'ml-3',
                ],
            ],
        ],
        // ['header' => 'สรุปผล', 'can' => ['*','dashboard']],
        [
            'text' => 'main_navigation',
            'route'  => 'dashboard.index',
            'icon' => 'fas fa-fw fa-chart-area',
            'active'      => ['*dashboard*'],
        ],
        [
            'text'    => 'revenue',
            'icon'    => 'fas fa-fw fa-hand-holding-usd',
            'can'  => ['*', 'all user_history', 'view user_history', 'all member_history', 'view member_history'],
            'submenu' => [
                [
                    'text' => 'quotation',
                    'route'  => 'quotations.index',
                    'active'      => [''],
                    'can'  => ['*', 'all user_history', 'view user_history'],
                ],
                [
                    'text' => 'delivery_note',
                    'route'  => 'invoices.index',
                    'active'      => [''],
                    'can'  => ['*', 'all user_history', 'view user_history'],
                ],
                [
                    'text' => 'receipt',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all user_history', 'view user_history'],
                ],
                [
                    'text' => 'sales_tax_invoice',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all user_history', 'view user_history'],
                ],
                [
                    'text' => 'credit_note',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all user_history', 'view user_history'],
                ],
                [
                    'text' => 'debit_note',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all user_history', 'view user_history'],
                ],
                [
                    'text' => 'billing_note',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all user_history', 'view user_history'],
                ],
                [
                    'text' => 'import_document',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all user_history', 'view user_history'],
                ],
            ],
        ],
        [
            'text'    => 'expense',
            'icon'    => 'fas fa-fw fa-file-invoice-dollar',
            'can'  => ['*', 'all user_history', 'view user_history', 'all member_history', 'view member_history'],
            'submenu' => [
                [
                    'text' => 'purchase_order',
                    'route'  => 'purchase_orders.index',
                    'active'      => [''],
                    'can'  => ['*', 'all user_history', 'view user_history'],
                ],
                [
                    'text' => 'purchase_inventory_record',
                    'route'  => 'purchase_invoices.index',
                    'active'      => [''],
                    'can'  => ['*', 'all user_history', 'view user_history'],
                ],
                [
                    'text' => 'expense_record',
                    'route'  => 'expenses.index',
                    'active'      => [''],
                    'can'  => ['*', 'all user_history', 'view user_history'],
                ],
                [
                    'text' => 'purchase_order_asset',
                    'route'  => 'purchase_asset_orders.index',
                    'active'      => [''],
                    'can'  => ['*', 'all user_history', 'view user_history'],
                ],
                [
                    'text' => 'purchase_asset',
                    'route'  => 'purchase_asset_invoices.index',
                    'active'      => [''],
                    'can'  => ['*', 'all user_history', 'view user_history'],
                ],
                [
                    'text' => 'purchase_tax_invoice',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all user_history', 'view user_history'],
                ],
                [
                    'text' => 'receive_credit_note',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all user_history', 'view user_history'],
                ],
                [
                    'text' => 'receive_debit_note',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all user_history', 'view user_history'],
                ],
                [
                    'text' => 'combined_payment_note',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all user_history', 'view user_history'],
                ],
                [
                    'text' => 'import_document',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all user_history', 'view user_history'],
                ],
            ],
        ],
        [
            'text'    => 'contacts',
            'icon'    => 'fas fa-file-invoice-dollar',
            'route'  => 'contacts.index',
            'active'  => ['contact'],
            'can'  => ['*', 'all contact', 'view contact'],
        ],
        [
            'text'    => 'sales',
            'icon'    => 'fas fa-comment-dollar',
            'can'  => ['*', 'all sales', 'view sales', 'all sale_promotion', 'view sale_promotion'],
            'submenu' => [
                [
                    'text' => 'sale_promotion',
                    'icon'    => 'fas fa-tags',
                    'route'  => 'salepromo.index',
                    'active'      => [''],
                    'can'  => ['*', 'all sale_promotion', 'view sale_promotion'],
                ],
            ],
        ],
        [
            'text'    => 'products',
            'icon'    => 'fas fa-fw fa-box',
            'can'  => ['*', 'all product_service', 'view product_service', 'all product_category', 'view product_category', 'all product_type', 'view product_type',  'all unit_set', 'view unit_set', 'all unit', 'view unit', 'all product_set', 'view product_set'],
            'submenu' => [
                [
                    'text' => 'product_service',
                    'route'  => 'products.index',
                    'active'      => [''],
                    'can'  => ['*', 'all product', 'view product'],
                ],
                [
                    'text' => 'product_set',
                    'route'  => 'productset.index',
                    'active'      => [''],
                    'can'  => ['*', 'all product_set', 'view product_set'],
                ],
                [
                    'text' => 'product_category',
                    'route'  => 'productcategory.index',
                    'active'      => [''],
                    'can'  => ['*', 'all product_category', 'view product_category'],
                ],
                [
                    'text' => 'product_type',
                    'route'  => 'producttype.index',
                    'active'      => [''],
                    'can'  => ['*', 'all product_type', 'view product_type'],
                ],
                [
                    'text' => 'unit_set',
                    'route'  => 'unitset.index',
                    // 'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all unit_set', 'view unit_set'],
                ],
                [
                    'text' => 'unit',
                    'route'  => 'units.index',
                    // 'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all unit', 'view unit'],
                ],
            ],
        ],
        //Authorized By Myint
        [
            'text'    => 'warehouses',
            'icon'    => 'fas fa-warehouse',
            'can'  => ['*', 'all warehouse', 'view warehouse'],
            'submenu' => [
                [
                    'text' => 'issue_requisition',
                    'route'  => 'issuerequisition.index',
                    'icon' => 'fas fa-inbox',
                    'active' => ['*issuerequisition*'],
                    'can'  => ['*', 'all issue_requisition', 'view issue_requisition'],
                ],
                [
                    'text' => 'issue_return_stock',
                    'route'  => 'issuereturnstock.index',
                    'icon' => 'fa-solid fa-cubes-stacked',
                    'active'      => ['*issuereturnstock*'],
                    'can'  => ['*', 'all reture_issue_stock', 'view reture_issue_stock'],
                ],
                [
                    'text' => 'receipt_planning',
                    'route'  => 'receiptplanning.index',
                    'icon' => 'fas fa-receipt',
                    'active'      => ['*receiptplanning*'],
                    'can'  => ['*', 'all receipt_planning', 'view receipt_planning'],
                ],
                [
                    'text' => 'receive_finish_stock',
                    'route'  => 'receivefinishstock.index',
                    'icon' => 'fas fa-box-open',
                    'active'  => [' *receivefinishstock*'],
                    'can'  => ['*', 'all receive_finish_stock', 'view receive_finish_stock'],
                ],
                [
                    'text' => 'return_finish_stock',
                    'route'  => 'returnfinishstock.index',
                    'icon' => 'fas fa-boxes',
                    'active'      => [' *returnfinishstock*'],
                    'can'  => ['*', 'all return_finish_stock', 'view return_finish_stock'],
                ],
                [
                    'text' => 'tranfer_requistion',
                    'route'  => 'transferrequistion.index',
                    'icon' => 'fas fa-exchange-alt',
                    'active'      => [' *transferrequistion*'],
                    'can'  => ['*', 'all tranfer_requistion', 'view tranfer_requistion'],
                ],
                [
                    'text' => 'tranfer_stock',
                    'route'  => 'transferstock.index',
                    'icon' => 'fas fa-shuffle',
                    'active'      => [' *transferstock*'],
                    'can'  => ['*', 'all tranfer_stock', 'view tranfer_stock'],
                ],
                [
                    'text' => 'beginning_balance',
                    'route'  => 'beginningbalance.index',
                    'fontAwesome' => true,
                    'icon' => 'fas fa-dollar-sign',
                    'active'      => [' *beginningbalance*'],
                    'can'  => ['*', 'all beginning_balance', 'view beginning_balance'],
                ],
                [
                    'text' => 'inventory_add_product_lot',
                    'route'  => 'inventorylot.index',
                    'fontAwesome' => true,
                    'icon' => 'fas fa-plus',
                    'active'      => [' *inventorylot*'],
                    'can'  => ['*', 'all inventory_lot', 'view inventory_lot'],
                ],
                [
                    'text' => 'inventory_stock_adjustment',
                    'route'  => 'inventorystockadjustment.index',
                    'fontAwesome' => true,
                    'icon' => 'fas fa-plus-minus',
                    'active'      => [' *inventorystockadjustment*'],
                    'can'  => ['*', 'all inventory_stock_adjustment', 'view inventory_stock_adjustment'],
                ],
                // [
                //     'text' => 'inventory_stock',
                //     'route'  => 'inventorystock.index',
                //     'fontAwesome' => true,
                //     'icon' => 'fas fa-clock-rotate-left',
                //     'active'      => [' *inventorystock*'],
                //     'can'  => ['*', 'all inventory_stock', 'view inventory_stock'],
                // ],
                [
                    'text' => 'inventory_stock_history',
                    'route'  => 'inventorystockhistory.index',
                    'fontAwesome' => true,
                    'icon' => 'fas fa-clock-rotate-left',
                    'active'      => [' *inventorystock_history*'],
                    'can'  => ['*', 'all inventory_stock_history', 'view inventory_stock_history'],
                ],
                [
                    'text' => 'inventory',
                    'route'  => 'inventory.index',
                    'fontAwesome' => true,
                    'icon' => 'fas fa-layer-group',
                    'active'      => ['*inventory*'],
                    'can'  => ['*', 'all inventory', 'view inventory'],
                ],
                [
                    'text' => 'warehouse',
                    'route'  => 'warehouse.index',
                    'fontAwesome' => true,
                    'icon' => 'fas fa-house-chimney',
                    'active'      => [' *warehouse*'],
                    'can'  => ['*', 'all warehouse', 'view warehouse'],
                ],
            ],
        ],
        [
            'text'    => 'finances',
            'icon'    => 'fas fa-fw fa-money-bill',
            'can'  => ['*', 'all prefix', 'view prefix'],
            'submenu' => [
                [
                    'text' => 'overview',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all prefix', 'view prefix'],
                ],
                [
                    'text' => 'cash_bank_ewallet',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all prefix', 'view prefix'],
                ],
                [
                    'text' => 'cheque_receive',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all prefix', 'view prefix'],
                ],
                [
                    'text' => 'cheque_issue',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all prefix', 'view prefix'],
                ],
                [
                    'text' => 'expense_claims',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all prefix', 'view prefix'],
                ],
                [
                    'text' => 'withheld_tax',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all prefix', 'view prefix'],
                ],
                [
                    'text' => 'withholding_tax',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all prefix', 'view prefix'],
                ],
            ],
        ],
        [
            'text'    => 'accounts',
            'icon'    => 'fas fa-fw fa-book',
            'can'  => ['*', 'all prefix', 'view prefix'],
            'submenu' => [
                [
                    'text' => 'chart_of_accounts',
                    'route'  => 'chart_of_account.index',
                    'active'      => ['chart_of_account'],
                    'can'  => ['*', 'all chart_of_account', 'view chart_of_account'],
                ],
                [
                    'text' => 'daily_journals',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all prefix', 'view prefix'],
                ],
                [
                    'text' => 'general_ledgers',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all prefix', 'view prefix'],
                ],
                [
                    'text' => 'trial_balance',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all prefix', 'view prefix'],
                ],
                [
                    'text' => 'statement_of_financial_position',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all prefix', 'view prefix'],
                ],
                [
                    'text' => 'income_statement',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all prefix', 'view prefix'],
                ],
                [
                    'text' => 'cash_flow_statement',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all prefix', 'view prefix'],
                ],
                [
                    'text' => 'dbd_efilling',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all prefix', 'view prefix'],
                ],
                [
                    'text' => 'fixed_asset',
                    'url'  => '#',
                    'active'      => [''],
                    'can'  => ['*', 'all prefix', 'view prefix'],
                ],
            ],
        ],
        [
            'text'    => 'เอกสาร',
            'icon'    => 'fas fa-fw fa-folder-open',
            'can'  => ['*', 'all prefix', 'view prefix'],
            'submenu' => [
                [
                    'text' => 'คลังเอกสาร',
                    'route'  => 'uploadDocument.index',
                    'active'      => ['uploadDocument'],
                    'can'  => ['*', 'all prefix', 'view prefix'],
                ],

            ],
        ],
        [
            'text'    => 'setting',
            'icon'    => 'fas fa-fw fa-cogs',
            'can'  => ['*', 'doc_setting', 'all member', 'view member', 'all member_history', 'view member_history'],
            'submenu' => [
                [
                    'text' => 'company_setting',
                    'route'  => 'company.index',
                    'icon' => 'fas fa-building',
                    'active'      => ['member'],
                    'can'  => ['*', 'all member', 'view member'],
                ],
                [
                    'text' => 'Branch',
                    'route' => 'branch.index',
                    'icon' => 'fas fa-sitemap',
                    'active' => ['branch'],
                    'can' => ['*', 'all branch', 'view branch'],
                ],

                [
                    'text' => 'member_management',
                    'route'  => 'member.index',
                    'icon' => 'fas fa-fw fa-user',
                    'active'      => ['member'],
                    'can'  => ['*', 'all member', 'view member'],
                ],
                [
                    'text'    => 'package',
                    'icon'    => 'fas fa-money-check',
                    'can'  => ['*'],
                    'submenu' => [
                        [
                            'text' => 'upgrade_extend_package',
                            'url'  => '#',
                            'active'      => [''],
                            'can'  => ['*'],
                        ],
                        [
                            'text' => 'payment_history',
                            'url'  => '#',
                            'active'      => [''],
                            'can'  => ['*'],
                        ],
                        [
                            'text' => 'card_info',
                            'url'  => '#',
                            'active'      => [''],
                            'can'  => ['*'],
                        ],
                    ],
                ],
                [
                    'text'    => 'doc_setting_pagename',
                    'icon'    => 'fas fa-paste',
                    'can'  => ['*', 'doc_setting'],
                    'submenu' => [
                        [
                            'text' => 'doc_setting_pagename_1',
                            'route'  => 'numbering_system.index',
                            // 'icon' => 'far fa-sticky-note',
                            'active' => [''],
                            'can'  => ['*', 'doc_setting'],
                        ],
                        [
                            'text' => 'doc_setting_pagename_2',
                            'route'  => 'setting-remark.index',
                            // 'icon' => 'far fa-sticky-note',
                            'active' => [''],
                            'can'  => ['*', 'doc_setting'],
                        ],
                        [
                            'text' => 'doc_setting_pagename_3',
                            'route'  => 'due_date.index',
                            // 'icon' => 'far fa-sticky-note',
                            'active' => [''],
                            'can'  => ['*', 'doc_setting'],
                        ],
                        [
                            'text' => 'doc_setting_pagename_4',
                            'route'  => 'setting-payment-channel.index',
                            // 'url'  => '#',
                            // 'icon' => 'far fa-sticky-note',
                            'active' => [''],
                            'can'  => ['*', 'doc_setting'],
                        ],
                        [
                            'text' => 'doc_setting_pagename_5',
                            'route'  => 'setting-classification-group.index',
                            // 'icon' => 'far fa-sticky-note',
                            'active' => [''],
                            'can'  => ['*', 'doc_setting'],
                        ],
                        [
                            'text' => 'doc_setting_pagename_6',
                            // 'route'  => '#',
                            'route'  => 'setting-public-link.index',
                            // 'icon' => 'far fa-sticky-note',
                            'active' => [''],
                            'can'  => ['*', 'doc_setting'],
                        ],
                        [
                            'text' => 'doc_setting_pagename_7',
                            'route'  => 'setting-tax-invoice.index',
                            // 'url'  => '#',
                            // 'icon' => 'far fa-sticky-note',
                            'active' => [''],
                            'can'  => ['*', 'doc_setting'],
                        ],
                    ],
                ],
                [
                    'text' => 'payment_method',
                    'route'  => 'setting-payment.index',
                    'icon' => 'fas fa-money-bill-wave',
                    'active' => ['*setting-payment*'],
                    'can'  => ['*'],
                ],
            ],
        ],
        [
            'text'    => 'payroll',
            'icon'    => 'fas fa-fw fa-file-invoice-dollar',
            'can'  => ['*', 'all payroll_setting', 'view payroll_setting'],
            'submenu' => [
                [
                    'text' => 'salary',
                    'route'  => 'payroll_salary.index',
                    'active'      => ['*payroll_salary/index*', '*payroll_salary/create*', '*payroll_salary/edit*'],
                    'can'  => ['*', 'all payroll_salary', 'view payroll_salary'],
                ],
                [
                    'text' => 'salary-summary',
                    'route'  => 'payroll_salary_summary.index',
                    'active'      => ['payroll_salary_summary'],
                    'can'  => ['*', 'all payroll_salary', 'view payroll_salary'],
                ],
                [
                    'text' => 'employee',
                    'route'  => 'payroll_employee.index',
                    'active'      => ['*employee*'],
                    'can'  => ['*', 'all payroll_employee', 'view payroll_employee'],
                ],
                [
                    'text' => 'department',
                    'route'  => 'payroll_department.index',
                    'active'      => ['payroll_department'],
                    'can'  => ['*', 'all payroll_department', 'view payroll_department'],
                ],
                [
                    'text' => 'revenue',
                    'route'  => 'payroll_financial_record.index',
                    'active'      => ['payroll_financial_record'],
                    'can'  => ['*', 'all payroll_financial_record', 'view payroll_financial_record'],
                ],
                [
                    'text'    => 'payroll_setting',
                    'route' => 'payroll_setting.index',
                    'can'  => ['*', 'payroll_setting'],
                    'active' => ['payroll_setting'],
                ],
            ],
        ],
        [
            'header' => 'superadmin',
            'classes' => 'text-bold',
            'can'  => ['*', 'all article', 'view article', 'all user', 'view user', 'all role', 'view role', 'all permission', 'view permission', 'all prefix', 'view prefix', 'all bank', 'view bank', 'website_setting', 'all user_history', 'view user_history'],
        ],
        [
            'text' => 'article_management',
            'route'  => 'article.index',
            'icon' => 'fas fa-fw fa-newspaper',
            'active'      => ['*article*'],
            'can'  => ['*', 'all article', 'view article'],
        ],
        [
            'text'    => 'package_management',
            'icon'    => 'fas fa-fw fa-box',
            'can'  => ['*', 'all package_manage', 'view package_manage', 'all feature_title', 'view feature_title', 'all feature', 'view feature'],
            'submenu' => [
                [
                    'text' => 'feature_title',
                    'route'  => 'feature_title.index',
                    'active'      => [''],
                    'can'  => ['*', 'all feature_title', 'view feature_title'],
                ],
                [
                    'text' => 'feature',
                    'route'  => 'feature.index',
                    'active'      => [''],
                    'can'  => ['*', 'all feature', 'view feature'],
                ],
                [
                    'text' => 'package',
                    'route'  => 'package_manage.index',
                    'active'      => [''],
                    'can'  => ['*', 'all package_manage', 'view package_manage'],
                ],
            ],
        ],
        [
            'text'    => 'user_setting',
            'icon'    => 'fas fa-fw fa-users-cog',
            'can'  => ['*', 'all user', 'view user', 'all role', 'view role', 'all permission', 'view permission'],
            'submenu' => [
                [
                    'text' => 'user_management',
                    'route'  => 'user.index',
                    'icon' => 'fas fa-fw fa-user',
                    'active'      => ['user'],
                    'can'  => ['*', 'all user', 'view user'],
                ],

                [
                    'text' => 'role',
                    'icon' => 'fa-solid fa-user-shield',
                    'route'  => 'role.index',
                    'active'      => ['*role*'],
                    'can'  => ['*', 'all role', 'view role'],
                ],
                [
                    'text' => 'permission',
                    'icon' => 'fa-solid fa-user-check',
                    'route'  => 'permission.index',
                    'active'      => ['*permission*'],
                    'can'  => ['*', 'all permission', 'view permission'],
                ],
            ],
        ],
        [
            'text'    => 'master_data_management',
            'icon'    => 'fas fa-fw fa-box-open',
            'can'  => ['*', 'all prefix', 'view prefix', 'all bank', 'view bank'],
            'submenu' => [
                [
                    'text' => 'prefix_management',
                    'route'  => 'prefix.index',
                    'active'      => ['*prefix*'],
                    'can'  => ['*', 'all prefix', 'view prefix'],
                ],
                [
                    'text' => 'bank_management',
                    'route'  => 'bank.index',
                    'active'      => ['*bank*'],
                    'can'  => ['*', 'all bank', 'view bank'],
                ],
            ],
        ],
        [
            'text' => 'website_setting',
            'icon' => 'fas fa-fw fa-globe',
            'route' => 'setting.index',
            'can' => ['*', 'website_setting']
        ],
        [
            'text'    => 'history',
            'icon'    => 'fas fa-fw fa-history',
            'can'  => ['*', 'all user_history', 'view user_history'],
            'submenu' => [
                [
                    'text' => 'user_history',
                    'route'  => 'user_history.index',
                    'active'      => ['user_history'],
                    'can'  => ['*', 'all user_history', 'view user_history'],
                ],

            ],
        ],
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
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.0/fc-4.2.2/fh-3.3.2/kt-2.8.2/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.js'
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.0/fc-4.2.2/fh-3.3.2/kt-2.8.2/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.css'
                ],
                //pdfmake
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js'
                ],
                //vfs_font
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js'
                ]
            ],
        ],
        'Select2' => [
            'active' => true,
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
        'Dropzone' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'plugins/dropzone/dropzone.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'plugins/dropzone/dropzone.css',
                ],
            ],
        ],
        'FontAwesomeV5' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'fontawesome/css/fontawesome.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'fontawesome/css/brands.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'fontawesome/css/solid.css',
                ],
            ],
        ],
        'SummerNote' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'plugins/summernote/summernote-bs4.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'plugins/summernote/plugin/tam-emoji/css/emoji.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'plugins/summernote/summernote-bs4.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'plugins/summernote/plugin/tam-emoji/js/config.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'plugins/summernote/plugin/tam-emoji/js/tam-emoji.min.js',
                ],
            ],
        ],
        'CKEditor' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'plugins/ckeditorV5/build/ckeditor.js',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/chart.js',
                ],
            ],
        ],
        'MomentJs' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js',
                ],
            ],
        ],
        'JqueryPlugins' => [
            'active' => true,
            'files' => [
                //InputMasks
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js'
                ],
                //progressbar
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/progressbar.js/0.6.1/progressbar.min.js'
                ],
                //Date Range Picker
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js'
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css'
                ],
                //Flat Picker
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css'
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/flatpickr'
                ],
                // iCheck
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css'
                ],


            ]
        ],
        'tiltJS' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/tilt.js/1.2.1/tilt.jquery.min.js'
                ],
            ],
        ],
        'SmartWizard' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'plugins/jquery-smartwizard-master/dist/css/smart_wizard_all.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'plugins/jquery-smartwizard-master/dist/js/jquery.smartWizard.min.js',
                ],
            ],
        ],
        'JqueryUI' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js',
                ],
                //Cupertino Theme
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//code.jquery.com/ui/1.13.2/themes/cupertino/jquery-ui.css'
                ]
            ],
        ],
        'ZebraDatePicker' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/zebra_datepicker@latest/dist/zebra_datepicker.min.js'
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/zebra_datepicker@latest/dist/css/bootstrap/zebra_datepicker.min.css',
                ],
            ],
        ],
        'ekko-lightbox' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js'
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css',
                ],
            ],
        ],
        'jsTree' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js',
                ],
            ],
        ],
        'SortableJs' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
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
        'CustomFileInput' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js',
                ],
            ],
        ],
        'Duallistbox' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/bootstrap4-duallistbox/4.0.2/bootstrap-duallistbox.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/bootstrap4-duallistbox/4.0.2/jquery.bootstrap-duallistbox.min.js',
                ],
            ],
        ],
        'Toastr' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js',
                ],
            ],
        ],
        'Thailand' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'plugins/jquery.Thailand.js/dependencies/JQL.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'plugins/jquery.Thailand.js/dependencies/typeahead.bundle.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'plugins/jquery.Thailand.js/dist/jquery.Thailand.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'plugins/jquery.Thailand.js/dist/jquery.Thailand.min.js',
                ],
            ],
        ],
        'BootstrapSwitch' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css',
                ],

            ],
        ],
        'Leaflet' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//unpkg.com/leaflet@1.9.4/dist/leaflet.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//unpkg.com/leaflet@1.9.4/dist/leaflet.js',
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
