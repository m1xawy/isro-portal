<?php

namespace App\Nova\Settings;

use AlexAzartsev\Heroicon\Heroicon;
use Alexwenzel\DependencyContainer\DependencyContainer;
use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Panel;
use Outl1ne\NovaSettings\NovaSettings;
use Timothyasp\Color\Color;
use Whitecube\NovaFlexibleContent\Flexible;

class General
{
    public function __construct()
    {
        return [
            NovaSettings::addSettingsFields([
                new Tabs('General', [

                    new Tab('General', [
                        Text::make('Server Name', 'server_name'),
                        Text::make('Description', 'server_desc'),
                        Text::make('Server Url', 'server_url'),
                        Image::make('Favicon', 'server_favicon'),
                        Image::make('Logo', 'server_logo'),
                    ]),

                    new Tab('Misc', [
                        Select::make('Server Time Zone', 'server_timezone')->options(['UTC' => 'UTC', 'Africa/Cairo' => 'Africa/Cairo']),
                        Select::make('Site Language', 'server_lang')->options(['switch' => 'Switch', 'en' => 'English', 'ar' => 'Arabic']),
                        Select::make('Server files', 'server_files_type')->options(['isro' => 'iSRO', 'vsro' => 'vSRO']),
                        Number::make('News Posts limit', 'server_news_limit'),
                        Number::make('Max Player', 'server_max_player'),
                        Number::make('Discord Server ID', 'server_discord_id'),
                    ]),

                    new Tab('Appearance', [
                        Boolean::make('BreadCrumb Enable', 'breadcrumb_enable'),
                        Select::make('Site Theme', 'site_theme')->options(['default_theme' => 'Default', 'add_new' => 'Add new']),

                        DependencyContainer::make([
                            Select::make('Theme Mode', 'theme_mode')->options(['switch' => 'Switch', 'dark' => 'Dark', 'light' => 'Light', 'customize' => 'Customize']),
                        ])->dependsOn('site_theme', 'default_theme'),

                        DependencyContainer::make([
                            Text::make('Theme Name', 'theme_name')->help('Enter Theme Name'),
                        ])->dependsOn('site_theme', 'add_new'),

                        DependencyContainer::make([
                            Image::make('Background Image', 'color_background_image'),
                            Color::make('Background Color', 'color_background')->chrome()->help('default: #111827'),
                            Color::make('Navbar Color', 'color_navbar')->chrome()->help('default: #1f2937'),
                            Color::make('Footer Color', 'color_footer')->chrome()->help('default: #1f2937'),
                            Color::make('Boxes Color', 'color_boxes')->chrome()->help('default: #1f2937'),
                            Color::make('Dropdown Color', 'color_dropdown')->chrome()->help('default: #374151'),
                            Color::make('Border Color', 'color_border')->chrome()->help('default: #374151'),
                            Color::make('Heading Color', 'color_heading')->chrome()->help('default: #f3f4f6'),
                            Color::make('Paragraph Color', 'color_paragraph')->chrome()->help('default: #9ca3af'),
                            Color::make('Link Color', 'color_link')->chrome()->help('default: #9ca3af'),
                            Color::make('Button Background Color', 'color_background_button')->chrome()->help('default: #1f2937'),
                            Color::make('Button Color', 'color_button')->chrome()->help('default: #e5e7e'),
                            Color::make('Input Color', 'color_input')->chrome()->help('default: #111827'),
                            Color::make('Hover Color', 'color_hover')->chrome()->help('default: #1f2937'),
                        ])->dependsOn('site_theme', 'default_theme'),
                    ]),

                    new Tab('Slider', [
                        Flexible::make('Slider', 'slider')
                            ->addLayout('Slider', 'slider', [
                                Text::make('Title', 'slider_title'),
                                Text::make('Description', 'slider_desc'),
                                URL::make('URL', 'slider_url'),
                                URL::make('Image URL', 'slider_image'),
                            ]),
                    ]),

                    new Tab('Social links', [
                        Flexible::make('Social', 'socials')
                            ->addLayout('Social', 'social', [
                                Heroicon::make('Icon', 'social_icon'),
                                Text::make('Name', 'social_name'),
                                URL::make('URL', 'social_url'),
                            ]),
                    ]),

                    new Tab('Back links', [
                        Flexible::make('Backlinks', 'backlinks')
                            ->addLayout('Backlinks', 'backlinks', [
                                Text::make('Name', 'backlink_name'),
                                URL::make('URL', 'backlink_url'),
                                URL::make('Icon URL', 'backlink_icon'),
                            ]),
                    ]),

                ]),
            ], [], 'General'),
        ];
    }
}
