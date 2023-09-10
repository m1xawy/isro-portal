<?php

namespace Laravel\Nova\Actions;

use ArrayAccess;
use JsonSerializable;

class ActionResponse implements ArrayAccess, JsonSerializable
{
    /**
     * @var string
     */
    private $danger;

    /**
     * @var bool
     */
    private $deleted;

    /**
     * @var string
     */
    private $download;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $openInNewTab;

    /**
     * @var string
     */
    private $redirect;

    /**
     * @var array
     */
    private $visit;

    /**
     * @var string
     */
    private $modal;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @param  string  $message
     * @return \Laravel\Nova\Actions\ActionResponse
     */
    public static function message($message)
    {
        return tap(new static, function (self $response) use ($message) {
            $response->withMessage($message);
        });
    }

    /**
     * @param  string  $message
     * @return $this
     */
    public function withMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param  string  $message
     * @return $this
     */
    public function withDangerMessage($message)
    {
        $this->danger = $message;

        return $this;
    }

    /**
     * @param  string  $message
     * @return \Laravel\Nova\Actions\ActionResponse
     */
    public static function danger(string $message)
    {
        return tap(new static, function (self $response) use ($message) {
            $response->withDangerMessage($message);
        });
    }

    /**
     * @return $this
     */
    public function withDeleted()
    {
        $this->deleted = true;

        return $this;
    }

    /**
     * @return \Laravel\Nova\Actions\ActionResponse
     */
    public static function deleted()
    {
        return tap(new static, function (self $response) {
            $response->withDeleted();
        });
    }

    /**
     * @param  string  $url
     * @return $this
     */
    public function withRedirect($url)
    {
        $this->redirect = $url;

        return $this;
    }

    /**
     * @param  string  $url
     * @return \Laravel\Nova\Actions\ActionResponse
     */
    public static function redirect($url)
    {
        return tap(new static, function (self $response) use ($url) {
            $response->withRedirect($url);
        });
    }

    /**
     * @param  string  $url
     * @return \Laravel\Nova\Actions\ActionResponse
     */
    public static function openInNewTab($url)
    {
        return tap(new static, function (self $response) use ($url) {
            $response->usingNewTab($url);
        });
    }

    /**
     * @param  string  $path
     * @param  array  $options
     * @return $this
     */
    public function withVisitOptions($path, $options = [])
    {
        $this->visit = [
            'path' => '/'.ltrim($path, '/'),
            'options' => $options,
        ];

        return $this;
    }

    /**
     * @param  string  $path
     * @param  array  $options
     * @return \Laravel\Nova\Actions\ActionResponse
     */
    public static function visit($path, $options = [])
    {
        return tap(new static, function (self $response) use ($path, $options) {
            $response->withVisitOptions($path, $options);
        });
    }

    /**
     * @param  string  $url
     * @return $this
     */
    private function usingNewTab($url)
    {
        $this->openInNewTab = $url;

        return $this;
    }

    /**
     * @param  string  $name
     * @param  string  $url
     * @return $this
     */
    public function withDownload($name, $url)
    {
        $this->name = $name;
        $this->download = $url;

        return $this;
    }

    /**
     * @param  string  $name
     * @param  string  $url
     * @return \Laravel\Nova\Actions\ActionResponse
     */
    public static function download(string $name, string $url)
    {
        return tap(new static, function (self $response) use ($name, $url) {
            $response->withDownload($name, $url);
        });
    }

    /**
     * @param  string  $modal
     * @param  array  $data
     * @return $this
     */
    public function withModal($modal, $data = [])
    {
        $this->modal = $modal;
        $this->data = $data;

        return $this;
    }

    /**
     * @param  string  $modal
     * @param  array  $data
     * @return \Laravel\Nova\Actions\ActionResponse
     */
    public static function modal(string $modal, $data)
    {
        return tap(new static, function (self $response) use ($data, $modal) {
            $response->withModal($modal, $data);
        });
    }

    /**
     * Determine if the given offset exists.
     *
     * @param  string  $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->{$offset});
    }

    /**
     * Get the value for a given offset.
     *
     * @param  string  $offset
     * @return mixed|null
     */
    public function offsetGet($offset): mixed
    {
        return $this->{$offset};
    }

    /**
     * Set the value at the given offset.
     *
     * @param  string  $offset
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if (property_exists($this, $offset)) {
            $this->{$offset} = $value;
        }
    }

    /**
     * Unset the value at the given offset.
     *
     * @param  string  $offset
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->{$offset});
    }

    /**
     * Prepare the element for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return array_filter(array_merge([
            'danger' => $this->danger,
            'deleted' => $this->deleted,
            'download' => $this->download,
            'modal' => $this->modal,
            'message' => $this->message,
            'name' => $this->name,
            'openInNewTab' => $this->openInNewTab,
            'redirect' => $this->redirect,
            'visit' => $this->visit,
        ], $this->data));
    }
}
