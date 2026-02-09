<?php

namespace alcamo\rdfa;

use alcamo\xml\{NamespaceMapsInterface, XName};

/**
 * @brief Factory that creates RDFa statements from property CURIEs and values
 *
 * Both factory methods for statements first try to find a statment class in
 * alcamo::rdfa::RdfaFactory::PROP_URI_TO_STMT_CLASS. If that fails, they try
 * alcamo::rdfa::RdfaFactory::PROP_NS_NAME_TO_STMT_CLASS. If that fails as
 * well:
 * - createStmtFromUriAndData() creates an alcamo::rdfa::SimpleStmt object,
 * setting the namespace prefix to the canonical prefix, if known.
 * - createStmtFromCurieAndData() creates an alcamo::rdfa::SimpleStmt object,
 * if the namespace prefix  is a known canonical prefix.
 *
 * @date Last reviewed 2025-10-21
 */
class RdfaFactory implements RdfaFactoryInterface
{
    /// Map of canonical namespace prefixes
    public const NS_PRFIX_TO_NS_NAME =
        NamespaceMapsInterface::NS_PRFIX_TO_NS_NAME;

    /// Map of namespace names to canonical namespace prefixes
    public const NS_NAME_TO_NS_PREFIX =
        NamespaceMapsInterface::NS_NAME_TO_NS_PREFIX;

    /// Map of property URI to statement class.
    public const PROP_URI_TO_STMT_CLASS = [
        DcAbstract::PROP_URI              => DcAbstract::class,
        DcAccessRights::PROP_URI         => DcAccessRights::class,
        DcAlternative::PROP_URI          => DcAlternative::class,
        DcAudience::PROP_URI             => DcAudience::class,
        DcConformsTo::PROP_URI           => DcConformsTo::class,
        DcContributor::PROP_URI          => DcContributor::class,
        DcCoverage::PROP_URI             => DcCoverage::class,
        DcCreated::PROP_URI              => DcCreated::class,
        DcCreator::PROP_URI              => DcCreator::class,
        DcDate::PROP_URI                 => DcDate::class,
        DcFormat::PROP_URI               => DcFormat::class,
        DcIdentifier::PROP_URI           => DcIdentifier::class,
        DcLanguage::PROP_URI             => DcLanguage::class,
        DcModified::PROP_URI             => DcModified::class,
        DcPublisher::PROP_URI            => DcPublisher::class,
        DcRights::PROP_URI               => DcRights::class,
        DcSource::PROP_URI               => DcSource::class,
        DcTitle::PROP_URI                => DcTitle::class,
        DcType::PROP_URI                 => DcType::class,
        HttpCacheControl::PROP_URI       => HttpCacheControl::class,
        HttpContentDisposition::PROP_URI => HttpContentDisposition::class,
        HttpContentLength::PROP_URI      => HttpContentLength::class,
        HttpExpires::PROP_URI            => HttpExpires::class,
        OwlSameAs::PROP_URI              => OwlSameAs::class,
        OwlVersionInfo::PROP_URI         => OwlVersionInfo::class,
        RdfsComment::PROP_URI            => RdfsComment::class,
        RdfsLabel::PROP_URI              => RdfsLabel::class,
        RdfsSeeAlso::PROP_URI            => RdfsSeeAlso::class
    ];

    /// Map of property namespace name to statement class.
    public const PROP_NS_NAME_TO_STMT_CLASS = [
        XhvMetaStmt::PROP_NS_NAME => XhvMetaStmt::class
    ];

    public function createStmtFromUriAndData(
        string $propUri,
        $data
    ): StmtInterface {
        if (is_array($data)) {
            $data = new Node(
                $data[0],
                isset($data[1])
                    ? RdfaData::newFromIterable($data[1], $this)
                    : null
            );
        }

        if (isset(static::PROP_URI_TO_STMT_CLASS[$propUri])) {
            $class = static::PROP_URI_TO_STMT_CLASS[$propUri];

            return new $class($data);
        }

        [ $propNsName, $propLocalName ] =
            XName::newFromUri($propUri)->getPair();

        if (isset(static::PROP_NS_NAME_TO_STMT_CLASS[$propNsName])) {
            $class = static::PROP_NS_NAME_TO_STMT_CLASS[$propNsName];

            return new $class($propLocalName, $data);
        }

        return new SimpleStmt(
            $propNsName,
            static::NS_NAME_TO_NS_PREFIX[$propNsName] ?? null,
            $propLocalName,
            $data
        );
    }

    public function createStmtFromCurieAndData(
        string $propCurie,
        $data
    ): ?StmtInterface {
        if (is_array($data)) {
            $data = new Node(
                $data[0],
                isset($data[1])
                    ? RdfaData::newFromIterable($data[1], $this)
                    : null
            );
        }

        [ $propNsPrefix, $propLocalName ] = explode(':', $propCurie, 2);

        $propNsName = static::NS_PRFIX_TO_NS_NAME[$propNsPrefix] ?? null;

        if (!isset($propNsName)) {
            return null;
        }

        $propUri = "$propNsName$propLocalName";

        if (isset(static::PROP_URI_TO_STMT_CLASS[$propUri])) {
            $class = static::PROP_URI_TO_STMT_CLASS[$propUri];

            return new $class($data);
        }

        if (isset(static::PROP_NS_NAME_TO_STMT_CLASS[$propNsName])) {
            $class = static::PROP_NS_NAME_TO_STMT_CLASS[$propNsName];

            return new $class($propLocalName, $data);
        }

        return new SimpleStmt($propNsName, $propNsPrefix, $propLocalName, $data);
    }
}
