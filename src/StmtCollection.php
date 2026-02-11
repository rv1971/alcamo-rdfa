<?php

namespace alcamo\rdfa;

use alcamo\collection\ReadonlyCollection;
use alcamo\exception\DataValidationFailed;

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
     * @param Lang|string $lang desired language
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
        /** Return `null` if the collection is empty. */
        if (!$this->data_) {
            return null;
        }

        /** Return the first statement if $lang is `null` or the empty
         *  string. */
        if (!isset($lang) || $lang == '') {
            return $this->first();
        }

        if (!($lang instanceof Lang)) {
            $lang = Lang::newFromString($lang);
        }

        $bestMatch = null;
        $bestMatchLevel = -1;

        foreach ($this as $stmt) {
            $object = $stmt->getObject();

            $objectLang = $object instanceof HavingLangInterface
                ? $object->getLang()
                : null;

            if (!isset($objectLang)) {
                /* Language-agnostic statement. */

                if ($bestMatchLevel < 0) {
                    $bestMatch = $stmt;
                    $bestMatchLevel = 0;
                }

                continue;
            }

            /* If a perfect match is found, return it immediately. */
            if ($objectLang == $lang) {
                return $stmt;
            }

            /* Otherwise, save the current statement if is better than the
             * best match found so far. */
            $matchLevel = $objectLang->countCommonSubtags($lang);

            if ($matchLevel > $bestMatchLevel) {
                $bestMatch = $stmt;
                $bestMatchLevel = $matchLevel;
            }
        }

        return $bestMatchLevel >= 0
            ? $bestMatch
            : ($disableFallback ? null : $this->first());
    }
}
