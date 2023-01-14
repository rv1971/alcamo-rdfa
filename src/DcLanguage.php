<?php

namespace alcamo\rdfa;

use alcamo\ietf\Lang;

/**
 * @brief dc:language RDFa statement
 *
 * @sa [dc:language](http://purl.org/dc/terms/language).
 */
class DcLanguage extends AbstractLiteralObjectStmt
{
    public const PROPERTY_URI = self::DC_NS . 'language';

    public const CANONICAL_PROPERTY_CURIE = 'dc:language';

    public const OBJECT_CLASS   = Lang::class;

    public function __construct(Lang $lang)
    {
        parent::__construct($lang);
    }
}
