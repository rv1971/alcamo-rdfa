<?php

namespace alcamo\rdfa;

/**
 * @brief Simple RDFa statement
 *
 * @date Last reviewed 2025-10-19
 */
class SimpleStmt implements StmtInterface
{
    use ObjectTrait;

    private $propNsName_;    ///< string
    private $propNsPrefix_;  ///< string
    private $propLocalName_; ///< string

    public function __construct(
        string $propNsName,
        ?string $propNsPrefix,
        string $propLocalName,
        $object
    ) {
        $this->propNsName_ = $propNsName;
        $this->propNsPrefix_ = $propNsPrefix;
        $this->propLocalName_ = $propLocalName;
        $this->object_ = $object;
    }

    public function getPropNsName(): string
    {
        return $this->propNsName_;
    }

    public function getPropNsPrefix(): ?string
    {
        return $this->propNsPrefix_;
    }

    public function getPropLocalName(): string
    {
        return $this->propLocalName_;
    }

    public function getPropUri(): string
    {
        return "{$this->propNsName_}{$this->propLocalName_}";
    }

    public function getPropCurie(): ?string
    {
        return isset($this->propNsPrefix_)
            ? "{$this->propNsPrefix_}:{$this->propLocalName_}"
            : null;
    }
}
