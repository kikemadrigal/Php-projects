<?php
//Para ejecutarlo $ purephp/vendor/phpunit/phpunit/phpunit  purephp/test/PruebaTest.php
use PHPUnit\Framework\TestCase;

class PruebaTest extends TestCase{
    /**@test */
    public function getAllGamesByUsertest($array){
        $this->assertNotEmpty($array);
    }
}