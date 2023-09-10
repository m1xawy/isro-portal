<?php

namespace Laravel\Nova\Fields;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @extends \Illuminate\Support\Fluent<TKey, TValue>
 */
class FormData extends Fluent
{
    /**
     * The Request instance.
     *
     * @var \Laravel\Nova\Http\Requests\NovaRequest
     */
    protected $request;

    /**
     * Create a new fluent instance.
     *
     * @param  iterable<TKey, TValue>  $attributes
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return void
     */
    public function __construct($attributes, NovaRequest $request)
    {
        parent::__construct($attributes);

        $this->request = $request;
    }

    /**
     * Make fluent payload from request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  array<string, mixed>  $fields
     * @return static
     */
    public static function make(NovaRequest $request, array $fields)
    {
        if (! is_null($request->resource) && ! is_null($request->resourceId)) {
            $fields["resource:{$request->resource}"] = $request->resourceId;
        }

        if (! is_null($request->viaResource) && ! is_null($request->viaResourceId)) {
            $fields["resource:{$request->viaResource}"] = $request->viaResourceId;
        }

        if (! is_null($request->relatedResource) && ! is_null($request->relatedResourceId)) {
            $fields["resource:{$request->relatedResource}"] = $request->relatedResourceId;
        }

        return new static($fields, $request);
    }

    /**
     * Make fluent payload from request only on specific keys.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  array<int, string>  $onlyAttributes
     * @return static
     */
    public static function onlyFrom(NovaRequest $request, array $onlyAttributes)
    {
        $fields = $request->method() === 'GET' && ! is_null($dependsOn = $request->query('dependsOn'))
            ? Arr::only(json_decode(base64_decode($dependsOn), true), $onlyAttributes)
            : $request->only($onlyAttributes);

        return static::make($request, $fields);
    }

    /**
     * Get a resource attribute from the fluent instance.
     *
     * @param  string  $uriKey
     * @param  mixed  $default
     * @return mixed
     */
    public function resource($uriKey, $default = null)
    {
        $key = "resource:{$uriKey}";

        if (! empty($this->request->viaRelationship)
            && ($uriKey === $this->request->relatedResource || $uriKey === $this->request->viaResource)
        ) {
            return $this->get($key, $this->get($this->request->viaRelationship, $default));
        }

        return $this->get($key, $default);
    }

    /**
     * Retrieve input from the request as a Stringable instance.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return \Illuminate\Support\Stringable
     */
    public function str($key, $default = null)
    {
        return $this->string($key, $default);
    }

    /**
     * Retrieve input from the request as a Stringable instance.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return \Illuminate\Support\Stringable
     */
    public function string($key, $default = null)
    {
        return Str::of($this->get($key, $default));
    }

    /**
     * Retrieve input from the request as a json value.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function json($key, $default = null)
    {
        $value = $this->get($key, $default);

        return is_string($value) ? json_decode($value, true) : $value;
    }

    /**
     * Retrieve input as a boolean value.
     *
     * Returns true when value is "1", "true", "on", and "yes". Otherwise, returns false.
     *
     * @param  string|null  $key
     * @param  bool  $default
     * @return bool
     */
    public function boolean($key = null, $default = false)
    {
        return filter_var($this->get($key, $default), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Retrieve input as an integer value.
     *
     * @param  string  $key
     * @param  int  $default
     * @return int
     */
    public function integer($key, $default = 0)
    {
        return intval($this->get($key, $default));
    }

    /**
     * Retrieve input as a float value.
     *
     * @param  string  $key
     * @param  float  $default
     * @return float
     */
    public function float($key, $default = 0.0)
    {
        return floatval($this->get($key, $default));
    }

    /**
     * Retrieve input from the request as a Carbon instance.
     *
     * @param  string  $key
     * @param  string|null  $format
     * @param  string|null  $tz
     * @return \Illuminate\Support\Carbon|null
     *
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    public function date($key, $format = null, $tz = null)
    {
        $value = $this->get($key);

        if (! filled($value)) {
            return null;
        }

        if (is_null($format)) {
            return Date::parse($value, $tz);
        }

        return Date::createFromFormat($format, $value, $tz);
    }
}
