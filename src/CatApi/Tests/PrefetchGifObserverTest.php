<?php

namespace CatApi\Tests;

use CatApi\PrefetchGifObserver;

class PrefetchGifObserverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_stores_a_downloaded_gif()
    {
        $httpClient = $this->getMock('CatApi\HttpClientInterface');
        $httpClient
            ->expects($this->once())
            ->method('get')
            ->with('the-url')
            ->willReturn('raw-image-data');

        $observer = new PrefetchGifObserver($httpClient);

        $observer->notify('the-url');

        $this->assertSame(
            'raw-image-data',
            file_get_contents(__DIR__ . '/../../../cache/' . md5('the-url') . '.gif')
        );
    }
}
