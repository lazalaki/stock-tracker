<?php

namespace App\Models;

use App\Clients\BestBuy;
use App\Clients\ClientException;
use App\Clients\ClientFactory;
use App\Clients\Target;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stock';

    protected $casts = ['in_stock' => 'boolean'];

    public function track()
    {

        $status = $this->retailer->client()->checkAvailability($this);

        $this->update([
            'in_stock' => $status->available,
            'price' => $status->price
        ]);

        $this->recordHistory();
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    public function history()
    {
        return $this->hasMany(History::class);
    }

    public function recordHistory()
    {
        $this->history()->create([
            'price' => $this->price,
            'in_stock' => $this->in_stock,
            'product_id' => $this->product_id
        ]);
    }
}
