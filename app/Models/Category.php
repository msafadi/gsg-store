<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $connection = 'mysql';

    protected $table = 'categories';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'name', 'slug', 'parent_id', 'status', 'description',
    ];

    // Accessors: get{AttributeName}Attribute
    // Exists Attribute
    // $model->name
    public function getNameAttribute($value)
    {
        if ($this->trashed()) {
            return $value . ' (Deleted)';
        }
        return $value;
    }


    // Non-exists Attribute
    // $model->original_name
    public function getOriginalNameAttribute()
    {
        return $this->attributes['name'];
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function childern()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id')->withDefault([
            'name' => 'No Parent'
        ]);
    }
}
