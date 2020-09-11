<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\usuarios; //usuarios model
use Session;

class homeController extends Controller
{
    //=============================================================
    // Index
    public function index()
    {
        //Sessão Inativa/Ativa
        if(!Session::has('login'))
            return $this->pgLogin();
        else
            return view('home');
    }

    //===============================================
    // LOGIN
    public function pgLogin()
    {
        return view('pagina_inicial');
    }

    public function executarLogin(Request $request)
    {
        //==================================================
        // VALIDAÇÃO
        $this->validate($request, [
            'text_usuario' => 'required',
            'text_senha' => 'required',
        ]);
        // return 'OK';


        //==================================================
        // VERIFICAÇÃO
        $usuario = usuarios::where('usuario', $request->text_usuario)->first();
        // dd($usuario);

        if($usuario === null){
            $erros_bd = ['Essa conta de usuário não existe.'];
            return view('pagina_inicial', compact('erros_bd'));
        }

        // if($usuario->count() == 0){
        //     $erros_bd = ['Essa conta de usuário não existe.'];
        //     return view('pagina_inicial', compact('erros_bd'));
        // }

        //não é recomendado, porque diz que usuário existe
        //verifica se a senha bate com a do banco de dados
        if(!Hash::check($request->text_senha, $usuario->senha)){
            $erros_bd = ['A senha está incorreta.'];
            return view('pagina_inicial', compact('erros_bd'));
        }

        // if($usuario->senha !== $request->text_senha){
        //     $erros_bd = ['A senha está incorreta.'];
        //     return view('pagina_inicial', compact('erros_bd'));
        // }

        //session
        // Session::put('chave', 'validado');
        // Session::put('usuario',$usuario->usuario);
        Session::put('login', 'sim');
        Session::put('usuario', $usuario->usuario);

        return redirect('/');
    }



    //===============================================
    // CRIAÇÃO DE NOVA CONTA
    public function formCriarNovaConta()
    {
        //apresentar o formulário de criação de nova conta
        return view('criar_nova_conta');
    }


    public function executarCriacaoDeNovaConta(Request $request)
    {
        //executar os procedimentos e verificações para criação de uma nova conta


        //==================================================
        // VALIDAÇÃO
        //==================================================
        $this->validate($request, [
            'text_usuario' => 'required|between:3,30|alpha_num',
            'text_senha' => 'required|between:6,50',
            'text_senha_repetida' => 'required|same:text_senha',
            'text_email' => 'required|email',
            'check_termos_condicoes' => 'accepted'
        ]);
        // return 'OK';


        //==================================================
        // VERIFICAÇÃO
        //==================================================
        $dados = usuarios::where('usuario', '=', $request->text_usuario)
                ->orWhere('email', '=', $request->text_email)
                ->get();

        /* buscar a partir de array/objeto
        -----------------
        ->get()->frist()
            if(count($dados))
        *buscar a partir de collection
        ---------------------------
        ->get()
            if($dados->count())
        */

        if($dados->count() > 0){
            $erros_bd = ['Já existe um usuário com o mesmo nome ou com o mesmo email.'];
            return view('criar_nova_conta', compact('erros_bd'));
        }

        //==================================================
        //inserir novo usuário na base de dados
        $novo = new usuarios;
        $novo->usuario = $request->text_usuario;
        $novo->senha = Hash::make($request->text_senha);
        $novo->email = $request->text_email;
        $novo->save();

        $mensagem_sucesso = ['Conta criada com sucesso!'];

        return view('criar_nova_conta', compact('mensagem_sucesso'));
        // return redirect('/');

    }

    //============================================================
    // LOGOUT
    public function logout()
    {
        //destruir sessão e redirect
        Session::flush();
        return redirect('/');
    }

}
