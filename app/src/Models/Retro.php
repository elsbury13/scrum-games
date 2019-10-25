<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

class Retro extends Model
{
    protected $table = 'retros';

    /**
     * @param int $id
     * @return array $data
     */
    public static function getRetros()
    {
        $retros = Retro::get();
        $data = [];

        foreach ($retros as $retro) {
            $data[$retro->id] = $retro->retro_name;
        }

        return $data;
    }

    /**
     * @param int $id
     * @return array $data
     */
    public static function getRetro($id)
    {
        return Retro::raw('retro_name, retro_description')
                ->where('id', '=', $id)
                ->first();
    }

    /**
     * @param int $id
     * @return array $data
     */
    public static function getRandom()
    {
        $random = Retro::all()->random(1);
        $data = [];

        foreach ($random as $retro) {
            $data['id'] = $retro->id;
            $data['retroName'] = $retro->retro_name;
        }

        return $data;
    }

    /**
     * @param string $image
     * @param string $name
     * @param string $teamName
     * @param string $team
     * @param int $question
     */
    public static function saveRetro($retroName, $retroDescription)
    {
        Retro::insert(
            [
                'retro_name' => $retroName,
                'retro_description' => $retroDescription
            ]
        );
    }

    /**
     * @param string $image
     * @param string $name
     * @param string $teamName
     * @param string $team
     * @param int $question
     */
    public static function deleteRetro($id)
    {
/*

        Retro::insert(
            [
                'image' => $data,
                'image_name' => $date . $name . '.png',
                'image_added_by' => $name,
                'image_added' => $date,
                'question_id' => $question,
                'team_id' => $team,
            ]
        );
        */
    }
}
