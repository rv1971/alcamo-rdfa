<?php

namespace alcamo\rdfa;

/**
 * @brief Immutable collection of RDFa statements
 *
 * @date Last reviewed 2026-05-28
 */
class ImmutableRdfaData extends AbstractRdfaData
{
    public static function newFromData($rdfaData): ?self
    {
        switch (true) {
            case $rdfaData instanceof ImmutableRdfaData:
                return $rdfaData;

            case $rdfaData instanceof RdfaData:
                return $rdfaData->toImmutable();

            case !$rdfaData:
                return null;

            default:
                return ImmutableRdfaData::newFromIterable($rdfaData);
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
