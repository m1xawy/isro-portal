<?php

namespace App\Nova\Settings;

use AlexAzartsev\Heroicon\Heroicon;
use Alexwenzel\DependencyContainer\DependencyContainer;
use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Outl1ne\NovaSettings\NovaSettings;
use Whitecube\NovaFlexibleContent\Flexible;

class Donate
{
    public function __construct()
    {
        return [
            NovaSettings::addSettingsFields([
                new Tabs('Donation Settings', [

                    new Tab('Paypal', [
                        Boolean::make('Paypal Enable', 'donate_paypal_enable'),

                        Select::make('Paypal Mode', 'donate_paypal_mode')->options(['donate_paypal_sandbox' => 'Sandbox', 'donate_paypal_live' => 'Live']),

                        DependencyContainer::make([
                            Text::make('Sandbox Client ID', 'donate_paypal_sandbox_client_id'),
                            Text::make('Sandbox Secret', 'donate_paypal_sandbox_secret'),
                        ])->dependsOn('donate_paypal_mode', 'donate_paypal_sandbox'),

                        DependencyContainer::make([
                            Text::make('Live Client ID', 'donate_paypal_live_client_id'),
                            Text::make('Live Secret', 'donate_paypal_live_secret'),
                        ])->dependsOn('donate_paypal_mode', 'donate_paypal_live'),

                        Flexible::make('Paypal Price List', 'donate_paypal_price_list')
                            ->addLayout('Paypal Add Package', 'donate_paypal_package_add', [
                                URL::make('Package Image URL', 'donate_paypal_package_image'),
                                Text::make('Package Title', 'donate_paypal_package_title'),
                                Text::make('Package Description', 'donate_paypal_package_desc'),
                                Text::make('Package Amount', 'donate_paypal_package_amount'),
                                Text::make('Package Value', 'donate_paypal_package_value'),
                            ]),
                    ]),

                    new Tab('Maxigame', [
                        Boolean::make('Maxigame Enable', 'donate_maxigame_enable'),

                        Text::make('Maxigame Api Key', 'donate_maxigame_api_key'),
                        Text::make('Maxigame Api Password', 'donate_maxigame_api_password'),

                        Flexible::make('Maxigame Price List', 'donate_maxigame_price_list')
                            ->addLayout('Maxigame Add Package', 'donate_maxigame_package_add', [
                                URL::make('Package Image URL', 'donate_maxigame_package_image'),
                                Text::make('Package Title', 'donate_maxigame_package_title'),
                                Text::make('Package Description', 'donate_maxigame_package_desc'),
                                Text::make('Package Amount', 'donate_maxigame_package_amount'),
                                Text::make('Package Value', 'donate_maxigame_package_value'),
                            ]),
                    ]),

                ]),
            ], [], 'Donation'),
        ];
    }
}
