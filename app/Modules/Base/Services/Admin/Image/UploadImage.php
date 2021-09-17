<?php


namespace App\Modules\Base\Services\Admin\Image;


use App\Modules\Admin\Models\Statics\File;
use App\Modules\Base\Models\Image;
use Illuminate\Http\UploadedFile;
use Storage;

/**
 * @property UploadedFile|null file
 * @property string|null type
 * @property Image|Image[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model image
 * @property bool src
 */
class UploadImage
{
    /** @var */
    protected $file;

    /** @var */
    protected $type;

    /** @var */
    protected $image;

    /** @var string */
    protected $disk = 'public';

    /**
     * @param UploadedFile|null $file
     *
     * @return $this
     */
    public function setFile(UploadedFile $file = null) : self
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @param string|null $type
     *
     * @return $this
     */
    public function setType(string $type = null) : self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param int|null $imageId
     *
     * @return $this
     */
    public function setImageById(int $imageId = null) : self
    {
        $this->image = Image::findOrFail($imageId);
        return $this;
    }

    /**
     * @return $this
     */
    public function initImage() : self
    {
        $this->image = Image::create([
            'type'      => $this->type
        ]);
        return $this;
    }

    /**
     * @return $this
     */
    public function uploadImage() : self
    {
        // Save Original.
        $this->src = Storage::disk($this->disk)->put($this->type . '/' . $this->image->id,$this->file);
        return $this;
    }

    /**
     * @return $this
     */
    public function saveSrc() : self
    {
        $this->image->update([
            'src'   => $this->src
        ]);
        return $this;
    }

    /**
     * @return Image|Image[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getImage()
    {
        return $this->image;
    }

}
