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
    public const URI_AS_KEY = 1;

    /// Create RdfaData with no statements
    public static function newEmpty(): self
    {
        return new self();
    }

    /**
     * @brief Create from map of property CURIEs to object data
     *
     * @param $map Map of property CURIE to one of
     * - instance of StmtInterface
     * - statement object
     * - array of one or the other
     *
     * @param $rdfaFactory RDFa factory used to create RDFa data by calling
     * RdfaFactory::createStmtFromCurieAndData(). Defaults to a new instance
     * of RdfaFactory.
     *
     * @param $flags
     * - If $flags contain alcamo::rdfa::RdfaData::URI_AS_KEY
     */
    public static function newFromIterable(
        iterable $map,
        ?RdfaFactoryInterface $rdfaFactory = null,
        ?int $flags = null
    ): self {
        if (!isset($rdfaFactory)) {
            $rdfaFactory = new RdfaFactory();
        }

        $rdfaData = [];

        $curieToUri = [];

        foreach ($map as $pair) {
            [ $key, $data ] = $pair;

            switch (true) {
                /* Skip unset data asd well as empty array data. */
                case !$data:
                    continue 2;

                case $data instanceof StmtInterface:
                    /** @throw alcamo::exception::DataValidationFailed if a
                     *  key dos not match a statement CURIE/URI. */
                    if ($flags & self::URI_AS_KEY) {
                        if ($data->getPropUri() != $key) {
                            throw (new DataValidationFailed())->setMessageContext(
                                [
                                    'inData' => (string)$data,
                                    'extraMessage' =>
                                        "object property URI \""
                                        . $data->getPropUri()
                                        . "\" does not match key \"$key\""
                                ]
                            );
                        }
                    } else {
                        if ($data->getPropCurie() != $key) {
                            throw (new DataValidationFailed())->setMessageContext(
                                [
                                    'inData' => (string)$data,
                                    'extraMessage' =>
                                        "object property CURIE \""
                                        . $data->getPropCurie()
                                        . "\" does not match key \"$key\""
                                ]
                            );
                        }
                    }

                    $stmt = $data;
                    break;

                default:
                    $stmt = $flags & self::URI_AS_KEY
                        ? ($rdfaFactory
                           ->createStmtFromUriAndData($key, $data))
                        : ($rdfaFactory
                           ->createStmtFromCurieAndData($key, $data));
            }

            $uri = $flags & self::URI_AS_KEY ? $key : $stmt->getPropUri();

            $curie = $flags & self::URI_AS_KEY ? $stmt->getPropCurie() : $key;

            if (!isset($rdfaData[$uri])) {
                $stmtCollection = new StmtCollection();
                $rdfaData[$uri] = $stmtCollection;

                if (isset($curie)) {
                    $curieToUri[$curie] = $uri;
                }
            }

            $rdfaData[$uri]->addStmt($stmt);
        }

        return new self($rdfaData, $curieToUri);
    }

    private $curieToUri_; ///< array

    private function __construct(
        ?array $rdfaData = null,
        ?array $curieToUri = null
    ) {
        parent::__construct($rdfaData);

        $this->curieToUri_ = (array)$curieToUri;
    }

    /// Check presence of a property URI or CURIE
    public function offsetExists($offset): bool
    {
        return isset($this->data_[$offset])
            || isset($this->curieToUri_[$offset]);
    }

    /// Get a statement collection by property URI or CURIE
    public function offsetGet($offset)
    {
        return $this->data_[$offset]
        ?? (isset($this->curieToUri_[$offset])
            ? $this->data_[$this->curieToUri_[$offset]]
            : null);
    }

    /// Mapping of property CURIEs to URIs
    public function getCurieToUri(): array
    {
        return $this->curieToUri_;
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
                $newData[$key]->addStmtCollection($stmts);
            } else {
                $newData[$key] = clone $stmts;
            }
        }

        return new self($newData, $this->curieToUri_ + $rdfaData->curieToUri_);
    }

    /// Return a new object with added properties, overwriting existing ones
    public function replace(self $rdfaData): self
    {
        return new self(
            (clone $rdfaData)->data_ + (clone $this)->data_,
            $rdfaData->curieToUri_ + $this->curieToUri_
        );
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
                    /** @throw alcamo::exception::DataValidationFailed if the
                     *  same prefix is used for multiple namespaces. */
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
