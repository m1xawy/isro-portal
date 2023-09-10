<?php

namespace Laravel\Nova;

trait ManagesPresets
{
    /**
     * Indicates the preset the field should use.
     *
     * @var string
     */
    public $preset = 'default';

    /**
     * Define the preset the field should use, optionally providing a new preset class to add.
     *
     * @param  string  $preset
     * @param  string|null  $presetClass
     * @return $this
     */
    public function preset($preset, $presetClass = null)
    {
        if (! is_null($presetClass)) {
            $this->presets[$preset] = $presetClass;
        }

        $this->preset = $preset;

        return $this;
    }

    /**
     * Create a new instance of the configured preset.
     *
     * @return object
     */
    public function newPreset()
    {
        return new $this->presets[$this->preset];
    }
}
