<?php

namespace Database\Seeders;

use App\Models\Element;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class ElementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $elements = [
            ['sort_id' => 1, 'name' => 'fire'],
            ['sort_id' => 2, 'name' => 'ice'],
            ['sort_id' => 3, 'name' => 'thunder'],
            ['sort_id' => 4, 'name' => 'earth'],
            ['sort_id' => 5, 'name' => 'poison'],
            ['sort_id' => 6, 'name' => 'wind'],
            ['sort_id' => 7, 'name' => 'water'],
            ['sort_id' => 8, 'name' => 'holy'],
        ];

        foreach ($elements as $key => $value) {
            $elements[$key]['id'] = Uuid::generate(4);
            $elements[$key]['created_at'] = Carbon::now();
            $elements[$key]['updated_at'] = Carbon::now();
        }

        $element = new Element();

        $element->insert($elements);
    }
}
