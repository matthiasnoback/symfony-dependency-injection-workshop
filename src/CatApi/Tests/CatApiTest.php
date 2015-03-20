<?php

namespace CatApi\CatApi\Tests;

use CatApi\CachedCatApi;
use CatApi\CatApi;

class CatApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CachedCatApi
     */
    private $catApi;

    protected function setUp()
    {
        @unlink(__DIR__ . '/../../../cache/random');
        @unlink(__DIR__ . '/../../../cache/random.gif');
        @unlink(__DIR__ . '/../../../cache/vd');
        @unlink(__DIR__ . '/../../../cache/vd.gif');

        $this->catApi = new CachedCatApi(new CatApi());
    }

    /**
     * @test
     */
    public function it_fetches_the_url_of_a_cat_gif_by_its_id()
    {
        $actualUrl = $this->catApi->getCatGifUrl('vd');

        $this->assertSame('http://24.media.tumblr.com/tumblr_m1pgmg9Fe61qjahcpo1_1280.jpg', $actualUrl);

        // it downloads a copy of the image as well
        $this->assertSame(
            file_get_contents(__DIR__ . '/fixtures/vd.gif'),
            file_get_contents(__DIR__ . '/../../../cache/vd.gif')
        );
    }

    /**
     * @test
     */
    public function it_caches_the_url_of_a_cat_gif()
    {
        $start = microtime(true);
        $this->catApi->getCatGifUrl('vd');
        $firstRound = microtime(true) - $start;

        $start = microtime(true);
        $this->catApi->getCatGifUrl('vd');
        $secondRound = microtime(true) - $start;

        // doing the HTTP request is supposed to be much slower than using the cache
        $this->assertTrue($secondRound * 200 < $firstRound);
    }

    /**
     * @test
     */
    public function it_fetches_a_random_url_of_a_cat_gif()
    {
        $actualUrl = $this->catApi->getRandomCatGifUrl();

        $this->assertTrue(filter_var($actualUrl, FILTER_VALIDATE_URL) !== false);

        $this->assertFileExists(__DIR__ . '/../../../cache/random.gif');
    }

    /**
     * @test
     */
    public function it_caches_a_random_cat_gif_url_for_5_seconds()
    {
        $firstRandomUrl = $this->catApi->getRandomCatGifUrl();
        sleep(3);
        $secondRandomUrl = $this->catApi->getRandomCatGifUrl();

        // we've exceeded 5 seconds now
        sleep(4);

        $thirdRandomUrl = $this->catApi->getRandomCatGifUrl();
        $this->assertSame($firstRandomUrl, $secondRandomUrl);
        $this->assertNotSame($secondRandomUrl, $thirdRandomUrl);
    }
}
