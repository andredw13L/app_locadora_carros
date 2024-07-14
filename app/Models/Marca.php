<?php

namespace App\Models;

use App\Models\Modelo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Marca extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'imagem'];


    public function rules() {
        return [
            'nome' => 'required|unique:marcas,nome,'.$this->id.'|min:2',
            'imagem' => 'required|file|mimes:png'
        ];
    }

    /*  A regra unique aceita três parâmetros:

        1) Tabela: ex:(marcas)

        2) Nome da coluna: ex:(nome)

        3) Id do registro que será desconsiderado na pesquisa:
            ex:(.$this->id.)
    */
    

    public function feedback() {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'imagem.mimes' => 'O arquivo deve ser uma imagem do tipo PNG',
            'imagem.file' => 'O campo imagem deve conter um arquivo', 
            'nome.unique' => 'O nome da marca já existe',
            'nome.min' => 'O nome deve ter no mínimo 2 caracteres'
        ];
    }

    public function modelos(): HasMany {
        // Uma marca possui muitos modelos
        return $this->hasMany(Modelo::class);
    }
}
