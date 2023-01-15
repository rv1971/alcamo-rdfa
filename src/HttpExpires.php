<?php

namespace alcamo\rdfa;

use alcamo\time\Duration;

/**
 * @brief expires RDFa statement
 *
 * @sa [Expires](http://tools.ietf.org/html/rfc2616#section-14.21)
 */
class HttpExpires extends AbstractLiteralStmt
{
    public const PROP_NS_NAME = self::HTTP_NS;

    public const PROP_NS_PREFIX = 'http';

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
