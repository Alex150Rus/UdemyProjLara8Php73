<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testAccessibilityOfBlogPostsPage()
    {
        $response = $this->get('/posts');
        $response->assertStatus(200);
    }

    public function testSee1BlogPostsWhenThereIs1WithNoComments()
    {
        //Arrange part
        $post = $this->createDummyBlogPost();

        //Act part
        $response = $this->get('/posts');

        //Assert part
        $response->assertSeeText('New title');
        $response->assertSeeText('No comments yet!');
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New title',
            'content' => 'Content of the blog post',
        ]);
    }

    public function testSee1BlogPostWithComments() {
        //Arrange
        $post = $this->createDummyBlogPost();
        Comment::factory(['blog_post_id' => $post->id])->count(4)->create();

        //Act part
        $response = $this->get('/posts');

        $response->assertSeeText('4 comments');
    }

    public function testStoreValid()
    {
        $user = $this->user();

        $params = [
            'title' => 'Valid title',
            'content' => 'At least 10 characters'
        ];

        //submitting a form
        $this->actingAs($user)
            ->post('/posts', $params)
            //redirect
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was created');
    }

    public function testStoreFail(){
        $params = [
            'title' => 'x',
            'content' => 'x',
        ];

        $this->actingAs($this->user())
            ->post('/posts', $params)
            //redirect
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['title'][0], "The title must be at least 5 characters.");
        $this->assertEquals($messages['content'][0], "The content must be at least 10 characters.");
        //dd($messages->getMessages());
    }

    public function testUpdateValid() {
        //Arrange part
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);
        $this->assertDatabaseHas('blog_posts',  ['title' =>  $post->title]);

        $this->actingAs($user)
            ->put("/posts/{$post->id}", $post->toArray())
            //redirect
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was updated!');

        //$this->assertDatabaseMissing('blog_posts',  ['title' => 'New title']);
    }

    public function testDelete(){
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts',  ['title' => 'New title']);

        $this->actingAs($user)
            ->delete("/posts/{$post->id}")
            //redirect
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was deleted!');
        //$this->assertDatabaseMissing('blog_posts',  ['title' => 'New title']);
        $this->assertSoftDeleted('blog_posts',  ['title' => 'New title']);
    }

    private function createDummyBlogPost($userId = null): BlogPost {
//        $post = new BlogPost();
//        $post->title = 'New title';
//        $post->content = 'Content of the blog post';
//        $post->save();

        return BlogPost::factory()->newTitle()->create(
            [
                'user_id' => $userId ?? $this->user()->id,
            ]
        );


//        return $post;
    }

}
