<?php

namespace alcamo\rdfa;

use alcamo\exception\DataValidationFailed;

/**
 * @brief Factory that creates RDFa statements from property CURIEs and values
 *
 * @attention Each class listed in @ref PROP_CURIE_TO_CLASS must define a
 * boolean class constant `UNIQUE` which tells whether this property can only
 * have a unique value or may have an array of values.
 */
class Factory
{
    public const PROP_CURIE_TO_CLASS = [
        DcAbstract::PROP_CURIE             => DcAbstract::class,
        DcAccessRights::PROP_CURIE         => DcAccessRights::class,
        DcAlternative::PROP_CURIE          => DcAlternative::class,
        DcAudience::PROP_CURIE             => DcAudience::class,
        DcConformsTo::PROP_CURIE           => DcConformsTo::class,
        DcCoverage::PROP_CURIE             => DcCoverage::class,
        DcCreated::PROP_CURIE              => DcCreated::class,
        DcCreator::PROP_CURIE              => DcCreator::class,
        DcDate::PROP_CURIE                 => DcDate::class,
        DcFormat::PROP_CURIE               => DcFormat::class,
        DcIdentifier::PROP_CURIE           => DcIdentifier::class,
        DcLanguage::PROP_CURIE             => DcLanguage::class,
        DcModified::PROP_CURIE             => DcModified::class,
        DcPublisher::PROP_CURIE            => DcPublisher::class,
        DcRights::PROP_CURIE               => DcRights::class,
        DcSource::PROP_CURIE               => DcSource::class,
        DcTitle::PROP_CURIE                => DcTitle::class,
        DcType::PROP_CURIE                 => DcType::class,

        HttpCacheControl::PROP_CURIE       => HttpCacheControl::class,
        HttpContentDisposition::PROP_CURIE => HttpContentDisposition::class,
        HttpContentLength::PROP_CURIE      => HttpContentLength::class,
        HttpExpires::PROP_CURIE            => HttpExpires::class,

        MetaCharset::PROP_CURIE            => MetaCharset::class,

        OwlVersionInfo::PROP_CURIE         => OwlVersionInfo::class,

        RelContents::PROP_CURIE            => RelContents::class,
        RelHome::PROP_CURIE                => RelHome::class,
        RelUp::PROP_CURIE                  => RelUp::class
    ];

    public function createStmtFromPropCurie(
        string $propCurie,
        $object
    ): StmtInterface {
        return new $class($object);
    }

    /**
     * @param $data Map of property CURIE to one of
     * - instance of StmtInterface
     * - statement object
     * - array of one or the other
     * - null
     *
     * @return Map of property CURIE to either instance of StmtInterface or
     * array thereof, the latter indexed by string representation of the
     * object. Ignore entis with value null.
     *
     * @throw alcamo::exception::DataValidationFailed if the input contains an
     * RDFa statement not matching its key CURIE.
     */
    public function createStmtArrayFromPropCurieMap(iterable $map): array
    {
        $rdfaData = [];

        foreach ($map as $curie => $data) {
            switch (true) {
                case !isset($data):
                    continue 2;

                case $data instanceof StmtInterface:
                    if ($data->getPropCurie() != $curie) {
                        throw (new DataValidationFailed())->setMessageContext(
                            [
                                'inData' => (string)$data,
                                'extraMessage' =>
                                "object property CURIE \""
                                . $data->getPropCurie()
                                . "\" does not match key \"$curie\""
                            ]
                        );
                    }

                    $rdfaData[$curie] = $data;
                    break;

                case is_array($data):
                    $class = static::PROP_CURIE_TO_CLASS[$curie];

                    if ($class::UNIQUE) {
                        /** @throw alcamo::exception::DataValidationFailed if
                         *  an array is given as a value for a unique
                         *  property. */
                        throw (new DataValidationFailed())
                            ->setMessageContext(
                                [
                                    'inData' => (string)$curie,
                                    'extraMessage' =>
                                    "array given for unique $class"
                                ]
                            );
                    }

                    $objects = [];

                    foreach ($data as $item) {
                        if ($item instanceof StmtInterface) {
                            if ($item->getPropCurie() != $curie) {
                                throw (new DataValidationFailed())
                                    ->setMessageContext(
                                        [
                                            'inData' => (string)$item,
                                            'extraMessage' =>
                                            "object item property CURIE \""
                                            . $item->getPropCurie()
                                            . "\" does not match key \"$curie\""
                                        ]
                                    );
                            }

                            $objects[(string)$item] = $item;
                        } else {
                            $object = new $class($item);

                            $objects[(string)$object] = $object;
                        }
                    }

                    $rdfaData[$curie] = $objects;
                    break;

                default:
                    $class = static::PROP_CURIE_TO_CLASS[$curie];

                    $rdfaData[$curie] = new $class($data);
            }
        }

        return $rdfaData;
    }
}
