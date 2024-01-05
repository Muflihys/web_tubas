<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Pengguna;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){

        if(isset($_SESSION['id_pengguna'])){
            $row = Pengguna::where('id_pengguna', $_SESSION['id_pengguna'])->first();
            $pengguna = [
                'id_pengguna' => $row['id_pengguna'],
                'nama_pengguna' => $row['nama_pengguna'],
                'email_pengguna' => $row['email_pengguna'],
                'username_pengguna' => $row['username_pengguna'],
                'foto_pengguna' => $row['foto_pengguna'],
            ];
            $islogin = ['login' => 'pengguna'];
            return view('index', compact('pengguna', 'islogin'));
        } else if(isset($_SESSION['id_admin'])){
            $row = Admin::where('id_admin', $_SESSION['id_admin'])->first();
            $admin = [
                'id_admin' => $row['id_admin'],
                'nama_admin' => $row['nama_admin'],
                'email_admin' => $row['email_admin'],
                'username_admin' => $row['username_admin'],
                'jabatan' => $row['jabatan'],
                'foto_admin' => $row['foto_admin'],
            ];
            $islogin = ['login' => 'admin'];
            return view('index', compact('admin', 'islogin'));
        } else {
            $islogin = ['login' => 'false'];
            return view('index', compact('islogin'));
        }
    }
}
