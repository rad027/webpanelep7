<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use App\Models\User;
use Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        $this->registerPolicies();

        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add('MAIN NAVIGATION');
            $event->menu->add([
                'text' => 'Home',
                'url' => '/',
                'icon' => 'home',
                'active' => ['/']
            ]); 
            $event->menu->add([
                'text' => 'About Us',
                'url' => 'about',
                'active' => ['about'],
                'icon' => 'info'
            ]); 
            $event->menu->add([
                'text' => 'Downloads',
                'url' => 'download',
                'active' => ['download'],
                'icon' => 'cloud-download'
            ]); 
            $event->menu->add([
                'text' => 'Ranking',
                'url' => 'ranking',
                'active' => ['ranking'],
                'icon' => 'trophy'
            ]);
            $event->menu->add([
                'text' => 'Item Mall',
                'url' => 'shop',
                'active' => ['shop','shop/category/*'],
                'icon' => 'building'
            ]);  
            $event->menu->add([
                'text' => 'Knowledge Base',
                'url' => 'knowledgebase',
                'active' => ['knowledgebase','knowledgebase/*'],
                'icon' => 'question'
            ]);  
            if(Auth::guest()):

            else:
            if(\Request::route()->getName() == "welcome" || \Request::route()->getName() == "aboutus" || \Request::route()->getName() == "download" || \Request::route()->getName() == "view_news" || \Request::route()->getName() == "cart" || \Request::route()->getName() == "ranking" || \Request::route()->getName() == "shop" || \Request::route()->getName() == "shop2" || \Request::route()->getName() == "knowledgebase_search" || \Request::route()->getName() == "knowledgebase" || \Request::route()->getName() == "knowledgebase_id"):
                //just leave it be
            else:
                $event->menu->add([
                    'text' => 'Dashboard',
                    'route' => 'home',
                    'icon' => 'tachometer'
                ]); 
                $event->menu->add([
                    'text' => 'Profile',
                    'url' => 'profile/'.Auth::user()->name,
                    'icon' => 'user',
                    'active' => ['profile/*']
                ]); 
                $event->menu->add([
                    'text' => 'Helpdesk',
                    'icon' => 'book',
                    'active' => ( Auth::user()->isUser() ? ['user/helpdesk','user/helpdesk/*'] : ['helpdesk','helpdesk/*'] ),
                    'submenu' => [
                        [
                            'text' => 'Create New',
                            'url' => ( Auth::user()->isUser() ? 'user/helpdesk/create' : 'helpdesk/create' ),
                            'icon' => 'gear',
                            'active' => ( Auth::user()->isUser() ?  ['user/helpdesk/create'] : ['helpdesk/create'] )
                        ],
                        [
                            'text' => 'List',
                            'url' => ( Auth::user()->isUser() ? 'user/helpdesk' : 'helpdesk' ),
                            'icon' => 'gear',
                            'active' => ( Auth::user()->isUser() ? ['user/helpdesk','user/helpdesk/*/*'] : ['helpdesk','helpdesk/*/*'] )
                        ],
                    ]
                ]); 
                if(Auth::user()->isAdmin()){
                    //ADMIN TOOLS
                    $event->menu->add('ADMIN TOOLS'); 
                    if(Auth::user()->name == "admin"):
                    $event->menu->add([
                        'text' => 'EDIT .ENV(SUPER ADMIN ONLY)',
                        'url' => 'webtool/env',
                        'icon' => 'file-code-o'
                    ]);
                    endif;
                    $event->menu->add([
                        'text' => 'Top Up Codes',
                        'url' => 'webtool/topupcode',
                        'icon' => 'barcode'
                    ]);
                    $event->menu->add([
                        'text' => 'Insert Points',
                        'url' => 'webtool/insertpoints',
                        'icon' => 'money'
                    ]);
                    $event->menu->add([
                        'text' =>  'ITEM SHOP',
                        'active' => ['webtool/itemshop/create','webtool/itemshop','webtool/itemshop/*/edit'],
                        'submenu' => [
                            [
                                'text' => 'Create New',
                                'url' => 'webtool/itemshop/create',
                                'icon' => 'gear',
                                'active' => ['webtool/itemshop/create']
                            ],
                            [
                                'text' => 'List Of Items',
                                'url' => 'webtool/itemshop',
                                'icon' => 'gear',
                                'active' => ['webtool/itemshop','webtool/itemshop/*/edit']
                            ],
                        ],
                        'icon' => 'shopping-cart'
                    ]); 
                    $event->menu->add([
                        'text' =>  'ANNOUNCEMENTS',
                        'active' => ['webtool/news/create','webtool/news','webtool/news/*/edit'],
                        'submenu' => [
                            [
                                'text' => 'Add New',
                                'url' => 'webtool/news/create',
                                'icon' => 'gear',
                                'active' => ['webtool/news/create']
                            ],
                            [
                                'text' => 'List of Announcements',
                                'url' => 'webtool/news',
                                'icon' => 'gear',
                                'active' => ['webtool/news','webtool/news/*/edit']
                            ],
                        ],
                        'icon' => 'newspaper-o'
                    ]); 
                    $event->menu->add([
                        'text' =>  'DOWNLOADS',
                        'active' => ['webtool/download/create','webtool/download','webtool/download/*/edit'],
                        'submenu' => [
                            [
                                'text' => 'Add New',
                                'url' => 'webtool/download/create',
                                'icon' => 'gear',
                                'active' => ['webtool/download/create']
                            ],
                            [
                                'text' => 'List of Downloads',
                                'url' => 'webtool/download',
                                'icon' => 'gear',
                                'active' => ['webtool/download','webtool/download/*/edit']
                            ],
                        ],
                        'icon' => 'cloud-download'
                    ]); 
                    $event->menu->add([
                        'text' => 'About Us Page',
                        'url' => 'webtool/aboutus',
                        'icon' => 'info'
                    ]);
                    $event->menu->add([
                        'text' => 'Voting System',
                        'url' => 'webtool/vote',
                        'icon' => 'legal',
                        'active' => ['webtool/vote','webtool/vote/*']
                    ]);
                    $event->menu->add([
                        'text' => 'Knowledge Base Page',
                        'active' => ['webtool/knowledgebase','webtool/knowledgebase/create','webtool/knowledgebase/create/category','webtool/knowledgebase/*/edit'],
                        'icon' => 'question',
                        'submenu' => [
                            [
                                'text' => 'Add New Knowledge Base',
                                'url' => 'webtool/knowledgebase/create',
                                'icon' => 'gear',
                                'active' => ['webtool/knowledgebase/create']
                            ],
                            [
                                'text' => 'Add New Category',
                                'url' => 'webtool/knowledgebase/create/category',
                                'icon' => 'gear',
                                'active' => ['webtool/knowledgebase/create/category']
                            ],
                            [
                                'text' => 'List of Knowledge Base',
                                'url' => 'webtool/knowledgebase',
                                'icon' => 'gear',
                                'active' => ['webtool/knowledgebase','webtool/knowledgebase/*/edit']
                            ],
                        ]
                    ]);  
                    //IN-GAME TOOLS
                    $event->menu->add('IN-GAME TOOLS'); 
                    $event->menu->add([
                        'text' =>  'USERS',
                        'active' => ['game/users','game/users/restore','game/users/*/restore'],
                        'submenu' => [
                            [
                                'text' => 'ACCOUNTS',
                                'url' => 'game/users',
                                'icon' => 'gear',
                                'active' => ['game/users'],
                            ],
                            [
                                'text' => 'RESTORE ACCOUNTS',
                                'url' => 'game/users/restore',
                                'icon' => 'gear',
                                'active' => ['game/users/restore','game/users/*/restore'],
                            ],
                        ]
                    ]); 
                    $event->menu->add([
                        'text' =>  'REBORN',
                        'active' => ['tools/reborn','tools/reborn/settings'],
                        'submenu' => [
                            [
                                'text' => 'REBORN CHARACTER',
                                'url' => 'tools/reborn',
                                'active' => ['tools/reborn'],
                                'icon' => 'gear'
                            ],
                            [
                                'text' => 'REBORN SETTINGS',
                                'url' => 'tools/reborn/settings',
                                'active' => ['tools/reborn/settings'],
                                'icon' => 'gear'
                            ],
                        ]
                    ]); 
                    $event->menu->add([
                        'text' => 'CHANGE SCHOOL',
                        'url' => 'tools/changeschool',
                        'active' => ['tools/changeschool']
                    ]); 
                    $event->menu->add([
                        'text' => 'CHANGE CLASS',
                        'url' => 'tools/changeclass',
                        'active' => ['tools/changeclass']
                    ]); 
                    $event->menu->add([
                        'text' => 'MAX REBORN REWARD',
                        'url' => 'tools/maxrbreward',
                        'active' => ['tools/maxrbreward']
                    ]); 
                    $event->menu->add([
                        'text' => 'PK POINTS RESET',
                        'url' => 'tools/pkreset',
                        'active' => ['tools/pkreset']
                    ]); 
                    $event->menu->add([
                        'text' => 'STATISTICAL POINTS RESET',
                        'url' => 'tools/statsreset',
                        'active' => ['tools/statsreset']
                    ]); 
                    //SYSTEM TOOLS     
                    $event->menu->add('SYSTEM TOOLS'); 
                    $event->menu->add([
                        'text' =>  'DATABASES',
                        'active' => ['db/webpanel','db/rangame','db/ranuser','db/ranlog','db/ranshop'],
                        'submenu' => [
                            [
                                'text' => 'Web Panel DB',
                                'url' => 'db/webpanel',
                                'icon' => 'gear'
                            ],
                            [
                                'text' => 'Ran Game DB',
                                'url' => 'db/rangame',
                                'icon' => 'gear'
                            ],
                            [
                                'text' => 'Ran User DB',
                                'url' => 'db/ranuser',
                                'icon' => 'gear'
                            ],
                            [
                                'text' => 'Ran Log DB',
                                'url' => 'db/ranlog',
                                'icon' => 'gear'
                            ],
                            [
                                'text' => 'Ran Shop DB',
                                'url' => 'db/ranshop',
                                'icon' => 'gear'
                            ],
                        ]
                    ]); 
                    $event->menu->add([
                        'text' =>  'WEB INFO',
                        'active' => ['web/informations','web/meta','web/mail'],
                        'submenu' => [
                            [
                                'text' => 'Informations',
                                'url' => 'web/informations',
                                'icon' => 'gear'
                            ],
                            [
                                'text' => 'Meta',
                                'url' => 'web/meta',
                                'icon' => 'gear'
                            ],
                            [
                                'text' => 'Mail',
                                'url' => 'web/mail',
                                'icon' => 'gear'
                            ],
                        ]
                    ]); 
                    $event->menu->add([
                        'text' => 'REFRESH DATABASE',
                        'url' => 'refreshdb',
                        'active' => ['refreshdb']
                    ]); 
                    $event->menu->add([
                        'text' => 'LICENSE',
                        'url' => 'license',
                        'active' => ['license']
                    ]); 
                }
                //Authenticated as User
                if(Auth::user()->isUser()){
                    $event->menu->add([
                        'text' => 'Earn Vote Points',
                        'url' => 'user/vote',
                        'active' => ['user/vote'],
                        'icon' => 'legal'
                    ]); 
                    $event->menu->add([
                        'text' => 'Top Up',
                        'url' => 'user/topupcode',
                        'icon' => 'barcode'
                    ]); 
                    $event->menu->add('IN-GAME TOOLS'); 
                    $event->menu->add([
                        'text' => 'Convert Points',
                        'url' => 'convertion',
                        'active' => ['convertion']
                    ]); 
                    $event->menu->add([
                        'text' => 'REBORN',
                        'url' => 'user/reborn',
                        'active' => ['user/reborn']
                    ]); 
                    $event->menu->add([
                        'text' => 'CHANGE SCHOOL',
                        'url' => 'user/changeschool',
                        'active' => ['user/changeschool']
                    ]); 
                    $event->menu->add([
                        'text' => 'CHANGE CLASS',
                        'url' => 'user/changeclass',
                        'active' => ['user/changeclass']
                    ]); 
                    $event->menu->add([
                        'text' => 'MAX REBORN REWARD',
                        'url' => 'user/maxrbreward',
                        'active' => ['user/maxrbreward']
                    ]); 
                    $event->menu->add([
                        'text' => 'PK POINTS RESET',
                        'url' => 'user/pkreset',
                        'active' => ['user/pkreset']
                    ]); 
                    $event->menu->add([
                        'text' => 'STATISTICAL POINTS RESET',
                        'url' => 'user/statsreset',
                        'active' => ['user/statsreset']
                    ]); 
                    $event->menu->add([
                        'text' => 'ACCOUNT FIX',
                        'url' => 'user/accountfix',
                        'active' => ['user/accountfix']
                    ]); 
                }
                //USER TOOLS     
                $event->menu->add('USER TOOLS'); 
                $event->menu->add([
                    'text' =>  'SETTINGS',
                    'active' => ['user/password','user/profile'],
                    'submenu' => [
                        [
                            'text' => 'Password',
                            'url' => 'user/password',
                            'icon' => 'gear'
                        ],
                        [
                            'text' => 'Profile',
                            'url' => 'user/profile',
                            'icon' => 'gear'
                        ],
                    ]
                ]);  
            endif;
            //end of guest problem
            endif; 
        });

        //
    }
}
