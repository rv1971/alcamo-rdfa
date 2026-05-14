<?php

namespace alcamo\rdfa;

use alcamo\collection\ReadonlyCollection;
use alcamo\exception\DataValidationFailed;
use alcamo\rdf_literal\{HavingLangInterface, Lang};

/**
 * @brief Collection of RDFa statements
 *
 * @invariant If the collection is nonempty, all statements are about the
 * property returned by getPropUri().
 *
 * @invariant Statements are indexed by their digest. Duplicates are silently
 * discarded.
 *
 * @date Last reviewed 2026-02-05
 */
class StmtCollection extends ReadonlyCollection
{
    /**
     * @brief Add the values of data, ignoring keys
     *
     * Keys are obtained from the statement digests.
     */
    public function __construct(?array $data = null)
    {
        if (isset($data)) {
            foreach ($data as $stmt) {
                $this->addStmt($stmt);
            }
        }
    }

    public function getPropUri(): ?string
    {
        return $this->data_
            ? $this->data_[array_key_first($this->data_)]->getPropUri()
            : null;
    }

    /**
     * @brief Add a statement
     */
    public function addStmt(StmtInterface $stmt): self
    {
        if ($this->data_) {
            $propUri = $this->getPropUri();

            if ($stmt->getPropUri() != $propUri) {
                /** @throw alcamo::exception::DataValidationFailed on attempt
                 *  to insert a statement for a different property. */
                throw (new DataValidationFailed())->setMessageContext(
                    [
                        'extraMessage' =>
                            "attempt to insert a "
                            . "{$stmt->getPropUri()} statement "
                            . "into a collection of $propUri statements"
                    ]
                );
            }
        }

        $this->data_[$stmt->getDigest()] = $stmt;

        return $this;
    }

    /**
     * @brief Add statements from a collection, not overwriting existing
     * statements with identical keys
     */
    public function addStmtCollection(self $stmtCollection): self
    {
        $this->data_ += $stmtCollection->data_;

        return $this;
    }

    /**
     * @brief Find the first statement that is a best match for the desired
     * language, if any
     *
     * @param Lang|string|null $lang desired language. If '-' (and hence not a
     * valid language tag), the first language-agnostic statement (if any) is
     * returned.
     *
     * @param $disableFallback Do not return a statement with a different
     * primary language subtag as a fallback. Language-agnostic statements or
     * statements with the same primary language subtag can always be returned
     * as fallbacks.
     */
    public function findLang(
        $lang = null,
        ?bool $disableFallback = null
    ): ?StmtInterface {
        return Lang::findBestMatch($this->data_, $lang, $disableFallback);
    }
}
