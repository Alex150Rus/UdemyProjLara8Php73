<?php

namespace Tests\Feature;

use App\Models\BlogPost;
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

    public function testSee1BlogPostsWhenThereIs1()
    {
        //Arrange part
        $post = new BlogPost();
        $post->title = 'New title';
        $post->content = 'Content of the blog post';
        $post->save();

        //Act part
        $response = $this->get('/posts');

        //Assert part
        $response->assertSeeText('New title');
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New title',
            'content' => 'Content of the blog post',
        ]);
    }

    public function testStoreValid()
    {
        $params = [
            'title' => 'Valid title',
            'content' => 'At least 10 characters'
        ];

        //submitting a form
        $this->post('/posts', $params)
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

        $this->post('/posts', $params)
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
        $post = new BlogPost();
        $post->title = 'New title';
        $post->content = 'Content of the blog post';
        $post->save();

        $this->assertDatabaseHas('blog_posts',  ['title' => 'New title']);

        $params = [
            'title' => 'A new named title',
            'content' => 'Content was changed',
        ];

        $this->put("/posts/{$post->id}", $params)
            //redirect
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was updated!');

        $this->assertDatabaseMissing('blog_posts',  ['title' => 'New title']);
        $this->assertDatabaseHas('blog_posts',  $params);
    }


}
