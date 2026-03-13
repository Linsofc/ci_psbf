<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mahasiswa_model extends CI_Model {

    private $table = 'mahasiswa';

    function __construct() {
        parent::__construct();
    }

    // Ambil semua data
    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    // Ambil satu data by ID
    public function get_by_id($id) {
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    // Simpan data baru
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    // Update data
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    // Hapus data
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
}

/* End of file Mahasiswa_model.php */
/* Location: ./application/models/Mahasiswa_model.php */
