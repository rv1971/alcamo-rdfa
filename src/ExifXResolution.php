<?php

namespace alcamo\rdfa;

use alcamo\rdf_literal\NonNegativeIntegerLiteral;

/**
 * @brief XResolution RDFa statement
 *
 * @date Last reviewed 2026-10-20
 */
class ExifXResolution extends AbstractExifResolution
{
    public const PROP_LOCAL_NAME = 'XResolution';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;
}
