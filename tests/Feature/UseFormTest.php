<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;

class UseFormTest extends TestCase
{
    /** @test */
    public function unpublished_forms_are_not_visiable()
    {
        $this->signIn()->withExceptionHandling();
        $form = create('App\Form', ['published_at' => null]);

        $request = $this->get("/forms/{$form->uuid}");

        $request->assertStatus(404);
    }

    /** @test */
    public function published_forms_are_visible()
    {
        $this->signIn();
        $form = create('App\Form', ['published_at' => Carbon::now()]);

        $request = $this->get("/forms/{$form->uuid}");

        $request->assertStatus(200);
    }

    /** @test */
    public function form_name_display_can_be_toggled_on_and_off()
    {
        $this->signIn();
        $form = create('App\Form', [
            'name' => 'Form Name',
            'name_display' => 'Y',
            'published_at' => Carbon::now()
        ]);

        $this->get("/forms/{$form->uuid}")
            ->assertSee('Form Name');

        $form->update(['name_display' => 'N']);

        $this->get("/forms/{$form->uuid}")
            ->assertDontSee('Form Name');
    }

    /** @test */
    public function form_submissions_are_saved_to_the_database()
    {
        $this->signIn();

        $form = create('App\Form', [
            'name' => $name = 'Test Form',
            'published_at' => Carbon::now()
        ]);
        
        $field = create('App\FormField', [
            'form_id' => $form->id,
            'name' => 'Email',
        ]);

        $post = $this->post("/forms/{$form->uuid}", [
            'email' => 'test@example.org'
        ]);

        $submissionId = explode('/', $post->getTargetUrl());
        $this->get("/submissions/" . end($submissionId))
            ->assertJson(['data' => ['email' => 'test@example.org']]);
    }

    /** @test */
    public function invalid_fields_in_a_form_submissions_are_not_saved_to_the_database_but_valid_fields_are()
    {
        $this->signIn();

        $form = create('App\Form', [
            'name' => $name = 'Test Form',
            'published_at' => Carbon::now()
        ]);
        
        $field = create('App\FormField', [
            'form_id' => $form->id,
            'name' => 'Email',
        ]);

        $post = $this->post("/forms/{$form->uuid}", [
            'name' => 'Joe Bob',
            'email' => 'test@example.org'
        ]);

        $submissionId = explode('/', $post->getTargetUrl());
        $this->get("/submissions/" . end($submissionId))
            ->assertJsonFragment(['data' => ['email' => 'test@example.org']]);
    }

    /** @test */
    public function forms_can_be_soft_deleted()
    {
        $form = create('App\Form');

        $form->delete();

        $this->assertSoftDeleted('forms', ['id' => $form->id]);
    }
}
