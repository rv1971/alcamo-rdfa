<?php

namespace alcamo\rdfa;

use alcamo\collection\ReadonlyCollection;
use alcamo\exception\DataValidationFailed;

/**
 * @brief Collection of RDFa statements
 *
 * Map of properties to alcamo::collection::Collection objects of
 * statements. Each collection of statements is indexed by the string
 * representation of the statement value.
 *
 * The method alcamo::collection::ArrayIteratorTrait::first() is often useful
 * to access the first statement, in particular if it is known there is only
 * one statement because mupltiple statements do not make sense,
 * e.g. `$rdfaData['dc:created']->first()`.
 *
 * @invariant Immutable object.
 */
class RdfaData extends ReadonlyCollection
{
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
        ?FactoryInterface $factory = null
    ): self {
        if (!isset($factory)) {
            $factory = new Factory();
        }

        $rdfaData = [];

        foreach ($map as $pair) {
            [ $curie, $data ] = $pair;

            switch (true) {
                /* Skip unset data asd well as empty array data. */
                case !$data:
                    continue 2;

                case $data instanceof StmtInterface:
                    if ($data->getPropCurie() != $curie) {
                        throw (new DataValidationFailed())->setMessageContext(
                            [
                                'inData' => (string)$data,
                                'extraMessage' =>
                                    "object property CURIE \""
                                    . $data->getPropCurie()
                                    . "\" does not match key \"$curie\""
                            ]
                        );
                    }

                    $stmt = $data;
                    break;

                default:
                    $stmt = $factory->createStmtFromCurieAndData($curie, $data);
            }

            $uri = $stmt->getPropUri();

            if (!isset($rdfaData[$uri])) {
                $stmtCollection = new StmtCollection();
                $rdfaData[$uri] = $stmtCollection;
                $rdfaData[$curie] = $stmtCollection;
            }

            $rdfaData[$uri][(string)$stmt] = $stmt;
        }

        return new self($rdfaData);
    }

    private function __construct(?array $rdfaData = null)
    {
        parent::__construct($rdfaData);
    }

    /**
     * @brief Return new object, adding properties without overwriting
     * existing ones
     */
    public function add(self $rdfaData): self
    {
        $newData = $this->data_;

        foreach ($rdfaData->data_ as $key => $stmts) {
            if (isset($newData[$key])) {
                $newData[$key]->add($stmts);
            } else {
                $newData[$key] = clone $stmts;
            }
        }

        return new self($newData);
    }

    /// Return a new object with added properties, overwriting existing ones
    public function replace(self $rdfaData): self
    {
        return new self((clone $rdfaData)->data_ + (clone $this)->data_);
    }

    /// Return map of namespaces prefixes to namespaces
    public function createNamespaceMap(): array
    {
        $map = [];

        foreach ($this as $stmts) {
            $nsPrefix = $stmts->first()->getPropNsPrefix();
            $nsName = $stmts->first()->getPropNsName();

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
