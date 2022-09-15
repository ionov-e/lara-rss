<?php
/**
 * Модель для новости
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title', 'url', 'short', 'published_date', 'author', 'image_path'
    ];

}
