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
 * @invariant Add statements are indexed by their digest. Duplicates are
 * silently discarded.
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
     * language
     *
     * @param Lang|string $lang desired language
     */
    public function findLang($lang): ?StmtInterface
    {
        if ($lang instanceof Lang) {
            $lang = Lang::newFromString($lang);
        }

        $langString = (string)$lang;
        $bestMatch = $this->first();
        $bestMatchLen = 0;

        foreach ($this as $stmt) {
            $object = $stmt->getObject();

            /** This works for LangStringLiteral objects as well as for Node
             *  objects, taking a `dc:language` statement from the latter, if
             *  present. */
            switch (true) {
                case $object instanceof LangStringLiteral:
                    $objectLang = $object->getLang();
                    break;

                case $object instanceof Node:
                    if (isset($object->getRdfaData()['dc:language'])) {
                        $objectLang =
                            $object->getRdfaData()['dc:language']->first();
                    }

                    break;
            }

            if (!isset($objectLang)) {
                continue;
            }

            $objectLangString = (string)$objectLang;

            /* If a perfect match is found, return it immediately. */
            if ($objectLangString == $langString) {
                return $stmt;
            }

            /* Otherwise check the length of the common prefix. Save the
             * current statement if is better than the best match found so
             * far. */
            $maxLen = min(strlen($langString), strlen($objectLangString));

            for (
                $matchLen = 0;
                $matchLen < $maxLen
                    && $langString[$matchLen] == $objectLangString[$matchLen];
                $matchLen++
            );

            /* Ignore the last common character if it is a dash. */
            if ($langString[$matchLen - 1] == '-') {
                $matchLen--;
            }

            if ($matchLen > $bestMatchLen) {
                $bestMatch = $stmt;
                $bestMatchLen = $matchLen;
            }
        }

        return $bestMatch;
    }
}
