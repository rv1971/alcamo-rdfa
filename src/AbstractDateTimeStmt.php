<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa statement whose object is a DateTime object
 */
abstract class AbstractDateTimeStmt extends AbstractLiteralStmt
{
    /**
     * @brief Format used in __toString().
     *
     * @sa [DateTime::format()](https://www.php.net/manual/en/datetime.format)
     */
    public const DEFAULT_FORMAT = 'c';

    public function __construct($timestamp)
    {
        parent::__construct(
            $timestamp instanceof \DateTime
            ? $timestamp
            : new \DateTime($timestamp)
        );
    }

    /// Return content using @ref DEFAULT_FORMAT
    public function __toString(): string
    {
        return $this->format(static::DEFAULT_FORMAT);
    }

    /**
     * @param $format See
     * [DateTime::format()](https://www.php.net/manual/en/datetime.format).
     */
    public function format(string $format): string
    {
        return $this->getObject()->format($format);
    }
}
