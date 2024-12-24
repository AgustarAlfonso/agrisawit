<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AkunController extends Controller
{
    // Fungsi untuk mengambil semua akun
    public function ambilSemuaAkun()
    {
        return Akun::paginate(5);
    }

    // Fungsi untuk mengambil satu akun berdasarkan ID
    public function ambilAkun($id)
    {
        return Akun::findOrFail($id);
    }

    public function tampilAkun()
    {
        $akuns = $this->ambilSemuaAkun(); // Menggunakan ambilSemuaAkun()
        return view('dashboard.pemilik.akun.tampil', compact('akuns'));
    }

    public function tambahAkun()
    {
        return view('dashboard.pemilik.akun.tambah');
    }

    private function berhasilPopUp($pesan)
    {
        session()->flash('berhasil', $pesan);
    }
    
    private function gagalPopUp($errors)
    {
        session()->flash('gagal', $errors->all());
    }
        

    public function simpanDataAkun(Request $request)
    {
        try{
            $request->validate([
                'username' => ['required', 'string', 'max:255', 'unique:akun,username', 'regex:/^\S*$/u'],
                'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'],
                'role' => ['required', 'string'],
            ], [
                'username.required' => 'Username wajib diisi.',
                'username.unique' => 'Username sudah digunakan.',
                'username.regex' => 'Username tidak boleh mengandung spasi.',
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal harus 8 karakter.',
                'password.regex' => 'Password harus mengandung huruf dan angka.',
                'password.confirmed' => 'Konfirmasi password tidak sesuai.',
                'role.required' => 'Role wajib dipilih.',
            ]);
    
            $akun = new Akun();
            $akun->username = $request->username;
            $akun->name = $request->name;
            $akun->password = bcrypt($request->password);
            $akun->role = $request->role;
            $akun->save();
            $this->berhasilPopUp('Akun berhasil disimpan.');
        }catch(\Illuminate\Validation\ValidationException $e){
            $this->gagalPopUp($e->validator->errors());
            return redirect()->back()->withInput();
        }
       
        return redirect()->route('dashboard.pemilik.akun');    }

    public function hapusAkun($id)
    {
        $akun = $this->ambilAkun($id); // Menggunakan ambilAkun()
        $akun->delete();

        return redirect()->route('dashboard.pemilik.akun')->with('berhasilDihapus', 'Akun berhasil dihapus');
    }

    public function ubahAkun($id)
    {
        $akun = $this->ambilAkun($id); // Menggunakan ambilAkun()
        return view('dashboard.pemilik.akun.ubah', compact('akun'));
    }

    public function perbaruiDataAkun(Request $request, $id)
    {

        try{
            $request->validate([
                'username' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:akun,username,' . $id, 
                    'regex:/^\S*$/u' 
                ],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed', 
                    'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/', 
                ],
                'role' => ['required', 'string'],
            ], [
                'username.required' => 'Username wajib diisi.',
                'username.unique' => 'Username sudah digunakan.',
                'username.regex' => 'Username tidak boleh mengandung spasi.',
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal harus 8 karakter.',
                'password.regex' => 'Password harus mengandung huruf dan angka.',
                'password.confirmed' => 'Konfirmasi password tidak sesuai.',
                'role.required' => 'Role wajib dipilih.',
            ]);
        
            $akun = $this->ambilAkun($id); // Menggunakan ambilAkun()
            $akun->username = $request->username;
            $akun->name = $request->name;
            $akun->password = bcrypt($request->password);
            $akun->role = $request->role;
            $akun->save();

            $this->berhasilPopUp('Akun berhasil diperbarui.');
        }catch(\Illuminate\Validation\ValidationException $e){
            $this->gagalPopUp($e->validator->errors());
            return redirect()->back()->withInput();
        }

        return redirect()->route('dashboard.pemilik.akun');
    }
}
