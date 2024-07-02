<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
            'imagem.mimes' => 'O arquivo deve ser uam imagem do tipo PNG',
            'nome.unique' => 'o nome da marca já existe',
            'nome.min' => 'O nome deve ter no mínimo 2 caracteres'
        ];
    }
}
