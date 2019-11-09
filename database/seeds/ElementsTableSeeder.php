<?php

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
            [ 'name' => 'fire' ],
            [ 'name' => 'ice' ],
            [ 'name' => 'thunder' ],
            [ 'name' => 'earth' ],
            [ 'name' => 'poison' ],
            [ 'name' => 'wind' ],
            [ 'name' => 'water' ],
            [ 'name' => 'holy' ],
        ];

        // Assign a UUID and timestamp to each record.
        // Do this in bulk to maintain readability.
        foreach ($elements as $key => $value) {
            $elements[$key]['id'] = Uuid::generate(4);
            $elements[$key]['created_at'] = Carbon::now();
            $elements[$key]['updated_at'] = Carbon::now();
        }

        $element = new Element();

        $element->insert($elements);
    }
}
