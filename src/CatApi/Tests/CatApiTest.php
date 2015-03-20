<?php

namespace CatApi\CatApi\Tests;

use CatApi\CatApi;
use CatApi\HttpClientInterface;
use CatApi\NewUrlObserver;
use CatApi\PrefetchGifObserver;

class CatApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CatApi
     */
    private $catApi;

    /**
     * @var HttpClientInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $httpClient;

    /**
     * @var NewUrlObserver|\PHPUnit_Framework_MockObject_MockObject
     */
    private $observer;

    protected function setUp()
    {
        $this->httpClient = $this->getMock('CatApi\HttpClientInterface');
        $this->observer = $this->getMock('CatApi\NewUrlObserver');
        $this->catApi = new CatApi($this->httpClient, [$this->observer]);
    }

    /**
     * @test
     */
    public function it_fetches_the_url_of_a_cat_gif_by_its_id()
    {
        $xmlResponse = <<<XML
<?xml version="1.0"?>
<response>
  <data>
    <images>
      <image>
        <url>http://24.media.tumblr.com/tumblr_m1pgmg9Fe61qjahcpo1_1280.jpg</url>
        <id>vd</id>
        <source_url>http://thecatapi.com/?id=vd</source_url>
      </image>
    </images>
  </data>
</response>
XML;
        $this->httpClient
            ->expects($this->once())
            ->method('get')
            ->with('http://thecatapi.com/api/images/get?format=xml&image_id=vd')
            ->willReturn($xmlResponse);
//        $this->httpClient
//            ->expects($this->at(1))
//            ->method('get')
//            ->with('http://24.media.tumblr.com/tumblr_m1pgmg9Fe61qjahcpo1_1280.jpg')
//            ->willReturn('raw-image-data');

        $this->observer
            ->expects($this->once())
            ->method('notify')
            ->with('http://24.media.tumblr.com/tumblr_m1pgmg9Fe61qjahcpo1_1280.jpg');

        $actualUrl = $this->catApi->getCatGifUrl('vd');

        $this->assertSame('http://24.media.tumblr.com/tumblr_m1pgmg9Fe61qjahcpo1_1280.jpg', $actualUrl);

//        // it downloads a copy of the image as well
//        $this->assertSame(
//            'raw-image-data',
//            file_get_contents(__DIR__ . '/../../../cache/' . md5('http://24.media.tumblr.com/tumblr_m1pgmg9Fe61qjahcpo1_1280.jpg') . '.gif')
//        );

    }

    public function it_fetches_a_random_url_of_a_cat_gif()
    {
        $this->markTestIncomplete('Too lazy to implement this');

        $actualUrl = $this->catApi->getRandomCatGifUrl();

        $this->assertTrue(filter_var($actualUrl, FILTER_VALIDATE_URL) !== false);

        $this->assertFileExists(__DIR__ . '/../../../cache/random.gif');
    }
}
