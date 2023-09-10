<?php

namespace Laravel\Nova\Support;

use Illuminate\Support\Str;
use Illuminate\Support\Traits\ForwardsCalls;
use JsonSerializable;

/**
 * @mixin \Illuminate\Support\Stringable
 */
class PendingTranslation implements JsonSerializable
{
    use ForwardsCalls;

    /**
     * The translation string.
     *
     * @var string|null
     */
    public $key;

    /**
     * The translation replacement.
     *
     * @var array<string, string>
     */
    public $replace = [];

    /**
     * The translation locale.
     *
     * @var string|null
     */
    public $locale = null;

    /**
     * The translation transformation callback.
     *
     * @var (callable(\Illuminate\Support\Stringable):(\Stringable|string))|null
     */
    public $transformCallback;

    /**
     * Create a new pending translation.
     *
     * @param  string|null  $key
     * @param  array<string, string>  $replace
     * @param  string|null  $locale
     */
    public function __construct($key = null, $replace = [], $locale = null)
    {
        $this->key = $key;
        $this->replace = $replace;
        $this->locale = $locale;
    }

    /**
     * Transform the translation.
     *
     * @param  (callable(\Illuminate\Support\Stringable):(\Stringable|string))  $transformCallback
     * @return $this
     */
    public function transform(callable $transformCallback)
    {
        $this->transformCallback = $transformCallback;

        return $this;
    }

    /**
     * Get the resolved value.
     *
     * @param  string|null  $locale
     * @return string
     */
    public function value($locale = null)
    {
        $locale = $locale ?? $this->locale;

        return (string) with(Str::of(
            transform(__($this->key, $this->replace, $locale), function ($translation) {
                return is_string($translation) ? $translation : $this->key;
            }) ?? ''
        ), $this->transformCallback);
    }

    /**
     * Dynamically proxy method calls to Stringable.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->forwardCallTo(Str::of($this->value()), $method, $parameters);
    }

    /**
     * Get the translation as string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->value();
    }

    /**
     * Get the translation as json.
     *
     * @return string
     */
    public function jsonSerialize(): string
    {
        return $this->value();
    }
}
