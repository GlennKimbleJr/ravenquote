<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FormSubmissionsTest extends TestCase
{

    /** @test */
    public function users_cannot_view_other_users_form_submissions()
    {
        // Arrange
    
        // Act
    
        // Assert
    }
    
    /** @test */
    public function users_can_view_saved_form_submissions_from_their_own_forms()
    {
        // Arrange
    
        // Act
    
        // Assert
    }    

    /** @test */
    public function administrators_can_view_saved_form_submissions_from_everyones_forms()
    {
        // Arrange
    
        // Act
    
        // Assert
    }

    /** @test */
    public function form_submissions_display_as_unread()
    {
        // Arrange
    
        // Act
    
        // Assert
    }

    /** @test */
    public function form_submissions_display_as_read()
    {
        // Arrange
    
        // Act
    
        // Assert
    }

    /** @test */
    public function unread_form_submissions_display_as_read_after_viewing()
    {
        // Arrange
    
        // Act
    
        // Assert
    }

    /** @test */
    public function form_submissions_can_be_soft_deleted()
    {
        // Arrange
    
        // Act
    
        // Assert
    }

    /** @test */
    public function soft_deleted_form_submissions_can_no_longer_be_viewed_by_the_user()
    {
        // Arrange
    
        // Act
    
        // Assert
    }

    /** @test */
    public function soft_deleted_form_submissions_can_still_be_viewed_by_an_admin()
    {
        // Arrange
    
        // Act
    
        // Assert
    }
}
