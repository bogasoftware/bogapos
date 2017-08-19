<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->lang->load('auth', settings('language'));
    }

    public function login() {
        if ($this->ion_auth->logged_in())
            redirect();

        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('identity', 'lang:login_identity_label', 'required|valid_email');
            $this->form_validation->set_rules('password', 'lang:login_password_label', 'required');
            if ($this->form_validation->run() == true) {
                $remember = (bool) $this->input->post('remember');
                if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                    $user = $this->ion_auth->user()->row();
                    if ($user->store != 0) {
                        $this->session->set_userdata('store', $this->main->get('stores', array('id' => $user->store)));
                    } else {
                        $stores = $this->main->gets('stores');
                        if ($stores->num_rows() > 1) {
                            $data = (object) array('id' => 'all', 'name' => lang('choose_store_all_label'));
                            $this->session->set_userdata('store', $data);
                        } else {
                            $this->session->set_userdata('store', $stores->row());
                        }
                    }
                    $return = array('message' => $this->ion_auth->messages(), 'status' => 'success');
                } else {
                    $return = array('message' => $this->ion_auth->errors(), 'status' => 'danger');
                }
            } else {
                $return = array('message' => validation_errors(), 'status' => 'danger');
            }
            echo json_encode($return);
        } else {
            $this->template->_auth();
            $this->load->js('assets/js/modules/auth/login.min.js');

            $this->output->set_title(lang('login_heading'));
            $this->load->view('login');
        }
    }

    public function profile() {
        if (!$this->ion_auth->logged_in())
            redirect('auth/login');

        $this->template->_default();
        $this->template->form();

        $this->data['menu'] = array('menu' => 'profile', 'submenu' => '');

        $this->output->set_title('Pengaturan Akun - Bogatoko');
        $this->load->view('profile', $this->data);
    }

    public function update_profile() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $this->form_validation->set_rules('fullname', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('phone', 'Handphone', 'trim|required');
        $this->form_validation->set_rules('password_old', 'Password', 'trim');
        $this->form_validation->set_rules('password', 'Password', 'trim|min_length[6]');

        //validate the form
        if ($this->form_validation->run() === true) {
            $data = $this->input->post(null, true);

            $email = $this->data['user']->email;

            do {
                if ($data['password']) {
                    if (!$data['password_old']) {
                        $return = array('message' => "Untuk merubah password silahkan isi password lama Anda.", 'status' => 'danger');
                        break;
                    } else {
                        if (!$this->ion_auth->change_password($email, $data['password_old'], $data['password'])) {
                            $return = array('message' => "Password lama yang dimasukkan salah.", 'status' => 'danger');
                            break;
                        }
                    }
                }
                unset($data['password']);
                unset($data['password_old']);
                $save = $this->main->update('users', $data, array('id' => $this->ion_auth->get_user_id()));
//                if ($save) {
                $this->data['user']->fullname = $data['fullname'];
                $this->data['user']->phone = $data['phone'];
                $return = array('message' => "Akun berhasil diperbaharui.", 'status' => 'success');
//                } else {
//                    $return = array('message' => "Akun gagal disimpan.", 'status' => 'danger');
//                }
            } while (0);
        } else {
            $return = array('message' => validation_errors(), 'status' => 'danger');
        }
        echo json_encode($return);
    }

    // log the user out
    public function logout() {
        $this->ion_auth->logout();
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('auth/login', 'refresh');
    }

    public function forgot_password() {
        if ($this->ion_auth->logged_in())
            redirect();

        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('email', 'Alamat Email', 'required|valid_email');
            if ($this->form_validation->run() == true) {
                $forgotten = $this->auth->forgotten_password($this->input->post('email'));
                if ($forgotten) {
                    $return = array('message' => 'Permintaan reset password telah diterima. Silahkan cek email Anda untuk langkah selanjutnya.', 'status' => 'success');
                } else {
                    $return = array('message' => 'Email yang Anda masukkan tidak terdaftar.', 'status' => 'danger');
                }
            } else {
                $return = array('message' => validation_errors(), 'status' => 'danger');
            }
            echo json_encode($return);
        } else {
            $this->template->_auth();
            $this->load->js('assets/js/modules/auth/forgot_password.min.js');

            $this->output->set_title('Lupa Password Bogatoko');
            $this->load->view('forgot_password');
        }
    }

    public function reset_password($code) {
        if ($this->ion_auth->logged_in())
            redirect();

        $reset = $this->ion_auth->forgotten_password_complete($code);
        $this->template->_auth();

        $this->output->set_title('Reset Password Bogatoko');
        if ($reset) {
            $this->load->view('forgot_password_complete');
        } else {
            $this->load->view('forgot_password_failed');
        }
    }

}
