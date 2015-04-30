<?php namespace TeamTeaTime\Filer;

use Eloquent;

class Attachment extends Eloquent
{

    // Eloquent properties
    protected $table      = 'filer_attachments';
    public    $timestamps = true;
    protected $fillable   = ['user_id', 'model_key'];
    protected $with       = ['model', 'attachment'];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function model()
    {
        return $this->morphTo();
    }

    public function attachment()
    {
        return $this->morphTo();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeKey($query, $key)
    {
        return $query->where('model_key', '=', $key);
    }

    /*
    |--------------------------------------------------------------------------
    | Attributes
    |--------------------------------------------------------------------------
    */

    public function getURLAttribute()
    {
        if (config('filer.append_query_string'))
        {
            return "{$this->attachment->url}?v={$this->updated_at->timestamp}";
        }

        return $this->attachment->url;
    }

    public function getDownloadURLAttribute()
    {
        return route('filer.file.download', $this->attachment->id);
    }

}
