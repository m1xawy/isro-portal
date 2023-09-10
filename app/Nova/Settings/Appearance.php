<?php

namespace App\Nova\Settings;

use Alexwenzel\DependencyContainer\DependencyContainer;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Outl1ne\NovaSettings\NovaSettings;
use Timothyasp\Color\Color;

class Appearance
{
    public function __construct()
    {
        return [
            NovaSettings::addSettingsFields([
                Select::make('Theme Name', 'theme_name')->options(['default' => 'Default', 'add' => 'Add new']),

                DependencyContainer::make([
                    Select::make('Theme Mode', 'theme_mode')->options(['switch' => 'Switch', 'dark' => 'Dark', 'light' => 'Light', 'customize' => 'Customize']),
                ])->dependsOn('theme_name', 'default'),

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
                ])->dependsOn('theme_mode', 'dark')->dependsOn('theme_name', 'default'),
            ], [], 'Appearance'),
        ];
    }
}
