<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function books(){
        return $this->belongsToMany('App\Models\Book')->withPivot('quantity');
    }

    //dynamic property
    public function getTotalQualityAttribute(){
        $total_quantity = 0;

        foreach($this->book as $book){
            $total_quantity = $total_quantity + $book->pivot->quantity;

        }

        return $total_quantity;
    }

    
}
