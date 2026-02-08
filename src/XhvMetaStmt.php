<?php

namespace alcamo\rdfa;

use alcamo\exception\ProgramFlowException;

/**
 * @brief XHML metainformation RDFa statement class
 *
 * @sa [XHTML Metainformation Vocabulary](https://www.w3.org/1999/xhtml/vocab#XHTMLMetaInformationModule)
 *
 * @date Last reviewed 2025-10-20
 */
class XhvMetaStmt implements StmtInterface
{
    use FixedNsTrait;

    public const PROP_NS_NAME = self::XHV_NS;

    public const PROP_NS_PREFIX = self::NS_NAME_TO_NS_PREFIX[self::PROP_NS_NAME];

    private $propLocalName_; ///< string

    /**
     * @param $propLocalName Property local name (i.e. without namespace)
     *
     * @param Node|stringable $nodeOrUri Resource Node object or URI.
     *
     * @param RdfaData|array RDFa data about the resource
     */
    public function __construct(
        string $propLocalName,
        $nodeOrUri,
        $rdfaData = null
    ) {
        if (isset($rdfaData) && $nodeOrUri instanceof Node) {
            throw (new ProgramFlowException())->setMessageContext(
                [
                    'inMethod' => __METHOD__,
                    'extraMessage' => '$rdfaData must not be given when $nodeOrUri is already a node'
                ]
            );
        }

        $this->propLocalName_ = $propLocalName;

        $this->object_ = $nodeOrUri instanceof Node
            ? $nodeOrUri
            : new Node($nodeOrUri, $rdfaData);
    }

    /// @copydoc StmtInterface::getPropLocalName()
    public function getPropLocalName(): string
    {
        return $this->propLocalName_;
    }

    /// @copydoc StmtInterface::getPropUri()
    public function getPropUri(): string
    {
        return self::PROP_NS_NAME . $this->propLocalName_;
    }

    /// @copydoc StmtInterface::getPropCurie()
    public function getPropCurie(): string
    {
        return self::PROP_NS_PREFIX . ":{$this->propLocalName_}";
    }
}
