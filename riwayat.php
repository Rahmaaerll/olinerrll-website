<?php
include 'koneksi.php';

// Query untuk mengambil data dari tabel denda
$sql_denda = "SELECT * FROM denda";
$result_denda = $conn->query($sql_denda);
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
            background-image: url("bg5.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
        }
        #sidebar {
            background-color: rgba(218, 48, 133, 0.53);
            height: 100vh;
            position: fixed;
            width: 250px;
            padding-top: 20px;
            padding-bottom: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            z-index: 999;
        }
        #sidebar .sidebar-heading {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            text-align: center;
            padding-bottom: 30px;
        }
        #sidebar .list-group-item {
            background-color: transparent;
            color: white;
            border: none;
            padding: 15px 20px;
            font-size: 1.1rem;
            text-align: left;
        }
        #sidebar .list-group-item:hover {
            background-color: rgba(218, 48, 133, 0.8);
            cursor: pointer;
        }
        #sidebar .list-group-item.active {
            background-color: rgba(218, 48, 133, 1);
            font-weight: bold;
        }
        #page-content-wrapper {
            margin-left: 250px;
            padding: 20px;
        }
        .navbar {
            background-color: rgba(219, 31, 119, 0.75);
            padding-top: 2rem;
            padding-bottom: 1rem;
        }
        .navbar .navbar-brand {
            color: white;
            font-size: 1.5rem;
        }
        .table th, .table td {
            text-align: center;
        }
        .modal-body input {
            margin-bottom: 1rem;
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

    </style>
</head>
<body>
<div class="d-flex" id="wrapper">
    <div class="bg-expand-lg" id="sidebar">
        <div class="sidebar-heading text-white p-4">PlayStation Rental</div>
        <div class="list-group list-group-flush">
            <a href="index.php" class="list-group-item list-group-item-action text-white bg-expand-lg">Dashboard</a>
            <a href="playstation.php" class="list-group-item list-group-item-action text-white bg-expand-lg">PlayStation Room</a>
            <a href="member.php" class="list-group-item list-group-item-action text-white bg-expand-lg">Join Member</a>
            <a href="pinjam.php" class="list-group-item list-group-item-action text-white bg-expand-lg">Peminjaman PlayStation</a>
            <a href="riwayat.php" class="list-group-item list-group-item-action text-white bg-expand-lg">Riwayat Penggunaan</a>
        </div>
    </div>
    <div id="page-content-wrapper" class="w-100">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <h1><span class="navbar-brand">PlayStation Denda Pelanggan</span></h1>
                <form class="d-flex ms-auto" id="searchForm">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="searchInput">
                    <button class="btn btn-outline-light" type="submit">Pencarian..</button>
                </form>
            </div>
        </nav>
        <div>
            <h2>Denda Member PlayStation Rental 24</h2>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahDataModal">Tambah Data</button>
            <table>
                <thead>
                    <tr>
                        <th>ID Denda</th>
                        <th>Id Peminjaman</th>
                        <th>Jumlah Denda</th>
                        <th>Tanggal Dibayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_denda->num_rows > 0) {
                        while($row = $result_denda->fetch_assoc()) {
                            echo "<tr>
                                    <td>".$row['id_denda']."</td>
                                    <td>".$row['id_peminjaman']."</td>
                                    <td>".$row['jumlah_denda']."</td>
                                    <td>".$row['tanggal_dibayar']."</td>
                                    <td>
                                        <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal".$row['id_denda']."'>Edit</button>
                                        <a href='hapus_data.php?id=".$row['id_denda']."' class='btn btn-danger btn-sm'>Hapus</a>
                                    </td>
                                  </tr>";
                            echo "<!-- Modal Edit Data -->
                                  <div class='modal fade' id='editModal".$row['id_denda']."' tabindex='-1' aria-labelledby='editModalLabel".$row['id_denda']."' aria-hidden='true'>
                                      <div class='modal-dialog'>
                                          <div class='modal-content'>
                                              <div class='modal-header'>
                                                  <h5 class='modal-title' id='editModalLabel".$row['id_denda']."'>Edit Data Denda</h5>
                                                  <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                              </div>
                                              <form action='edit_data.php' method='POST'>
                                                  <div class='modal-body'>
                                                      <input type='hidden' name='id_denda' value='".$row['id_denda']."'>
                                                      <div class='mb-3'>
                                                          <label for='idPeminjaman' class='form-label'>ID Peminjaman</label>
                                                          <input type='text' class='form-control' name='id_peminjaman' value='".$row['id_peminjaman']."'>
                                                      </div>
                                                      <div class='mb-3'>
                                                          <label for='jumlahDenda' class='form-label'>Jumlah Denda</label>
                                                          <input type='number' class='form-control' name='jumlah_denda' value='".$row['jumlah_denda']."'>
                                                      </div>
                                                      <div class='mb-3'>
                                                          <label for='tanggalDibayar' class='form-label'>Tanggal Dibayar</label>
                                                          <input type='date' class='form-control' name='tanggal_dibayar' value='".$row['tanggal_dibayar']."'>
                                                      </div>
                                                  </div>
                                                  <div class='modal-footer'>
                                                      <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                                      <button type='submit' class='btn btn-primary'>Save Changes</button>
                                                  </div>
                                              </form>
                                          </div>
                                      </div>
                                  </div>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data pelanggan</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Denda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="tambah_data.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="idPeminjaman" class="form-label">ID Peminjaman</label>
                        <input type="text" class="form-control" name="id_peminjaman" required>
                    </div>
                    <div class="mb-3">
                        <label for="jumlahDenda" class="form-label">Jumlah Denda</label>
                        <input type="number" class="form-control" name="jumlah_denda" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggalDibayar" class="form-label">Tanggal Dibayar</label>
                        <input type="date" class="form-control" name="tanggal_dibayar" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
