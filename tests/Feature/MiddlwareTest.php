<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MiddlwareTest extends TestCase
{
    /** @test */
    public function middlewareRequest()
    {
        $this->signIn();

        $response = $this->post('/testroute')->assertStatus(200);

        $response->assertJson([
            'joe_property' => 'bob',
            'joe_get' => 'bob',
        ]);
    }
}
