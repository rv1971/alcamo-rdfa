<?php

namespace alcamo\rdfa;

/**
 * @brief dc:type RDFa statement
 *
 * @sa [dc:type](http://purl.org/dc/terms/type)
 * @sa [DCMIType](http://purl.org/dc/terms/DCMIType)
 */
class DcType extends AbstractEnumeratorObjectStmt
{
    public const PROPERTY_URI = self::DC_NS . 'type';

    public const CANONICAL_PROPERTY_CURIE = 'dc:type';

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
