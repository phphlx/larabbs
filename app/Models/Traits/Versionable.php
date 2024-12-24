<?php

namespace App\Models\Traits;

use App\Models\Version;

trait Versionable {
    public function version()
    {
        return $this->morphOne(Version::class, 'versionable');
    }

    public function createVersion($model)
    {
        $this->version()->create([
            'user_id' => $model->user_id,
            'model_data' => serialize($model),
        ]);
    }
}
