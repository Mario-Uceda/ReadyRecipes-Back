<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comentario;
use App\Models\Receta;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComentariosController extends Controller
{


    public function comentariosReceta($id) { //le pasamos por request un objeto receta
        $receta = Receta::find($id);

        $comentarios = $receta->comentarios()->select('contenido','id_Usuario')
                        ->get();

        foreach($comentarios as $comentario) {
            $datos_usuario=$comentario->usuario()->select('email','nombre','apellidos')->get();
            $comentario->usuario=$datos_usuario;
            $comentario->makeHidden('id_Usuario');
        }

        return json_encode($comentarios);
    }

    public function nuevoComentario(Request $request) {
        $comentario = new Comentario();
        $comentario->id_Receta = $request->id_receta;
        $comentario->id_Usuario = auth()->user()->id;
        $comentario->contenido = $request->contenido;
        $comentario->save();
    }

    public function numeroComentarios() {
        $modifs = collect();
        $coments = Comentario::orderBy("created_at")->withTrashed()->get();
        foreach($coments as $co) {
            $modifs->push([
                "fecha" => $co->created_at->toDateString(),
                "num" => 1
            ]);
        }
        $coments = Comentario::orderBy("deleted_at")->onlyTrashed()->get();
        foreach($coments as $co) {
            $modifs->push([
                "fecha" => $co->deleted_at->toDateString(),
                "num" => -1
            ]);
        }
        $agrupado = $modifs->groupBy('fecha')->map(function($item) use (&$anterior) {
            $num = $item->sum('num');
            $anterior += $num;
            return $anterior;
        })->sortBy('fecha');
        return response()->json($agrupado);
    }
}
