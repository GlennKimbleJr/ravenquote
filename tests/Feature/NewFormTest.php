<?php

namespace Tests\Feature;

use Tests\TestCase;

class NewFormTest extends TestCase
{
    /** @test */
    public function unauthenticated_users_cannot_create_new_forms()
    {
        $this->withExceptionHandling();

        $this->get('/forms/create')
            ->assertStatus(302);
        
        $this->post('/forms')
            ->assertStatus(302);
    }

    /** @test */
    public function authenticated_users_can_create_new_forms()
    {
        $this->signIn();
        $this->assertDatabaseMissing('forms', ['user_id' => auth()->id()]);
        
        $this->get('/forms/create')
            ->assertStatus(200);

        $this->post('/forms', 
            make('App\Form')->toArray()
        );

        $this->assertDatabaseHas('forms', ['user_id' => auth()->id()]);
    }

    /** @test */
    public function new_forms_are_unpublished_by_default()
    {
        $this->signIn();

        $form = create('App\Form');

        $this->assertNull($form->published_at);
    }

    /** @test */
    public function forms_have_names()
    {
        $this->signIn();

        $form = create('App\Form', ['name' => 'Test Name']);

        $this->assertEquals('Test Name', $form->fresh()->name);
    }

    /** @test */
    public function form_type_can_be_live_calculation()
    {
        $this->signIn();
        $allowable_types = \App\Form\Types::get();
        $this->assertContains('live_calculation', $allowable_types);

        $request = $this->post('/forms', 
            make('App\Form', ['type' => 'live_calculation'])->toArray()
        );

        $this->assertDatabaseHas('forms', ['type' => 'live_calculation']);
    }

    /** @test */
    public function form_type_can_be_click_to_calculate()
    {
        $this->signIn();
        $allowable_types = \App\Form\Types::get();
        $this->assertContains('click_to_calculate', $allowable_types);

        $request = $this->post('/forms', 
            make('App\Form', ['type' => 'click_to_calculate'])->toArray()
        );

        $this->assertDatabaseHas('forms', ['type' => 'click_to_calculate']);
    }

    /** @test */
    public function form_type_can_be_request_for_quote()
    {
        $this->signIn();
        $allowable_types = \App\Form\Types::get();
        $this->assertContains('request_for_quote', $allowable_types);

        $request = $this->post('/forms', 
            make('App\Form', ['type' => 'request_for_quote'])->toArray()
        );

        $this->assertDatabaseHas('forms', ['type' => 'request_for_quote']);
    }

    /** @test */
    public function form_type_can_be_email_calculation()
    {
        $this->signIn();
        $allowable_types = \App\Form\Types::get();
        $this->assertContains('email_calculation', $allowable_types);

        $request = $this->post('/forms', 
            make('App\Form', ['type' => 'email_calculation'])->toArray()
        );

        $this->assertDatabaseHas('forms', ['type' => 'email_calculation']);
    }

    /** @test */
    public function form_type_can_be_email_calculation_with_admin_approval()
    {
        $this->signIn();
        $allowable_types = \App\Form\Types::get();
        $this->assertContains('email_calculation_with_admin_approval', $allowable_types);

        $request = $this->post('/forms', 
            make('App\Form', ['type' => 'email_calculation_with_admin_approval'])->toArray()
        );

        $this->assertDatabaseHas('forms', ['type' => 'email_calculation_with_admin_approval']);
    }

    /** @test */
    public function form_type_cannot_be_something_other_then_a_value_returned_by_the_form_type_object()
    {
        $this->signIn()->withExceptionHandling();
        $allowable_types = \App\Form\Types::get();
        $this->assertNotContains('invalid_form_type', $allowable_types);

        $request = $this->post('/forms', 
            make('App\Form', ['type' => 'invalid_form_type'])->toArray()
        );

        $request->assertSessionHasErrors('type');
        $this->assertDatabaseMissing('forms', ['type' => 'invalid_form_type']);
    }

    /** @test */
    public function forms_have_fields()
    {
        $this->signIn();

        $field = create('App\FormField');

        $this->assertDatabaseHas('form_fields', ['id' => $field->id]);
        $this->assertDatabaseHas('forms', ['id' => $field->form_id]);
    }

    /** @test */
    public function form_fields_have_a_name()
    {
        $this->signIn();

        $name = 'Form Field Name Test';
        $field = create('App\FormField', ['name' => $name]);

        $this->assertEquals($name, $field->name);
    }

    /** @test */
    public function form_fields_can_be_radio_button()
    {
        $this->signIn();
        $allowable_types = \App\Form\FieldTypes::get();
        $this->assertContains('radio_button', $allowable_types);

        $form = make('App\Form')->toArray();
        $form['fields'] = [
            make('App\FormField', ['type' => 'radio_button'])->toArray(),
        ];
        $request = $this->post('/forms', $form);

        $this->assertDatabaseHas('form_fields', ['type' => 'radio_button']);
    }

    /** @test */
    public function form_fields_can_be_check_box()
    {
        $this->signIn();
        $allowable_types = \App\Form\FieldTypes::get();
        $this->assertContains('check_box', $allowable_types);

        $form = make('App\Form')->toArray();
        $form['fields'] = [
            make('App\FormField', ['type' => 'check_box'])->toArray(),
        ];
        $request = $this->post('/forms', $form);

        $this->assertDatabaseHas('form_fields', ['type' => 'check_box']);
    }

    /** @test */
    public function form_fields_can_be_dropdown_menu()
    {
        $this->signIn();
        $allowable_types = \App\Form\FieldTypes::get();
        $this->assertContains('dropdown_menu', $allowable_types);

        $form = make('App\Form')->toArray();
        $form['fields'] = [
            make('App\FormField', ['type' => 'dropdown_menu'])->toArray(),
        ];
        $request = $this->post('/forms', $form);

        $this->assertDatabaseHas('form_fields', ['type' => 'dropdown_menu']);
    }

    /** @test */
    public function form_fields_can_be_number_input()
    {
        $this->signIn();
        $allowable_types = \App\Form\FieldTypes::get();
        $this->assertContains('number_input', $allowable_types);

        $form = make('App\Form')->toArray();
        $form['fields'] = [
            make('App\FormField', ['type' => 'number_input'])->toArray(),
        ];
        $request = $this->post('/forms', $form);

        $this->assertDatabaseHas('form_fields', ['type' => 'number_input']);
    }

    /** @test */
    public function form_fields_can_be_text_input()
    {
        $this->signIn();
        $allowable_types = \App\Form\FieldTypes::get();
        $this->assertContains('text_input', $allowable_types);

        $form = make('App\Form')->toArray();
        $form['fields'] = [
            make('App\FormField', ['type' => 'text_input'])->toArray(),
        ];
        $request = $this->post('/forms', $form);

        $this->assertDatabaseHas('form_fields', ['type' => 'text_input']);
    }

    /** @test */
    public function form_fields_can_be_hidden_input()
    {
        $this->signIn();
        $allowable_types = \App\Form\FieldTypes::get();
        $this->assertContains('hidden_input', $allowable_types);

        $form = make('App\Form')->toArray();
        $form['fields'] = [
            make('App\FormField', ['type' => 'hidden_input'])->toArray(),
        ];
        $request = $this->post('/forms', $form);

        $this->assertDatabaseHas('form_fields', ['type' => 'hidden_input']);
    }

    /** @test */
    public function form_fields_type_cannot_be_something_other_then_a_value_returned_by_the_form_field_type_object()
    {
        $this->signIn()->withExceptionHandling();
        $allowable_types = \App\Form\FieldTypes::get();
        $this->assertNotContains('invalid_form_type', $allowable_types);

        $form = make('App\Form')->toArray();
        $form['fields'] = [
            make('App\FormField', ['type' => 'invalid_form_type'])->toArray(),
        ];
        $request = $this->post('/forms', $form);

        $this->assertDatabaseMissing('form_fields', ['type' => 'invalid_form_type']);
    }

    /** @test */
    public function an_invalid_form_field_type_will_keep_a_new_from_from_being_created()
    {
        $this->signIn()->withExceptionHandling();

        $form = make('App\Form')->toArray();
        $form['fields'] = [
            make('App\FormField', ['type' => 'invalid_form_type'])->toArray(),
        ];
        $request = $this->post('/forms', $form);

        $this->assertDatabaseMissing('forms', ['type' => $form['type']]);
    }
    
    /** @test */
    public function form_fields_have_a_value()
    {
        $this->signIn();

        $form = make('App\Form')->toArray();
        $form['fields'] = [
            make('App\FormField', ['value' => 'test_value'])->toArray(),
        ];
        $request = $this->post('/forms', $form);

        $this->assertDatabaseHas('form_fields', ['value' => 'test_value']);
    }

    /** @test */
    public function form_fields_have_a_final_modified_value()
    {
        $this->signIn();

        $form = make('App\Form')->toArray();
        $form['fields'] = [
            make('App\FormField', ['final_value' => 'test_value'])->toArray(),
        ];
        $request = $this->post('/forms', $form);

        $this->assertDatabaseHas('form_fields', ['final_value' => 'test_value']);
    }

    /** @test */
    public function form_fields_final_modified_value_can_affect_another_form_fields_final_modified_value()
    {
        $this->signIn();

        $form = make('App\Form')->toArray();
        $form['fields'] = [
            make('App\FormField', ['name' => 'test1', 'affects' => 'test2'])->toArray(),
            make('App\FormField', ['name' => 'test2'])->toArray(),
        ];
        $request = $this->post('/forms', $form);

        $this->assertDatabaseHas('form_fields', ['name' => 'test1', 'affects' => 'test2']);
    }

    /** @test */
    public function form_fields_final_value_can_affect_the_total()
    {
        $this->signIn();

        $form = make('App\Form')->toArray();
        $form['fields'] = [
            make('App\FormField', ['name' => 'test1', 'affects' => 'total'])->toArray(),
        ];
        $request = $this->post('/forms', $form);

        $this->assertDatabaseHas('form_fields', ['name' => 'test1', 'affects' => 'total']);
    }

    /** @test */
    public function form_fields_final_value_cannot_affect_something_other_than_an_existing_form_field_or_the_total()
    {
        $this->signIn()->withExceptionHandling();

        $form = make('App\Form')->toArray();
        $form['fields'] = [
            make('App\FormField', ['name' => 'test1', 'affects' => 'invalid-value'])->toArray(),
            make('App\FormField', ['name' => 'test2'])->toArray(),
        ];
        $request = $this->post('/forms', $form);

        $request->assertSessionHasErrors('fields.0.affects');
        $this->assertDatabaseMissing('form_fields', ['name' => 'test1', 'affects' => 'invalid-value']);
    }

    /** @test */
    public function form_fields_final_modified_value_can_not_affect_its_own_final_modified_value()
    {
        $this->signIn()->withExceptionHandling();

        $form = make('App\Form')->toArray();
        $form['fields'] = [
            make('App\FormField', ['name' => 'test1', 'affects' => 'test1'])->toArray(),
            make('App\FormField', ['name' => 'test2'])->toArray(),
        ];
        $request = $this->post('/forms', $form);

        $request->assertSessionHasErrors('fields.0.affects');
        $this->assertDatabaseMissing('form_fields', ['name' => 'test1', 'affects' => 'test1']);
    }

    /** @test */
    public function forms_have_themes()
    {
        $this->signIn();

        $form = create('App\Form', ['theme' => $theme = 'blue']);

        $this->assertEquals($theme, $form->theme);
    }

    /** @test */
    public function valid_uuids_are_generated_at_creation()
    {
        $this->signIn();

        $form = create('App\Form', ['theme' => $theme = 'blue']);

        $this->assertNotNull($form->uuid);
        $this->assertEquals(36, strlen($form->uuid));
        $this->assertRegExp(
            '/[a-f0-9]{8}-?[a-f0-9]{4}-?4[a-f0-9]{3}-?[89ab][a-f0-9]{3}-?[a-f0-9]{12}/', 
            $form->uuid
        );
    }
}
