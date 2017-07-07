<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Exceptions\UnauthorizedAccessException;

class ViewFormSubmissionsTest extends TestCase
{
    /** @test */
    public function users_cannot_view_other_users_form_submissions()
    {
        $this->signIn();
        $form = create('App\Form', ['published_at' => Carbon::now()]);
        $post = $this->post("/forms/{$form->uuid}");
        $submissionId = explode('/', $post->getTargetUrl());

        $this->expectException(UnauthorizedAccessException::class);

        $otherUser = create('App\User');
        $this->signIn($otherUser);
        $this->get("/submissions/" . end($submissionId));
    }
    
    /** @test */
    public function users_can_view_saved_form_submissions_from_their_own_forms()
    {
        $this->signIn();
        $form = create('App\Form', ['published_at' => Carbon::now()]);
        $post = $this->post("/forms/{$form->uuid}");
        $submissionId = explode('/', $post->getTargetUrl());

        $request = $this->get("/submissions/" . end($submissionId));
        
        $request->assertStatus(200);
    }

    /** @test */
    public function new_form_submissions_are_unread()
    {
        $submission = create('App\FormSubmission');

        $this->assertNull($submission->read_at);
    }

    /** @test */
    public function unread_form_submissions_display_as_read_after_viewing()
    {
        $this->signIn();
        $submission = create('App\FormSubmission');
        $this->assertNull($submission->read_at);

        $request = $this->get("/submissions/{$submission->id}");
        
        $this->assertNotNull($submission->fresh()->read_at);
    }

    /** @test */
    public function form_submissions_can_be_soft_deleted()
    {
        $submission = create('App\FormSubmission');

        $submission->delete();

        $this->assertSoftDeleted('form_submissions', ['id' => $submission->id]);
    }

    /** @test */
    public function soft_deleted_form_submissions_can_no_longer_be_viewed_by_the_user()
    {
        $this->signIn()->withExceptionHandling();
        $submission = create('App\FormSubmission');
        $this->get("/submissions/{$submission->id}")->assertStatus(200);

        $submission->delete();

        $this->assertDatabaseHas('form_submissions', ['id' => $submission->id]);
        $this->get("/submissions/{$submission->id}")->assertStatus(404);
    }
}
