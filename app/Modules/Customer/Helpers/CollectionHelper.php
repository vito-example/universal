<?php
/**
 *  app/Modules/Customer/Helpers/CollectionHelper.php
 *
 * Date-Time: 07.07.21
 * Time: 11:47
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Modules\Customer\Helpers;


use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

/**
 * Class CollectionHelper
 * @package App\Modules\Customer\Helpers
 */
class CollectionHelper
{
    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function paginate(Collection $results, $pageSize): LengthAwarePaginator
    {
        $page = Paginator::resolveCurrentPage('page');

        $total = $results->count();

        return self::paginator($results->forPage($page, $pageSize), $total, $pageSize, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);

    }

    /**
     * Create a new length-aware paginator instance.
     *
     * @param \Illuminate\Support\Collection $items
     * @param int $total
     * @param int $perPage
     * @param int $currentPage
     * @param array $options
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected static function paginator(Collection $items, int $total, int $perPage, int $currentPage, array $options): LengthAwarePaginator
    {
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items', 'total', 'perPage', 'currentPage', 'options'
        ));
    }
}