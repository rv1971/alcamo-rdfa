<?php

namespace alcamo\rdfa;

use alcamo\exception\DataValidationFailed;

/**
 * @brief Factory that creates RDFa statements from property CURIEs and values
 *
 * @attention Each class listed in @ref PROP_CURIE_TO_CLASS must define a
 * boolean class constant `UNIQUE` which tells whether this property can only
 * have a unique value or may have an array of values.
 *
 * @date Last reviewed 2025-10-21
 */
class Factory implements FactoryInterface
{
    /**
     * @brief Map of property namespace prefix to statement class.
     *
     * Needed for property namespaces where one class implements all
     * properties of that namespace. For prefixes not in this map, it is
     * assumed that there is one class for each supported property.
     *
     * Derived classes may add items to support more such classes.
     */
    public const PROP_NS_PREFIX_TO_STMT_CLASS = [
        XhvMetaStmt::PROP_NS_PREFIX => XhvMetaStmt::class
    ];

    /**
     * @brief Construct a statement from a property CURIE and object data
     *
     * If $data is an array, construct a Node from it. This allows to
     * distinguish in $data whether a string represents a string value or a
     * Node URI, for those statements where both are possible (such as
     * DcRights). In the latter case, the Node URI must be given as a
     * one-element array.
     */
    public function createStmtFromCurieAndData(
        string $curie,
        $data
    ): StmtInterface {
        [ $propNsPrefix, $propLocalName ] = explode(':', $curie, 2);

        if (is_array($data)) {
            $nodeRdfaData = isset($data[1])
                ? new RdfaData($this->createStmtArrayFromIterable($data[1]))
                : null;
        }

        if (isset(static::PROP_NS_PREFIX_TO_STMT_CLASS[$propNsPrefix])) {
            $class = static::PROP_NS_PREFIX_TO_STMT_CLASS[$propNsPrefix];

        return is_array($data)
            ? new $class($propLocalName, new Node($data[0], $nodeRdfaData))
            : new $class($propLocalName, $data);
        }

        $class = __NAMESPACE__ . '\\'
            . ucfirst($propNsPrefix) . ucfirst($propLocalName);

        return is_array($data)
            ? new $class(new Node($data[0], $nodeRdfaData))
            : new $class($data);
    }

    public function createStmtArrayFromIterable(iterable $map): array
    {
        $rdfaData = [];

        foreach ($map as $pair) {
            [ $curie, $data ] = $pair;

            switch (true) {
                case !isset($data):
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
                    $stmt = $this->createStmtFromCurieAndData($curie, $data);
            }

            if ($stmt->isOnceOnly()) {
                $rdfaData[$curie] = $stmt;
            } else {
                if (!isset($rdfaData[$curie])) {
                    $rdfaData[$curie] = [];
                }

                $rdfaData[$curie][(string)$stmt] = $stmt;
            }
        }

        return $rdfaData;
    }
}
