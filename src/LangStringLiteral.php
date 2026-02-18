<?php

namespace alcamo\rdfa;

/**
 * @brief RDF language-tagged string
 *
 * @date Last reviewed 2026-02-05
 */
class LangStringLiteral extends AbstractLiteral
{
    public const DATATYPE_URI = self::RDF_NS . 'langString';

    private $lang_; ///< ?Lang

    /**
     * @param $value stringable
     *
     * @param $lang Lang object or language string.
     *
     * @param $datatypeUri Datatype IRI. [Default `xsd:langString`]
     */
    public function __construct(
        $value = null,
        $lang = null,
        $datatypeUri = null
    ) {
        parent::__construct(
            (string)$value,
            $datatypeUri ?? static::DATATYPE_URI
        );

        if (isset($lang)) {
            $this->lang_ =
                $lang instanceof Lang ? $lang : Lang::newFromString($lang);
        }
    }

    /** Currently the only class that may return non-`null`. */
    public function getLang(): ?Lang
    {
        return $this->lang_;
    }

    public function getDigest(): string
    {
        return "\"$this->value_\"" .
            (isset($this->lang_) ? "@$this->lang_" : '');
    }
}
