<?php

namespace Unit;

use Exception;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;
use src\Services\Parser;
use src\Services\XmlParser;

final class ParserTest extends TestCase
{
    private Parser $parser;

    protected function setUp(): void
    {
        parent::setUp();
        $xmlParser = new XmlParser();
        $this->parser = new Parser($xmlParser);
    }

    public function testReadFile()
    {
        $file = 'test.xml';
        $this->expectException(Exception::class);
        $this->parser->read($file);
    }

    public function testParseItem()
    {
        $data = new SimpleXMLElement('
            <item>
                <entity_id>6236</entity_id>
                <CategoryName><![CDATA[Brands]]></CategoryName>
                <sku>55-100-1-43</sku>
                <name><![CDATA[Barrie House 100% Colombian Ground Coffee 42 1.5 oz Bags]]></name>
                <description></description>
                <shortdesc>
                    <![CDATA[Barrie House 100% Colombian Ground Coffee 42 1.25 oz bags provide coffee drinkers with a delicious cup of South American caffeinated ground coffee from Barrie House.]]></shortdesc>
                <price>39.9900</price>
                <link>http://www.coffeeforless.com/barrie-house-100pct-colombian-ground-coffee-42-1-5-oz-bags.html</link>
                <image>http://mcdn.coffeeforless.com/media/catalog/product/no_selection</image>
                <Brand><![CDATA[Barrie House]]></Brand>
                <Rating>0</Rating>
                <CaffeineType>Caffeinated</CaffeineType>
                <Count>42</Count>
                <Flavored>No</Flavored>
                <Seasonal>No</Seasonal>
                <Instock>No</Instock>
                <Facebook>1</Facebook>
                <IsKCup>0</IsKCup>
            </item>
        ');

        $expected = [
            'id' => 6236,
            'category' => 'Brands',
            'sku' => '55-100-1-43',
            'name' => 'Barrie House 100% Colombian Ground Coffee 42 1.5 oz Bags',
            'description' => '',
            'shortdesc' => 'Barrie House 100% Colombian Ground Coffee 42 1.25 oz bags provide coffee drinkers with a delicious cup of South American caffeinated ground coffee from Barrie House.',
            'price' => 39.9900,
            'link' => 'http://www.coffeeforless.com/barrie-house-100pct-colombian-ground-coffee-42-1-5-oz-bags.html',
            'image' => 'http://mcdn.coffeeforless.com/media/catalog/product/no_selection',
            'brand' => 'Barrie House',
            'rating' => 0,
            'caffeine_type' => 'Caffeinated',
            'count' => 42,
            'flavored' => false,
            'seasonal' => false,
            'instock' => false,
            'facebook' => true,
            'iskcup' => false
        ];

        $result = $this->parser->parseItem($data);

        $this->assertEquals($expected, $result);
    }

    public function testGetData()
    {
        $file = 'data/feed_test.xml';
        $this->parser->read($file);
        $this->assertInstanceOf(SimpleXMLElement::class, $this->parser->getData());
    }
}
