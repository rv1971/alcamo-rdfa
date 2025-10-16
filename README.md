# Overview

## RDFa statements

This package manages [RDFa](https://www.w3.org/TR/rdfa-primer/)
statements, providing an interface `StmtInterface` and two
implementation approaches.

The data model assumes that each property has a canonical prefix, such
as `dc` for http://purl.org/dc/terms/ . Thus, for instance, the
package can deduce that the properties in 

~~~
[ 
    'dc:title' => 'Alice and Bob' ,
    'dc:created' => '2025-10-15T21:01:42Z'
]
~~~

are the Dublic Core properties *title* and *created* and can create
objects of class `DcTitle` and `DcCreated` for them. The latter class
knows that its object is a timestamp and is able to output it in
various formats.

The abstract class `AbstractStmt` serves as a base class for statement
classes where the RDFa property, the type of data it contains etc. are
mostly configured by class constants. Thus, a bunch of classes like
`DcTitle` are derived from it which contain nothing but some class
constants.

## Auxiliary classes

The package also provides some classes needed in RDFa statements which
are useful by themselves:

* `Lang` implements an [RFC4646](http://tools.ietf.org/html/rfc4646)
  language tag.
* `MediaType` implements an [RFC
  2046](https://tools.ietf.org/html/rfc2046) media type.
