<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded = ['id'];

    public function toSubFormat()
    {
        $date = $this->created_at;
        if ($this->subscription_type === Category::class) {
            $i = Category::query()->where('id', $this->subscription_id)->first();
            $i['is_favorite'] = $this->favorite;
            $i['date'] = $date;
        } else {
            $i = User::query()->where('id', $this->subscription_id)->first();
            $i['is_favorite'] = $this->favorite;
            $i['date'] = $date;
        }

        return $i;
    }
}
