<?php

use App\Models\SeedTest;
use App\Models\TestQuestion;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class TestQuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seedTests = (new SeedTest())->all();

        $testQuestions = [
            // Level 1
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 1;
                })->id,
                'question_number' => 1,
                'question' => 'The Draw command extracts magic from enemies.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 1;
                })->id,
                'question_number' => 2,
                'question' => 'GF stands for Garden Fighter.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 1;
                })->id,
                'question_number' => 3,
                'question' => 'There are a total of 8 elemental attributes.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 1;
                })->id,
                'question_number' => 4,
                'question' => 'In battle, a higher Strength stat causes more physical damage.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 1;
                })->id,
                'question_number' => 5,
                'question' => 'HP-J is a junction ability.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 1;
                })->id,
                'question_number' => 6,
                'question' => "You can't assign specific abilities for your GF to learn.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 1;
                })->id,
                'question_number' => 7,
                'question' => 'Magic uses MP.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 1;
                })->id,
                'question_number' => 8,
                'question' => 'You can name your GF.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 1;
                })->id,
                'question_number' => 9,
                'question' => 'You can wear protective gear.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 1;
                })->id,
                'question_number' => 10,
                'question' => 'GF level up with AP.',
                'answer' => 'no',
            ],
            // Level 2
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 2;
                })->id,
                'question_number' => 1,
                'question' => 'You can raise your Vitality by junctioning magic.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 2;
                })->id,
                'question_number' => 2,
                'question' => "Squall's weapon is the Gauntlet",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 2;
                })->id,
                'question_number' => 3,
                'question' => 'You can Stock drawn magic.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 2;
                })->id,
                'question_number' => 4,
                'question' => 'Any action taken while Poisoned causes damage. There is no damage if you take no action.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 2;
                })->id,
                'question_number' => 5,
                'question' => 'Being hit by a physical attack removes Confuse.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 2;
                })->id,
                'question_number' => 6,
                'question' => "Squall's Limit Break is Kenzokuken.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 2;
                })->id,
                'question_number' => 7,
                'question' => 'To junction magic, you need a matching junction ability for the stat you want to junction.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 2;
                })->id,
                'question_number' => 8,
                'question' => '<Junction Ability Icon> signifies a Junction Ability.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 2;
                })->id,
                'question_number' => 9,
                'question' => 'The 8 elements are Fire, Ice, Thunder, Poison, Earth, Sorcery, Wind, and Holy.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 2;
                })->id,
                'question_number' => 10,
                'question' => 'There is a limit to how much magic you can draw from monsters.',
                'answer' => 'no',
            ],
            // Level 3
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 3;
                })->id,
                'question_number' => 1,
                'question' => "Potions can restore a GF's HP.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 3;
                })->id,
                'question_number' => 2,
                'question' => 'Magic can only by acquired by drawing from enemies.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 3;
                })->id,
                'question_number' => 3,
                'question' => "Selphie's weapon is the nunchaku",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 3;
                })->id,
                'question_number' => 4,
                'question' => 'You only need money to remodel your weapon.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 3;
                })->id,
                'question_number' => 5,
                'question' => 'Whoever strikes the finishing blow in battle receives the most EXP.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 3;
                })->id,
                'question_number' => 6,
                'question' => 'GF also have levels: the higher their levels, the stronger their attacks.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 3;
                })->id,
                'question_number' => 7,
                'question' => '<Command Ability Icon> signifies Command Ability.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 3;
                })->id,
                'question_number' => 8,
                'question' => 'Each party member can have up to 5 Character and Party Abilities.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 3;
                })->id,
                'question_number' => 9,
                'question' => 'Command Abilities must be set to be used in battle.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 3;
                })->id,
                'question_number' => 10,
                'question' => 'AP means Action Point.',
                'answer' => 'no',
            ],
            // Level 4
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 4;
                })->id,
                'question_number' => 1,
                'question' => 'Only Squall can use a gunblade.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 4;
                })->id,
                'question_number' => 2,
                'question' => 'Attack magic can be used against party members.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 4;
                })->id,
                'question_number' => 3,
                'question' => 'There is an ability that allows you to make magic from items.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 4;
                })->id,
                'question_number' => 4,
                'question' => 'Higher Vitality reduces physical damage.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 4;
                })->id,
                'question_number' => 5,
                'question' => 'Blue Magic is learned by being attacked by a monster',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 4;
                })->id,
                'question_number' => 6,
                'question' => 'The magic Dispel cures poison.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 4;
                })->id,
                'question_number' => 7,
                'question' => "If you are KO'd with status change, but are revived after battle, the status change is removed.",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 4;
                })->id,
                'question_number' => 8,
                'question' => "T-Rexaur is a monster that lives in Balamb Garden's training center.",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 4;
                })->id,
                'question_number' => 9,
                'question' => "Squall's gunblade causes more damage by pressing <L2> at the right time.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 4;
                })->id,
                'question_number' => 10,
                'question' => 'You can stock up to 255 of each magic.',
                'answer' => 'no',
            ],
            // Level 5
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 5;
                })->id,
                'question_number' => 1,
                'question' => '<Character Ability Icon> signifies a party ability.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 5;
                })->id,
                'question_number' => 2,
                'question' => 'You can Draw from party members.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 5;
                })->id,
                'question_number' => 3,
                'question' => 'You can save the game anywhere.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 5;
                })->id,
                'question_number' => 4,
                'question' => 'When a GF learns an ability, some new abilities may appear.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 5;
                })->id,
                'question_number' => 5,
                'question' => 'A Character Ability must be set; otherwise, it is useless.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 5;
                })->id,
                'question_number' => 6,
                'question' => 'The higher the Speed stat, the better your chances of using a Limit Break.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 5;
                })->id,
                'question_number' => 7,
                'question' => 'An ability is something you learn by gaining EXP.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 5;
                })->id,
                'question_number' => 8,
                'question' => 'Under Zombie, you succumb more easily to Holy attacks.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 5;
                })->id,
                'question_number' => 9,
                'question' => "'Physical Attack' means harm caused by use of weapons like swords and guns.",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 5;
                })->id,
                'question_number' => 10,
                'question' => 'You can steal Steel Pipe from a Wendigo.',
                'answer' => 'yes',
            ],
            // Level 6
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 6;
                })->id,
                'question_number' => 1,
                'question' => "Zell's weapons are gloves.",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 6;
                })->id,
                'question_number' => 2,
                'question' => 'You can still summon GF while Silenced.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 6;
                })->id,
                'question_number' => 3,
                'question' => 'Ifrit can learn the F Mag-RF ability',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 6;
                })->id,
                'question_number' => 4,
                'question' => 'If more than 1 GF with the same junction ability is junctioned to a character, the effect of those abilities remains the same.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 6;
                })->id,
                'question_number' => 5,
                'question' => 'All status changes return to normal after battle.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 6;
                })->id,
                'question_number' => 6,
                'question' => 'You can use the Attack and Draw commands without junctioning a GF.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 6;
                })->id,
                'question_number' => 7,
                'question' => "When you set Squall's gunblade on auto, there is no need to press <R1>",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 6;
                })->id,
                'question_number' => 8,
                'question' => 'The Mag stat determines the strength and effectiveness of magic.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 6;
                })->id,
                'question_number' => 9,
                'question' => 'When using Auto to junction, you can only choose Atk or Def.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 6;
                })->id,
                'question_number' => 10,
                'question' => 'A Grat uses Sleep attacks.',
                'answer' => 'yes',
            ],
            // Level 7
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 7;
                })->id,
                'question_number' => 1,
                'question' => 'Evade indicates how well you can evade physical attacks. Higher Eva stat reduces hits from physical attack.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 7;
                })->id,
                'question_number' => 2,
                'question' => 'Using Fire against enemies that absorb Fire raises their HP.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 7;
                })->id,
                'question_number' => 3,
                'question' => "Squall's finishing blow is different depending on the type of gunblade he uses.",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 7;
                })->id,
                'question_number' => 4,
                'question' => 'By using F Mag-RF, you can refine 5 Fires from 1 M-Stone Piece.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 7;
                })->id,
                'question_number' => 5,
                'question' => 'Only 1 rare card exists in the whole world.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 7;
                })->id,
                'question_number' => 6,
                'question' => 'A Buel sometimes uses Fire.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 7;
                })->id,
                'question_number' => 7,
                'question' => 'Spirit only relates to using Confuse. Higher Spr stat increases the likelihood of success when using Confuse.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 7;
                })->id,
                'question_number' => 8,
                'question' => 'A Geezard drops many Screws.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 7;
                })->id,
                'question_number' => 9,
                'question' => 'Enemies level up as you do.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 7;
                })->id,
                'question_number' => 10,
                'question' => 'You encounter fewer enemies on the World Map if you walk instead of run.',
                'answer' => 'no',
            ],
            // Level 8
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 8;
                })->id,
                'question_number' => 1,
                'question' => "Galbadian Soldiers don't use magic.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 8;
                })->id,
                'question_number' => 2,
                'question' => 'Weapons can be remodeled into more powerful models at the Junk Shop.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 8;
                })->id,
                'question_number' => 3,
                'question' => '<Party Ability Icon> signifies Character Ability.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 8;
                })->id,
                'question_number' => 4,
                'question' => "Casting Slow over Haste will cancel Haste and return the target's status back to 
                normal.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 8;
                })->id,
                'question_number' => 5,
                'question' => 'You encounter more enemies in the forest than the plains on the World Map.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 8;
                })->id,
                'question_number' => 6,
                'question' => "When Elem-Def goes over 100%, that element's damage will be absorbed.",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 8;
                })->id,
                'question_number' => 7,
                'question' => 'The Garden exists only in Balamb.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 8;
                })->id,
                'question_number' => 8,
                'question' => 'There are no Bombs in the Fire Cavern.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 8;
                })->id,
                'question_number' => 9,
                'question' => 'Each GF can learn different abilities.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 8;
                })->id,
                'question_number' => 10,
                'question' => 'Junk Shops sell weapons.',
                'answer' => 'no',
            ],
            // Level 9
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 9;
                })->id,
                'question_number' => 1,
                'question' => 'You can cast the GF you drew instead of Stock.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 9;
                })->id,
                'question_number' => 2,
                'question' => '<Menu Ability Icon> signifies Menu Ability.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 9;
                })->id,
                'question_number' => 3,
                'question' => "Magic listed in Selphie's Limit Break is magic she owns.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 9;
                })->id,
                'question_number' => 4,
                'question' => 'If a GF is hardly used, or has low compatibility with party members, it may leave your party.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 9;
                })->id,
                'question_number' => 5,
                'question' => 'Party Abilities can be used without setting them as abilities.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 9;
                })->id,
                'question_number' => 6,
                'question' => "GF left KO'd too long perish and cannot be revived.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 9;
                })->id,
                'question_number' => 7,
                'question' => '1 Sharp Spike refines into 5 AP Ammo.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 9;
                })->id,
                'question_number' => 8,
                'question' => ' Defeating the enemy who caused a status change returns status to normal.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 9;
                })->id,
                'question_number' => 9,
                'question' => 'Enemies change attack patterns as you level up.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 9;
                })->id,
                'question_number' => 10,
                'question' => 'When Poisoned, every action you take damages you.',
                'answer' => 'yes',
            ],
            // Level 10
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 10;
                })->id,
                'question_number' => 1,
                'question' => 'Use the magic Confuse to inflict confuse status on your enemy.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 10;
                })->id,
                'question_number' => 2,
                'question' => ' A Potion restores 100 HP.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 10;
                })->id,
                'question_number' => 3,
                'question' => "Quistis' weapon is a magic sword.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 10;
                })->id,
                'question_number' => 4,
                'question' => 'ATB stands for Ability Tone Black.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 10;
                })->id,
                'question_number' => 5,
                'question' => 'You are more susceptible to fire under Zombie.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 10;
                })->id,
                'question_number' => 6,
                'question' => 'You can refine 1 Tent from 1 Healing Water by using the Menu Ability Tool-RF.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 10;
                })->id,
                'question_number' => 7,
                'question' => 'EXP are divided equally among all characters participating in battle.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 10;
                })->id,
                'question_number' => 8,
                'question' => "Blind sucks out an enemy's brain to prevent him from attacking.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 10;
                })->id,
                'question_number' => 9,
                'question' => 'Esuna or Soft removes petrify.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 10;
                })->id,
                'question_number' => 10,
                'question' => 'Nothing removes Sleep.',
                'answer' => 'no',
            ],
            // Level 11
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 11;
                })->id,
                'question_number' => 1,
                'question' => 'GF can regain HP while walking.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 11;
                })->id,
                'question_number' => 2,
                'question' => 'The Draw command must be set in order to use a Draw Point.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 11;
                })->id,
                'question_number' => 3,
                'question' => 'Limit Breaks always kill enemies.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 11;
                })->id,
                'question_number' => 4,
                'question' => 'Siren can learn the ability Treatment.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 11;
                })->id,
                'question_number' => 5,
                'question' => 'You can junction more than one GF.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 11;
                })->id,
                'question_number' => 6,
                'question' => 'Adamantine is an item dropped by a level 10 Adamantoise.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 11;
                })->id,
                'question_number' => 7,
                'question' => 'You can rearrange the magic and items displayed during battle.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 11;
                })->id,
                'question_number' => 8,
                'question' => 'Shiva can learn Doom right after becoming an ally.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 11;
                })->id,
                'question_number' => 9,
                'question' => "Drain absorbs HP from enemies, but can't be used to absorb from party members.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 11;
                })->id,
                'question_number' => 10,
                'question' => 'Recovery magic damages Undead monsters.',
                'answer' => 'yes',
            ],
            // Level 12
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 12;
                })->id,
                'question_number' => 1,
                'question' => 'Armadodo absorbs Earth attacks.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 12;
                })->id,
                'question_number' => 2,
                'question' => 'You can refine 20 Curas from 1 Healing Water by using L Mag-RF.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 12;
                })->id,
                'question_number' => 3,
                'question' => "You receive EXP after the battle is won even when KO'd.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 12;
                })->id,
                'question_number' => 4,
                'question' => 'You can only draw GF from an enemy or defeat a GF to make them yours.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 12;
                })->id,
                'question_number' => 5,
                'question' => 'The maximum number of magic that can be drawn from an enemy in one turn is 9.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 12;
                })->id,
                'question_number' => 6,
                'question' => "You can't steal Sharp Spike from a Grand Mantis.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 12;
                })->id,
                'question_number' => 7,
                'question' => 'Press <Select> to hide battle commands temporarily in battle.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 12;
                })->id,
                'question_number' => 8,
                'question' => 'Magic and GF commands are the only commands disabled by Silence.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 12;
                })->id,
                'question_number' => 9,
                'question' => 'You can use Scan on party members.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 12;
                })->id,
                'question_number' => 10,
                'question' => "If you set Poison magic(100%) to ST-Def-J, you don't receive damage from poisonous physical attacks.",
                'answer' => 'no',
            ],
            // Level 13
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 13;
                })->id,
                'question_number' => 1,
                'question' => 'You gain EXP for the damage you inflict on enemies, even if you run away.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 13;
                })->id,
                'question_number' => 2,
                'question' => 'You can mug Blue Spikes from a Chimera.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 13;
                })->id,
                'question_number' => 3,
                'question' => 'GF abilities must be set to a party member for use, or it is ineffective.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 13;
                })->id,
                'question_number' => 4,
                'question' => 'You can only Draw once from any Draw Point.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 13;
                })->id,
                'question_number' => 5,
                'question' => 'GF Quezacotl can learn the Card Mod ability without using an item.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 13;
                })->id,
                'question_number' => 6,
                'question' => "When you fail to Draw a number of times, you can't use the Draw ability for a while.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 13;
                })->id,
                'question_number' => 7,
                'question' => "When a GF is KO'd, its compatibilty goes down with the junctioned party member.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 13;
                })->id,
                'question_number' => 8,
                'question' => 'You can run from any enemy if you take enough time.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 13;
                })->id,
                'question_number' => 9,
                'question' => "You must have ammo to pull Squall's gunblade trigger.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 13;
                })->id,
                'question_number' => 10,
                'question' => 'When you attack a Fire monster, you always receive Fire damage.',
                'answer' => 'no',
            ],
            // Level 14
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 14;
                })->id,
                'question_number' => 1,
                'question' => 'You can draw some GF from enemies.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 14;
                })->id,
                'question_number' => 2,
                'question' => 'In critical situations, Squall can use Renzokuken more often.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 14;
                })->id,
                'question_number' => 3,
                'question' => "Higher the Hit stat, higher the accuracy of physical attacks, but if the enemy's Evade is high, you may still miss.",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 14;
                })->id,
                'question_number' => 4,
                'question' => 'Some items affect the compatibility value between GF and party members.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 14;
                })->id,
                'question_number' => 5,
                'question' => 'Under Shell, magic damage is reduced to 1/4 of its usual amount.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 14;
                })->id,
                'question_number' => 6,
                'question' => 'There is a monster called Belhelmel.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 14;
                })->id,
                'question_number' => 7,
                'question' => "You can only use the Attack command in battle if no GF are junctioned, or command abilities aren't set.",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 14;
                })->id,
                'question_number' => 8,
                'question' => 'Defeating enemies by physical attacks rather than magical attacks gives you more EXP.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 14;
                })->id,
                'question_number' => 9,
                'question' => 'Cover only protects a party member standing next to you.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 14;
                })->id,
                'question_number' => 10,
                'question' => 'Pressing <Square> continuously is the best way to use Boost.',
                'answer' => 'no',
            ],
            // Level 15
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 15;
                })->id,
                'question_number' => 1,
                'question' => 'Compatibility with GF increases as you summon them.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 15;
                })->id,
                'question_number' => 2,
                'question' => "It's not possible for one member to hold all types of magic.",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 15;
                })->id,
                'question_number' => 3,
                'question' => "Fastitocalon's Sand Storm is a Wind attack.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 15;
                })->id,
                'question_number' => 4,
                'question' => 'You can use Reflect to reflect magic that has already been reflected.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 15;
                })->id,
                'question_number' => 5,
                'question' => "Confuse doesn't make you attack yourself.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 15;
                })->id,
                'question_number' => 6,
                'question' => 'You can refine Arctic Wind into Blizzard by using an ability.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 15;
                })->id,
                'question_number' => 7,
                'question' => 'GF Cerberus can learn the Spd Bonus ability.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 15;
                })->id,
                'question_number' => 8,
                'question' => "Party members under Silence can't use magic, even in the menu.",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 15;
                })->id,
                'question_number' => 9,
                'question' => 'Echo Screen cures Petrify.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 15;
                })->id,
                'question_number' => 10,
                'question' => 'When afflicted with Silence while summoning GF, the summoning stops.',
                'answer' => 'yes',
            ],
            // Level 16
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 16;
                })->id,
                'question_number' => 1,
                'question' => 'You can use Limit Breaks more often your HP is low.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 16;
                })->id,
                'question_number' => 2,
                'question' => "When you junction with a GF who learned Elem-Def-J and Elem-Defx2, you can junction 3 magic to Elem-Def slots.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 16;
                })->id,
                'question_number' => 3,
                'question' => 'There is a command to remove GF without losing magic on the menu junction screen.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 16;
                })->id,
                'question_number' => 4,
                'question' => "There are enemies whose status doesn't change, even if your ST-Atk-J is set at 100%.",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 16;
                })->id,
                'question_number' => 5,
                'question' => 'Draw means drawing magic stocked by a monster. When it runs out of stock, it can no longer use magic.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 16;
                })->id,
                'question_number' => 6,
                'question' => 'Low level Bite Bugs drop M-Stone Pieces.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 16;
                })->id,
                'question_number' => 7,
                'question' => "G-Mega-Potion Revives a KO'd GF.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 16;
                })->id,
                'question_number' => 8,
                'question' => 'The game is over when all party members are afflicted with Death, Zombie, or Petrify.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 16;
                })->id,
                'question_number' => 9,
                'question' => 'Hi-Potion restores 1,000 HP.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 16;
                })->id,
                'question_number' => 10,
                'question' => 'Walk-Gil is an ability to acquire Gil by walking on the field.',
                'answer' => 'no',
            ],
            // Level 17
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 17;
                })->id,
                'question_number' => 1,
                'question' => 'You can use Limit Breaks more frequently under Aura.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 17;
                })->id,
                'question_number' => 2,
                'question' => "G-Potion, which restores GF's HP, can also be used in battle.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 17;
                })->id,
                'question_number' => 3,
                'question' => 'The Med Data ability enables the use of 2 potions in 1 turn.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 17;
                })->id,
                'question_number' => 4,
                'question' => "Finishing blows come out more often if you time the trigger for Squall's Renzokuken correctly.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 17;
                })->id,
                'question_number' => 5,
                'question' => 'Set the ability Alert to avoid back attacks.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 17;
                })->id,
                'question_number' => 6,
                'question' => 'Limit Breaks activate when Berserked.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 17;
                })->id,
                'question_number' => 7,
                'question' => 'You can use Potions to cure a zombied party members in the menu.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 17;
                })->id,
                'question_number' => 8,
                'question' => "GF Alexander's attacks are Holy attacks.",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 17;
                })->id,
                'question_number' => 9,
                'question' => "T-Rexaur sometimes drops Dinosaur Fangs.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 17;
                })->id,
                'question_number' => 10,
                'question' => 'Under Darkness, you are blinded, and may attack party members.',
                'answer' => 'no',
            ],
            // Level 18
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 18;
                })->id,
                'question_number' => 1,
                'question' => "You can't junction witout GF, no matter how high your level.",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 18;
                })->id,
                'question_number' => 2,
                'question' => 'Reflect can turn away any magic.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 18;
                })->id,
                'question_number' => 3,
                'question' => 'There are a total of 30 different statuses.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 18;
                })->id,
                'question_number' => 4,
                'question' => 'There is no magic that cures Zombie.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 18;
                })->id,
                'question_number' => 5,
                'question' => 'When choosing a target in battle, press <L1> to choose your target from a window.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 18;
                })->id,
                'question_number' => 6,
                'question' => 'There is 1 ability you can learn by yourself.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 18;
                })->id,
                'question_number' => 7,
                'question' => 'After receiving magic damage, Wendigo lands to shoot Pulse Ammo from its mouth.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 18;
                })->id,
                'question_number' => 8,
                'question' => 'HP is restored slowly in Sleep.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 18;
                })->id,
                'question_number' => 9,
                'question' => 'GF Carbuncle casts Shell and Protect on all party members.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 18;
                })->id,
                'question_number' => 10,
                'question' => 'Confuse takes precedence over Berserk when the 2 are cast simultaneously.',
                'answer' => 'no',
            ],
            // Level 19
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 19;
                })->id,
                'question_number' => 1,
                'question' => 'Defense against Death is determined by Death% stat in ST-Def-J.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 19;
                })->id,
                'question_number' => 2,
                'question' => 'Zombied party members take damage if they use Drain on a Zombie enemy.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 19;
                })->id,
                'question_number' => 3,
                'question' => 'Cockatrice bites can sometimes be poisonous.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 19;
                })->id,
                'question_number' => 4,
                'question' => 'Invincible status returns to normal after battle.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 19;
                })->id,
                'question_number' => 5,
                'question' => 'The Chimera has dragon, frog, goat, bird, and wild boar heads.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 19;
                })->id,
                'question_number' => 6,
                'question' => 'Protect is not effective while Vitality is zero.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 19;
                })->id,
                'question_number' => 7,
                'question' => 'You float higher each time you cast Float.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 19;
                })->id,
                'question_number' => 8,
                'question' => 'You must run from X-ATM092, as it is invincible.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 19;
                })->id,
                'question_number' => 9,
                'question' => "Break turns an enemy's Spirit to zero, so it has no effect on enemies with zero Spirit.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 19;
                })->id,
                'question_number' => 10,
                'question' => 'With weapons learned from Weapons Monthly, the Junk Shop tells you which items you need in gray.',
                'answer' => 'yes',
            ],
            // Level 20
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 20;
                })->id,
                'question_number' => 1,
                'question' => "You don't encounter enemies while in a car.",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 20;
                })->id,
                'question_number' => 2,
                'question' => '1 Inferno Fang refines into 20 Flares.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 20;
                })->id,
                'question_number' => 3,
                'question' => 'A Gayla is about 12 meters tall.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 20;
                })->id,
                'question_number' => 4,
                'question' => 'There are some non-elemental monsters that have no elemental attributes.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 20;
                })->id,
                'question_number' => 5,
                'question' => 'When your SeeD level goes up, your Magic power and Draw success rates go up.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 20;
                })->id,
                'question_number' => 6,
                'question' => "The damage you inflict on enemies doesn't change even if your HP is running low.",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 20;
                })->id,
                'question_number' => 7,
                'question' => 'High compatibility with GF assures a shorter summoning time.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 20;
                })->id,
                'question_number' => 8,
                'question' => 'A Caterchipillar sometimes drops Spider Webs.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 20;
                })->id,
                'question_number' => 9,
                'question' => 'Setting Str+20% and Str+40% is more effective than setting Str+60% alone.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 20;
                })->id,
                'question_number' => 10,
                'question' => "GF Siren's attack is physical damage plus Confusion.",
                'answer' => 'no',
            ],
            // Level 21
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 21;
                })->id,
                'question_number' => 1,
                'question' => 'Bombs sometimes self-detonate.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 21;
                })->id,
                'question_number' => 2,
                'question' => 'Malboros lurk in North Esthar.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 21;
                })->id,
                'question_number' => 3,
                'question' => 'Combat King is a magazine that introduces combat skills.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 21;
                })->id,
                'question_number' => 4,
                'question' => 'You can draw a GF from Elvoret on the communication tower.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 21;
                })->id,
                'question_number' => 5,
                'question' => 'Even if afflicted with Stop while summoning a GF, summoning continues, because the GF is not affected by Stop.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 21;
                })->id,
                'question_number' => 6,
                'question' => 'Defend protects you from all physical attacks, but magic attacks can still inflict damage.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 21;
                })->id,
                'question_number' => 7,
                'question' => 'Junction Life to raise defense against all elemental attributes.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 21;
                })->id,
                'question_number' => 8,
                'question' => 'There is a libary in Balamb Garden.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 21;
                })->id,
                'question_number' => 9,
                'question' => 'Mega Phoenix is an item that casts Phoenix Down on all party members.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 21;
                })->id,
                'question_number' => 10,
                'question' => 'You can refine 1 Bomb Spirit from 1 Bomb Card.',
                'answer' => 'no',
            ],
            // Level 22
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 22;
                })->id,
                'question_number' => 1,
                'question' => 'Casting Protect over Shell cancels Shell, leaving the party member only with Protect.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 22;
                })->id,
                'question_number' => 2,
                'question' => 'You may drop Gil and Items if your Luck stat is low.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 22;
                })->id,
                'question_number' => 3,
                'question' => 'To defend against Fire attacks, Junction Ice magic to Elem-Def-J.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 22;
                })->id,
                'question_number' => 4,
                'question' => 'Junctioning Reflect to ST-Def raises your defense stat in 9 slots.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 22;
                })->id,
                'question_number' => 5,
                'question' => 'Zombie and Pain are Sorcery elemental magic.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 22;
                })->id,
                'question_number' => 6,
                'question' => 'There is an Item called Hi-Potion+ that restores 3,000 HP.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 22;
                })->id,
                'question_number' => 7,
                'question' => 'When your SeeD level goes up, shops give you a discount.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 22;
                })->id,
                'question_number' => 8,
                'question' => "If you use the same elemental magic used in a GF's attack, your compatibility goes up.",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 22;
                })->id,
                'question_number' => 9,
                'question' => 'When new info is acquired, more explanations may be added to the Help menu.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 22;
                })->id,
                'question_number' => 10,
                'question' => 'A higher Hit stat affects the success rate of Draw.',
                'answer' => 'no',
            ],
            // Level 23
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 23;
                })->id,
                'question_number' => 1,
                'question' => 'You can make Remedy+ from Remedy.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 23;
                })->id,
                'question_number' => 2,
                'question' => "Hold down <R1><R2> simultaneously to escape from battle. (But sometimes you can't run.)",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 23;
                })->id,
                'question_number' => 3,
                'question' => 'The command ability Recover can revive party members from KO.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 23;
                })->id,
                'question_number' => 4,
                'question' => 'Esuna removes status changes, and Dispel removes elemental changes.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 23;
                })->id,
                'question_number' => 5,
                'question' => 'Under Regen, HP is restored regulary, even if you are afflicted with Stop.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 23;
                })->id,
                'question_number' => 6,
                'question' => "You can't use any Limit Breaks when Cursed.",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 23;
                })->id,
                'question_number' => 7,
                'question' => 'Berserk raises attack power, but the only command activated is Attack.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 23;
                })->id,
                'question_number' => 8,
                'question' => 'There is an ability to make Remedy from Malboro Tentacles.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 23;
                })->id,
                'question_number' => 9,
                'question' => 'Float expires after a certain time.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 23;
                })->id,
                'question_number' => 10,
                'question' => 'Protect reduces physical damage by 1/2.',
                'answer' => 'yes',
            ],
            // Level 24
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 24;
                })->id,
                'question_number' => 1,
                'question' => 'Use Esuna to cure Slow.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 24;
                })->id,
                'question_number' => 2,
                'question' => 'Setting Float to Elem-Def-J raises defense against Earth elemental attacks.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 24;
                })->id,
                'question_number' => 3,
                'question' => 'The ATB runs even while a GF is appearing.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 24;
                })->id,
                'question_number' => 4,
                'question' => "Auto Reflect casts Reflect on you as long as you don't fall under KO.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 24;
                })->id,
                'question_number' => 5,
                'question' => '<GF Ability Icon> signifies GF ability.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 24;
                })->id,
                'question_number' => 6,
                'question' => 'There are a limited number of abilities a GF can learn.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 24;
                })->id,
                'question_number' => 7,
                'question' => 'Protect keeps reducing damage with each use.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 24;
                })->id,
                'question_number' => 8,
                'question' => 'You get Poison along with HP when using Drain against a poisoned target.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 24;
                })->id,
                'question_number' => 9,
                'question' => 'A weapon can break after multiple battles. (It can be fixed.)',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 24;
                })->id,
                'question_number' => 10,
                'question' => 'If you are Silenced while you are afflicted with Confuse, you cannot use magic.',
                'answer' => 'yes',
            ],
            // Level 25
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 25;
                })->id,
                'question_number' => 1,
                'question' => 'You can mug a Laser Cannon from an enemy called Elastoid.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 25;
                })->id,
                'question_number' => 2,
                'question' => "GF Leviathan's skill Tsunami causes a forest fire.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 25;
                })->id,
                'question_number' => 3,
                'question' => 'Use Amnesia Greens to make a GF forget to an ability.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 25;
                })->id,
                'question_number' => 4,
                'question' => "There is an ability to see Save Points and Draw Points you can't usually see.",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 25;
                })->id,
                'question_number' => 5,
                'question' => 'GF gains more EXP if only 1 GF is junctioned to a party member.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 25;
                })->id,
                'question_number' => 6,
                'question' => 'It is good to return to Balamb Garden once in a while to collect your SeeD salary.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 25;
                })->id,
                'question_number' => 7,
                'question' => 'The magic Watera and Waterga are more powerful than magic Water.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 25;
                })->id,
                'question_number' => 8,
                'question' => "Counter doesn't react to attacks which affect all party members.",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 25;
                })->id,
                'question_number' => 9,
                'question' => "GF can learn an ability to succeed in every Mug by using an Item called Bandit's Hand.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 25;
                })->id,
                'question_number' => 10,
                'question' => 'You can Draw magic that causes Curse.',
                'answer' => 'no',
            ],
            // Level 26
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 26;
                })->id,
                'question_number' => 1,
                'question' => 'Using Drain on the undead damages you.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 26;
                })->id,
                'question_number' => 2,
                'question' => 'The Character ability Initiative enables you to begin battle with a full ATB gauge, even while you are back-attacked.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 26;
                })->id,
                'question_number' => 3,
                'question' => 'The Command Ability, Darkside, inflicts Darkness on a target when you make a physical attack.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 26;
                })->id,
                'question_number' => 4,
                'question' => 'Holy is the only Holy elemental magic.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 26;
                })->id,
                'question_number' => 5,
                'question' => 'Even GFs that are not junctioned gain EXP and AP.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 26;
                })->id,
                'question_number' => 6,
                'question' => 'Shell reduces the effectiveness of recovery magic by half.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 26;
                })->id,
                'question_number' => 7,
                'question' => 'With a high Evade stat, you sometimes evade attacks even when under Sleep.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 26;
                })->id,
                'question_number' => 8,
                'question' => 'You can make GF forget an ability.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 26;
                })->id,
                'question_number' => 9,
                'question' => 'Doom continues counting down in the field even after you run from battle.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 26;
                })->id,
                'question_number' => 10,
                'question' => 'Attack magic is more effective if your Strength, rather than Magic stat is high.',
                'answer' => 'no',
            ],
            // Level 27
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 27;
                })->id,
                'question_number' => 1,
                'question' => "Haste reduces Draw's success rate.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 27;
                })->id,
                'question_number' => 2,
                'question' => 'Your SeeD salary relates to how many enemies you have defeated.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 27;
                })->id,
                'question_number' => 3,
                'question' => 'The Double GF ability summons multiple GF simultaneously.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 27;
                })->id,
                'question_number' => 4,
                'question' => 'Choose Rearrange in the menu to rearrange items automatically.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 27;
                })->id,
                'question_number' => 5,
                'question' => 'Every monster has a weakness.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 27;
                })->id,
                'question_number' => 6,
                'question' => "Bio weakens the target's cell structure to make the body more vulnerable.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 27;
                })->id,
                'question_number' => 7,
                'question' => "It's harder to run when back-attacked.",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 27;
                })->id,
                'question_number' => 8,
                'question' => 'Flare is a Fire elemental magic.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 27;
                })->id,
                'question_number' => 9,
                'question' => 'You can find out how many monsters you have defeated.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 27;
                })->id,
                'question_number' => 10,
                'question' => 'Party members not participating in battle also receive a small amount of EXP.',
                'answer' => 'no',
            ],
            // Level 28
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 28;
                })->id,
                'question_number' => 1,
                'question' => 'A higher Speed stat fills the ATB gauge faster.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 28;
                })->id,
                'question_number' => 2,
                'question' => 'You can remove Doom with Esuna.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 28;
                })->id,
                'question_number' => 3,
                'question' => 'Magic attack means attacking with any type of magic, except for Holy magic.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 28;
                })->id,
                'question_number' => 4,
                'question' => 'No magic removes doom.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 28;
                })->id,
                'question_number' => 5,
                'question' => 'Pain inflicts Poison, Silence, and Darkness on enemies, but sometimes not all 3 status changes will occur.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 28;
                })->id,
                'question_number' => 6,
                'question' => 'Staying at a hotel removes status changes and restores all HP.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 28;
                })->id,
                'question_number' => 7,
                'question' => "You can stop Squall's Renzokuken by pressing <X>",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 28;
                })->id,
                'question_number' => 8,
                'question' => 'Double or Triple lets you use the same magic multiple times.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 28;
                })->id,
                'question_number' => 9,
                'question' => 'Petrify wears off after time passes.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 28;
                })->id,
                'question_number' => 10,
                'question' => "Using Soft while Petrifying won't stop the countdown.",
                'answer' => 'no',
            ],
            // Level 29
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 29;
                })->id,
                'question_number' => 1,
                'question' => 'Phoenix Heart restores your party members from KO.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 29;
                })->id,
                'question_number' => 2,
                'question' => "A GF in KO is revived in the next battle, even if you don't revive it.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 29;
                })->id,
                'question_number' => 3,
                'question' => 'Casting Double while under Double turns the status into Triple.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 29;
                })->id,
                'question_number' => 4,
                'question' => 'Mag Up raises the Mag stat by 1.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 29;
                })->id,
                'question_number' => 5,
                'question' => 'The ability Rare Item changes the probability of enemies dropping items.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 29;
                })->id,
                'question_number' => 6,
                'question' => 'The Galbadian soldier Biggs, who was on the communication tower, is a colonel.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 29;
                })->id,
                'question_number' => 7,
                'question' => 'You need at least 3 magic in stock to use Triple.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 29;
                })->id,
                'question_number' => 8,
                'question' => 'If 2 party members are under Zombie and you become inflicted by confuse, game is over.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 29;
                })->id,
                'question_number' => 9,
                'question' => 'Meteor chooses targets randomly from the enemy group.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 29;
                })->id,
                'question_number' => 10,
                'question' => 'Meltdown is a magic attack that melts enemies.',
                'answer' => 'no',
            ],
            // Level 30
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 30;
                })->id,
                'question_number' => 1,
                'question' => 'It is good to use Float when fighting Thrustaevis, who uses Earthquakes.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 30;
                })->id,
                'question_number' => 2,
                'question' => "There is no point using Life or Full-life on party members who haven't been KO'd.",
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 30;
                })->id,
                'question_number' => 3,
                'question' => 'If you receive 800 HP damage while summoning a GF with 500 HP, the difference of 300 HP are received by the summoner.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 30;
                })->id,
                'question_number' => 4,
                'question' => "Torama sometimes drops an item called Torama's Beard.",
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 30;
                })->id,
                'question_number' => 5,
                'question' => 'Casting Aura under Curse will bring your status back to normal.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 30;
                })->id,
                'question_number' => 6,
                'question' => 'There is a monster called GraBia on the Galbadia continent.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 30;
                })->id,
                'question_number' => 7,
                'question' => 'Silence is not removed, even after battle.',
                'answer' => 'yes',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 30;
                })->id,
                'question_number' => 8,
                'question' => 'Reflect always returns magic to the one who cast it.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 30;
                })->id,
                'question_number' => 9,
                'question' => 'Status can change while under Petrify.',
                'answer' => 'no',
            ],
            [
                'seed_test_id' => $seedTests->first(function ($value, $key) {
                    return $value->level === 30;
                })->id,
                'question_number' => 10,
                'question' => 'The only way for GF to learn abilities is to gain AP (Ability Points).',
                'answer' => 'no',
            ],
        ];

        foreach ($testQuestions as $key => $question) {
            $testQuestions[$key]['id'] = Uuid::generate(4);
            $testQuestions[$key]['created_at'] = Carbon::now();
            $testQuestions[$key]['updated_at'] = Carbon::now();
        }

        $testQuestion = new TestQuestion();

        $testQuestion->insert($testQuestions);
    }
}
