<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Game
 *
 * @property int $id
 * @property int $number
 * @property int|null $first_player_id
 * @property int|null $second_player_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Player|null $firstPlayer
 * @property-read \App\Player|null $secondPlayer
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Game nextGames()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Game query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Game whereFirstPlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Game whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Game whereSecondPlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Game whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Game extends Model
{
    protected $fillable = [
        'number',
        'first_player_id',
        'second_player_id',
    ];

    public function firstPlayer()
    {
        return $this->belongsTo(Player::class, 'first_player_id')
                    ->withDefault([
                        'name' => '??',
                    ]);
    }

    public function secondPlayer()
    {
        return $this->belongsTo(Player::class, 'second_player_id')
                    ->withDefault([
                        'name' => '??',
                    ]);
    }

    /**
     * @param \Eloquent $query
     * @return mixed
     */
    public function scopeNextGames($query)
    {
        return $query->where('number', '>', Setting::currentGame()->value)
                     ->orderBy('number')
                     ->limit(10);
    }
}
