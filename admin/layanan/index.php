<?php 
include('../template/curl.php'); 
include('../../config.php');
include('../template/head.php');
on_system();
$token = $_SESSION['access_token']; 

if(isset($_POST['btn-save-service']))
{
    $data = getData(api_url()."/api/v1/service/store",$token,$_POST);    
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
                                <h3>Layanan <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-original-title="test" data-target="#addService">Tambah Layanan</button>
                                    <small>Padistic Admin panel</small>
                                </h3>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ol class="breadcrumb pull-right">
                                <li class="breadcrumb-item"><a href="index.html"><i data-feather="home"></i></a></li>
                                <li class="breadcrumb-item active">Layanan</li>
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
                                <h5>Daftar Layanan</h5>                                
                            </div>
                            <div class="card-body">
                                <div id="basicScenario" class="product-list">
                                    <div class="table-responsive">
                                        <table id="example" class="display jsgrid-table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Nama Layanan</th>
                                                    <th>Detail </th>
                                                    <th>Harga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $data = getData(api_url()."/api/v1/service/all",$token,NULL);
                                                    $data = json_decode($data,true);
                                                    $data = $data['data'];
                                                    for($i=0; $i<sizeof($data); $i++)
                                                    {
                                                
                                                ?>
                                            
                                                <tr>
                                                    <td><?= $data[$i]['name'] ?></td>
                                                    <td><?= $data[$i]['detail'] ?></td>
                                                    <td><?= $data[$i]['price']; ?></td>
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

        </div>
        

        <?php include('../template/footer.php');?>
    </div>

</div>
<div class="modal fade" id="addService" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title f-w-600" id="exampleModalLabel">Tambah Layanan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" method="POST" >
                    <div class="form">
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Nama Layanan</label>
                            <input class="form-control" name="name" type="text" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Detail</label>
                            <input class="form-control" name="detail" type="text" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Harga</label>
                            <input class="form-control" name="price" type="text" required>
                        </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" name="btn-save-service" id="btn-save-service">Simpan</button>
                <button class="btn btn-danger" type="button" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php include('../template/script.php') ?>

</body>
</html>
