<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\Pelanggan;
use App\Models\Pengguna;
use App\Models\User;
use Ramsey\Uuid\Uuid;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function postLogin()
    {
        $input = $this->request->getPost();

        $model = new User();
        $dataUser = $model->where('email', $input['email'])->first();

        if ($dataUser) {
            if (!password_verify($input['password'], $dataUser['password'])) {
                return redirect()->to(base_url('/login'))->with('errors', "Username/Email atau Password tidak cocok");
            }else {
                $session = session();
                $session->set('logged_in', true);
                $session->set('username', $dataUser['username']);
                $session->set('role', $dataUser['role']);
                $session->set('id', base64_encode($dataUser['user_id']));
                
                return redirect()->to(base_url(strtolower($dataUser['role']).'/dashboard'));
            }
        } else {
            return redirect()->to(base_url('/login'))->with('errors', "Username/Email atau Password tidak cocok");
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();

        return redirect()->to(base_url('login'));
    }

    public function register()
    {
        return view('auth/register');
    }

    public function postRegister()
    {
        $modelUser = new User();
        $modelPelanggan = new Pelanggan();

        $validationRules = array_merge($modelUser->validationRules, $modelPelanggan->validationRules);
        $validationMessages = array_merge($modelUser->validationMessages, $modelPelanggan->validationMessages);
        
        $validationRules['pass_confirm'] = 'required_with[password]|matches[password]';
        $validationMessages['pass_confirm'] = [
            'required_with' => 'Konfirmasi Password tidak boleh kosong',
            'matches' => "Konfirmasi Password tidak sama dengan Password"
        ];
        if (!$this->validate($validationRules, $validationMessages)) {
            $validation = \Config\Services::validation();
            
            session();
            return view('auth/register', ['validation' => $validation]);
        } 
        
        $modelUser->save([
            'role' => "Pelanggan",
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
        ]);
    
        $modelPelanggan->save([
            'id_user' => $modelUser->getInsertID(),
            'nama' => $this->request->getVar('nama'),
            'noHp' => $this->request->getVar('noHp'),
            'alamat' => $this->request->getVar('alamat')
        ]);
        
        return redirect()->to(base_url('login'))->with('success', "Berhasil melakukan registrasi");
    }
}
