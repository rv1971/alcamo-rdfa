<?php

namespace alcamo\rdfa;

/**
 * @brief Factory that creates RDFa statements from property CURIEs and values
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

    public function createStmtFromCurieAndData(
        string $curie,
        $data
    ): StmtInterface {
        [ $propNsPrefix, $propLocalName ] = explode(':', $curie, 2);

        if (is_array($data)) {
            $nodeRdfaData = isset($data[1])
                ? RdfaData::newFromIterable($data[1])
                : null;
        }

        if (isset(static::PROP_NS_PREFIX_TO_STMT_CLASS[$propNsPrefix])) {
            $class = static::PROP_NS_PREFIX_TO_STMT_CLASS[$propNsPrefix];

            return is_array($data)
                ? new $class($propLocalName, new Node($data[0], $nodeRdfaData))
                : new $class($propLocalName, $data);
        }

        $class = __NAMESPACE__ . '\\'
            . ucfirst($propNsPrefix)
            . implode('', array_map('ucfirst', explode('-', $propLocalName)));

        return is_array($data)
            ? new $class(new Node($data[0], $nodeRdfaData))
            : new $class($data);
    }
}
