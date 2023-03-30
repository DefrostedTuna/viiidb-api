<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\StatusEffect;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemStatusEffectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $itemsMap = [
            [
                'slug' => 'phoenix-down',
                'status-effects' => [
                    'death',
                ],
            ],
            [
                'slug' => 'mega-phoenix',
                'status-effects' => [
                    'death',
                ],
            ],
            [
                'slug' => 'elixir',
                'status-effects' => [
                    'poison',
                    'petrify',
                    'darkness',
                    'silence',
                    'berserk',
                    'sleep',
                    'slow',
                    'stop',
                    'curse',
                    'doom',
                    'petrifying',
                    'confuse',
                    'vit 0',
                ],
            ],
            [
                'slug' => 'megalixir',
                'status-effects' => [
                    'poison',
                    'petrify',
                    'darkness',
                    'silence',
                    'berserk',
                    'sleep',
                    'slow',
                    'stop',
                    'curse',
                    'doom',
                    'petrifying',
                    'confuse',
                    'vit 0',
                ],
            ],
            [
                'slug' => 'antidote',
                'status-effects' => [
                    'poison',
                ],
            ],
            [
                'slug' => 'soft',
                'status-effects' => [
                    'petrify',
                    'petrifying',
                ],
            ],
            [
                'slug' => 'eye-drops',
                'status-effects' => [
                    'darkness',
                ],
            ],
            [
                'slug' => 'echo-screen',
                'status-effects' => [
                    'silence',
                ],
            ],
            [
                'slug' => 'holy-water',
                'status-effects' => [
                    'zombie',
                    'curse',
                ],
            ],
            [
                'slug' => 'remedy',
                'status-effects' => [
                    'poison',
                    'petrify',
                    'darkness',
                    'silence',
                    'berserk',
                    'zombie',
                    'sleep',
                    'curse',
                    'petrifying',
                    'confuse',
                ],
            ],
            [
                'slug' => 'remedy-plus',
                'status-effects' => [
                    'poison',
                    'petrify',
                    'darkness',
                    'silence',
                    'berserk',
                    'zombie',
                    'sleep',
                    'slow',
                    'stop',
                    'curse',
                    'doom',
                    'petrifying',
                    'confuse',
                ],
            ],
            [
                'slug' => 'hero-trial',
                'status-effects' => [
                    'invincible',
                ],
            ],
            [
                'slug' => 'hero',
                'status-effects' => [
                    'invincible',
                ],
            ],
            [
                'slug' => 'holy-war-trial',
                'status-effects' => [
                    'invincible',
                ],
            ],
            [
                'slug' => 'holy-war',
                'status-effects' => [
                    'invincible',
                ],
            ],
        ];

        $dbItems = Item::all();
        $dbStatusEffects = StatusEffect::all();
        $recordsToInsert = [];

        foreach ($itemsMap as $item) {
            $matchedItem = $dbItems->filter(function ($i) use ($item) {
                return $i['slug'] === $item['slug'];
            })->first();

            foreach ($item['status-effects'] as $statusEffectName) {
                $matchedStatusEffect = $dbStatusEffects->filter(function ($i) use ($statusEffectName) {
                    return $i['name'] === $statusEffectName;
                })->first();

                $recordsToInsert[] = [
                    'item_id' => $matchedItem->id,
                    'status_effect_id' => $matchedStatusEffect->id,
                ];
            }
        }

        DB::table('item_status_effect')->insert($recordsToInsert);
    }
}
