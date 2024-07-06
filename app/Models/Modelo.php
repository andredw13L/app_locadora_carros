<?php

namespace App\Models;

use App\Models\Marca;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Modelo extends Model
{
    use HasFactory;
    protected $fillable = [
        'marca_id', 
        'nome', 
        'imagem', 
        'numero_portas', 
        'lugares', 
        'air_bag', 
        'abs'
    ];


    public function rules() {
        return [
            'marca_id' =>'exists:marcas,id',
            'nome' => 'required|unique:modelos,nome,'.$this->id.'|min:2',
            'imagem' => 'required|file|mimes:png,jpeg,jpg',
            //digits_between: Aceita dígitos nesse escopo
            'numero_portas' => 'required|integer|digits_between:1,5',//(1,2,3,4,5)
            'lugares' => 'required|integer|digits_between:1,20',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean' // true, false, 1, 0, "0", "1"
        ];
    }


    public function marca(): BelongsTo {
        // Um modelo pertence a uma marca
        return $this->belongsTo(Marca::class);
    }
    
}
