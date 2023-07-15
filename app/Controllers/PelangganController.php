<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pelanggan;
use App\Models\User;

class PelangganController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Pelanggan();
    }

    public function index()
    {
        return view('admin/pelanggan/index', [
            'title' => "Pelanggan",
            'datas' => $this->model->join('users', 'pelanggans.id_user = users.user_id')->whereNotIn('nama', ['Admin', 'Owner'])->find()
        ]);
    }

    public function store()
    {
        $modelUser = new User();
        $modelPelanggan = $this->model;

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
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ]);

        $modelPelanggan->save([
            'id_user' => $modelUser->getInsertID(),
            'nama' => $this->request->getVar('nama'),
            'noHp' => $this->request->getVar('noHp'),
            'alamat' => $this->request->getVar('alamat')
        ]);

        return redirect()->back()->with('success', 'Berhasil menambah data');
    }

    public function edit($id)
    {
        session();
        return view('admin/pelanggan/edit', [
            'data' => $this->model->getPelangganWithUser($id),
        ]);
    }

    public function update($id)
    {
        $modelUser = new User();
        // $modelPelanggan = $this->model;
        // $dataPelanggan = $this->model->find($id);

        // $validationRules = array_merge($modelUser->validationRules, $modelPelanggan->validationRules);
        // $validationMessages = array_merge($modelUser->validationMessages, $modelPelanggan->validationMessages);
        // unset($validationRules['password'], $validationRules['role'], $validationMessages['password'], $validationMessages['role']);
        

        // if (!$this->validate($validationRules, $validationMessages)) {
        //     $validation = \Config\Services::validation();

        //     session();
        //     return redirect()->to(base_url('admin/pelanggan/edit/'.$dataPelanggan['id_user'] ))->with('validation', $validation->getErrors());
        // }

        // $modelPelanggan->update($id, [
        //     'nama' => $this->request->getVar('nama'),
        //     'noHp' => $this->request->getVar('noHp'),
        //     'alamat' => $this->request->getVar('alamat')
        // ]);

        // $modelUser->update($dataPelanggan['id_user'], [
        //     'role' => "Pelanggan",
        //     'username' => $this->request->getVar('username'),
        //     'email' => $this->request->getVar('email'),
        // ]);

        $dataUser = $modelUser->where('user_id', $id)->first();

        // $oldPassword = $this->request->getVar('passwordLama');
        // if ($oldPassword || $this->request->getVar('password')) {
            // if (!password_verify($oldPassword, $dataUser['password'])) {
                // return redirect()->to(base_url('admin/pelanggan/'))->with('errors', "Password lama salah");
            // } else {
                $validationRulePassword = $modelUser->getValidationRules(['only' => ['password']]);
                $validationRulePassword['pass_confirm'] = 'required_with[password]|matches[password]';
                $validationMessagePassword['pass_confirm'] = [
                    'required_with' => 'Konfirmasi Password tidak boleh kosong',
                    'matches' => "Konfirmasi Password tidak sama dengan Password"
                ];
    
                if (!$this->validate($validationRulePassword, $validationMessagePassword)) {
                    $validation = \Config\Services::validation();
    
                    return redirect()->to(base_url('admin/pelanggan/'))->with('validation', $validation->getErrors());
                }
    
                $modelUser->update($dataUser['user_id'], [
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
                ]);
            // }
        // }


        return redirect()->back()->with('success', 'Berhasil memperbarui password');
    }

    public function destroy($id)
    {
        $result = $this->model->destroyPelangganWithUser($id);

        if ($result) {
            session()->setFlashdata('success', "Berhasil menghapus data");
            return redirect()->to(base_url('admin/pelanggan'));
        } else {
            session()->setFlashdata('errors', "Gagal menghapus data");
            return redirect()->to(base_url('admin/pelanggan'));
        }
    }
}