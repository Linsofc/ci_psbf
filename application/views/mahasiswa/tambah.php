<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Mahasiswa</title>
</head>
<body>
<div style="width:600px; margin:20px auto;">
    <h2>Tambah Mahasiswa</h2>
    <a href="<?php echo site_url('mahasiswa'); ?>">&larr; Kembali ke Daftar</a>
    <hr>

    <?php if (isset($error_upload)) echo $error_upload; ?>
    <?php if (isset($error_db)) echo '<p style="color:red;">' . $error_db . '</p>'; ?>

    <?php echo form_open_multipart('mahasiswa/tambah'); ?>

        <table>
            <tr>
                <td width="150"><label>NIM <span style="color:red;">*</span></label></td>
                <td>
                    <input type="text" name="nim" value="<?php echo set_value('nim'); ?>" style="width:300px;">
                    <?php echo form_error('nim'); ?>
                </td>
            </tr>
            <tr>
                <td width="150"><label>Nama <span style="color:red;">*</span></label></td>
                <td>
                    <input type="text" name="nama" value="<?php echo set_value('nama'); ?>" style="width:300px;">
                    <?php echo form_error('nama'); ?>
                </td>
            </tr>
            <tr>
                <td><label>Email <span style="color:red;">*</span></label></td>
                <td>
                    <input type="text" name="email" value="<?php echo set_value('email'); ?>" style="width:300px;">
                    <?php echo form_error('email'); ?>
                </td>
            </tr>
            <tr>
                <td><label>Gambar</label></td>
                <td>
                    <input type="file" name="gambar">
                    <br><small>Format: JPG, JPEG, PNG, GIF. Maks. 2MB.</small>
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-top:10px;">
                    <input type="submit" value="Simpan">
                    &nbsp;
                    <a href="<?php echo site_url('mahasiswa'); ?>">Batal</a>
                </td>
            </tr>
        </table>

    <?php echo form_close(); ?>
</div>
</body>
</html>
