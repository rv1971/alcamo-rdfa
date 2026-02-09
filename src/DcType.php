<?php

namespace alcamo\rdfa;

/**
 * @brief dc:type RDFa statement
 *
 * @sa [dc:type](http://purl.org/dc/terms/type)
 * @sa [DCMIType](http://purl.org/dc/terms/DCMIType)
 *
 * @date Last reviewed 2025-10-19
 */
class DcType extends AbstractDcStmt
{
    use EnumeratorStmtTrait;

    public const PROP_LOCAL_NAME = 'type';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    /// Objects are language-agnostic
    public const LITERAL_CLASS = StringLiteral::class;

    public const VALUES = [
        'Collection',
        'Dataset',
        'Event',
        'Image',
        'InteractiveResource',
        'MovingImage',
        'PhysicalObject',
        'Service',
        'Software',
        'Sound',
        'StillImage',
        'Text'
    ];
}
