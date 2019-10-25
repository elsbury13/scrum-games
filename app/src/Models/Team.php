<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public $timestamps = false;
    protected $table = 'team';

    /**
     * @return array $data
     */
    public static function getAll()
    {
        $teams = Team::raw('team_name')
                ->where('live', '=', '1')
                ->get();
        $data = [];

        foreach ($teams as $team) {
            $data['teamNames'][$team->id] = $team->team_name;
        }

        return $data;
    }

    public static function add($teamName)
    {
        Team::insert(['team_name' => $teamName]);
    }
}
