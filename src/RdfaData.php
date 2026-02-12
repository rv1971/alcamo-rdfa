<?php

namespace alcamo\rdfa;

use alcamo\collection\{ReadonlyCollection, StringIndexedReadArrayAccessTrait};
use alcamo\exception\DataValidationFailed;
use Ds\Set;

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
 * @date Last reviewed 2026-02-12
 */
class RdfaData extends ReadonlyCollection
{
    use StringIndexedReadArrayAccessTrait;

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

            $uri = (string)(
                $flags & self::URI_AS_KEY ? $key : $stmt->getPropUri()
            );

            $curie = $flags & self::URI_AS_KEY ? $stmt->getPropCurie() : $key;

            if (!isset($rdfaData[$uri])) {
                $stmtCollection = new StmtCollection();
                $rdfaData[$uri] = $stmtCollection;

                if (isset($curie)) {
                    $curieToUri[(string)$curie] = $uri;
                }
            }

            $rdfaData[$uri]->addStmt($stmt);
        }

        return new self($rdfaData, $curieToUri);
    }

    private $curieToUri_; ///< array

    private $propUrisToDelete_; ///< Set

    private function __construct(
        ?array $rdfaData = null,
        ?array $curieToUri = null
    ) {
        parent::__construct($rdfaData);

        $this->curieToUri_ = (array)$curieToUri;

        $this->propUrisToDelete_ = new Set();
    }

    public function __clone()
    {
        $this->propUrisToDelete_ = clone $this->propUrisToDelete_;
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
     * The properties with URIs in this set are deleted from an RdfData object
     * when the present object is used as an argument for replace().
     */
    public function getPropUrisToDelete(): Set
    {
        return $this->propUrisToDelete_;
    }

    /**
     * @brief Find the first statement that is a best match for the desired
     * language, if any
     *
     * @param $prop Property URI or CURIE
     *
     * @param Lang|string|null $lang desired language
     *
     * @param $disableFallback See alcamo::rdfa::StmtCollection::findLang
     */
    public function findStmtWithLang(
        string $prop,
        $lang = null,
        ?bool $disableFallback = null
    ): ?StmtInterface {
        $stmts = $this[$prop];

        return isset($stmts) ? $stmts->findLang($lang, $disableFallback) : null;
    }

    /**
     * @brief Add properties without overwriting existing ones
     *
     * @return $this
     */
    public function add(self $rdfaData): self
    {
        foreach ($rdfaData->data_ as $uri => $stmts) {
            if (isset($this->data_[$uri])) {
                $this->data_[$uri]->addStmtCollection($stmts);
            } else {
                $this->data_[$uri] = clone $stmts;
            }

            $this->propUrisToDelete_->remove($uri);
        }

        $this->curieToUri_ += $rdfaData->curieToUri_;

        $this->propUrisToDelete_ =
            $this->propUrisToDelete_->union($rdfaData->propUrisToDelete_);

        return $this;
    }

    /// Return a new object with added properties, overwriting existing ones
    public function replace(self $rdfaData): self
    {
        $this->data_ = $rdfaData->data_ + $this->data_;

        $this->curieToUri_ = $rdfaData->curieToUri_ + $this->curieToUri_;

        foreach ($rdfaData->propUrisToDelete_ as $uri) {
            $uri = (string)$uri;

            if (isset($this->data_[$uri])) {
                unset($this->data_[$uri]);

                foreach ($this->curieToUri_ as $curie => $uri2) {
                    if ($uri2 == $uri) {
                        unset($this->curieToUri_[$curie]);

                        break;
                    }
                }
            }
        }

        foreach ($rdfaData->data_ as $uri => $stmts) {
            $this->propUrisToDelete_->remove($uri);
        }

        return $this;
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
