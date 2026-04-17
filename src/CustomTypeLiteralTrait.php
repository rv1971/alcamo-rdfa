<?php

namespace alcamo\rdfa;

use alcamo\uri\FileUriFactory;
use Psr\Http\Message\UriInterface;

/**
 * @brief RDFa literal of a custom type
 *
 * @note A class using this trait must define the constants
 * `DATATYPE_LOCAL_NAME` and `XSD_FILENAME` and a function validateValue()
 * that is called in the constructor *after* construction and should throw if
 * the value is not valid for the datatype.
 *
 * @date Last reviewed 2026-04-17
 */
trait CustomTypeLiteralTrait
{
    public static function getClassDatatypeUri(): UriInterface
    {
        static $uris = [];

        return $uris[static::DATATYPE_LOCAL_NAME]
        ?? ($uris[static::DATATYPE_LOCAL_NAME]
            = (new FileUriFactory())
            ->create(static::XSD_FILENAME)
            ->withFragment(static::DATATYPE_LOCAL_NAME));
    }
}
