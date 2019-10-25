<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    /**
     * @param int $id
     * @return array $data
     */
    public static function getAllDates($id)
    {
        $dates = Image::raw('DATE_FORMAT(distinct(image_added), "%d-%M-%y") as image_added')
                ->where('team_id', '=', $id)
                ->get();

        $data = [];

        foreach ($dates as $date) {
            $data['date'][$date->image_added] = $date->image_added;
        }

        return $data;
    }

    /**
     * @param string $image
     * @param string $name
     * @param string $teamName
     * @param int $question
     * @param string $date
     * @return array $data
     */
    private static function moveImage($image, $name, $teamName, $question, $date)
    {
        $imageName = $date . $name . '.png';
        $imageLocation = 'uploads/' . $teamName . '/' . $date . '/question' . $question . '/';

        $data = self::sortImage($image);

        if (file_exists($imageLocation)) {
            file_put_contents($imageLocation . $imageName, $data);
        } else {
            mkdir($imageLocation, 0777, true);
            file_put_contents($imageLocation . $imageName, $data);
        }

        return $data;
    }

    /**
     * @param string $image
     * @return string base 64 encoded image
     */
    private static function sortImage($image)
    {
        $image = str_replace('data:image/png;base64,', '', $image);

        $image = str_replace(' ', '+', $image);

        return base64_decode($image);
    }

    /**
     * @param string $image
     * @param string $name
     * @param string $teamName
     * @param string $team
     * @param int $question
     */
    public static function saveDoodle($image, $name, $teamName, $team, $question)
    {
        $date = date('Y-m-d');

        $data = self::moveImage($image, $name, $teamName, $question, $date);

        Image::insert(
            [
                'image' => $data,
                'image_name' => $date . $name . '.png',
                'image_added_by' => $name,
                'image_added' => $date,
                'question_id' => $question,
                'team_id' => $team,
            ]
        );
    }
}
