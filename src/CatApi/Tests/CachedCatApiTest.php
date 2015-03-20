<?php

namespace CatApi\Tests;

use CatApi\CachedCatApi;
use CatApi\CatApiInterface;

class CachedCatApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CachedCatApi
     */
    private $cachedCatApi;

    /**
     * @var CatApiInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $catApi;

    private $tempDir;

    protected function setUp()
    {
        $this->tempDir = sys_get_temp_dir();
        @unlink($this->tempDir . '/random');
        @unlink($this->tempDir . '/vd');

        $this->catApi = $this->getMock('CatApi\CatApiInterface');
        $this->cachedCatApi = new CachedCatApi($this->catApi, $this->tempDir);
    }

    /**
     * @test
     */
    public function it_fetches_the_url_of_a_cat_gif_by_its_id_and_stores_it_in_the_cache()
    {
        $this->catApi
            ->expects($this->once())
            ->method('getCatGifUrl')
            ->with('vd')
            ->willReturn('the-url');

        $actualUrl = $this->cachedCatApi->getCatGifUrl('vd');

        $this->assertSame('the-url', $actualUrl);
        $this->assertSame('the-url', file_get_contents($this->tempDir . '/vd'));
    }

    /**
     * @test
     */
    public function it_returns_a_cached_url()
    {
        $this->catApi
            ->expects($this->once())
            ->method('getCatGifUrl')
            ->with('vd')
            ->willReturn('the-url');

        $this->assertSame('the-url', $this->cachedCatApi->getCatGifUrl('vd'));

        // calling this the second time returns the URL from cache
        $this->assertSame('the-url', $this->cachedCatApi->getCatGifUrl('vd'));
    }
}
