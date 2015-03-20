<?php
namespace CatApi;

interface CatApiInterface
{
    public function getCatGifUrl($id);

    public function getRandomCatGifUrl();
}
