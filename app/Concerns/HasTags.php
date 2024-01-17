<?php

namespace App\Concerns;

use App\Models\Tag;
use ArrayAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTags
{
    protected array $queuedTags = [];

    public static function bootHasTags()
    {
        static::created(function (Model $model) {
            if (count($model->queuedTags) === 0) {
                return;
            }

            $model->attachTags($model->queuedTags);

            $model->queuedTags = [];
        });

        static::deleted(function (Model $deletedModel) {
            $tags = $deletedModel->tags()->get();

            $deletedModel->detachTags($tags);
        });
    }

    public function setTagsAttribute(string|array|ArrayAccess|Tag $tags)
    {
        if (! $this->exists) {
            $this->queuedTags = $tags;

            return;
        }

        $this->syncTags($tags);
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function syncTags(array $tags)
    {
        $this->tags()->sync($tags);
    }

    public function attachTags(array|ArrayAccess|Tag $tags): static
    {
        $tags = collect(Tag::findOrCreate($tags));

        $this->tags()->syncWithoutDetaching($tags->pluck('id')->toArray());

        return $this;
    }

    public function detachTags(array $tags = null)
    {
        $this->tags()->detach($tags);
    }
}
