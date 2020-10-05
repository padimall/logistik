<?php 
include('../template/curl.php'); 
include('../../config.php');
include('../template/head.php');
on_system();
$token = $_SESSION['access_token']; 

if(isset($_POST['btn-save-package']))
{
    $data = getData(api_url()."/api/v1/package/store",$token,$_POST);    
}

?>
<body>

<!-- page-wrapper Start-->
<div class="page-wrapper">

    <?php include('../template/navbar.php') ?>

    <!-- Page Body Start-->
    <div class="page-body-wrapper">

        <?php include('../template/sidebar.php');?>

        <div class="page-body">
            <!-- Content start here -->
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="page-header-left">
                                <h3>Paket <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-original-title="test" data-target="#addPackage">Tambah Paket</button>
                                    <small>Padistic Admin panel</small>
                                </h3>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ol class="breadcrumb pull-right">
                                <li class="breadcrumb-item"><a href="index.html"><i data-feather="home"></i></a></li>
                                <li class="breadcrumb-item active">Paket</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->

            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Daftar Paket</h5>                                
                            </div>
                            <div class="card-body">
                                <div id="basicScenario" class="product-list">
                                    <table id="example" class="display jsgrid-table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No Resi</th>
                                                <th>Layanan</th>
                                                <th>Jenis </th>
                                                <th>Asal</th>
                                                <th>Tujuan</th>
                                                <th>Penerima</th>
                                                <th>Kontak Penerima</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $data = getData(api_url()."/api/v1/package/all",$token,NULL);
                                                $data = json_decode($data,true);
                                                $data = $data['data'];
                                                for($i=0; $i<sizeof($data); $i++)
                                                {
                                            
                                            ?>
                                        
                                            <tr>
                                                <td><?= $data[$i]['id'] ?></td>
                                                <td><?= $data[$i]['service_name'] ?></td>
                                                <td><?= $data[$i]['type'] ?></td>
                                                <td><?= $data[$i]['origin']; ?></td>
                                                <td><?= $data[$i]['receiver_city']; ?></td>
                                                <td><?= $data[$i]['receiver']; ?></td>
                                                <td><?= $data[$i]['receiver_contact']; ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        

        <?php include('../template/footer.php');?>
    </div>

</div>
<div class="modal fade" id="addPackage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title f-w-600" id="exampleModalLabel">Tambah Paket</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" method="POST" >
                    <div class="form">
                        <div class="form-group">
                            <label for="validationCustom01" class="mb-1">Layanan</label>
                            <select name="service_id" class="form-control" required>
                                <option disabled selected>-- Silahkan pilih layanan --</option>
                            <?php 
                            $data = getData(api_url()."/api/v1/service/all",$token,NULL);
                            $data = json_decode($data,true);
                            $data = $data['data'];
                            
                            for($i=0; $i<sizeof($data); $i++)
                            {
                            ?>
                                <option value='<?= $data[$i]['id'];?>'><?= $data[$i]['name'].' ['.$data[$i]['detail'].']'?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Jenis Paket</label>
                            <input class="form-control" name="type" type="text" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Pengirim</label>
                            <input class="form-control" name="sender" type="text" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Kontak Pengirim</label>
                            <input class="form-control" name="sender_contact" type="text" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Penerima</label>
                            <input class="form-control" name="receiver" type="text" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Kontak Penerima</label>
                            <input class="form-control" name="receiver_contact" type="text" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Provinsi Penerima</label>
                            <input class="form-control" name="receiver_province" type="text" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Kota/Kabupaten Penerima</label>
                            <input class="form-control" name="receiver_city" type="text" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Kecamatan Penerima</label>
                            <input class="form-control" name="receiver_district" type="text" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Kode Pos Penerima</label>
                            <input class="form-control" name="receiver_post_code" type="text" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Alamat Penerima</label>
                            <input class="form-control" name="address" type="text" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Berat Paket</label>
                            <input class="form-control" name="weight" type="text" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Ongkos Kirim</label>
                            <input class="form-control" name="price" type="text" required>
                        </div>

                    </div>
                
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" name="btn-save-package" id="btn-save-package">Simpan</button>
                <button class="btn btn-danger" type="button" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php include('../template/script.php') ?>

</body>
</html>
