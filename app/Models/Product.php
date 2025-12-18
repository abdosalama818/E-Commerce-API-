<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasTranslations;

    public $translatable = ['description', 'title'];
    protected $fillable = [
        'description',
        'price',
        'quantity',
        'title',
        'slug',
    ];

    // Automatically generate slug from title on creating a product >> observable but i dont use it now i generate it in seeder
    public static function booted()
    {
        static::creating(function ($product) {
            $product->slug = Str::slug($product->title);
        });
    }



public function getTranslatedData()
{
    $locale = request()->header('Accept-Language', 'en'); // Set default language to English if not provided
    return [
        'id'=>$this->id,
        'title' => $this->getTranslation('title', $locale),
         'slug' => $this->slug,
        'description' => $this->getTranslation('description', $locale),
        'price' => $this->price,
        'quantity' => $this->quantity,
        'image' => $this->image_url,
       'language' => $locale,

    ];
}



    public function getImageUrlAttribute()
    {

        $media = $this->getFirstMedia('images');

        if ($media) {
            return $media->getUrl('preview');
        }

        return asset('default.jfif');
    }








    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 
        'order_product',
        'product_id',
        'order_id',
        'id',
        'id'
        
        )->using(OrderItems::class)
        ->withPivot(['qty','price','product_name']);
    }
}
