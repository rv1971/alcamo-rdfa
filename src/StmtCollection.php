<?php

namespace alcamo\rdfa;

use alcamo\collection\Collection;

/**
 * @brief Colelction of RDFa statements
 *
 * Intended for statments of the same type.
 *
 * @date Last reviewed 2026-02-05
 */
class StmtCollection extends Collection
{
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
