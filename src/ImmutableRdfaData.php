<?php

namespace alcamo\rdfa;

/**
 * @brief Immutable collection of RDFa statements
 *
 * @date Last reviewed 2026-05-28
 */
class ImmutableRdfaData extends AbstractRdfaData
{
    /**
     * @brief Create from array of RDFa data or RDFa data object or null
     *
     * @param RdfaData|ImmutableRdfaData|array|null If array, see
     * alcamo::rdfa_data::AbstractRdfaData::newFromIterable().
     *
     * @param $rdfaFactory See
     * alcamo::rdfa_data::AbstractRdfaData::newFromIterable().
     *
     * @param $flags See
     * alcamo::rdfa_data::AbstractRdfaData::newFromIterable().
     */
    public static function newFromData(
        $rdfaData,
        ?RdfaFactoryInterface $rdfaFactory = null,
        ?int $flags = null
    ): self {
        switch (true) {
            case $rdfaData instanceof ImmutableRdfaData:
                return $rdfaData;

            case $rdfaData instanceof RdfaData:
                return $rdfaData->toImmutable();

            case !$rdfaData:
                return self::newEmpty();

            default:
                return self::newFromIterable($rdfaData, $rdfaFactory, $flags);
        }
    }

    public static function newFromIterable(
        iterable $map,
        ?RdfaFactoryInterface $rdfaFactory = null,
        ?int $flags = null
    ): AbstractRdfaData {
        return RdfaData::newFromIterable($map, $rdfaFactory, $flags)
            ->toImmutable();
    }

    public function toMutable(): RdfaData
    {
        $mutable = RdfaData::newEmpty();

        $mutable->data_ = [];

        foreach ($this->data_ as $key => $stmts) {
            $mutable->data_[$key] = $stmts->toMutable();
        }

        $mutable->curieToUri_ = $this->curieToUri_;

        return $mutable;
    }
}
