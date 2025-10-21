<?php

namespace alcamo\rdfa;

use alcamo\exception\ProgramFlowException;

/**
 * @brief RDFa statement whose object is a node
 *
 * @date Last reviewed 2025-10-20
 */
trait NodeStmtTrait
{
    public function __construct($nodeOrUri, ?RdfaData $rdfaData = null)
    {
        if (isset($rdfaData) && $nodeOrUri instanceof Node) {
            throw (new ProgramFlowException())->setMessageContext(
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
