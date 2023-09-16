<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Cards\Help;

use Laravel\Nova\Dashboards\Main as Dashboard;
use Stepanenko3\NovaCards\Cards\CacheCard;
use Stepanenko3\NovaCards\Cards\GreeterCard;
use Stepanenko3\NovaCards\Cards\HtmlCard;
use Stepanenko3\NovaCards\Cards\SystemResourcesCard;
use Stepanenko3\NovaCards\Cards\VersionsCard;
use Stepanenko3\NovaCards\Cards\WorldClockCard;

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
            //new Help,

            GreeterCard::make()
                ->user(
                    name: $user->username,
                    title: 'Admin',
                )
                ->message(
                    text: 'Welcome back,',
                )
                ->button(
                    name: 'Profile',
                    target: '/admin/resources/users/' . $user->id,
                )
                ->button(
                    name: 'Users',
                    target: '/admin/resources/users',
                )
                ->avatar(
                    url: $user->avatar
                        ? storage_url($user->avatar, 'public')
                        :  'https://www.gravatar.com/avatar/'.md5($user->email)
                ),
            (new HtmlCard)
                ->width('1/3')
                ->html(
        "<h1 class='text-red-400'>Message:</h1>
                    <span># This project is totally for free</span><br>
                    <span># Please Don't be a dick, leave my name in footer</span><br><br>

                    <h1 class='text-red-400'>Links:</h1>
                    <span>Github:</span><a href='https://github.com/m1xawy/isro-portal'>https://github.com/m1xawy/isro-portal</a><br>
                    <span>Discord:</span><a href='https://discord.com/users/462695018751328268'>m1xawy</a><br>
                    <p></p>"
                ), // Required
            (new WorldClockCard())
                ->timezones([ // Required
                    'Africa/Cairo',
                    'Europe/Istanbul',
                    'Europe/Berlin',
                ])
                ->title(__('World Clock')), // Optional

            (new CacheCard),
            (new SystemResourcesCard),
            (new VersionsCard),
        ];
    }
}
