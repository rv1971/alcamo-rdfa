<?php

namespace alcamo\rdfa;

/**
 * @brief Namespace constants needed in many places
 *
 * @date Last reviewed 2026-02-07
 */
interface NamespaceConstantsInterface
{
    public const DC_NS   = 'http://purl.org/dc/terms/';
    public const HTTP_NS = 'tag:rv1971@web.de,2021:alcamo-rdfa:ns:http#';
    public const OWL_NS  = 'http://www.w3.org/2002/07/owl#';
    public const RDFS_NS = 'http://www.w3.org/2000/01/rdf-schema#';
    public const XHV_NS  = 'https://www.w3.org/1999/xhtml/vocab#';

    /// Map of namespace names to canonical namespace prefixes
    public const NS_URI_TO_NS_PREFIX = [
        self::DC_NS   => 'dc',
        self::HTTP_NS => 'http',
        self::OWL_NS  => 'owl',
        self::RDFS_NS => 'rdfs',
        self::XHV_NS  => 'xhv'
    ];
}
