<?php

namespace Laravel\Nova\Testing\Browser\Components;

use Laravel\Dusk\Component as BaseComponent;
use Laravel\Nova\Testing\Browser\Concerns\InteractsWithElements;

abstract class Component extends BaseComponent
{
    use InteractsWithElements;
}
