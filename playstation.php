<?php
include 'koneksi.php';

// Tambah data
if (isset($_POST['tambah'])) {
    $jenis_ps = $_POST['jenis_ps'];
    $nomor_seri = $_POST['nomor_seri'];
    $status_ps = $_POST['status_ps'];

    $sql_tambah = "INSERT INTO playstation (jenis_ps, nomor_seri, status_ps) VALUES ('$jenis_ps', '$nomor_seri', '$status_ps')";
    $conn->query($sql_tambah);
    header("Location: playstation.php");
}

// Hapus data
if (isset($_GET['hapus'])) {
    $id_ps = $_GET['hapus'];
    $sql_hapus = "DELETE FROM playstation WHERE id_ps = $id_ps";
    $conn->query($sql_hapus);
    header("Location: playstation.php");
}

// Edit data
if (isset($_POST['edit'])) {
    $id_ps = $_POST['id_ps'];
    $jenis_ps = $_POST['jenis_ps'];
    $nomor_seri = $_POST['nomor_seri'];
    $status_ps = $_POST['status_ps'];

    $sql_edit = "UPDATE playstation SET jenis_ps='$jenis_ps', nomor_seri='$nomor_seri', status_ps='$status_ps' WHERE id_ps = $id_ps";
    $conn->query($sql_edit);
    header("Location: playstation.php");
}

// Pencarian data
$search_query = "";
if (isset($_POST['search'])) {
    $search_query = $_POST['search'];
}
$sql_playstation = "SELECT * FROM playstation WHERE jenis_ps LIKE '%$search_query%' OR nomor_seri LIKE '%$search_query%' OR status_ps LIKE '%$search_query%'";
$result_playstation = $conn->query($sql_playstation);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlayStation Rental 2024</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url("bg5.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
        }
        table, th, td {
            border: 1px solid white;
            padding: 10px;
            text-align: center;
        }
        table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse; /* Merge table borders */
    background-color: rgba(0, 0, 0, 0.6); /* Semi-transparent background for the table */
    color: white; /* White text for better visibility */
}

th, td {
    padding: 15px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.5); /* Lighter borders */
}

thead {
    background-color: rgba(218, 48, 133, 0.8); /* Slightly transparent pink for header */
}

tbody tr:hover {
    background-color: rgba(218, 48, 133, 0.3); /* Light pink on row hover */
}

button.btn-sm {
    font-size: 12px;
    padding: 5px 10px;
}

.navbar {
    background-color: rgba(218, 48, 133, 0.75); /* Adjusted to match sidebar */
}

.modal-content {
    background-color: rgba(0, 0, 0, 0.85); /* Darker modal background */
    color: white;
}

.modal-header, .modal-footer {
    background-color: rgba(218, 48, 133, 0.8); /* Consistent modal header and footer color */
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
            <h1><span class="navbar-brand" style="color: pink;">PlayStation Room</span></h1>
            </div>
        </nav>
        <div>
<div class="container mt-4">
    <h1 class="text-center">PlayStation Room</h1>
    <form method="POST" class="d-flex mb-3">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari data..." value="<?= $search_query ?>">
        <button type="submit" class="btn btn-outline-light">Cari</button>
    </form>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Data</button>

    <table>
        <thead>
            <tr>
                <th>ID PlayStation</th>
                <th>Jenis PS</th>
                <th>Nomor Seri</th>
                <th>Status PS</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_playstation->num_rows > 0) {
                while ($row = $result_playstation->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id_ps']}</td>
                        <td>{$row['jenis_ps']}</td>
                        <td>{$row['nomor_seri']}</td>
                        <td>{$row['status_ps']}</td>
                        <td>
                            <button class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#editModal{$row['id_ps']}'>Edit</button>
                            <a href='playstation.php?hapus={$row['id_ps']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Hapus data ini?\")'>Hapus</a>
                        </td>
                    </tr>";

                    // Modal Edit
                    echo "<div class='modal fade' id='editModal{$row['id_ps']}' tabindex='-1'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title'>Edit Data PlayStation</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                </div>
                                <form method='POST'>
                                    <div class='modal-body'>
                                        <input type='hidden' name='id_ps' value='{$row['id_ps']}'>
                                        <input type='text' name='jenis_ps' class='form-control mb-2' value='{$row['jenis_ps']}' placeholder='Jenis PS'>
                                        <input type='text' name='nomor_seri' class='form-control mb-2' value='{$row['nomor_seri']}' placeholder='Nomor Seri'>
                                        <input type='text' name='status_ps' class='form-control mb-2' value='{$row['status_ps']}' placeholder='Status PS'>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='submit' name='edit' class='btn btn-primary'>Simpan</button>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "<tr><td colspan='5'>Tidak ada data.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class='modal-title'>Tambah Data PlayStation</h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="text" name="jenis_ps" class="form-control mb-2" placeholder="Jenis PS">
                    <input type="text" name="nomor_seri" class="form-control mb-2" placeholder="Nomor Seri">
                    <input type="text" name="status_ps" class="form-control mb-2" placeholder="Status PS">
                </div>
                <div class="modal-footer">
                    <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss='modal'>Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
