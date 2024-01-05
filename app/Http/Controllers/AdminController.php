<?php

namespace App\Http\Controllers;
use App\Admin;
use App\Article;
use App\Books;
use App\Monograf;
use App\Pengguna;
session_start();



use Illuminate\Http\Request;

class AdminController extends Controller {

    public function index(){
        if (!isset($_SESSION['id_admin'])) {
            return redirect('admin/login');
        } else {
            $row = Admin::where('id_admin', $_SESSION['id_admin'])->first();
            $admin = [
                'id_admin' => $row['id_admin'],
                'nama_admin' => $row['nama_admin'],
                'email_admin' => $row['email_admin'],
                'username_admin' => $row['username_admin'],
                'jabatan' => $row['jabatan'],
                'foto_admin' => $row['foto_admin'],
            ];
            

            $dashboard = [
                'jumlah_pengguna' => Pengguna::count(),
                'jumlah_buku' => Books::count(),
                'jumlah_article' => Article::where('deleted', 0)->count(),
                'jumlah_monograf' => Monograf::count(),
            ];

            $books = Books::join('tb_pengguna', 'tb_pengguna.id_pengguna', '=', 'tb_books.id_pengguna')->join('tb_admin', 'tb_admin.id_admin', '=', 'tb_books.id_admin')->orderBy('id_books','desc')->get();

            $article = Article::join('tb_pengguna', 'tb_pengguna.id_pengguna', '=', 'tb_artikels.id_pengguna')->join('tb_admin', 'tb_admin.id_admin', '=', 'tb_reservasi.id_admin')->where('deleted', 0)->orderBy('id_reservasi','desc')->get();

            return view('admin.index', compact('admin', 'dashboard','reservasi', 'pesanan'));
        }
        
        return view('admin.index', compact('admin'));
    }

    public static function getadmin(){
    	if (!isset($_SESSION['id_admin'])) {
            return false;
        } else {
            $row = admin::where('id_admin', $_SESSION['id_admin'])->first();
            $admin = [
                'id_admin' => $row['id_admin'],
                'nama_admin' => $row['nama_admin'],
                'email_admin' => $row['email_admin'],
                'username_admin' => $row['username_admin'],
                'jabatan_admin' => $row['jabatan_admin'],
                'foto_admin' => $row['foto_admin'],
            ];
            return $admin;
        }
    }

    public static function showLoginForm(){
    	if (!isset($_SESSION['id_admin'])) {
            $alert = false;
    		return view('admin.auth.login', compact('alert'));
    	} else {
    		return redirect('admin');
    	}
    }

    public static function login(Request $request){
    	$email_admin = $request->email;
    	$password_admin = md5($request->password);

    	$row = admin::where('email_admin', $email_admin)->where('password_admin', $password_admin)->exists();
    	$rows = $row['exists'];

    	if($row){
            $admin = admin::where('email_admin', $email_admin)->where('password_admin', $password_admin)->get();
            foreach ($admin as $admin) {
                $_SESSION = [
                    'id_admin' => $admin->id_admin,
                    'nama_admin' => $admin->nama_admin,
                    'email_admin' => $admin->email_admin,
                    'username_admin' => $admin->username_admin,
                ];
            }
            return redirect('/');
    		
    	} else {
            $alert = true;
            return view('admin.auth.login', compact('alert'));
    	}
    }

    public function showRegisterForm(){
        return view('admin.auth.register');
    }

    public function register(Request $request){
        $file = $request->file('foto_admin');
        $format = $file->getClientOriginalExtension();
        $name = $request->username.'.'.$format;
        $file->move('images/profil', $name);

        $data = [
            'nama_admin' => $request->name,
            'email_admin' => $request->email,
            'username_admin' => $request->username,
            'password_admin' => md5($request->password),
            'foto_admin' => $name,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ];

        admin::insert($data);

        $admin = admin::where('email_admin', $data['email_admin'])->where('password_admin', $data['password_admin'])->get();

        foreach ($admin as $admin) {
            $_SESSION = [
                'id_admin' => $admin->id_admin,
                'nama_admin' => $admin->nama_admin,
                'email_admin' => $admin->email_admin,
                'username_admin' => $admin->username_admin,
            ];
        }
        return redirect('/');
    }

    public function logout(){
        session_destroy();

        return redirect('');
    }
}