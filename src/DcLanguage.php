<?php

namespace alcamo\rdfa;

/**
 * @brief dc:language RDFa statement
 *
 * @sa [dc:language](http://purl.org/dc/terms/language).
 *
 * @date Last reviewed 2025-10-19
 */
class DcLanguage extends AbstractDcStmt
{
    public const PROP_LOCAL_NAME = 'language';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    public function __construct($lang)
    {
        parent::__construct(
            $lang instanceof \Lang
            ? $lang
            : Lang::newFromString($lang)
        );
    }
}
