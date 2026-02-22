<?php

namespace alcamo\rdfa;

use alcamo\exception\OutOfRange;

/**
 * @brief RDFa positive gregorian year literal
 *
 * @date Last reviewed 2026-02-22
 */
class PositiveGYearLiteral extends GYearLiteral
{
    /**
     * `data:` URI representation of the `PositiveGYear` fragment of
     *
     *     <?xml version='1.0'?>
     *     <schema
     *         xmlns='http://www.w3.org/2001/XMLSchema'
     *         targetNamespace='tag:rv1971@web.de,2021:alcamo:ns:base#'>
     *       <simpleType
     *           name='PositiveGYear'
     *           xml:id='PositiveGYear'>
     *         <restriction base='gYear'>
     *           <xs:minInclusive value='1'/>
     *         </restriction>
     *       </simpleType>
     *     </schema>
     */
    public const DATATYPE_URI = 'data:,%3C%3Fxml%20version=1.0%3F%3E'
        . '%3Cschema%20xmlns=http://www.w3.org/2001/XMLSchema%20'
        . 'targetNamespace=tag:rv1971%40web.de,2021:alcamo:ns:base%23%3E'
        . '%3CsimpleType%20name=PositiveGYear%20xml:id=PositiveGYear%3E'
        . '%3Crestriction%20base=gYear%3E%3Cxs:minInclusive%20value=1/%3E'
        . '%3C/restriction%3E%3C/simpleType%3E%3C/schema%3E#PositiveGYear';

    /**
     * @param $value DateTime|int|string DateTime, datetime string, or
     * integer, representing a positive gregorian year.
     *
     * @param $datatypeUri Datatype IRI.
     */
    public function __construct($value = null, $datatypeUri = null)
    {
        if ($value instanceof \Datetime) {
            OutOfRange::throwIfNegative($value->format('Y'));
        } else {
            OutOfRange::throwIfNegative($value);
        }

        parent::__construct(
            $value,
            $datatypeUri ?? static::DATATYPE_URI
        );
    }
}
