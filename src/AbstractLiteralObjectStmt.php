<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa statement whose object is always literal content
 *
 * A derived class may define a class constant OBJECT_CLASS which will be
 * returned by getObjectClass()
 */
abstract class AbstractLiteralObjectStmt extends AbstractStmt
{
    /// Object class returned by getObjectClass()
    public const OBJECT_CLASS = null;

    /**
     * @copydoc StmtInterface::getObjectClass()
     *
     * @warning The default constructor does not enforce that an object is of
     * this class. This is rather a hint tro Factory::createFromClassName()
     * that a value must be converted to this type before feeding it to a
     * constructor. Derived classes should provide constructors that enforce
     * the correct types on their value parameter.
     */
    public static function getObjectClass(): ?string
    {
        return static::OBJECT_CLASS;
    }

    public function __construct($content)
    {
        parent::__construct($content, false);
    }
}
