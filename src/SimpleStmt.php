<?php

namespace alcamo\rdfa;

/// Simple statement
class SimpleStmt implements StmtInterface
{
    private $propNsName_;    ///< string
    private $propNsPrefix_;  ///< string
    private $propLocalName_; ///< string
    private $object_;        ///< any type

    public function __construct(
        string $propNsName,
        string $propNsPrefix,
        string $propLocalName,
        $object
    ) {
        $this->propNsName_ = $propNsName;
        $this->propNsPrefix_ = $propNsPrefix;
        $this->propLocalName_ = $propLocalName;
        $this->object_ = $object;
    }

    /// @copydoc StmtInterface::getPropNsName()
    public function getPropNsName(): string
    {
        return $this->propNsName_;
    }

    /// @copydoc StmtInterface::getPropNsPrefix()
    public function getPropNsPrefix(): string
    {
        return $this->propNsPrefix_;
    }

    /// @copydoc StmtInterface::getPropLocalName()
    public function getPropLocalName(): string
    {
        return $this->propLocalName_;
    }

    /// @copydoc StmtInterface::getPropUri()
    public function getPropUri(): string
    {
        return $this->propNsName_ . $this->propLocalName_;
    }

    /// @copydoc StmtInterface::getPropCurie()
    public function getPropCurie(): string
    {
        return $this->propNsPrefix_ . ':' . $this->propLocalName_;
    }

    /// @copydoc StmtInterface::getObject()
    public function getObject()
    {
        return $this->object_;
    }

    /// @copydoc StmtInterface::__toString()
    public function __toString(): string
    {
        return (string)$this->object_;
    }
}
