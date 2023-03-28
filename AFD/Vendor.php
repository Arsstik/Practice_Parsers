<?php

namespace App\Feeds\Vendors\AFD;

use App\Feeds\Processor\HttpProcessor;

class Vendor extends HttpProcessor
{
    public const CATEGORY_LINK_CSS_SELECTORS = [ '.pagination-list .pagination-item--next a' ];
    public const PRODUCT_LINK_CSS_SELECTORS = [ '.product .card-title a' ];

    protected array $first = [ 'https://afdhome.com/collections/' ];
}