<?php
include 'koneksi.php'; 

// Query untuk mengambil data dari tabel admin
$sql_admin = "SELECT * FROM admin";
$result_admin = $conn->query($sql_admin);

// Menambahkan anggota
if (isset($_POST['submit_anggota'])) {
    $nama_admin = $_POST['nama_admin'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk menambahkan data admin
    $sql_insert = "INSERT INTO admin (nama_admin, username, password) VALUES ('$nama_admin', '$username', '$password')";
    if ($conn->query($sql_insert) === TRUE) {
        echo "<script>
                alert('Anggota berhasil ditambahkan');
                window.location.href=''; // reload halaman agar tidak ada popup berulang
              </script>";
    } else {
        echo "<script>alert('Gagal menambahkan anggota');</script>";
    }
}

// Edit anggota
if (isset($_POST['update_anggota'])) {
    $id_admin = $_POST['id_admin'];
    $nama_admin = $_POST['nama_admin'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql_update = "UPDATE admin SET nama_admin='$nama_admin', username='$username', password='$password' WHERE id_admin='$id_admin'";
    if ($conn->query($sql_update) === TRUE) {
        echo "<script>
                alert('Data berhasil diperbarui');
                window.location.href=''; // reload halaman agar tidak ada popup berulang
              </script>";
    } else {
        echo "<script>alert('Gagal memperbarui data');</script>";
    }
}

// Hapus anggota
if (isset($_GET['delete'])) {
    $id_admin = $_GET['delete'];
    $sql_delete = "DELETE FROM admin WHERE id_admin='$id_admin'";
    if ($conn->query($sql_delete) === TRUE) {
        echo "<script>
                alert('Data berhasil dihapus');
                window.location.href=''; // reload halaman agar tidak ada popup berulang
              </script>";
    } else {
        echo "<script>alert('Gagal menghapus data');</script>";
    }
}

// Ambil data admin
$sql_admin = "SELECT * FROM admin";
$result_admin = $conn->query($sql_admin);
?>
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
        <div>
        <h1>WELCOME TO PLAYSTATION RENTAL 24</h1> 
        <h4>Segera daftarkan dirimu menjadi bagian member kita!!</h4>
        <h4>Tersedia berbagai macam PS dan Game terbaru 2024</h4>
        <h4>HAPPY NEW YEAR!!</h4>
        </div>
        <div class="container-fluid p-3">
            <div class="row justify-content-center">
                <!-- Gambar pertama -->
                <div class="col-12 col-md-4 mb-4">
                    <div class="card shadow-lg" onclick="window.location.href='#';" data-bs-toggle="modal" data-bs-target="#adminModal">
                        <img src="ps6.jpg" alt="Deskripsi Gambar" class="card-img-top" style="height: 300px; object-fit: cover;">
                        <div class="card-body">
                            <p class="card-text">Click to manage admin</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-4">
                    <div class="card shadow-lg" onclick="window.location.href='game.html';">
                        <img src="ps4.jpg" alt="Deskripsi Gambar" class="card-img-top" style="height: 300px; object-fit: cover;">
                        <div class="card-body">
                        <p class="card-text">The latest information</p>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Admin Management -->
<div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminModalLabel">Manajemen Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h2>Anggota Admin</h2>
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Anggota</button>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID Admin</th>
                                <th>Nama Admin</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_admin->num_rows > 0) {
                                while($row = $result_admin->fetch_assoc()) {
                                    echo "<tr>
                                            <td>".$row['id_admin']."</td>
                                            <td>".$row['nama_admin']."</td>
                                            <td>".$row['username']."</td>
                                            <td>".$row['password']."</td>
                                            <td>
                                                <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal' data-id='".$row['id_admin']."' data-nama='".$row['nama_admin']."' data-username='".$row['username']."' data-password='".$row['password']."'>Edit</button>
                                                <a href='?delete=".$row['id_admin']."' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>Tidak ada data admin</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Tambah Anggota -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="nama_admin" class="form-label">Nama Admin</label>
                        <input type="text" class="form-control" id="nama_admin" name="nama_admin" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" name="submit_anggota" class="btn btn-primary">Tambah Anggota</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Anggota -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" id="id_admin" name="id_admin">
                    <div class="mb-3">
                        <label for="edit_nama_admin" class="form-label">Nama Admin</label>
                        <input type="text" class="form-control" id="edit_nama_admin" name="nama_admin" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="edit_username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="edit_password" name="password" required>
                    </div>
                    <button type="submit" name="update_anggota" class="btn btn-primary">Update Anggota</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var editModal = document.getElementById('editModal')
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget
        var id_admin = button.getAttribute('data-id')
        var nama_admin = button.getAttribute('data-nama')
        var username = button.getAttribute('data-username')
        var password = button.getAttribute('data-password')

        var modalId = editModal.querySelector('.modal-body #id_admin')
        var modalNama = editModal.querySelector('.modal-body #edit_nama_admin')
        var modalUsername = editModal.querySelector('.modal-body #edit_username')
        var modalPassword = editModal.querySelector('.modal-body #edit_password')

        modalId.value = id_admin
        modalNama.value = nama_admin
        modalUsername.value = username
        modalPassword.value = password
    })
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
