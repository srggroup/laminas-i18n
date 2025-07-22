<?php

namespace Laminas\I18n\Filter;

use Laminas\Stdlib\ErrorHandler;

use function is_float;
use function is_int;
use function is_scalar;

/** @final */
class NumberFormat extends NumberParse
{
    /**
     * Defined by Laminas\Filter\FilterInterface
     *
     * @param mixed $value
     * @return mixed
     * @see    \Laminas\Filter\FilterInterface::filter()
     *
     */
    public function filter($value): mixed
    {
        if (! is_scalar($value)) {
            return $value;
        }

        if (! is_int($value) && ! is_float($value)) {
            $result = parent::filter($value);
        } else {
            ErrorHandler::start();

            $result = $this->getFormatter()->format($value, $this->getType());

            ErrorHandler::stop();
        }

        if (false !== $result) {
            return $result;
        }

        return $value;
    }

    /**
     * {@inheritDoc}
     *
     * Will return null if $value is present in the deny-list. If $value is NOT present then it will return $value.
     */
    public function __invoke(mixed $value): mixed
    {
        return $this->filter($value);
    }
}
