<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Cards\Help;

use Laravel\Nova\Dashboards\Main as Dashboard;

use Orion\NovaGreeter\GreeterCard;
use Akbsit\NovaCardCache\NovaCardCache;
use InteractionDesignFoundation\HtmlCard\HtmlCard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        $user = auth()->user();

        return [
            GreeterCard::make()
                ->user(name: $user->username, title: 'Admin')
                ->message(text: 'Welcome back,')
                ->button(name: 'Profile', target: '/nova/resources/users' . $user->id)
                ->button(name: 'See users', target: '/nova/resources/users')
                ->avatar(url: 'https://www.gravatar.com/avatar/' .md5($user->email))
                ->width('1/3'),

            (new HtmlCard)
                ->width('1/3')
                ->html(
        "<h1 class='text-red-400'>Message:</h1>
                    <span># This project is totally for free</span><br>
                    <span># Please Don't be a dick, leave my name in footer</span><br>
                    <span># If you're using this in commercial, Please buy Nova license</span><br><br>

                    <h1 class='text-red-400'>Links:</h1>
                    <span>Github:</span><a href='https://github.com/m1xawy/isro-portal'>https://github.com/m1xawy/isro-portal</a><br>
                    <span>Discord:</span><a href='https://discord.com/users/462695018751328268'>m1xawy</a><br>
                    <p></p>"
                ),

            NovaCardCache::make(),
        ];
    }
}
