<?php

namespace alcamo\rdfa;

/**
 * @brief Factory that creates RDFa statements from property CURIEs and values
 */
class Factory
{
    public const CANONICAL_PROP_CURIE_TO_CLASS = [
        DcAbstract::CANONICAL_PROP_CURIE        => DcAbstract::class,
        DcAccessRights::CANONICAL_PROP_CURIE    => DcAccessRights::class,
        DcAudience::CANONICAL_PROP_CURIE        => DcAudience::class,
        DcConformsTo::CANONICAL_PROP_CURIE      => DcConformsTo::class,
        DcCreated::CANONICAL_PROP_CURIE         => DcCreated::class,
        DcCreator::CANONICAL_PROP_CURIE         => DcCreator::class,
        DcFormat::CANONICAL_PROP_CURIE          => DcFormat::class,
        DcIdentifier::CANONICAL_PROP_CURIE      => DcIdentifier::class,
        DcLanguage::CANONICAL_PROP_CURIE        => DcLanguage::class,
        DcModified::CANONICAL_PROP_CURIE        => DcModified::class,
        DcPublisher::CANONICAL_PROP_CURIE       => DcPublisher::class,
        DcRights::CANONICAL_PROP_CURIE          => DcRights::class,
        DcSource::CANONICAL_PROP_CURIE          => DcSource::class,
        DcTitle::CANONICAL_PROP_CURIE           => DcTitle::class,
        DcType::CANONICAL_PROP_CURIE            => DcType::class,

        HttpCacheControl::CANONICAL_PROP_CURIE  => HttpCacheControl::class,
        HttpContentDisposition::CANONICAL_PROP_CURIE
        => HttpContentDisposition::class,
        HttpContentLength::CANONICAL_PROP_CURIE => HttpContentLength::class,
        HttpExpires::CANONICAL_PROP_CURIE       => HttpExpires::class,

        MetaCharset::CANONICAL_PROP_CURIE       => MetaCharset::class,

        OwlVersionInfo::CANONICAL_PROP_CURIE    => OwlVersionInfo::class,

        RelContents::CANONICAL_PROP_CURIE       => RelContents::class,
        RelHome::CANONICAL_PROP_CURIE           => RelHome::class,
        RelUp::CANONICAL_PROP_CURIE             => RelUp::class
    ];

    public function createStmtFromCanonicalpropCurie(
        string $canonicalpropCurie,
        $object
    ): StmtInterface {
        $class = static::CANONICAL_PROP_CURIE_TO_CLASS[$canonicalpropCurie];

        $objectClass = $class::getObjectClass();

        if (isset($objectClass)) {
            if ($object instanceof $objectClass) {
                return new $class($object);
            } elseif (method_exists($objectClass, 'newFromString')) {
                return new $class($objectClass::newFromString($object));
            } else {
                return new $class(new $objectClass($object));
            }
        } else {
            return new $class($object);
        }
    }

    /** @todo
     * - create array of props
     * - handle iterables as prop values
     */

    public function createRdfaData(iterable $data): RdfaData
    {
        return RdfaData::newFromIterable($data, $this);
    }
}
