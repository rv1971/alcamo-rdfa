<?php

namespace alcamo\rdfa;

use alcamo\collection\{ReadonlyCollection, StringIndexedReadArrayAccessTrait};
use alcamo\exception\DataValidationFailed;
use alcamo\rdf_literal\LiteralOrNodeInterface;
use Ds\Set;

/**
 * @brief Collection of RDFa statements
 *
 * Map of properties to alcamo::rdfa_data::AbstractStmtCollection objects of
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
abstract class AbstractRdfaData extends ReadonlyCollection implements
    HavingLabelInterface
{
    use StringIndexedReadArrayAccessTrait;

    public const URI_AS_KEY = 1;

    /// Create RdfaData with no statements
    public static function newEmpty(): self
    {
        return new static();
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
                $rdfaData[$uri] = new StmtCollection();

                if (isset($curie)) {
                    $curieToUri[$curie] = $uri;
                }
            }

            $rdfaData[$uri]->addStmt($stmt);
        }

        return new static($rdfaData, $curieToUri);
    }

    protected $curieToUri_;       ///< array
    protected $propUrisToDelete_; ///< Set

    protected function __construct(
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
        $offset = (string)$offset;

        return isset($this->data_[$offset])
            || isset($this->curieToUri_[$offset]);
    }

    /// Get a statement collection by property URI or CURIE
    public function offsetGet($offset)
    {
        $offset = (string)$offset;

        return $this->data_[$offset]
        ?? (isset($this->curieToUri_[$offset])
            ? $this->data_[$this->curieToUri_[$offset]]
            : null);
    }

    /// First statement for property URI or CURIE, if any
    public function getFirstStmt(string $prop): ?StmtInterface
    {
        $stmts = $this[$prop];

        return isset($stmts) ? $stmts->first() : null;
    }

    /// Object of first statement for property URI or CURIE, if any
    public function getFirstObject(string $prop): ?LiteralOrNodeInterface
    {
        $stmts = $this[$prop];

        return isset($stmts) ? $stmts->first()->getObject() : null;
    }

    /**
     * @brief Value or URI of object of first statement for property URI or
     * CURIE, if any
     */
    public function getFirstValueOrUri(string $prop)
    {
        $stmts = $this[$prop];

        if (!isset($stmts)) {
            return null;
        }

        $object = $stmts->first()->getObject();

        return $object instanceof Node
            ? $object->getUri()
            : $object->getValue();
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
    abstract public function getPropUrisToDelete(): Set;

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

    public function getLabel($lang = null, ?int $flags = null): ?string
    {
        return $this->findStmtWithLang(
            'rdfs:label',
            $lang,
            !($flags & self::FALLBACK_TO_DIFFERENT_LANG)
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
