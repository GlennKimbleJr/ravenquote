<?php

namespace Tests\Feature;

use Tests\TestCase;

class NewFormTest extends TestCase
{
    /** @test */
    public function unauthenticated_users_cannot_create_new_forms()
    {
        $this->withExceptionHandling();

        $this->get('/forms/create')->assertStatus(302);
        $this->post('/forms')->assertStatus(302);
    }

    /** @test */
    public function authenticated_users_can_create_new_forms()
    {
        $this->signIn();
        $this->assertDatabaseMissing('forms', ['user_id' => auth()->id()]);
        
        $this->get('/forms/create')->assertStatus(200);
        $this->post('/forms', make('App\Form')->toArray());

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

        $form = create('App\Form', ['name' => $name = 'Test Name']);

        $this->assertEquals($name, $form->name);
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
        // Arrange
    
        // Act
    
        // Assert
    }

    /** @test */
    public function form_fields_have_a_name()
    {
        // Arrange
    
        // Act
    
        // Assert
    }

    /** @test */
    public function form_fields_can_be_radio_buttons()
    {
        // Arrange
    
        // Act
    
        // Assert
    }

    /** @test */
    public function form_fields_can_be_check_boxes()
    {
        // Arrange
    
        // Act
    
        // Assert
    }

    /** @test */
    public function form_fields_can_be_dropdown_menus()
    {
        // Arrange
    
        // Act
    
        // Assert
    }

    /** @test */
    public function form_fields_can_be_number_inputs()
    {
        // Arrange
    
        // Act
    
        // Assert
    }

    /** @test */
    public function form_fields_can_be_text_inputs()
    {
        // Arrange
    
        // Act
    
        // Assert
    }

    /** @test */
    public function form_fields_can_be_hidden_inputs()
    {
        // Arrange
    
        // Act
    
        // Assert
    }
    
    /** @test */
    public function form_fields_have_a_value()
    {
        // Arrange
    
        // Act
    
        // Assert
    }

    /** @test */
    public function form_fields_have_a_final_modified_value()
    {
        // Arrange
    
        // Act
    
        // Assert
    }

    /** @test */
    public function form_fields_final_modified_value_can_affect_another_form_fields_final_modified_value_but_not_its_own()
    {
        // Arrange
    
        // Act
    
        // Assert
    }

    /** @test */
    public function form_fields_final_value_can_affect_the_total()
    {
        // Arrange
    
        // Act
    
        // Assert
    }

    /** @test */
    public function forms_have_themes()
    {
        // Arrange
    
        // Act
    
        // Assert
    }

    /** @test */
    public function forms_can_be_soft_deleted()
    {
        // Arrange
    
        // Act
    
        // Assert
    }
}
