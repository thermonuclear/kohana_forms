<?php

// ./vendor/bin/phpunit ControllerAjaxTest

// class ControllerAjaxTest extends Unittest_TestCase
/**
 * Пример теста. настроить через модуль kohana unittest не получилось - сделал напрямую через phpunit.
*/
class ControllerAjaxTest extends PHPUnit\Framework\TestCase
{
    public function testContent()
    {
        $meduza = new Service_Meduza();
        $news = $meduza->getCacheNews();
        $this->assertNotEmpty($news);

        $oneNews = $meduza->getOneRandomNews($news);
        $this->assertArrayHasKey('title', $oneNews);
        $this->assertArrayHasKey('second_title', $oneNews);
        $this->assertArrayHasKey('image', $oneNews);
        // $this->assertValidKeys(['title', 'second_title', 'image'], $oneNews);
    }
}
