<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Mahasiswa_model');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
    }

    // -------------------------------------------------------
    // READ - Tampilkan daftar mahasiswa
    // -------------------------------------------------------
    public function index() {
        $data['mahasiswa'] = $this->Mahasiswa_model->get_all();
        $data['title']     = 'Daftar Mahasiswa';

        $this->load->view('mahasiswa/index', $data);
    }

    // -------------------------------------------------------
    // CREATE - Form tambah & simpan data
    // -------------------------------------------------------
    public function tambah() {
        $data['title'] = 'Tambah Mahasiswa';

        $this->form_validation->set_rules('nim',   'NIM',   'required|trim|max_length[20]');
        $this->form_validation->set_rules('nama',  'Nama',  'required|trim|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[100]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('mahasiswa/tambah', $data);
        } else {
            $nama_gambar = '';

            // Proses upload gambar jika ada file dikirim
            if (!empty($_FILES['gambar']['name'])) {
                $config_upload = array(
                    'upload_path'   => './uploads/',
                    'allowed_types' => 'gif|jpg|jpeg|png',
                    'max_size'      => 2048,
                    'file_name'     => time() . '_' . $_FILES['gambar']['name'],
                );
                $this->load->library('upload', $config_upload);

                if (!$this->upload->do_upload('gambar')) {
                    $data['error_upload'] = $this->upload->display_errors('<p style="color:red;">', '</p>');
                    $this->load->view('mahasiswa/tambah', $data);
                    return;
                }

                $upload_data = $this->upload->data();
                $nama_gambar = $upload_data['file_name'];
            }

            $insert = array(
                'nim'    => $this->input->post('nim'),
                'nama'   => $this->input->post('nama'),
                'email'  => $this->input->post('email'),
                'gambar' => $nama_gambar,
            );

            if ($this->Mahasiswa_model->insert($insert)) {
                redirect('mahasiswa?success=tambah');
            } else {
                $data['error_db'] = 'Gagal menyimpan data ke database.';
                $this->load->view('mahasiswa/tambah', $data);
            }
        }
    }

    // -------------------------------------------------------
    // UPDATE - Form edit & update data
    // -------------------------------------------------------
    public function edit($id = NULL) {
        if ($id === NULL) redirect('mahasiswa');

        $mahasiswa = $this->Mahasiswa_model->get_by_id($id);
        if (!$mahasiswa) show_404();

        $data['title']     = 'Edit Mahasiswa';
        $data['mahasiswa'] = $mahasiswa;

        $this->form_validation->set_rules('nim',   'NIM',   'required|trim|max_length[20]');
        $this->form_validation->set_rules('nama',  'Nama',  'required|trim|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[100]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('mahasiswa/edit', $data);
        } else {
            $nama_gambar = $mahasiswa->gambar; // Gunakan gambar lama by default

            // Proses ganti gambar jika ada file baru
            if (!empty($_FILES['gambar']['name'])) {
                $config_upload = array(
                    'upload_path'   => './uploads/',
                    'allowed_types' => 'gif|jpg|jpeg|png',
                    'max_size'      => 2048,
                    'file_name'     => time() . '_' . $_FILES['gambar']['name'],
                );
                $this->load->library('upload', $config_upload);

                if (!$this->upload->do_upload('gambar')) {
                    $data['error_upload'] = $this->upload->display_errors('<p style="color:red;">', '</p>');
                    $this->load->view('mahasiswa/edit', $data);
                    return;
                }

                // Hapus gambar lama jika ada
                if (!empty($mahasiswa->gambar) && file_exists('./uploads/' . $mahasiswa->gambar)) {
                    unlink('./uploads/' . $mahasiswa->gambar);
                }

                $upload_data = $this->upload->data();
                $nama_gambar = $upload_data['file_name'];
            }

            $update = array(
                'nim'    => $this->input->post('nim'),
                'nama'   => $this->input->post('nama'),
                'email'  => $this->input->post('email'),
                'gambar' => $nama_gambar,
            );

            if ($this->Mahasiswa_model->update($id, $update)) {
                redirect('mahasiswa?success=edit');
            } else {
                $data['error_db'] = 'Gagal mengupdate data.';
                $this->load->view('mahasiswa/edit', $data);
            }
        }
    }

    // -------------------------------------------------------
    // DELETE - Hapus data & file gambar
    // -------------------------------------------------------
    public function hapus($id = NULL) {
        if ($id === NULL) redirect('mahasiswa');

        $mahasiswa = $this->Mahasiswa_model->get_by_id($id);
        if (!$mahasiswa) show_404();

        // Hapus file gambar dari server jika ada
        if (!empty($mahasiswa->gambar) && file_exists('./uploads/' . $mahasiswa->gambar)) {
            unlink('./uploads/' . $mahasiswa->gambar);
        }

        $this->Mahasiswa_model->delete($id);
        redirect('mahasiswa?success=hapus');
    }
}

/* End of file Mahasiswa.php */
/* Location: ./application/controllers/Mahasiswa.php */
