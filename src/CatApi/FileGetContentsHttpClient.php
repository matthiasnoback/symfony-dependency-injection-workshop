<?php

namespace CatApi;

class FileGetContentsHttpClient implements HttpClientInterface
{
    public function get($url)
    {
        return @file_get_contents($url);
    }
}
