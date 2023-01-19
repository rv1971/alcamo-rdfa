<?php

namespace alcamo\rdfa;

/**
 * @brief dc:type RDFa statement
 *
 * @sa [dc:type](http://purl.org/dc/terms/type)
 * @sa [DCMIType](http://purl.org/dc/terms/DCMIType)
 */
class DcType extends AbstractEnumeratorStmt
{
    public const PROP_NS_NAME = self::DC_NS;

    public const PROP_NS_PREFIX = 'dc';

    public const PROP_LOCAL_NAME = 'type';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    public const UNIQUE = true;

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
