<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\User;

class AdministratorController extends BaseController
{
    public function index()
    {
        $modelUser = new User;

        return view('owner/administrator/index', [
            'title' => 'Admnistrator',
            'datas' => $modelUser->join('pelanggans', 'pelanggans.id_user = users.user_id', 'left')->where('role', 'Admin')->find()
        ]);
    }

    public function update($id_user)
    {
        $input = $this->request->getPost();
        $modelUser = new User();

        if ($input['password'] != null) {
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

            $modelUser->update($id_user, [
                'password' => password_hash($input['password'], PASSWORD_DEFAULT)
            ]);
        }

        $modelUser->update($id_user, [
            'is_aktif' => $input['status'],
        ]);

        return redirect()->back()->with('success', 'Berhasil memperbarui data');
    }
}