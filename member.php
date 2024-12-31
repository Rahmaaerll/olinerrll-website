<?php
include 'koneksi.php';

// Fungsi untuk tambah data
if (isset($_POST['tambah'])) {
    
    $nama_lengkap = $_POST['nama_lengkap'];
    $no_telepon = $_POST['no_telepon'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $status_pelanggan = $_POST['status_pelanggan'];

    $sql_tambah = "INSERT INTO pelanggan (nama_lengkap, no_telepon, email, alamat, status_pelanggan)
                   VALUES ('$nama_lengkap', '$no_telepon', '$email', '$alamat', '$status_pelanggan')";
    $conn->query($sql_tambah);
}

// Fungsi untuk edit data
if (isset($_POST['edit'])) {
    $id_pelanggan = $_POST['id_pelanggan'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $no_telepon = $_POST['no_telepon'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $status_pelanggan = $_POST['status_pelanggan'];

    $sql_edit = "UPDATE pelanggan SET 
                    nama_lengkap='$nama_lengkap', 
                    no_telepon='$no_telepon', 
                    email='$email', 
                    alamat='$alamat', 
                    status_pelanggan='$status_pelanggan' 
                    WHERE id_pelanggan='$id_pelanggan'";
    $conn->query($sql_edit);
}

// Fungsi untuk hapus data
if (isset($_GET['hapus'])) {
    $id_pelanggan = $_GET['hapus'];
    $sql_hapus = "DELETE FROM pelanggan WHERE id_pelanggan='$id_pelanggan'";
    $conn->query($sql_hapus);
}

// Fungsi untuk mencari data
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $sql_pelanggan = "SELECT * FROM pelanggan WHERE nama_lengkap LIKE '%$search_query%' OR id_pelanggan LIKE '%$search_query%'";
} else {
    $sql_pelanggan = "SELECT * FROM pelanggan";
}

$result_pelanggan = $conn->query($sql_pelanggan);
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
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
        .modal-body input {
            margin-bottom: 1rem;
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
            <h1><span class="navbar-brand" style="color: pink;">PlayStation Rental</span></h1>
                <form class="d-flex ms-auto" id="searchForm">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="searchInput">
                    <button class="btn btn-outline-light" type="submit">Pencarian..</button>
                </form>
            </div>
        </nav>
        <div>
<div class="container mt-5">
    <h2>Data Member PlayStation Rental 2024</h2>
    
    <!-- Form tambah data -->
    <form method="POST" action="">
        <h4>Tambah Data Pelanggan</h4>
        <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required>
        <input type="text" name="no_telepon" placeholder="No Telepon" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="alamat" placeholder="Alamat" required>
        <input type="text" name="status_pelanggan" placeholder="Status Pelanggan" required>
        <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
    </form>

    <br>
    
    <!-- Pencarian -->
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Cari..." value="<?php echo $search_query; ?>" class="form-control" required>
        <button type="submit" class="btn btn-outline-light">Cari</button>
    </form>
    <br>

    <!-- Tabel data -->
    <table class="table">
        <thead>
            <tr>
                <th>ID Pelanggan</th>
                <th>Nama Lengkap</th>
                <th>No Telepon</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Tanggal Daftar</th>
                <th>Status Pelanggan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_pelanggan->num_rows > 0) {
                while($row = $result_pelanggan->fetch_assoc()) {
                    echo "<tr>
                            <td>".$row['id_pelanggan']."</td>
                            <td>".$row['nama_lengkap']."</td>
                            <td>".$row['no_telepon']."</td>
                            <td>".$row['email']."</td>
                            <td>".$row['alamat']."</td>
                            <td>".$row['tanggal_daftar']."</td>
                            <td>".$row['status_pelanggan']."</td>
                            <td>
                                <a href='edit.php?id=".$row['id_pelanggan']."' class='btn btn-warning'>Edit</a>
                                <a href='?hapus=".$row['id_pelanggan']."' class='btn btn-danger' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Tidak ada data pelanggan</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php
// Menutup koneksi
$conn->close();
?>