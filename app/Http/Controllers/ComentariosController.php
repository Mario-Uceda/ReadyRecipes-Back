<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComentariosController extends Controller
{
    public function comentariosUsuario(Request $request) {
        $id = $request->id_usuario;
        $comentarios_encontrados = Comentario::where('id_usuario', $id)->get();
        return json_encode($comentarios_encontrados);
    }

    public function comentariosReceta(Request $request) { //le pasamos por request un objeto receta
        $id_receta = $request->id_receta;

        $resultado = DB::table('comentarios')
            ->join('recetas', 'recetas.id', '=', 'comentarios.id_Receta')
            ->join('usuarios', 'usuarios.id', '=', 'comentarios.id_Usuario')
            ->select('usuarios.nombre', 'usuarios.apellidos', 'comentarios.contenido')
            ->where('comentarios.id_Receta', $id_receta)
            ->get();
        

        return json_encode($resultado);
    }

    public function nuevoComentario(Request $request) {

        $comentario = new Comentario();

        $comentario->id_receta = $request->id_receta;
        $comentario->id_usuario = $request->id_usuario;
        $comentario->contenido = $request->contenido;
        
        $comentario->save();

    }
}
