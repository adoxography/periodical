<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageControllerTest extends TestCase
{
    /** @test */
    public function an_image_can_be_fetched()
    {
        Storage::fake();
        $image = UploadedFile::fake()->image('foo.jpg');
        $url = $image->store('/images');
        Storage::assertExists($url);

        $response = $this->get($url);

        $response->assertOk();
    }
}
