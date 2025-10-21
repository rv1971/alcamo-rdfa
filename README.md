# Usage exmaple

~~~
use alcamordfaRdfaData;

$rdfaData = RdfaData::newFromIterable(
    [
        [ 'dc:title', 'Example data' ],
        [ 'dc:creator', 'Alice' ],
        [ 'dc:creator', 'Bob' ],
        [ 'dc:created', '2025-10-21T19:09+02:00' ]
    ]
);

/* $rdfaData['dc:title'] is an array because a subject may have
 * multiple titles. */
$titles = $rdfaData['dc:title'];

echo 'Title: ' . reset($titles) . "\n";

echo 'Creators: ';

/* $rdfaData['dc:creator'] is an array for the same reason. */
foreach ($rdfaData['dc:creator'] as $creator) {
    /* Each DcCreator object is implicitly converted to a string. */
    echo "$creator, ";
}

echo "\n";

/* $rdfaData['dc:created'] is a single DcCreated object because a
 * subject may have only one such property. */
echo "Created at: {$rdfaData['dc:created']}\n";

/* The format() method is applied to the DateTime object contained in
 * the DcCreated object. */
echo "Same in a different format: "
    . $rdfaData['dc:created']->format('r') . "\n";
~~~

# Overview

## RDFa statements

This package manages [RDFa](https://www.w3.org/TR/rdfa-primer/)
statements, providing an interface `StmtInterface` and three
implementation approaches.

The data model assumes that each property has a canonical prefix, such
as `dc` for http://purl.org/dc/terms/ . Thus, the package can deduce
that the properties in the abov e example are the Dublic Core
properties *title*, *creator* and *created* and can create objects of
class `DcTitle`, `DcCreator` and `DcCreated` for them. The latter
class knows that its object is a timestamp and is able to output it in
various formats.

All statement classes implement the interface `StmtInterface`.
* Classes like `DcTitle` provide one class for one property.
* The class `XhvMetaStmt` provides one class for all XHTML metadata properties.
* The class `SimpleStmt` can be used for any statement of any property.

A number of statement classes is provided, more classes can easily be added.

Some classes know that their object is of a particular data type, such
as DateTime for `DcCreated`. A number of classes have an object which
must be or can be an RDFa node, which can itself have RDFa data
attached. The class `Node` is provided for the latter case.

This package focuses on the data model for RDFa statements themselves,
in order to have a unique way to manage metadata wherever they come
from or go to.

Other packages may do something useful with these data,
for instance [alcamo-http](https://github.com/rv1971/alcamo-http)
creates HTTP headers, and
[alcamo-html-page](https://github.com/rv1971/alcamo-html-page) creates
HTML page headers.

## Auxiliary classes

The package also provides some classes needed in RDFa statements which
are useful by themselves:

* `Lang` implements an [RFC4646](http://tools.ietf.org/html/rfc4646)
  language tag.
* `MediaType` implements an [RFC
  2046](https://tools.ietf.org/html/rfc2046) media type.
