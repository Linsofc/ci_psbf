<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Mahasiswa</title>
</head>
<body>
<div style="width:900px; margin:20px auto;">
    <h2>Daftar Mahasiswa</h2>
    <a href="<?php echo site_url('mahasiswa/tambah'); ?>">+ Tambah Mahasiswa</a>
    <hr>

    <?php if ($this->input->get('success') == 'tambah'): ?>
        <p style="color:green;">Data berhasil ditambahkan!</p>
    <?php elseif ($this->input->get('success') == 'edit'): ?>
        <p style="color:green;">Data berhasil diperbarui!</p>
    <?php elseif ($this->input->get('success') == 'hapus'): ?>
        <p style="color:green;">Data berhasil dihapus!</p>
    <?php endif; ?>

    <?php if (empty($mahasiswa)): ?>
        <p>Belum ada data mahasiswa.</p>
    <?php else: ?>
        <table border="1" cellpadding="8" cellspacing="0" style="border-collapse:collapse; width:100%;">
            <thead style="background:#eee;">
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($mahasiswa as $row): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($row->nim); ?></td>
                    <td><?php echo htmlspecialchars($row->nama); ?></td>
                    <td><?php echo htmlspecialchars($row->email); ?></td>
                    <td>
                        <?php if (!empty($row->gambar)): ?>
                            <img src="<?php echo base_url('uploads/' . $row->gambar); ?>" width="80" alt="gambar">
                        <?php else: ?>
                            <em>-</em>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo site_url('mahasiswa/edit/' . $row->id); ?>">Edit</a>
                        &nbsp;|&nbsp;
                        <a href="<?php echo site_url('mahasiswa/hapus/' . $row->id); ?>"
                           onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
