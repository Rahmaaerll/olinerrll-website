<?php
include 'koneksi.php';

// Tambahkan logika untuk pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql_peminjaman = "SELECT * FROM peminjaman";
if (!empty($search)) {
    $sql_peminjaman .= " WHERE id_peminjaman LIKE '%$search%' OR id_pelanggan LIKE '%$search%' OR id_ps LIKE '%$search%'";
}
$result_peminjaman = $conn->query($sql_peminjaman);

// Tambah data baru
if (isset($_POST['add_data'])) {
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_ps = $_POST['id_ps'];
    $id_admin = $_POST['id_admin'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $status = $_POST['status'];

    $sql_add = "INSERT INTO peminjaman (id_pelanggan, id_ps, id_admin, tanggal_pinjam, tanggal_kembali, status) VALUES ('$id_pelanggan', '$id_ps', '$id_admin', '$tanggal_pinjam', '$tanggal_kembali', '$status')";
    $conn->query($sql_add);
    header("Location: pinjam.php");
}

// Hapus data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql_delete = "DELETE FROM peminjaman WHERE id_peminjaman = '$id'";
    $conn->query($sql_delete);
    header("Location: pinjam.php");
}

// Edit data
if (isset($_POST['edit_data'])) {
    $id_peminjaman = $_POST['id_peminjaman'];
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_ps = $_POST['id_ps'];
    $id_admin = $_POST['id_admin'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $status = $_POST['status'];

    $sql_edit = "UPDATE peminjaman SET id_pelanggan = '$id_pelanggan', id_ps = '$id_ps', id_admin = '$id_admin', tanggal_pinjam = '$tanggal_pinjam', tanggal_kembali = '$tanggal_kembali', status = '$status' WHERE id_peminjaman = '$id_peminjaman'";
    $conn->query($sql_edit);
    header("Location: pinjam.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlayStation Rental 2024</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
    background-image: url("bg5.jpg"); /* Tambahkan url() untuk gambar */
    background-size: cover;           /* Memastikan gambar memenuhi seluruh halaman */
    background-position: center;      /* Memposisikan gambar di tengah */
    background-attachment: fixed;     /* Membuat latar belakang tetap saat di-scroll */
    color: white;                     /* Warna teks agar kontras dengan background */
        }
        
        #sidebar {
    background-color: rgba(218, 48, 133, 0.53); /* Warna pink transparan */
    height: 100vh; /* Sidebar memanjang penuh ke bawah */
    position: fixed; /* Tetap di tempat meskipun halaman di-scroll */
    width: 250px; /* Lebar sidebar */
    padding-top: 20px; /* Memberikan ruang di atas */
    padding-bottom: 20px; /* Memberikan ruang di bawah */
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); /* Bayangan sisi kiri sidebar */
    z-index: 999; /* Menjaga sidebar tetap di depan */
}

#sidebar .sidebar-heading {
    font-size: 1.5rem;
    font-weight: bold;
    color: white;
    text-align: center;
    padding-bottom: 30px; /* Memberikan ruang bawah pada judul */
}

#sidebar .list-group-item {
    background-color: transparent; /* Menghilangkan background default */
    color: white; /* Warna teks */
    border: none; /* Menghilangkan border */
    padding: 15px 20px; /* Padding item sidebar */
    font-size: 1.1rem; /* Ukuran font lebih besar */
    text-align: left; /* Mengatur teks agar rata kiri */
}

#sidebar .list-group-item:hover {
    background-color: rgba(218, 48, 133, 0.8); /* Hover efek warna */
    cursor: pointer; /* Mengubah kursor saat hover */
}

#sidebar .list-group-item.active {
    background-color: rgba(218, 48, 133, 1); /* Menetapkan warna aktif */
    font-weight: bold; /* Menebalkan teks item aktif */
}

#page-content-wrapper {
    margin-left: 250px; /* Memberikan ruang untuk sidebar */
    padding: 20px; /* Memberikan ruang di sekitar konten */
}

        }
        .navbar {
            background-color:rgba(219, 31, 119, 0.75); /* Sama dengan warna latar belakang */
            padding-top: 2rem; /* Tambahkan padding atas */
            padding-bottom: 1rem; /* Tambahkan padding bawah */
        }
        .navbar .navbar-brand {
            color: white; /* Warna teks navbar */
            font-size: 1.5rem; /* Ukuran teks lebih besar */
        }
        .navbar .form-control {
            width: 250px;
        }
        .table th, .table td {
            text-align: center;
        }
        .modal-content {
    background-image: url("bg5.jpg"); /* Gunakan gambar yang sama seperti latar belakang halaman utama */
    background-size: cover;           /* Memastikan gambar memenuhi seluruh modal */
    background-position: center;      /* Memposisikan gambar di tengah modal */
    background-attachment: fixed;     /* Membuat latar belakang tetap saat di-scroll */
    color: white;                     /* Menjaga teks tetap kontras dengan latar belakang */
}

.modal-header, .modal-body, .modal-footer {
    background: rgba(226, 100, 170, 0.6);  /* Menambahkan sedikit transparansi di atas gambar */
}

.modal-body input {
    background-color: rgba(255, 255, 255, 0.8); /* Membuat input lebih mudah dibaca dengan latar belakang putih transparan */
    color: black;  /* Agar teks input lebih terlihat */
}

.modal-body button {
    background-color: rgba(218, 48, 133, 0.8); /* Warna tombol sesuai dengan sidebar */
    color: white;
}

        }
        .card {
        border-radius: 15px; /* Membuat sudut kartu melengkung agar terlihat seperti bantal */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19); /* Efek bayangan */
        transform-style: preserve-3d;
        transition: transform 0.5s ease; /* Animasi flip */
        }
        .card:hover {
        transform: rotateY(19deg); /* Efek flip ketika hover */
        }
        .card-img-top {
        border-radius: 15px; /* Sudut gambar mengikuti sudut kartu */
        transition: transform 0.3s ease, box-shadow 0.3s ease; /* Animasi ketika di-hover */
        }
        .card-img-top:hover {
        transform: scale(1.1); /* Membuat gambar membesar saat hover */
        box-shadow: 0 10px 20px rgba(214, 38, 141, 0.3); /* Menambah bayangan */
        }
        .card-body {
        background-color: rgba(185, 17, 109, 0.6); /* Transparan hitam */
        border-radius: 10px;
        padding: 10px;
        color: white;
        }
h1 {
      text-align: center;     /* Jika Anda ingin teks di tengah dalam elemen */
      color:maroon;
    }
h4 {
      text-align: center;
      color: pink;
    }
    </style>
</head>
<body>

<div class="d-flex" id="wrapper">
    <div class="bg-expand-lg" id="sidebar" style="background-color:rgba(218, 48, 133, 0.53);">
        <div class="sidebar-heading text-white p-4">PlayStation Rental</div>
        <div class="list-group list-group-flush">
            <a href="index.php" class="list-group-item list-group-item-action text-white bg-expand-lg" style="background-color:rgba(218, 48, 133, 0.53);">Dashboard</a>
            <a href="playstation.php" class="list-group-item list-group-item-action text-white bg-expand-lg" style="background-color:rgba(218, 48, 133, 0.53);">PlayStation Room</a>
            <a href="member.php" class="list-group-item list-group-item-action text-white bg-expand-lg" style="background-color:rgba(218, 48, 133, 0.53);">Join Member</a>
            <a href="pinjam.php" class="list-group-item list-group-item-action text-white bg-expand-lg"style="background-color:rgba(218, 48, 133, 0.53);">Peminjaman PlayStation</a>
            <a href="riwayat.php" class="list-group-item list-group-item-action text-white bg-expand-lg"style="background-color:rgba(218, 48, 133, 0.53);">Riwayat Penggunaan</a>
            
        </div>
    </div>
    <div id="page-content-wrapper" class="w-100">
    <nav class="navbar navbar-expand-lg" style="background-color:rgba(218, 48, 133, 0.53);">
        <div class="container-fluid">
            <h1><span class="navbar-brand" style="color: pink;">Dashboard</span></h1>
            </div>
        </nav>
<body>
<div class="container mt-5">
    <h2>Data Peminjaman PlayStation Rental 24</h2>

    <form class="d-flex my-3" method="get">
        <input class="form-control me-2" type="search" placeholder="Search" name="search" value="<?php echo $search; ?>">
        <button class="btn btn-primary" type="submit">Search</button>
    </form>

    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Data</button>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID Peminjaman</th>
            <th>ID Pelanggan</th>
            <th>ID PS</th>
            <th>ID Admin</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result_peminjaman->num_rows > 0) {
            while ($row = $result_peminjaman->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id_peminjaman']}</td>
                        <td>{$row['id_pelanggan']}</td>
                        <td>{$row['id_ps']}</td>
                        <td>{$row['id_admin']}</td>
                        <td>{$row['tanggal_pinjam']}</td>
                        <td>{$row['tanggal_kembali']}</td>
                        <td>{$row['status']}</td>
                        <td>
                            <a href='?delete={$row['id_peminjaman']}' class='btn btn-danger btn-sm'>Hapus</a>
                            <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal{$row['id_peminjaman']}'>Edit</button>
                        </td>
                      </tr>";

                // Modal Edit
                echo "<div class='modal fade' id='editModal{$row['id_peminjaman']}' tabindex='-1'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <form method='post'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title'>Edit Data</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <input type='hidden' name='id_peminjaman' value='{$row['id_peminjaman']}'>
                                        <input type='text' name='id_pelanggan' class='form-control' value='{$row['id_pelanggan']}' required>
                                        <input type='text' name='id_ps' class='form-control' value='{$row['id_ps']}' required>
                                        <input type='text' name='id_admin' class='form-control' value='{$row['id_admin']}' required>
                                        <input type='date' name='tanggal_pinjam' class='form-control' value='{$row['tanggal_pinjam']}' required>
                                        <input type='date' name='tanggal_kembali' class='form-control' value='{$row['tanggal_kembali']}' required>
                                        <input type='text' name='status' class='form-control' value='{$row['status']}' required>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Batal</button>
                                        <button type='submit' name='edit_data' class='btn btn-primary'>Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>";
            }
        } else {
            echo "<tr><td colspan='8'>Tidak ada data</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="id_pelanggan" class="form-control" placeholder="ID Pelanggan" required>
                    <input type="text" name="id_ps" class="form-control" placeholder="ID PS" required>
                    <input type="text" name="id_admin" class="form-control" placeholder="ID Admin" required>
                    <input type="date" name="tanggal_pinjam" class="form-control" required>
                    <input type="date" name="tanggal_kembali" class="form-control" required>
                    <input type="text" name="status" class="form-control" placeholder="Status" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="add_data" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>