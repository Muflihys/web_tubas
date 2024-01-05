<?php
namespace App\Http\Controllers;
use App\Books;
session_start();
use App\pengguna;
use App\Reservasi;
use App\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class penggunaController extends Controller {

    public function index(){
        if (!isset($_SESSION['id_pengguna'])) {
            return redirect('pengguna/login');
        } else {

            $check_books = count(Books::where('id_pengguna', $_SESSION['id_pengguna'])->get());
            if($check_books == 0){
                $pemesanan_terakhir = 0;
                $total_books = 0;
            } else {
                $row_pemesanan_terakhir = Books::where('id_pengguna', $_SESSION['id_pengguna'])->orderBy('id_pengguna', 'desc')->first();
                $pemesanan_terakhir = $row_pemesanan_terakhir->total_pemesanan;
                $total_books = Books::where('id_pengguna', $_SESSION['id_pengguna'])->sum('total_buku');
            }

            $row = pengguna::where('id_pengguna', $_SESSION['id_pengguna'])->first();
            $pengguna = [
                'id_pengguna' => $row['id_pengguna'],
                'nama_pengguna' => $row['nama_pengguna'],
                'email_pengguna' => $row['email_pengguna'],
                'foto_pengguna' => $row['foto_pengguna'],
            ];
            return view('pengguna.index', compact('pengguna', 'jumlah_kunjungan', 'pemesanan_terakhir', 'total_pemesanan'));
        }
        
        return view('pengguna.index', compact('pengguna'));
    }

    public static function getpengguna(){
        if (!isset($_SESSION['id_pengguna'])) {
            return false;
        } else {
            $row = pengguna::where('id_pengguna', $_SESSION['id_pengguna'])->first();
            $pengguna = [
                'id_pengguna' => $row['id_pengguna'],
                'nama_pengguna' => $row['nama_pengguna'],
                'email_pengguna' => $row['email_pengguna'],
                'username_pengguna' => $row['username_pengguna'],
                'foto_pengguna' => $row['foto_pengguna'],
            ];
            return $pengguna;
        }
    }

    public static function showLoginForm(){
        if (!isset($_SESSION['id_pengguna'])) {
            $alert = false;
            return view('pengguna.auth.login', compact('alert'));
        } else {
            return redirect('pengguna');
        }
    }

    public static function login(Request $request){
    	$email_pengguna = $request->email;
    	$password_pengguna = md5($request->password);

    	$row = pengguna::where('email_pengguna', $email_pengguna)->where('password_pengguna', $password_pengguna)->exists();
    	// $rows = $row['exists'];

    	if($row){
            $pengguna = pengguna::where('email_pengguna', $email_pengguna)->where('password_pengguna', $password_pengguna)->get();
            foreach ($pengguna as $pengguna) {
                $_SESSION = [
                    'id_pengguna' => $pengguna->id_pengguna,
                ];
            }
            return redirect('/');
    		
    	} else {
            $alert = true;
    		return view('pengguna.auth.login', compact('alert'));
    	}
    }

    public function showRegisterForm(){
        return view('pengguna.auth.register');
    }

    public function register(Request $request){
        $file = $request->file('foto_pengguna');
        $format = $file->getClientOriginalExtension();
        $name = $request->username.'.'.$format;
        $file->move('images/profil', $name);


        $data = [
            'nama_pengguna' => $request->name,
            'email_pengguna' => $request->email,
            'username_pengguna' => $request->username,
            'password_pengguna' => md5($request->password),
            'foto_pengguna' => $name,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ];

        pengguna::insert($data);

        $pengguna = pengguna::where('email_pengguna', $data['email_pengguna'])->where('password_pengguna', $data['password_pengguna'])->get();

        foreach ($pengguna as $pengguna) {
            $_SESSION = [
                'id_pengguna' => $pengguna->id_pengguna,
                'nama_pengguna' => $pengguna->nama_pengguna,
                'email_pengguna' => $pengguna->email_pengguna,
                'username_pengguna' => $pengguna->username_pengguna,
            ];
        }
        return redirect('/');
    }

    public function logout(){
        session_destroy();

        return redirect('');
    }
}
