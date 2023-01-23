<?php

namespace alcamo\rdfa;

use alcamo\collection\ReadonlyCollection;
use alcamo\exception\DataValidationFailed;

/**
 * @brief Collection of RDFa statements
 *
 * Readonly map of properties to objects.
 *
 * @invariant Immutable class.
 */
class RdfaData extends ReadonlyCollection
{
    public const PROP_CURIE_TO_CLASS = Factory::PROP_CURIE_TO_CLASS;

    /**
     * @brief Create from map of property CURIEs to object data
     *
     * @param $map Map of property CURIE to one of
     * - instance of StmtInterface
     * - statement object
     * - array of one or the other
     *
     * @param $factory RDFa factory used to create RDFa data by calling
     * Factory::createStmtArrayFromPropCurieMap(). Defaults to a new instance
     * of Factory.
     */
    public static function newFromIterable(
        iterable $map,
        ?Factory $factory = null
    ) {
        return new self(($factory ?? new Factory())
            ->createStmtArrayFromPropCurieMap($map));
    }

    private function __construct(array $map)
    {
        parent::__construct($map);

        /** If `meta:charset` is not provided, add it from `dc:format` if
         *  possible. */
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

        foreach ($rdfaData->data_ as $curie => $value) {
            if (isset($newData[$curie])) {
                /** If a property is already present and is unique, leave it
                 *  unchanged. */

                $class = static::PROP_CURIE_TO_CLASS[$curie] ?? null;

                if (isset($class) && $class::UNIQUE) {
                    continue;
                }

                /** Otherwise, add new data to its values. The result is an
                 *  array indexed by the string representations of the
                 *  values. */
                $data = $newData[$curie];

                if (!is_array($data)) {
                    $newData[$curie] = [ (string)$data => $data ];
                }

                if (is_array($value)) {
                    $newData[$curie] += $value;
                } else {
                    $newData[$curie] += [ (string)$value => $value ];
                }
            } else {
                $newData[$curie] = $value;
            }
        }

        return new self($newData);
    }

    /// Return a new object with added properties, overwriting existing ones
    public function replace(self $rdfaData): self
    {
        return new self($rdfaData->data_ + $this->data_);
    }

    /// Return map of namespaces prefixes to namespaces
    public function createNamespaceMap(): array
    {
        $map = [];

        foreach ($this as $stmts) {
            if (is_array($stmts)) {
                $nsPrefix = current($stmts)->getPropNsPrefix();
                $nsName = current($stmts)->getPropNsName();
            } else {
                $nsPrefix = $stmts->getPropNsPrefix();
                $nsName = $stmts->getPropNsName();
            }

            if (isset($map[$nsPrefix])) {
                if ($map[$nsPrefix] != $nsName) {
                    throw (new DataValidationFailed())->setMessageContext(
                        [
                            'extraMessage' =>
                            "namespace prefix \"$nsPrefix\" denotes "
                            . "different namespaces \"$map[$nsPrefix]\" "
                            . "and \"{$nsName}\""
                        ]
                    );
                }
            } else {
                $map[$nsPrefix] = $nsName;
            }
        }

        return $map;
    }
}
