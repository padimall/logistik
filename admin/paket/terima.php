<?php 
include('../template/curl.php'); 
include('../../config.php');
include('../template/head.php');
on_system();
$token = $_SESSION['access_token']; 

if(isset($_POST['btn-terima']))
{
    $packageReceive = getData(api_url()."/api/v1/tracking/receive",$token,$_POST);

    $send = array(
        'target_id' => $_POST['package_id']
    );

    $tracking = getData(api_url()."/api/v1/tracking/package",$token,$send);
    $tracking = json_decode($tracking,true);
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
                                <h3>Paket
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
                                <h5>Terima Paket</h5><br>                   
                                <form method="POST">
                                    <div class="form">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" name="package_id" placeholder="Nomor Resi">
                                                    <?php 
                                                        if(empty($tracking['data']) && isset($_POST['btn-terima'])){
                                                            echo '<p style="color: red;">Nomor resi tidak ditemukan!</p>';
                                                        }
                                                        else if(isset($_POST['btn-terima']) && !empty($tracking['data'])){
                                                            echo '<p style="color: red;">Berhasil ditambahkan!</p>';
                                                        }
                                                    ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <button class="btn btn-primary btn-sm" name="btn-terima">Terima</button>
                                                </div>
                                            </div>
                                        </div>                                
                                    </div>
                                </form>             
                            </div>
                            <div class="card-body">
                                <div id="basicScenario" class="product-list">
                                    <?php 
                                    
                                    if(isset($_POST['btn-terima']) && !empty($tracking['data'])){ 
                                        $tracking = $tracking['data'];
                                        ?>   
                                        <table id="example" class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Lokasi</th>
                                                    <th>Detail</th>
                                                    <th>Waktu</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    for($i=0; $i<sizeof($tracking); $i++)
                                                    {
                                                ?>
                                            
                                                <tr>
                                                    <td><?= $tracking[$i]['location'] ?></td>
                                                    <td><?= $tracking[$i]['detail'] ?></td>
                                                    <td><?= $tracking[$i]['created_at'] ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } ?>
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

<?php include('../template/script.php') ?>

</body>
</html>
