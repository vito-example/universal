<?php
/**
 *  app/Modules/Pages/Services/Client/LecturerData.php
 *
 * Date-Time: 05.08.21
 * Time: 16:19
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Pages\Services\Client;

use App\Modules\Customer\Models\Lecturer;
use App\Modules\Landing\Http\Resources\Blog\BlogItemResource;
use App\Modules\Landing\Http\Resources\Lecturer\LecturerItemResource;
use App\Modules\Pages\Models\Blog;

class LecturerData
{
    /**
     * @var Lecturer
     */
    protected Lecturer $lecturers;

    /**
     * LecturerData constructor.
     */
    public function __construct()
    {
        $this->lecturers = new Lecturer();
    }


    /**
     * @return array
     */
    public function getRandomLecturers(): array
    {
        $lecturers = $this->lecturers::with(['translations', 'images'])
            ->active()->inRandomOrder()->limit(8)->get();

        $lecturerData = [];

        foreach ($lecturers->getIterator() as $lecturer) {
            $lecturerData[] = (new LecturerItemResource($lecturer))->toListItem();
        }

        return $lecturerData;
    }
}
