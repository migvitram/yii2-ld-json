<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace migvitram\ldJson;

use yii\base\Widget;
use yii\helpers\Url;

/**
 * Class JsonLDWidget
 * @package migvitram\ldJson
 */
class JsonLDWidget extends Widget
{
    /** Types constants */
    const TYPE_ORGANIZATION     = 'Organization';
    const TYPE_PRODUCT          = 'Product';
    const TYPE_OFFER            = 'Offer';
    const TYPE_PERSON           = 'Person';
    const TYPE_FAQ_PAGE         = 'FAQPage';
    const TYPE_FAQ_QUESTION     = 'Question';
    const TYPE_FAQ_ANSWER       = 'Answer';

    /** @var string $type */
    public $type;

    /** @var array $inputData */
    public $inputData = [];

    /** @var string $jsonOutputData */
    protected $jsonOutputData;

    /** @var array $allLDJs */
    protected static $allLDJs = [];

    /**
     * Prepare output LD data
     */
    public function init()
    {
        /*
         *
         * {
              "@context": "https://schema.org",
              "@type": "Organization",
              "url": "http://etalon-power.in.ua",
              "name": "Industry and Military Power Converters",
              "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "+1-401-555-1212",
                "contactType": "Customer service"
              }
            }
         *
         */

        $type = $this->type ?? self::TYPE_ORGANIZATION;

        $initialArray = [
            "@context" => "https://schema.org",
            "@type" => $type,
            "url" => Url::base(true),
        ];

        if ( !empty($this->inputData) ) {

            $this->jsonOutputData = array_merge($initialArray, $this->inputData);

            // and static variable for multiple ld+json injections ???
            self::$allLDJs[] = $this->jsonOutputData;
        }

        parent::init();
    }

    /**
     * Render the script part
     * @return string
     */
    public function run()
    {
        if ( $this->inputData === self::$allLDJs ) {
            $returnResult = $this->inputData;
        }else{

            if ( count(self::$allLDJs) == 1) {
                self::$allLDJs = self::$allLDJs[0];
            }

            $returnResult = self::$allLDJs;
        }

        return $this->render('default', [
            'jsonData' => $returnResult,
        ]);
    }

    /**
     * @param array $dataToAdd
     */
    public static function addLDJson( array $dataToAdd )
    {
        self::$allLDJs[] = $dataToAdd;
    }

    // Product structured data
    /*
         *
         * {
              "@context": "https://schema.org/",
              "@type": "Product",
              "name": "Executive Anvil",
              "image": [
                "https://example.com/photos/1x1/photo.jpg",
                "https://example.com/photos/4x3/photo.jpg",
                "https://example.com/photos/16x9/photo.jpg"
               ],
              "description": "Sleeker than ACME's Classic Anvil, the Executive Anvil is perfect for the business traveler looking for something to drop from a height.",
              "sku": "0446310786",
              "mpn": "925872",
              "brand": {
                "@type": "Brand",
                "name": "ACME"
              },
              "review": {
                "@type": "Review",
                "reviewRating": {
                  "@type": "Rating",
                  "ratingValue": "4",
                  "bestRating": "5"
                },
                "author": {
                  "@type": "Person",
                  "name": "Fred Benson"
                }
              },
              "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "4.4",
                "reviewCount": "89"
              },
              "offers": {
                "@type": "Offer",
                "url": "https://example.com/anvil",
                "priceCurrency": "USD",
                "price": "119.99",
                "priceValidUntil": "2020-11-20",
                "itemCondition": "https://schema.org/UsedCondition",
                "availability": "https://schema.org/InStock",
                "seller": {
                  "@type": "Organization",
                  "name": "Executive Objects"
                }
              }
            }
         *
         */
}