<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| Middleware options can be located in `app/Http/Kernel.php`
|
*/

// Homepage Route
Route::get('/', 'WelcomeController@welcome')->name('welcome')->middleware(['installed','laravel']);

Route::get('updateuser','WelcomeController@updatemo');

// Authentication Routes
Auth::routes();
// Public Routes
Route::group(['middleware' => ['web', 'activity']], function () { 

    //Installer View
    Route::get('view_env','InstallController@view_env');
    Route::get('install','InstallController@install_step1_view');//STEP 1
    Route::get('install/2','InstallController@install_step2_view');//STEP 2
    Route::get('install/3','InstallController@install_step3_view');//STEP 3
    Route::get('install/4','InstallController@install_step4_view');//STEP 4
    Route::get('install/5','InstallController@install_step5_view');//STEP 5
    Route::get('install/6','InstallController@install_step6_view');//STEP 6
    Route::get('install/7','InstallController@install_step7_view');//STEP 7
    Route::get('install/8','InstallController@install_step8_view');//STEP 8
    Route::get('install/lock','InstallController@lock_installer');//STEP FINAL
    //Installer Process
    Route::post('install','InstallController@install_step1_process');
    Route::post('install/2','InstallController@install_step2_process');
    Route::post('install/3','InstallController@install_step3_process');
    Route::post('install/4','InstallController@install_step4_process');
    Route::post('install/5','InstallController@install_step5_process');
    Route::post('install/6','InstallController@install_step6_process');
    Route::post('install/7','InstallController@install_step7_process');
    Route::post('install/8','InstallController@install_step8_process');

    //Database test Connection view 
    Route::get('install/db/test/{server}','InstallController@db_test');

    //Invalid License
    Route::get('invalid_license','InstallController@invalid_license');
    Route::post('invalid_license','InstallController@check_license');
    //Validate License Process
    Route::post('install/license','InstallController@check_license');

    //ads blocker detected view
    Route::get('ads_blocker_detected',function(){
        return view('pages.public.adsblocker');
    })->name('ads');

});

// Public Routes
Route::group(['middleware' => ['web', 'activity','installed','laravel']], function () {

    // Activation Routes
    Route::get('/activate', ['as' => 'activate', 'uses' => 'Auth\ActivateController@initial']);

    Route::get('/activate/{token}', ['as' => 'authenticated.activate', 'uses' => 'Auth\ActivateController@activate']);
    Route::get('/activation', ['as' => 'authenticated.activation-resend', 'uses' => 'Auth\ActivateController@resend']);
    Route::get('/exceeded', ['as' => 'exceeded', 'uses' => 'Auth\ActivateController@exceeded']);

    //Restore account view
    Route::get('restore/account','RestoreAccountController@restore_view');
    //Restore account process
    Route::post('restore/account','RestoreAccountController@restore_process');

    //About US
    Route::get('about','WelcomeController@about_us_view')->name('aboutus');
    //Download Page
    Route::get('download','WelcomeController@download_view')->name('download');
    //NEWS VIEW BY ID
    Route::get('news/{id}/show','WelcomeController@show_news')->name('view_news');
    //RANKING VIEW
    Route::get('ranking','WelcomeController@ranking_view')->name('ranking');
    //ITEM MALL
    Route::get('shop','WelcomeController@shop_view')->name('shop');
    //ITEM MALL BY CATEGORY
    Route::get('shop/category/{id}','WelcomeController@shop_view')->name('shop2');
    //KNOWLEDGE BASE
    Route::get('knowledgebase','WelcomeController@knowledgebase_view')->name('knowledgebase');
        //KNOWLEDGE BASE SEARCH
        Route::post('knowledgebase','WelcomeController@knowledgebase_search')->name('knowledgebase_search');
        //KNOWLEDGE BASE VIEW BY ID
        Route::get('knowledgebase/{id}/view','WelcomeController@knowledgebase_id_view')->name('knowledgebase_id');
});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity','installed','laravel']], function () {

    // Activation Routes
    Route::get('/activation-required', ['uses' => 'Auth\ActivateController@activationRequired'])->name('activation-required');
    Route::get('/logout', ['uses' => 'Auth\LoginController@logout'])->name('logout');
});

Route::group(['middleware' => ['auth', 'activated', 'activity', 'twostep','installed','laravel']], function () {

    //  Homepage Route - Redirect based on user role is in controller.
    Route::get('home', ['as' => 'home',   'uses' => 'UserController@index']);
});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity', 'role:user', 'twostep','installed','laravel']], function () {

    //INGAME TOOLS

    //REBORN VIEW
    Route::get('user/reborn','UserToolsController@reborn_view');
        //REBORN SYSTEM PROCESS
        Route::post('user/reborn','UserToolsController@reborn_process');
    //CHANGE SCHOOL VIEW
    Route::get('user/changeschool','UserToolsController@changeschool_view');
        //CHANGE SCHOOL PROCESS
        Route::post('user/changeschool','UserToolsController@changeschool_process');
    //CHANGE CLASS VIEW
    Route::get('user/changeclass','UserToolsController@changeclass_view');
        //CHANGE CLASS PROCESS
        Route::post('user/changeclass','UserToolsController@changeclass_process');
    //Max Reborn Reward View
    Route::get('user/maxrbreward','UserToolsController@maxrbreward_view');
        //Max Reborn Reward Process
        Route::post('user/maxrbreward','UserToolsController@maxrbreward_process');
    //PK Points Reset View
    Route::get('user/pkreset','UserToolsController@pkreset_view');
        //PK Points Reset Process
        Route::post('user/pkreset','UserToolsController@pkreset_process');
    //STATISTICAL POINTS RESET View
    Route::get('user/statsreset','UserToolsController@statsreset_view');
        //STATS POINTS RESET PROCESS
        Route::post('user/statsreset','UserToolsController@statsreset_process');
    //ACCOUNT FIX VIEW
    Route::get('user/accountfix','UserToolsController@accountfix_view');
        //ACCOUNT FIX PROCESS
        Route::post('user/accountfix','UserToolsController@accountfix_process');
    //TOP UP VIEW
    Route::get('user/topupcode','UserToolsController@topup_view');
        //TOP UP PROCESS
        Route::post('user/topupcode','UserToolsController@topup_process');

    //VOTING SYSTEM VIEW
    Route::get('user/vote','UserToolsController@vote_view');
        //VOTING SYSTEM VOTE NOW PROCESS
        Route::post('user/vote/{id}','UserToolsController@vote_now_process');
        //VOTING SYSTEM VOTE SUCCESS
        Route::get('vote/success',function(){
            return redirect('user/vote')->with('success','You have successfully vote our site. Now, You have earned <b>5 Vote points.</b>. Thank Your!.');
        });

    //CART FUNCTIONS
        //ADD TO CART
        Route::post('shop/addtocart','CartController@add_to_cart');
        //CART VIEW
        Route::get('cart','CartController@cart_view')->name('cart');
        //CART CHECKOUT
        Route::get('cart/checkout','CartController@cart_checkout');

        //CART REMOVE BY ITEM
        Route::get('cart/{id}/remove','CartController@remove_by_item');
        //CART REMOVE ALL ITEMS
        Route::get('cart/remove/all','CartController@remove_items');

        //CART ITEM QUANTITY CONTROLL
        Route::get('cart/{com}/{id}/item','CartController@item_quantity');

    //Help desk
    Route::get('user/helpdesk','HelpdeskController@helpdesk_view');
        //Help desk create view
        Route::get('user/helpdesk/create','HelpdeskController@helpdesk_create_view');
        //Help desk create process
        Route::post('user/helpdesk/create','HelpdeskController@helpdesk_create_process');
        //Help desk view by id view
        Route::get('user/helpdesk/view/{id}','HelpdeskController@helpdesk_view_id');
        //Help desk view by id process
        Route::post('user/helpdesk/view/{id}/{receiver}','HelpdeskController@helpdesk_view_id_process');

    //CONVERTON POINTS VIEW
    Route::get('convertion','ConvertionController@convertion_view');
        //CONVERTION POINTS PROCESS
        Route::post('convertion','ConvertionController@convertion_process');
});

// Registered, activated, and is current user routes.
Route::group(['middleware' => ['auth', 'activated', 'currentUser', 'activity', 'twostep','installed','laravel']], function () {

    // User Profile and Account Routes
    Route::resource(
        'user/profile',
        'ProfilesController', [
            'names' => [
                'update' => 'user.update.info'
            ],
            'only' => [
                'index',
                'show',
                'edit',
                'update',
                'create',
            ],
        ]
    );
    Route::put('profile/{username}/updateUserAccount', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@updateUserAccount',
    ]);
    Route::put('profile/{username}/updateUserPassword', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@updateUserPassword',
    ]);
    Route::delete('profile/{username}/deleteUserAccount', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@deleteUserAccount',
    ]);

    // Route to show user avatar
    Route::get('images/profile/{id}/avatar/{image}', [
        'uses' => 'ProfilesController@userProfileAvatar',
    ]);

    // Route to upload user avatar.
    Route::post('user/profile/avatar/upload', ['as' => 'avatar.upload', 'uses' => 'ProfilesController@upload']);

    //USER tool
    Route::resource('user/password','PasswordController',[
        'names' => [
            'update' => 'users.password.update'
        ]
    ]);
    //Route::get('user/profilecreate','UserController@profilecreate');
    //Profile Timeline
    Route::get('profile/{name}','UserTimelineController@profile_view');
});

// Registered, activated, and is admin routes.
Route::group(['middleware' => ['auth', 'activated', 'role:admin', 'activity', 'twostep','installed','laravel']], function () {
    Route::resource('/users/deleted', 'SoftDeletesController', [
        'only' => [
            'index', 'show', 'update', 'destroy',
        ],
    ]);

    Route::resource('users', 'UsersManagementController', [
        'names' => [
            'index'   => 'users',
            'destroy' => 'user.destroy',
        ],
        'except' => [
            'deleted',
        ],
    ]);
    Route::post('search-users', 'UsersManagementController@search')->name('search-users');

    Route::resource('themes', 'ThemesManagementController', [
        'names' => [
            'index'   => 'themes',
            'destroy' => 'themes.destroy',
        ],
    ]);

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('routes', 'AdminDetailsController@listRoutes');
    Route::get('active-users', 'AdminDetailsController@activeUsers');

    //Database View
    Route::get('db/webpanel','DatabaseController@webpaneldb_view');
    Route::get('db/rangame','DatabaseController@rangame_view');
    Route::get('db/ranuser','DatabaseController@ranuser_view');
    Route::get('db/ranlog','DatabaseController@ranlog_view');
    Route::get('db/ranshop','DatabaseController@ranshop_view');
    //Database Process
    Route::post('db/webpanel','DatabaseController@webpaneldb_process');
    Route::post('db/rangame','DatabaseController@rangame_process');
    Route::post('db/ranuser','DatabaseController@ranuser_process');
    Route::post('db/ranlog','DatabaseController@ranlog_process');
    Route::post('db/ranshop','DatabaseController@ranshop_process');

    //REFRESH DB
    Route::get('refreshdb','DatabaseController@refreshdb_view');
        //REFRESH DB PROCESS
        Route::post('refreshdb','DatabaseController@refreshdb_process');

    //Check Connection
    Route::get('check/{con}','DatabaseController@check_connection');

    //Web Info View
    Route::get('web/informations','WebInfoController@informations');
    Route::get('web/meta','WebInfoController@meta');
    Route::get('web/mail','WebInfoController@mail');
    //Web Info Process
    Route::post('web/informations','WebInfoController@informations_process');
    Route::post('web/meta','WebInfoController@meta_process');
    Route::post('web/mail','WebInfoController@mail_process');
    //License Info
    Route::get('license','WebInfoController@license_info');
    Route::post('license','WebInfoController@license_process');

    //USERS view
    Route::get('game/users','UserController@users_view');
        //EDIT USER INFORMATIONS
        Route::get('game/users/{id}/informations','UserController@edit_informations_view');
        Route::post('game/users/{id}/informations','UserController@edit_informations_process');
        //EDIT USER PASSWORD
        Route::get('game/users/{id}/password','UserController@edit_password_view');
        Route::post('game/users/{id}/password','UserController@edit_password_process');
        //EDIT ACCOUNT TYPE
        Route::get('game/users/{id}/creds','UserController@edi_acctype_view');
        Route::post('game/users/{id}/creds','UserController@edi_acctype_process');

        //USERS restore view
        Route::get('game/users/restore','UserController@restore_index_view');
            //USERS RESTORE VIEW BY ID
            Route::get('game/users/{id}/restore','UserController@restore_view_id');
            //USERS RESTORE PROCESS
            Route::post('game/users/{id}/restore','UserController@restore_user');
    //Tool Reborn Setting View
    Route::get('tools/reborn/settings','ToolsController@reborn_settings_view');
        //Reborn Setting Process
        Route::post('tools/reborn/system','ToolsController@reborn_form_process');
    //Tool Reborn View
    Route::get('tools/reborn','ToolsController@reborn_view');
        //Request User`s Character Info
        Route::post('tools/reborn/charinfo','ToolsController@reborn_charinfo_process');
        //Reborn Process
        Route::post('tools/reborn','ToolsController@reborn_process');
    //Change School View
    Route::get('tools/changeschool','ToolsController@changeschool_view');
        //Change School Process
        Route::post('tools/changeschool','ToolsController@changeschool_process');
        //Change School Setting Process
        Route::post('tools/changeschool/currency','ToolsController@changeschool_settings_process');
    //Change Class View
    Route::get('tools/changeclass','ToolsController@changeclass_view');
        //Change class setting process
        Route::post('tools/changeclass/setting','ToolsController@changeclass_setting_process');
        //Change Class Process
        Route::post('tools/changeclass','ToolsController@changeclass_process');
    //Max Reborn Reward View
    Route::get('tools/maxrbreward','ToolsController@maxrbreward_view');
        //Max Reborn Reward Process
        Route::post('tools/maxrbreward','ToolsController@maxrbreward_process');
    //PK Points Reset View
    Route::get('tools/pkreset','ToolsController@pkreset_view');
        //PK Points Reset Setting Process
        Route::post('tools/pkreset/setting','ToolsController@pkreset_setting_process');
        //PK Points Reset Process
        Route::post('tools/pkreset','ToolsController@pkreset_process');
    //STATISTICAL POINTS RESET View
    Route::get('tools/statsreset','ToolsController@statsreset_view');
        //STATS POINTS RESET SETTING Process
        Route::post('tools/statsreset/setting','ToolsController@statsreset_setting_process');
        //STATS POINTS RESET PROCESS
        Route::post('tools/statsreset','ToolsController@statsreset_process');



    //EDIT ENV VIEW
    Route::get('webtool/env','WebToolController@env_view');
        //EDIT ENV PROCESS
        Route::post('webtool/env','WebToolController@env_process');
    //TOP UP CODE VIEW
    Route::get('webtool/topupcode','WebToolController@topupcode_view');
        //TOP UP CODE PROCESS
        Route::post('webtool/topupcodes','WebToolController@topupcode_process');
        //TOP UP CODE REVOKE PROCESS
        Route::get('webtool/topupcodes/revoke/{id}','WebToolController@topupcode_revoke_process');
    //ITEM SHOP
        //ITEM SHOP CREATE NEW VIEW
        Route::get('webtool/itemshop/create','WebToolController@itemshop_create_view');
        //ITEM SHOP CREATE NEW PROCESS
        Route::post('webtool/itemshop/create','WebToolController@itemshop_create_process');
        //ITEM SHOP LIST VIEW
        Route::get('webtool/itemshop','WebToolController@itemshop_list_view');
        //ITEM SHOP EDIT VIEW
        Route::get('webtool/itemshop/{id}/edit','WebToolController@itemshop_edit_view');
        //ITEM SHOP EDIT PROCESS
        Route::post('webtool/itemshop/{id}/edit','WebToolController@itemshop_edit_process');
        //ITEM SHOP DELETE PROCESS
        Route::get('webtool/itemshop/{id}/delete','WebToolController@itemshop_delete_process');
    //INSERT POINTS VIEW
    Route::get('webtool/insertpoints','WebToolController@insertpoints_view');
        //INSERT POINTS PROCESS
        Route::post('webtool/insertpoints','WebToolController@insertpoints_process');
    //ANNOUNCEMENTS
        //ANNOUNCEMENTS CREATE VIEW
        Route::get('webtool/news/create','WebToolController@news_create_view');
        //ANNOUNCEMENTS CREATE PROCESS
        Route::post('webtool/news/create','WebToolController@news_create_process');
        //ANNOUNCEMENTS LIST VIEW
        Route::get('webtool/news','WebToolController@news_view');
        //ANNOUNCEMENTS PER ITEM VIEW
        Route::get('webtool/news/{id}/show','WebToolController@news_view_byid');
        //ANNOUNCEMENTS EDIT VIEW
        Route::get('webtool/news/{id}/edit','WebToolController@news_edit_view');
        //ANNOUNCEMENTS EDIT PROCESS
        Route::post('webtool/news/{id}/edit','WebToolController@news_edit_process');
        //ANNOUNCEMENTS DELETE PROCESS
        Route::get('webtool/news/{id}/delete','WebToolController@news_delete_process');
    //DOWNLOAD PAGE
        //DOWNLOAD PAGE VIEW
        Route::get('webtool/download/create','WebToolController@download_create_view');
        //DOWNLOAD PAGE PROCESS
        Route::post('webtool/download/create','WebToolController@download_create_process');
        //DOWNLOAD PAGE LIST VIEW
        Route::get('webtool/download','WebToolController@download_list_view');
        //DOWNLOAD PAGE VIEW TITLE
        Route::get('webtool/download/{title}/show','WebToolController@download_view_id');
        //DOWNLOAD PAGE EDIT VIEW
        Route::get('webtool/download/{id}/edit','WebToolController@download_edit_view');
        //DOWNLOAD PAGE EDIT PROCESS
        Route::post('webtool/download/{id}/edit','WebToolController@download_edit_process');
        //DOWNLOAD PAGE CONTENT DELETE PROCESS
        Route::get('webtool/download/{id}/delete','WebToolController@download_delete_process');
    //ABOUT USE PAGE
        //ABOUT US PAGE VIEW
        Route::get('webtool/aboutus','WebToolController@about_us_view');
        //ABOUT US PAGE PROCESS
        Route::post('webtool/aboutus','WebToolController@about_us_prorcess');
    //VOTING SYSTEM VIEW
    Route::get('webtool/vote','WebToolController@vote_view');
        //VOTING SYSTEM CREATE PROCESS
        Route::post('webtool/vote/create','WebToolController@vote_create_process');
        //VOTING SYSTEM EDIT VIEW
        Route::get('webtool/vote/edit/{id}','WebToolController@vote_edit_view');
        //VOTING SYSTEM EDIT PROCESS
        Route::post('webtool/vote/edit/{id}','WebToolController@vote_edit_process');
        //VOTING SYSTEM DELETE PROCESS
        Route::get('webtool/vote/delete/{id}','WebToolController@vote_delete_process');
    //KNOWLEDGE BASE
        //KNOWLEDGE BASE CREATE VIEW
        Route::get('webtool/knowledgebase/create','WebToolController@knowledgebase_create_view');
        //KNOWLEDGE BASE CREATE PROCESS
        Route::post('webtool/knowledgebase/create','WebToolController@knowledgebase_create_process');
        //KNOWLEDGE BASE CREATE CATEGORY VIEW
        Route::get('webtool/knowledgebase/create/category','WebToolController@knowledgebase_create_category_view');
        //KNOWLEDGE BASE CREATE CATEGORY PROCESS
        Route::post('webtool/knowledgebase/create/category','WebToolController@knowledgebase_create_category_process');
        //KNOWLEDGE BASE EDIT CATEGORY VIEW
        Route::get('webtool/knowledgebase/category/{id}/edit','WebToolController@knowledgebase_edit_category_view');
        //KNOWLEDGE BASE EDIT CATEGORY PROCESS
        Route::post('webtool/knowledgebase/category/{id}/edit','WebToolController@knowledgebase_edit_category_process');
        //KNOWLEDGE BASE DELETE CATEGORY PROCESS
        Route::get('webtool/knowledgebase/category/{id}/delete','WebToolController@knowledgebase_delete_category_process');
        //KNOWLEDGE BASE LIST VIEW
        Route::get('webtool/knowledgebase','WebToolController@knowledgebase_list_view');
        //KNOWLEDGE BASE VIEW BY ID
        Route::get('webtool/knowledgebase/{id}/view','WebToolController@knowledgebase_view_id');
        //KNOWLEDGE BASE EDIT BY ID
        Route::get('webtool/knowledgebase/{id}/edit','WebToolController@knowledgebase_edit_id');
        //KNOWLEDGE BASE EDIT BY ID PROCESS
        Route::post('webtool/knowledgebase/{id}/edit','WebToolController@knowledgebase_edit_id_process');
        //KNOWLEDGE BASE DELETE BY ID
        Route::get('webtool/knowledgebase/{id}/delete','WebToolController@knowledgebase_delete_id');

    //Help desk
    Route::get('helpdesk','HelpdeskController@helpdesk_view');
        //Help desk create view
        Route::get('helpdesk/create','HelpdeskController@helpdesk_create_view');
        //Help desk create process
        Route::post('helpdesk/create','HelpdeskController@helpdesk_create_process');
        //Help desk view by id view
        Route::get('helpdesk/view/{id}','HelpdeskController@helpdesk_view_id');
        //Help desk view by id process
        Route::post('helpdesk/view/{id}/{receiver}','HelpdeskController@helpdesk_view_id_process');


});

Route::redirect('/php', '/phpinfo', 301);
