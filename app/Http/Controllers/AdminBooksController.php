<?php

namespace App\Http\Controllers;
use App\Books;
use Illuminate\Http\Request;

class adminbooksController extends Controller {

    public function index(){
        if(!AdminController::getadmin()){
            return redirect('admin/login');
        }
        $admin = AdminController::getadmin();
        
        $books = Books::where('Judul')->get();
       

        return view('admin.books.index', compact('Judul', 'admin'));
    }

    public function create(){
        if(!adminController::getadmin()){
            return redirect('admin/login');
        }
        $admin = adminController::getadmin();
        return view('admin.books.create', compact('admin'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'Judul' => 'required',
            'Penulis' => 'required',
            'ISBN' => 'required',
            'Penerbit' => 'required',
            'Jumlah_Halaman' => 'required',
        ]);

        $file = $request->file('FileUpload');
        $format = $file->getClientOriginalExtension();
        $name = $request->nama_books.'.'.$format;
        $file->move('images/books', $name);

        $data = [
            'Judul' => $request->nama_books,
            'Penulis' => $request->penulis,
            'ISBN' => $request->isbn,
            'Penerbit' => $request->penerbit,
            'Jumlah_Halaman' => $request->jumlah_halaman,
            'FileUpload' => $name,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ];
        Books::insert($data);
        return redirect('admin/books');
    }

    public function show($id)
    {
        //
    }

    public function edit($id){
        if(!adminController::getadmin()){
            return redirect('admin/login');
        }
        $admin = adminController::getadmin();
        $books = books::where('id_books', $id)->get();
        return view('admin.books.edit', compact('books', 'admin'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'Judul' => 'required',
            'Penulis' => 'required',
            'ISBN' => 'required',
            'Penerbit' => 'required',
            'Jumlah_Halaman' => 'required',
        ]);

        $file = $request->file('FileUpload');
        $format = $file->getClientOriginalExtension();
        $name = $request->nama_books.'.'.$format;
        $file->move('images/books', $name);

        $data = [
            'Judul' => $request->nama_books,
            'Penulis' => $request->penulis,
            'ISBN' => $request->isbn,
            'Penerbit' => $request->penerbit,
            'Jumlah_Halaman' => $request->jumlah_halaman,
            'FileUpload' => $name,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        books::where('id_books', $id)->update($data);

        return redirect('admin/books');
    }

    public function destroy($id){
        books::where('id_books', '=', $id)->delete();
        return redirect('admin/books');
    }
}
