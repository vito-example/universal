<?php


namespace App\Modules\Review\Services;

use App\Modules\Review\Models\Review;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ReviewService
{
    /**
     * @var object
     */
    protected object $model;

    /**
     * @var object
     */
    protected object $user;

    /**
     * @var object
     */
    protected object $review;

    /**
     * @var string
     */
    protected string $content;

    /**
     * @var int
     */
    protected int $rate;

    /**
     * @param $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @param $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param $review
     * @return $this
     */
    public function setReview($review)
    {
        $this->review = $review;
        return $this;
    }

    /**
     * @param $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @param $rate
     * @return $this
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
        return $this;
    }

    /**
     * @return $this
     */
    public function createReview()
    {
        $this->model->review()->create([
            'user_id' => $this->user->id,
            'content' => $this->content,
            'value'   => $this->rate,
            'status' => Review::STATUS_PENDING
        ]);
        return $this;
    }

    /**
     * @param $status
     * @return $this
     */
    public function updateStatus($status)
    {
        $this->review->forceFill(['status' => $status])->save();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReviews()
    {
        return [
            'data'       => $this->model->review()->with('user')->where('status', Review::STATUS_ACCEPTED)->get(),
            'can_review' => auth()->check() ? count(auth()->user()->review()->where('model_id', $this->model->id)->get()) === 0 : false
        ];
    }

    /**
     * @return Builder[]|Collection
     */
    public function getAll()
    {
        return Review::with(['model', 'user'])->get();
    }

    /**
     * @return Builder[]|Collection
     */
    public function getLastReviews()
    {
        return Review::with(['model', 'user'])->where('status', Review::STATUS_ACCEPTED)->take(5)->get();
    }
}
