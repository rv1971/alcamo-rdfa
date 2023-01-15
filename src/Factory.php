<?php

namespace alcamo\rdfa;
use alcamo\exception\DataValidationFailed;

/**
 * @brief Factory that creates RDFa statements from property CURIEs and values
 */
class Factory
{
    public const PROP_CURIE2CLASS = [
        DcAbstract::PROP_CURIE             => DcAbstract::class,
        DcAccessRights::PROP_CURIE         => DcAccessRights::class,
        DcAudience::PROP_CURIE             => DcAudience::class,
        DcConformsTo::PROP_CURIE           => DcConformsTo::class,
        DcCreated::PROP_CURIE              => DcCreated::class,
        DcCreator::PROP_CURIE              => DcCreator::class,
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
        $class = static::PROP_CURIE2CLASS[$propCurie];

        return new $class($object);
    }

    /**
     * @param $data Map of property CURIE to one of
     * - instance of StmtInterface
     * - statement object
     * - array of one or the other
     *
     * @return Map of property CURIE to either instance of StmtInterface or
     * array thereof, the latter indexed by string representation of the
     * object.
     *
     * @throw alcamo::exception::DataValidationFailed if the input contains an
     * RDFa statement not matching its key CURIE.
     */
    public function createStmtArrayFromPropCurieMap(iterable $map): array
    {
        $rdfaData = [];

        foreach ($map as $curie => $data) {
            switch (true) {
                case $data instanceof StmtInterface:
                    if ($data->getPropCurie() != $curie) {
                        throw (new DataValidationFailed())->setMessageContext(
                            [
                                'inData' => (string)$data,
                                'extraMessage' =>
                                "object property CURIE "
                                . $data->getPropCurie()
                                . " does not match key $curie"
                            ]
                        );
                    }

                    $rdfaData[$curie] = $data;
                    break;

                case is_array($data):
                    $objects = [];

                    foreach ($data as $item) {
                        if ($item instanceof StmtInterface) {
                            if ($item->getPropCurie() != $curie) {
                                throw (new DataValidationFailed())
                                    ->setMessageContext(
                                        [
                                            'inData' => (string)$item,
                                            'extraMessage' =>
                                            "object item property CURIE "
                                            . $item->getPropCurie()
                                            . " does not match key $curie"
                                        ]
                                    );
                            }

                            $objects[(string)$item] = $item;
                        } else {
                            $object =
                                static::createStmtFromPropCurie($curie, $item);

                            $objects[(string)$object] = $object;
                        }
                    }

                    $rdfaData[$curie] = $objects;
                    break;

                default:
                    $rdfaData[$curie] =
                        static::createStmtFromPropCurie($curie, $data);
            }
        }

        return $rdfaData;
    }
}
