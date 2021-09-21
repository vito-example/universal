<?php
/**
 *  app\Modules\Pages\Services\Client\ServiceData.php
 *
 * Date-Time: 9/21/2021
 * Time: 5:45 AM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Pages\Services\Client;

use App\Modules\Landing\Http\Resources\Project\ProjectItemResource;
use App\Modules\Landing\Http\Resources\Service\ServiceItemResource;
use App\Modules\Pages\Models\Service;

class ServiceData
{
    /**
     * @var Service
     */
    protected Service $services;

    /**
     * ServiceData constructor.
     */
    public function __construct()
    {
        $this->services = new Service();
    }


    /**
     * @param int $number
     * @return array
     */
    public function getServices($number = 4): array
    {
        $services = $this->services::with(['translations', 'images'])
            ->active()->inRandomOrder()->take($number)->get();

        $servicesData = [];
        foreach ($services->getIterator() as $service) {
            $servicesData[] = (new ServiceItemResource($service))->toListItem();
        }
        return $servicesData;
    }

    /**
     * @param int $number
     * @return array
     */
    public function getServicesStatic($number = 5): array
    {
        $services = $this->services::with(['translations', 'images'])
            ->active()->inRandomOrder()->take($number)->get();

        $servicesData = [];
        foreach ($services->getIterator() as $service) {
            $servicesData[] = (new ServiceItemResource($service))->toStatic();
        }
        return $servicesData;
    }
}
