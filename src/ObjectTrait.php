<?php

namespace alcamo\rdfa;

/**
 * @brief Object of an RDFa statement and methods to access it
 *
 * @attention Cloning is shallow, hence $object_ (if it is a PHP object) is
 * cloned by reference. Applications should not modify the result of
 * getObject() or modify it via _call(), unless it is desired that the
 * modification applies to all statements that reference it.
 *
 * @date Last reviewed 2025-10-19
 */
trait ObjectTrait
{
    private $object_; ///< any type

    /**
     * @param $object Object of the RDFa statement.
     */
    public function __construct($object)
    {
        $this->object_ = $object;
    }

    /// @copydoc StmtInterface::getObject()
    public function getObject()
    {
        return $this->object_;
    }

    /// @copydoc StmtInterface::__toString()
    public function __toString(): string
    {
        return $this->object_;
    }

    public function getDigest(): string
    {
        return $this->object_ instanceof HavingDigestInterface
            ? $this->object_->getDigest()
            : $this;
    }

    public function __call(string $name, array $params)
    {
        return call_user_func_array([ $this->object_, $name ], $params);
    }
}
