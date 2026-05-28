<?php

namespace alcamo\rdfa;

/**
 * @brief Immutable collection of RDFa statements
 *
 * @date Last reviewed 2026-05-28
 */
class ImmutableRdfaData extends AbstractRdfaData
{
    public static function newFromIterable(
        iterable $map,
        ?RdfaFactoryInterface $rdfaFactory = null,
        ?int $flags = null
    ): AbstractRdfaData {
        $rdfaData = parent::newFromIterable($map, $rdfaFactory, $flags);

        $immutableRdfaData = [];

        foreach ($rdfaData as $key => $value) {
            $immutableRdfaData[$key] = $value->toImmutable();
        }

        return new static($immutableRdfaData, $rdfaData->getCurieToUri());
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
