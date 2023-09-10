<?php

namespace Laravel\Nova\Metrics;

use Carbon\CarbonImmutable;
use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Builder;

abstract class TrendDateExpression
{
    /**
     * The value of the expression.
     *
     * @var string|int|float
     */
    protected $value;

    /**
     * The query builder being used to build the trend.
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    public $query;

    /**
     * The column being measured.
     *
     * @var string
     */
    public $column;

    /**
     * The unit being measured.
     *
     * @var string
     */
    public $unit;

    /**
     * The user's local timezone.
     *
     * @var string
     */
    public $timezone;

    /**
     * Create a new raw query expression.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $column
     * @param  string  $unit
     * @param  string  $timezone
     * @return void
     */
    public function __construct(Builder $query, $column, $unit, $timezone)
    {
        $this->unit = $unit;
        $this->query = $query;
        $this->column = $column;
        $this->timezone = $timezone;
    }

    /**
     * Get the timezone offset for the user's timezone.
     *
     * @return int
     */
    public function offset()
    {
        $timezoneOffset = function ($timezone) {
            return (new DateTime(CarbonImmutable::now()->format('Y-m-d H:i:s'), new DateTimeZone($timezone)))->getOffset() / 60 / 60;
        };

        if ($this->timezone) {
            $appOffset = $timezoneOffset(config('app.timezone'));
            $userOffset = $timezoneOffset($this->timezone);

            return $userOffset - $appOffset;
        }

        return 0;
    }

    /**
     * Wrap the given value using the query's grammar.
     *
     * @param  string  $value
     * @return string
     */
    protected function wrap($value)
    {
        return $this->query->getQuery()->getGrammar()->wrap($value);
    }

    /**
     * Get the value of the expression.
     *
     * @return mixed
     */
    abstract public function getValue();

    /**
     * Get the value of the expression.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getValue();
    }
}
