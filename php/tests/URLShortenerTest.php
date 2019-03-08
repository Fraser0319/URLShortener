<?php
use PHPUnit\Framework\TestCase;

class URLShortenerTest extends TestCase
{
    public function testItCanGenerateAShortURLCode(): void
    {
        $urlShortener = new URLShortener();
        $shortCode = $urlShortener->shorten();
        $this->assertTrue(strlen($shortCode) > 3);
    }

    public function testItWillReturnAUrlWithShortCode(): void
    {
        $urlShortener = new URLShortener();
        $url = $urlShortener->createShortendUrl('https://www.github.com/fraser0319',$urlShortener->shorten() );
        $this->assertTrue(!strpos($url, 'http://localhost:8100/')); // we have returned url with a shortcode
    }

    public function testIfADuplicateEntryOccurs(): void
    {
        $urlShortener = new URLShortener();
        $url = $urlShortener->createShortendUrl('https://www.github.com/fraser0319', "EEEEEE");
        $url = $urlShortener->createShortendUrl('https://www.github.com/fraser0319', "EEEEEE"); // make sure we create a duplicate
        $this->assertTrue(!strpos($url, "Duplicate Entry")); // we have returned url with a shortcode
    }

}