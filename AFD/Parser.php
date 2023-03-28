<?php

namespace App\Feeds\Vendors\AFD;

use App\Feeds\Parser\HtmlParser;
use App\Feeds\Utils\ParserCrawler;
use App\Helpers\StringHelper;

class Parser extends HtmlParser
{
    protected function getCleanDescriptionPatterns(): array
    {
        return
            [
                '~<\w+?[^>]*?>UPC.*?</\w+?>~s',
                '~<\w+?[^>]*?>Also see.*?</\w+?>~s',
                '~<\w+?[^>]*?>[^<]*?\$.*?</\w+?>~s',
            ];
    }

    public function getMpn(): string
    {
        return $this->getText( '.productView-info dd[data-product-sku]' );
    }

    public function getRawProduct(): string
    {
        return $this->getText( '.productView-product h1.productView-title' );
    }

    public function getUpc(): ?string
    {
        return $this->getText( '.productView-info dd[data-product-upc]' );
    }

    public function getAvail(): ?int
    {
        $avail = $this->getText( 'dl.productView-info' );
        return StringHelper::str_contains( $avail, 'In Stock', true ) ? self::DEFAULT_AVAIL_NUMBER : 0;
    }

    public function getCostToUs(): float
    {
        return $this->getMoney( '.productView-price .price.price--withoutTax' );
    }

    public function getListPrice(): ?float
    {
        return $this->getMoney( '.productView-price .price.price--rrp' );
    }

    public function getImages(): array
    {
        $images = [];

        $this->filter( '.productView-thumbnails .productView-thumbnail a.productView-thumbnail-link' )->each( function ( ParserCrawler $c ) use ( &$images ) {
            $final_url = StringHelper::normalizeSrcLink( $c->attr( 'href' ), $this->getUri() );

            if ( !in_array( $final_url, $images, true ) ) {
                $images[] = $final_url;
            }
        } );

        if ( empty( $images ) ) {
            $images[] = StringHelper::normalizeSrcLink( $this->getAttr( '.productView-images .productView-img-container a', 'href' ), $this->getUri() );
        }
        return array_values( array_filter( $images ) );
    }

    public function getRawDescription(): ?string
    {
        return $this->getHtml( '#tab-description' );
    }
}