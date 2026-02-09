<?php

namespace alcamo\rdfa;

use alcamo\exception\DataValidationFailed;

/**
 * @brief RDFa statement whose object is a node
 *
 * @date Last reviewed 2025-10-20
 */
trait NodeStmtTrait
{
    /**
     * @param Node|stringable $nodeOrUri Resource Node object or URI.
     *
     * @param RdfaData|array RDFa data about the resource
     */
    public function __construct($nodeOrUri, $rdfaData = null)
    {
        if (isset($rdfaData) && $nodeOrUri instanceof Node) {
            throw (new DataValidationFailed())->setMessageContext(
                [
                    'inMethod' => __METHOD__,
                    'extraMessage' => '$rdfaData must not be given when $nodeOrUri is already a node'
                ]
            );
        }

        parent::__construct(
            $nodeOrUri instanceof Node
                ? $nodeOrUri :
                new Node($nodeOrUri, $rdfaData)
        );
    }
}
