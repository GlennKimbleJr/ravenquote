<?php

namespace Tests\Unit;

use App\Form;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FormTest extends TestCase
{
    /** @test */
    public function name_is_only_returned_if_name_display_is_yes()
    {
        $form = new Form;
        $form->name = 'Test';
        $form->name_display = 'Y';

        $this->assertEquals('Test', $form->name);
        
        $form->name_display = 'N';
        $this->assertNull($form->name);
    }
}
