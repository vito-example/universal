<?php
/**
 *  app/Modules/Pages/Services/Client/BlogData.php
 *
 * Date-Time: 05.08.21
 * Time: 15:45
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Pages\Services\Client;

use App\Modules\Landing\Http\Resources\Blog\BlogItemResource;
use App\Modules\Pages\Models\Blog;

class BlogData
{
    /**
     * @var Blog
     */
    protected Blog $blogs;

    /**
     * BlogData constructor.
     */
    public function __construct()
    {
        $this->blogs = new Blog();
    }


    /**
     * @return array
     */
    public function getBlogs(): array
    {
        $blogs = $this->blogs::with(['translations', 'images'])
            ->active()->orderBy('created_at', 'DESC')->take(5)->get();

        $blogsData = [];
        foreach ($blogs->getIterator() as $blog) {
            $blogsData[] = (new BlogItemResource($blog))->toListItem();
        }
        return $blogsData;
    }
}
