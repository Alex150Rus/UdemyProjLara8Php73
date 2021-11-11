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


}
