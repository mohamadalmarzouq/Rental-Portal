<?php


//accessible for non authenticated users
Route::group(['middleware' => 'guest'], function () {

    /*  Route::get('login', function () {
        return view('auth.login');
    })->name('login')->middleware('throttle:10,1'); */
    Route::group(['middleware' => ['guest', 'prevent-back-history']], function () {
        Route::get('/login', 'Auth\LoginController@showLoginForm')
            ->name('login')
            ->middleware('throttle:10,1');
    });
    Route::get('forgot-password', function () {
        return view('auth.forgot_password');
    })->name('forgot_password')->middleware('throttle:10,1');

    Route::post('forgot-password', config('filesystems.PANEL_CONTROLLER_PATH') . 'UserController@forgotPassword')->name('forgot_password')->middleware('throttle:10,1');

    Route::post('forgot-password', config('filesystems.PANEL_CONTROLLER_PATH') . 'UserController@forgotPassword')->name('forgot_password')->middleware('throttle:10,1');

    Route::get('reset-password', config('filesystems.PANEL_CONTROLLER_PATH') . 'UserController@resetPassword')->name('reset_password')->middleware('throttle:10,1');

    Route::post('change-password', config('filesystems.PANEL_CONTROLLER_PATH') . 'UserController@changePassword')->name('change_password')->middleware('throttle:10,1');

    Route::get('pdf', function () {

        return view('panel.includes.pdf_format');
    });
    Route::get('social/login/{provider}', 'Auth\LoginController@redirectToProvider')->name('social_login');
    Route::get('social/login/callback/{provider}', 'Auth\LoginController@handleProviderCallback');
});

Route::get('files-download/{file_name}/{id}', function ($file_name = null, $id = null) {
    $path = storage_path("app/public/" . $id . "/" . $file_name);
    if (file_exists($path)) {
        return response()->download($path);
    }
});

Route::get('leases/export', config('filesystems.PANEL_CONTROLLER_PATH') . 'LeaseController@export')
    ->name('leases.export');
Route::get('properties/export', config('filesystems.PANEL_CONTROLLER_PATH') . 'PropertyController@export')
    ->name('properties.export');
Route::get('tenants/export', config('filesystems.PANEL_CONTROLLER_PATH') . 'TenantController@export')
    ->name('tenants.export');

Route::group(['middleware' => ['status_check', 'auth', 'activity_log', 'role', 'check_email_changed', 'prevent-back-history']], function () {

    Route::get('search', config('filesystems.PANEL_CONTROLLER_PATH') . 'GlobalSearchController@index')->name('search');

    Route::get('/', config('filesystems.PANEL_CONTROLLER_PATH') . 'PanelController@index')->name('home');


    Route::get('languages', config('filesystems.PANEL_CONTROLLER_PATH') . 'LanguageController@language')->name('languages.language');

    Route::post('edit-profile', config('filesystems.PANEL_CONTROLLER_PATH') . 'UserController@updateProfile')->name('update_profile');

    Route::post('edit-notification', config('filesystems.PANEL_CONTROLLER_PATH') . 'UserController@updateNotification')->name('update_notification');

    Route::get('user-profile', config('filesystems.PANEL_CONTROLLER_PATH') . 'UserController@profile')->name('profile');

    Route::get('user-notification', config('filesystems.PANEL_CONTROLLER_PATH') . 'UserController@notification')->name('notification');

    Route::post('languages-edit', config('filesystems.PANEL_CONTROLLER_PATH') . 'LanguageController@update')->name('languages.edit');

    Route::get('get-notification-count', config('filesystems.PANEL_CONTROLLER_PATH') . 'NotificationController@notificationCount')
        ->name('notification.count');
    Route::get('get-notifications/{count?}', config('filesystems.PANEL_CONTROLLER_PATH') . 'NotificationController@notifications')
        ->name('notification.show');


    $crud_modules = [

        [
            'module_name' => 'properties',
            'controller_name' => 'Property',

            'additional_routes' => [
                [
                    'route_name' => 'getUnitForDateRange',
                    'method' => 'getUnitForDateRange',
                    'url' => 'getUnitForDateRange',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'get-unit-view',
                    'method' => 'getUnitView',
                    'url' => 'get-unit-view/{index}/{property_id}',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'getDataForVacancyBarometer',
                    'method' => 'getDataForVacancyBarometer',
                    'url' => 'vacancy-data',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'getUnitType',
                    'method' => 'getUnitType',
                    'url' => 'getUnitType',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'remove-unit',
                    'method' => 'removeUnit',
                    'url' => 'remove-unit/{unit_id}',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'get-property-units',
                    'method' => 'getPropertyUnits',
                    'url' => 'get-property-units/{id}',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'get-residence-units-type',
                    'method' => 'getResidenceUnitsType',
                    'url' => 'get-residence-units-type/{id}',
                    'http_method' => 'get'
                ],

                [
                    'route_name' => 'search',
                    'method' => 'search',
                    'url' => 'search',
                    'http_method' => 'get'
                ],
                // [
                //     'route_name' => 'export',
                //     'method' => 'export',
                //     'url' => 'export',
                //     'http_method' => 'get'
                // ],
                [
                    'route_name' => 'get-graph-data',
                    'method' => 'getDataForUnitBarGraph',
                    'url' => 'get-graph-data/{value}',
                    'http_method' => 'get'
                ]
            ]
        ],

        [
            'module_name' => 'leases',
            'controller_name' => 'Lease',

            'additional_routes' => [
                [
                    'route_name' => 'cancel_lease',
                    'method' => 'cancelLease',
                    'url' => 'cancel_lease/{id}',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'remove-file',
                    'method' => 'removeLeaseFile',
                    'url' => 'remove-file/{id}',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'storeMedia',
                    'method' => 'storeMedia',
                    'url' => 'media',
                    'http_method' => 'post'
                ],
                [
                    'route_name' => 'end_lease',
                    'method' => 'endLease',
                    'url' => 'end_lease/{id}',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'approve_lease',
                    'method' => 'approveLease',
                    'url' => 'approve_lease/{id}',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'add_invoice',
                    'method' => 'addInvoice',
                    'url' => 'add_invoice/{id}',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'search',
                    'method' => 'search',
                    'url' => 'search',
                    'http_method' => 'get'
                ],
                // [
                //     'route_name' => 'export',
                //     'method' => 'export',
                //     'url' => 'export',
                //     'http_method' => 'get'
                // ],
                [
                    'route_name' => 'expiringLeases',
                    'method' => 'expiringLeasesListing',
                    'url' => 'expiringLeases',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'comment.add',
                    'method' => 'addCommentOverDue',
                    'url' => 'comment-add',
                    'http_method' => 'post'
                ],

                [
                    'route_name' => 'comment.vie',
                    'method' => 'viewCommentOverDue',
                    'url' => 'comment-view/{id}',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'get.waived.amount',
                    'method' => 'getWaivedAmount',
                    'url' => 'get-waived-amount/{tenant_id}',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'overdueInvoices',
                    'method' => 'overdueInvoicesListing',
                    'url' => 'overdueInvoices',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'overdueLeaseInvoices',
                    'method' => 'overdueLeaseInvoicesListing',
                    'url' => 'overdueLeaseInvoices',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'leasing-activity-graph',
                    'method' => 'getDataForLeasingActivityBarGraph',
                    'url' => 'leasing-activity-graph/{value}',
                    'http_method' => 'get'
                ],
            ]
        ],

        [
            'module_name' => 'users',
            'controller_name' => 'User',

            'additional_routes' => [

                [
                    'route_name' => 'allLandLords',
                    'method' => 'getAllLandLordsListing',
                    'url' => 'allLandLords',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'export',
                    'method' => 'export',
                    'url' => 'export',
                    'http_method' => 'get'
                ],

            ]

        ],

        [
            'module_name' => 'tenants',
            'controller_name' => 'Tenant',

            'additional_routes' => [
                [
                    'route_name' => 'get-tenant-data',
                    'method' => 'getTenantData',
                    'url' => 'get-tenant-data/{id}',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'allTenants',
                    'method' => 'getAllTenantsListing',
                    'url' => 'allTenants',
                    'http_method' => 'get'
                ],
                // [
                //     'route_name' => 'export',
                //     'method' => 'export',
                //     'url' => 'export',
                //     'http_method' => 'get'
                // ],
                [
                    'route_name' => 'approve_tenant',
                    'method' => 'approveTenant',
                    'url' => 'approve_tenant/{id}',
                    'http_method' => 'get'
                ],

            ]

        ],

        ['module_name' => 'roles', 'controller_name' => 'Role'],

        ['module_name' => 'widgets', 'controller_name' => 'Widget'],

        [
            'module_name' => 'bank_accounts',
            'controller_name' => 'BankAccount',

            'additional_routes' => [
                [
                    'route_name' => 'export',
                    'method' => 'export',
                    'url' => 'export',
                    'http_method' => 'get'
                ]

            ]
        ],

        ['module_name' => 'activity_logs', 'controller_name' => 'ActivityLog'],

        [
            'module_name' => 'report_settings',
            'controller_name' => 'ReportSetting',

            'additional_routes' => [
                [
                    'route_name' => 'enable_report',
                    'method' => 'enableReport',
                    'url' => 'enable_report',
                    'http_method' => 'get'
                ]
            ]
        ],

        [
            'module_name' => 'employees',
            'controller_name' => 'Employee',

            'additional_routes' => [
                [
                    'route_name' => 'export',
                    'method' => 'export',
                    'url' => 'export',
                    'http_method' => 'get'

                ]
            ],
        ],

        [
            'module_name' => 'reports',
            'controller_name' => 'Report',

            'additional_routes' => [
                [
                    'route_name' => 'search',
                    'method' => 'search',
                    'url' => 'search',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'export',
                    'method' => 'export',
                    'url' => 'export/{type}',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'show.in.dashboard',
                    'method' => 'showInDashboard',
                    'url' => 'show-in-dashboard',
                    'http_method' => 'get'
                ]

            ]

        ],

        [
            'module_name' => 'invoices',
            'controller_name' => 'Invoice',

            'additional_routes' => [
                [
                    'route_name' => 'get-lease-data',
                    'method' => 'getLeaseData',
                    'url' => 'get-lease-data/{id}',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'search',
                    'method' => 'search',
                    'url' => 'search',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'paid_invoice',
                    'method' => 'markAsPaidInvoice',
                    'url' => 'paid_invoice/{id}',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'cancel_invoice',
                    'method' => 'cancelInvoice',
                    'url' => 'cancel_invoice/{id}',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'approve_invoice',
                    'method' => 'approveInvoice',
                    'url' => 'approve_invoice/{id}',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'send_invoice',
                    'method' => 'sendInvoice',
                    'url' => 'send_invoice/{id}',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'allPaidInvoices',
                    'method' => 'allPaidInvoicesListing',
                    'url' => 'allPaidInvoices',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'outStandingBalances',
                    'method' => 'outStandingBalancesListing',
                    'url' => 'outStandingBalances',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'export',
                    'method' => 'export',
                    'url' => 'export',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'revenue.export',
                    'method' => 'revenueExport',
                    'url' => 'revenue-export',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'expense.export',
                    'method' => 'expenseExport',
                    'url' => 'expense-export',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'get-graph-data',
                    'method' => 'getDataForPlotLineGraph',
                    'url' => 'get-graph-data/{value}',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'check_tenant',
                    'method' => 'checkTenant',
                    'url' => 'check_tenant/{id}',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'update_tenant',
                    'method' => 'updateTenant',
                    'url' => 'update_tenant/{id}',
                    'http_method' => 'post'
                ],
                //                 [
                //                    'route_name' => 'overdueInvoices',
                //                    'method' => 'overdueInvoicesListing',
                //                    'url' => 'overdueInvoices',
                //                    'http_method' => 'get'
                //                 ],
                [
                    'route_name' => 'revenueGraphData',
                    'method' => 'getDataForRevenueBarGraph',
                    'url' => 'revenue-graph-data/{value}',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'expenseGraphData',
                    'method' => 'getDataForExpenseBarGraph',
                    'url' => 'expense-graph-data',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'extras',
                    'method' => 'extras',
                    'url' => 'extras/{key}',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'remove-extra',
                    'method' => 'removeExtra',
                    'url' => 'remove-extra/{id}',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'revenue.ajaxListing',
                    'method' => 'revenueAjaxListing',
                    'url' => 'revenue-ajaxListing',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'expense.ajaxListing',
                    'method' => 'expenseAjaxListing',
                    'url' => 'expense-ajaxListing',
                    'http_method' => 'get'
                ],
                [
                    'route_name' => 'storeMedia',
                    'method' => 'storeMedia',
                    'url' => 'media',
                    'http_method' => 'post'
                ],
                [
                    'route_name' => 'expense',
                    'method' => 'storeExpense',
                    'url' => 'expense',
                    'http_method' => 'post'
                ]
            ]
        ]
    ];

    makeRoute($crud_modules);
});

Route::get('date-filter', config('filesystems.PANEL_CONTROLLER_PATH') . 'PanelController@dateFilter');
Route::get('date-filter2', config('filesystems.PANEL_CONTROLLER_PATH') . 'PanelController@dateFilter');
function makeRoute($crud_modules)
{
    foreach ($crud_modules as $module) {

        $controller = config('filesystems.PANEL_CONTROLLER_PATH') . $module['controller_name'] . 'Controller';

        Route::get($module['module_name'], $controller . '@show')->name($module['module_name'] . '.show');

        Route::get($module['module_name'] . '-add', $controller . '@add')->name($module['module_name'] . '.add');

        Route::post($module['module_name'] . '-add', $controller . '@store')->name($module['module_name'] . '.add');

        Route::get($module['module_name'] . '-edit/{id}', $controller . '@edit')->name($module['module_name'] . '.edit');

        Route::post($module['module_name'] . '-edit/{id}', $controller . '@update')->name($module['module_name'] . '.edit');

        Route::get($module['module_name'] . '-delete/{id}', $controller . '@delete')->name($module['module_name'] . '.delete');

        Route::get($module['module_name'] . '-view/{id}', $controller . '@view')->name($module['module_name'] . '.view');

        Route::get($module['module_name'] . '-list', $controller . '@ajaxListing')->name($module['module_name'] . '.ajaxListing');

        if (!empty($module['additional_routes'])) {

            foreach ($module['additional_routes'] as $additional_route) {

                Route::match(
                    [$additional_route['http_method']],
                    $module['module_name'] . '-' . $additional_route['url'],
                    $controller . '@' . $additional_route['method']
                )
                    ->name($module['module_name'] . '.' . $additional_route['route_name']);
            }
        }
    }
}
