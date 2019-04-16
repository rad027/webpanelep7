<?php

return [

    'app_config' => env('APP_INSTALL'),

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'Asia/Manila',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        // Laravel\Socialite\SocialiteServiceProvider::class,
        SocialiteProviders\Manager\ServiceProvider::class,
        SocialiteProviders\Generators\GeneratorsServiceProvider::class,
        Collective\Html\HtmlServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        App\Providers\MacroServiceProvider::class,
        jeremykenedy\LaravelRoles\RolesServiceProvider::class,
        App\Providers\ComposerServiceProvider::class,
        Creativeorange\Gravatar\GravatarServiceProvider::class,
        Intervention\Image\ImageServiceProvider::class,
        App\Providers\LocalEnvironmentServiceProvider::class,
        Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider::class,
        jeremykenedy\laravelexceptionnotifier\LaravelExceptionNotifier::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App'          => Illuminate\Support\Facades\App::class,
        'Artisan'      => Illuminate\Support\Facades\Artisan::class,
        'Auth'         => Illuminate\Support\Facades\Auth::class,
        'Blade'        => Illuminate\Support\Facades\Blade::class,
        'Broadcast'    => Illuminate\Support\Facades\Broadcast::class,
        'Bus'          => Illuminate\Support\Facades\Bus::class,
        'Cache'        => Illuminate\Support\Facades\Cache::class,
        'Config'       => Illuminate\Support\Facades\Config::class,
        'Cookie'       => Illuminate\Support\Facades\Cookie::class,
        'Crypt'        => Illuminate\Support\Facades\Crypt::class,
        'DB'           => Illuminate\Support\Facades\DB::class,
        'Eloquent'     => Illuminate\Database\Eloquent\Model::class,
        'Event'        => Illuminate\Support\Facades\Event::class,
        'File'         => Illuminate\Support\Facades\File::class,
        'Gate'         => Illuminate\Support\Facades\Gate::class,
        'Hash'         => Illuminate\Support\Facades\Hash::class,
        'Lang'         => Illuminate\Support\Facades\Lang::class,
        'Log'          => Illuminate\Support\Facades\Log::class,
        'Mail'         => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password'     => Illuminate\Support\Facades\Password::class,
        'Queue'        => Illuminate\Support\Facades\Queue::class,
        'Redirect'     => Illuminate\Support\Facades\Redirect::class,
        'Redis'        => Illuminate\Support\Facades\Redis::class,
        'Request'      => Illuminate\Support\Facades\Request::class,
        'Response'     => Illuminate\Support\Facades\Response::class,
        'Route'        => Illuminate\Support\Facades\Route::class,
        'Schema'       => Illuminate\Support\Facades\Schema::class,
        'Session'      => Illuminate\Support\Facades\Session::class,
        'Storage'      => Illuminate\Support\Facades\Storage::class,
        'URL'          => Illuminate\Support\Facades\URL::class,
        'Validator'    => Illuminate\Support\Facades\Validator::class,
        'View'         => Illuminate\Support\Facades\View::class,
        'Form'         => \Collective\Html\FormFacade::class,
        'HTML'         => \Collective\Html\HtmlFacade::class,
        'Socialite'    => Laravel\Socialite\Facades\Socialite::class,
        'Input'        => Illuminate\Support\Facades\Input::class,
        'Gravatar'     => Creativeorange\Gravatar\Facades\Gravatar::class,
        'Image'        => Intervention\Image\Facades\Image::class,
        'Uuid'         => Webpatser\Uuid\Uuid::class,
        'HTMLMin'       => HTMLMin\HTMLMin\Facades\HTMLMin::class,
    ],

    //Web Setting

    'reborn_system' =>  env('REBORN_SYSTEM',1),

    //Reborn Stage 1
    'reborn' => [
        '1' => [
            'level'     => env('REBORN1_LEVEL'),
            'gold'      => env('REBORN1_GOLD'),
            'reward'    => env('REBORN1_REWARD'),
            'from'      => env('REBORN1_COUNT_FROM'),
            'to'        => env('REBORN1_COUNT_TO')
        ],
        '2' => [
            'status'    => env('REBORN2_STATUS'),
            'level'     => env('REBORN2_LEVEL'),
            'gold'      => env('REBORN2_GOLD'),
            'reward'    => env('REBORN2_REWARD'),
            'from'      => env('REBORN2_COUNT_FROM'),
            'to'        => env('REBORN2_COUNT_TO')
        ],
        '3' => [
            'status'    => env('REBORN3_STATUS'),
            'level'     => env('REBORN3_LEVEL'),
            'gold'      => env('REBORN3_GOLD'),
            'reward'    => env('REBORN3_REWARD'),
            'from'      => env('REBORN3_COUNT_FROM'),
            'to'        => env('REBORN3_COUNT_TO')
        ],
        '4' => [
            'status'    => env('REBORN4_STATUS'),
            'level'     => env('REBORN4_LEVEL'),
            'gold'      => env('REBORN4_GOLD'),
            'reward'    => env('REBORN4_REWARD'),
            'from'      => env('REBORN4_COUNT_FROM'),
            'to'        => env('REBORN4_COUNT_TO')
        ],
        '5' => [
            'status'    => env('REBORN5_STATUS'),
            'level'     => env('REBORN5_LEVEL'),
            'gold'      => env('REBORN5_GOLD'),
            'reward'    => env('REBORN5_REWARD'),
            'from'      => env('REBORN5_COUNT_FROM'),
            'to'        => env('REBORN5_COUNT_TO')
        ],
    ],

    'change_school' => [
        'currency'          =>  env('CHANGE_SCHOOL_CURRENCY'),
        'required_amount'   =>  env('CHANGE_SCHOOL_REQUIRED_AMOUNT'),
    ],

    'change_class'  =>  [
        'currency'                  => env('CHANGE_CLASS_CURRENCY'),
        'required_amount'           => env('CHANGE_CLASS_AMOUNT'),
        'change_class_archer'       => env('CHANGE_CLASS_ARCHER'),
        'change_class_brawler'      => env('CHANGE_CLASS_BRAWLER'),
        'change_class_swordsman'    => env('CHANGE_CLASS_SWORDSMAN'),
        'change_class_shaman'       => env('CHANGE_CLASS_SHAMAN'),
        'change_class_gunner'       => env('CHANGE_CLASS_GUNNER')
    ],

    'pk_points' =>  [
        'currency'          =>  env('PK_POINTS_CURRENCY'),
        'required_amount'   =>  env('PK_POINTS_AMOUNT')
    ],

    'stats_points' =>  [
        'currency'          =>  env('STATISTICAL_POINTS_CURRENCY'),
        'required_amount'   =>  env('STATISTICAL_POINTS_AMOUNT')
    ],

    'timeline' => [
        'statsreset'            =>  'Statistical Points Reset',
        'pkpointsreset'         =>  'PK Points Reset',
        'maxrbreward'           =>  'Max Reborn Reward',
        'change_class'          =>  'Change Class',
        'change_school'         =>  'Change School',
        'topupcode'             =>  'Top Up Codes',
        'reborn'                =>  'Reborn System',
        'itemshop'              =>  'Item Mall',
        'itemmall'              =>  'Item Mall',
        'insertpoints'          =>  'Insert Points',
        'announcement'          =>  'News & Announcements',
        'downloads'             =>  'Download Page',
        'aboutus'               =>  'About Us Process',
        'password'              =>  'Password Update',
        'avatar_update'         =>  'Avatar/Profile Picture Update',
        'profile_update'        =>  'Profile Information Update',
        'user_update'           =>  'User Update',
        'webinfo'               =>  'Web Information Update',
        'metainfo'              =>  'Meta Information Update',
        'mailserver'            =>  'Mail Server Information Update',
        'license_update'        =>  'License Information Update',
        'helpdesk'              =>  'Helpdesk',
        'votepage'              =>  'Voting System',
        'knowledgebase'         =>  'Knowledge Base',
        'convert_points'        =>  'Points Convertion'
    ],

    'convert_points'    =>  [
        //VP TO EP
        'FROM_VP_TO_EP_REQUIRED_AMOUNT'         =>  env('FROM_VP_TO_EP_REQUIRED_AMOUNT'),
        'FROM_VP_TO_EP_AMOUNT'                  =>  env('FROM_VP_TO_EP_AMOUNT'),
        //EP TO VP
        'FROM_EP_TO_VP_REQUIRED_AMOUNT'         =>  env('FROM_EP_TO_VP_REQUIRED_AMOUNT'),
        'FROM_EP_TO_VP_AMOUNT'                  =>  env('FROM_EP_TO_VP_AMOUNT'),
        //VP TO GOLD
        'FROM_VP_TO_GOLD_REQUIRED_AMOUNT'       =>  env('FROM_VP_TO_GOLD_REQUIRED_AMOUNT'),
        'FROM_VP_TO_GOLD_AMOUNT'                =>  env('FROM_VP_TO_GOLD_AMOUNT'),
        //EP TO GOLD
        'FROM_EP_TO_GOLD_REQUIRED_AMOUNT'       =>  env('FROM_EP_TO_GOLD_REQUIRED_AMOUNT'),
        'FROM_EP_TO_GOLD_AMOUNT'                =>  env('FROM_EP_TO_GOLD_AMOUNT'),
        //VP TO PP
        'FROM_VP_TO_PP_REQUIRED_AMOUNT'         =>  env('FROM_VP_TO_PP_REQUIRED_AMOUNT'),
        'FROM_VP_TO_PP_AMOUNT'                  =>  env('FROM_VP_TO_PP_AMOUNT'),
        //EP TO PP
        'FROM_EP_TO_PP_REQUIRED_AMOUNT'         =>  env('FROM_EP_TO_PP_REQUIRED_AMOUNT'),
        'FROM_EP_TO_PP_AMOUNT'                  =>  env('FROM_EP_TO_PP_AMOUNT'),
        //VP TO ZG
        'FROM_VP_TO_ZG_REQUIRED_AMOUNT'         =>  env('FROM_VP_TO_ZG_REQUIRED_AMOUNT'),
        'FROM_VP_TO_ZG_AMOUNT'                  =>  env('FROM_VP_TO_ZG_AMOUNT'),
        //EP TO ZG
        'FROM_EP_TO_ZG_REQUIRED_AMOUNT'         =>  env('FROM_EP_TO_ZG_REQUIRED_AMOUNT'),
        'FROM_EP_TO_ZG_AMOUNT'                  =>  env('FROM_EP_TO_ZG_AMOUNT'),
    ],
];
