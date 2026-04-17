<?php

namespace Tests\Unit;

use App\DAO\CategoryDAO;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryDAOTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_dao_can_create_update_and_delete_category(): void
    {
        $dao = app(CategoryDAO::class);

        $category = $dao->create([
            'name' => 'Skincare',
            'slug' => 'skincare',
        ]);
        $this->assertDatabaseHas('categories', ['id' => $category->id, 'slug' => 'skincare']);

        $updated = $dao->update($category, [
            'name' => 'Body Care',
            'slug' => 'body-care',
        ]);
        $this->assertSame('body-care', $updated->slug);

        $dao->delete($category);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
