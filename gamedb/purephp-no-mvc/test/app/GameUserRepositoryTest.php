<?php
//Para ejecutarlo $ purephp/vendor/phpunit/phpunit/phpunit  purephp/test/PruebaTest.php
use PHPUnit\Framework\TestCase;

class GameUserRepositoryTest extends TestCase{
    /**@test */
    public function prueba(){
        $this->assertEquals(1,1);
    }
}