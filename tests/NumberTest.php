<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NumberTest extends TestCase
{

    use DatabaseTransactions;
    /**
     * Test valid arabic.
     *
     * @return void
     */
    public function testNumber()
    {
        $this->json('GET', '/api/convert/42')
            ->seeJsonStructure([
                'data' => [
                    'arabic', 'roman'
                ]
            ]);

        $this->json('GET', '/api/convert/1990')
            ->seeJson([
                'arabic' => 1990,
                'roman' => "MCMXC"
            ]);

        $this->json('GET', '/api/convert/2008')
            ->seeJson([
                'arabic' => 2008,
                'roman' => "MMVIII"
            ]);
    }

    /**
     * Test convert string.
     *
     * @return void
     */
    public function testWrongString()
    {
        $this->json('GET', '/api/convert/bazinga')
            ->seeJson([
                'status_code' => 422
            ]);
    }

    /**
     * Test out of range.
     *
     * @return void
     */
    public function testWrongRange()
    {
        $this->json('GET', '/api/convert/4000')
            ->seeJson([
                'message' => "Could not convert the number."
            ]);
        $this->json('GET', '/api/convert/0')
            ->seeJson([
                'message' => "Could not convert the number."
            ]);
        $this->json('GET', '/api/convert/-500')
            ->seeJson([
                'message' => "Could not convert the number."
            ]);
    }
}
