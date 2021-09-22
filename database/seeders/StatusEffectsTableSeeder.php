<?php

namespace Database\Seeders;

use App\Models\StatusEffect;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class StatusEffectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statusEffects = $this->getStatusEffects();

        foreach ($statusEffects as $key => $value) {
            $statusEffects[$key]['id'] = Uuid::generate(4);
            $statusEffects[$key]['created_at'] = Carbon::now();
            $statusEffects[$key]['updated_at'] = Carbon::now();
        }

        $statusEffect = new StatusEffect();

        $statusEffect->insert($statusEffects);
    }

    /**
     * The Status Effects to be inserted into the database.
     *
     * @return array
     */
    protected function getStatusEffects(): array
    {
        return [
            [
                'name' => 'death',
                'type' => 'harmful',
                'description' => "The Death status reduces the target's HP to 0. Monsters afflicted with death are removed from combat. This effect does not wear off on its own.",
            ],
            [
                'name' => 'poison',
                'type' => 'harmful',
                'description' => "The Poison status deals damage to the target after each action they take. The damage is around 1/20th of the target's maximum HP each tick. This effect does not wear off on its own.",
            ],
            [
                'name' => 'petrify',
                'type' => 'harmful',
                'description' => 'The Petrify status will render the target unable to perform any actions. Enemies will be considered as removed from combat. If all targets are petrified (either enemies or players), the battle will end. This effect does not wear off on its own.',
            ],
            [
                'name' => 'darkness',
                'type' => 'harmful',
                'description' => 'The Darkness status will reduce the targets hit by 75%. Characters that have 255% hit will be unaffected by this status. This effect does not wear off on its own.',
            ],
            [
                'name' => 'silence',
                'type' => 'harmful',
                'description' => 'The Silence status will render targets unable to use the magic, GF, and draw commands. This effect does not wear off on its own.',
            ],
            [
                'name' => 'berserk',
                'type' => 'harmful',
                'description' => 'The Berserk status will force the target to perform basic attacks on a random target during each turn. Attacks are boosted by 50% of their normal value. This effect does not wear off on its own.',
            ],
            [
                'name' => 'zombie',
                'type' => 'harmful',
                'description' => 'The Zombie status causes the target to act as if undead. This effect does not wear off on its own.',
            ],
            [
                'name' => 'sleep',
                'type' => 'harmful',
                'description' => 'The Sleep status will render targets unable to perform an actions. Receiving physical damage will remove the effect. This effect will wear off automatically over time.',
            ],
            [
                'name' => 'haste',
                'type' => 'beneficial',
                'description' => 'The Haste status increases the rate at which the ATB bar fills, but also decreases how long beneficial Status Effects last. This effect will wear off automatically over time.',
            ],
            [
                'name' => 'slow',
                'type' => 'harmful',
                'description' => 'The Slow status decreases the rate at which the ATB bar fills, but also increases how long beneficial Status Effects last. This effect will wear off automatically over time.',
            ],
            [
                'name' => 'stop',
                'type' => 'harmful',
                'description' => 'The Stop status will render targets unable to execute any commands. This effect wears off automatically over time.',
            ],
            [
                'name' => 'regen',
                'type' => 'beneficial',
                'description' => 'The Regen status heals the target for a total of 80% of their maximum HP. This is done in 5% increments over the course of 16 ticks. This effect will wear off automatically over time.',
            ],
            [
                'name' => 'protect',
                'type' => 'beneficial',
                'description' => 'The Protect status halves physical damage dealt to the target. This effect wears off automatically over time.',
            ],
            [
                'name' => 'shell',
                'type' => 'beneficial',
                'description' => 'The Shell status halves magical damage dealt to the target. This reduction also affects curing spells. This effect wears off automatically over time.',
            ],
            [
                'name' => 'reflect',
                'type' => 'beneficial',
                'description' => 'The Reflect status redirects most single-target magic toward a random target on the opposing team. Spells can only be reflected once. Not all magic can be reflected. This effect wears off automatically over time.',
            ],
            [
                'name' => 'aura',
                'type' => 'beneficial',
                'description' => 'The Aura status significantly increases the chances of a character being able to use a limit break. This status also enhances the power of limit breaks. This effect wears off automatically over time.',
            ],
            [
                'name' => 'curse',
                'type' => 'harmful',
                'description' => 'The Curse status restricts a character from using limit breaks. This effect wears off automatically over time.',
            ],
            [
                'name' => 'doom',
                'type' => 'harmful',
                'description' => "The Doom status places a countdown timer on the target. When this timer expires, the target will be KO'd. If the battle ends before the countdown has finished, the status will be removed.",
            ],
            [
                'name' => 'invincible',
                'type' => 'beneficial',
                'description' => 'The Invincible status prevents targets from taking any form of damage. This status also prevents both beneficial, and harmful statuses from being applied to the target. Becoming Invincible removes any current negative status effects. Targets that are under the effect of Invincible can be healed by spells and items. This effect wears off automatically over time.',
            ],
            [
                'name' => 'petrifying',
                'type' => 'harmful',
                'description' => 'The Petrifying status places a countdown timer on the target. When this timer expired, the target will be afflicted with the Petrify status. If battle ends before the countdown has finished, the status will be removed.',
            ],
            [
                'name' => 'float',
                'type' => 'beneficial',
                'description' => 'The Floating status makes targets immune to earth based damage. This effect wears off automatically over time.',
            ],
            [
                'name' => 'confuse',
                'type' => 'harmful',
                'description' => 'The Confuse status makes targets use attacks, magic, or items on any ally (including themselves) or enemy at random. This status will wear off at the end of battle, or if physical damage is taken. This effect wears off automatically over time.',
            ],
            [
                'name' => 'double',
                'type' => 'beneficial',
                'description' => 'The Double status allows a target to cast magic twice in one turn. Casting two spells in one turn will consume two stocks of the spell that is cast. If the Expendx2-1 ability is in use, it will only consume one stocked spell. This effect will last until the end of battle.',
            ],
            [
                'name' => 'triple',
                'type' => 'beneficial',
                'description' => 'The Triple status allows a target to cast magic three times in one turn. Casting three spells in one turn will consume three stocks of the spell that is cast. If the Expendx3-1 ability is in use, it will only consume one stocked spell. This effect will last until the end of battle.',
            ],
            [
                'name' => 'defend',
                'type' => 'beneficial',
                'description' => 'The Defend status will prevent all physical damage and will halve magic damage received until another command is chosen. Physical attacks that can inflict status ailments will never have an effect on a target that under the Defend status.',
            ],
            [
                'name' => 'vit 0',
                'type' => 'harmful',
                'description' => 'The Vit 0 status reduces both vitality and spirit to 0, making the target more vulnerable to both physical and magic attacks. This effect lasts until battle ends.',
            ],
            [
                'name' => 'angel wing',
                'type' => 'beneficial',
                'description' => "The Angel Wing status is granted by Rinoa's Angel Wing limit break. This status will cause Rinoa to cast random spells on random targets, without consuming stocked spells. Spells deal 5 times the normal damage, and the effect lasts until the end of combat.",
            ],
            [
                'name' => 'drain',
                'type' => 'harmful',
                'description' => "The Drain status is used exclusively for calculating the amount of hit points gained from using a Drain effect. If the target has Drain resistance, they will take normal damage, however the user will regain hit points proportional to the target's Drain resistance.",
            ],
        ];
    }
}
