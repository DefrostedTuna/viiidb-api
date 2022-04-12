<?php

namespace Tests\Unit\Models;

use App\Models\SearchableModel;
use Laravel\Scout\Searchable;
use Tests\TestCase;

class SearchableModelTest extends TestCase
{
    /** @test */
    public function it_includes_search_functionality(): void
    {
        $this->assertTrue(in_array(
            Searchable::class,
            class_uses(SearchableModel::class) ?: []
        ));
    }

    /** @test */
    public function it_explicitly_defines_the_fields_that_are_searchable(): void
    {
        $model = new SearchableModel();

        $expected = [];

        $this->assertEquals($expected, $model->getSearchableFields());
    }
}
