<?php

namespace alcamo\rdfa;

use alcamo\collection\ReadonlyCollection;

/**
 * @brief Collection of RDFa statements
 *
 * Readonly map of properties to objects.
 *
 * @invariant Immutable class.
 */
class RdfaData extends ReadonlyCollection
{
    /**
     * @brief Create from map of property CURIEs to objects
     *
     * @param $data Map of property CURIEs to objects. @copydetails
     * alcamo::object_creation::createArray()
     *
     * @param $factory RDFa factory used to create RDFa data by calling
     * Factory::createArray(). Defaults to a new instance of Factory.
     */
    public static function newFromIterable(
        iterable $data,
        ?Factory $factory = null
    ) {
        if (!isset($factory)) {
            $factory = new Factory();
        }

        return new self($factory->createArray($data));
    }

    private function __construct(array $data)
    {
        parent::__construct($data);

        /** Add `meta:charset` from dc:format if appropriate. */
        if (
            !isset($this->data_['meta:charset'])
            && isset($this->data_['dc:format'])
        ) {
            $charset =
                $this->data_['dc:format']->getObject()->getParams()['charset']
                ?? null;

            if (isset($charset)) {
                $this->data_['meta:charset'] = new MetaCharset($charset);
            }
        }
    }

    /// Return new object, adding properties without overwriting existing ones
    public function add(self $rdfaData): self
    {
        $newData = $this->data_;

        foreach ($rdfaData->data_ as $key => $value) {
            if (isset($newData[$key])) {
                /** If a key is already present, add new data to its
                 *  values. In all cases, the result is an array indexed by
                 *  the string representations of the values. */
                $data = $newData[$key];

                if (!is_array($data)) {
                    $newData[$key] = [ (string)$data => $data ];
                }

                if (is_array($value)) {
                    $newData[$key] += $value;
                } else {
                    $newData[$key] += [ (string)$value => $value ];
                }
            } else {
                $newData[$key] = $value;
            }
        }

        return new self($newData);
    }

    /// Return a new object with added properties, overwriting existing ones
    public function replace(self $rdfaData): self
    {
        return new self($rdfaData->data_ + $this->data_);
    }
}
