<?php

namespace alcamo\rdfa;

use alcamo\time\Duration;

/**
 * @brief Expires RDFa statement
 *
 * @sa [Expires](https://datatracker.ietf.org/doc/html/rfc7234#section-5.3)
 *
 * @date Last reviewed 2025-10-19
 */
class HttpExpires extends AbstractHttpStmt
{
    public const PROP_LOCAL_NAME = 'expires';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    public function __construct($duration)
    {
        parent::__construct(
            $duration instanceof Duration
            ? $duration
            : new Duration($duration)
        );
    }
}
