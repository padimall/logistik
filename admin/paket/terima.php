<?php 
include('../template/curl.php'); 
include('../../config.php');
include('../template/head.php');
on_system();
$token = $_SESSION['access_token']; 

if(isset($_POST['btn-terima']))
{
    $packageReceive = getData(api_url()."/api/v1/tracking/receive",$token,$_POST);
    $packageReceive = json_decode($packageReceive,true);
    
    $send = array(
        'target_id' => $_POST['target_id']
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
                                    <small>Padistik Admin panel</small>
                                </h3>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ol class="breadcrumb pull-right">
                                <li class="breadcrumb-item"><a href="<?= base_url().'/admin'?>"><i data-feather="home"></i></a></li>
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
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nomor Resi</label>
                                                    <input type="text" class="form-control" name="target_id" placeholder="Masukkan nomor resi" required>
                                                    <?php 
                                                        if(isset($_POST['btn-terima'])){
                                                            if(isset($packageReceive['status'])){
                                                                if($packageReceive['status']==0){
                                                                    echo '<p class="badge badge-warning">Paket telah disini!</p>';
                                                                }
                                                                else if($packageReceive['status']==1){
                                                                    echo '<p class="badge badge-success">Paket berhasil diterima!</p>';
                                                                }
                                                            }
                                                            else {
                                                                echo '<p class="badge badge-danger">Nomor resi tidak ditemukan!</p>';
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <button class="btn btn-primary btn-sm" name="btn-terima">Terima</button>
                                                    <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-original-title="test" data-target="#scanPackage">Scan Paket</button>
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
                                        <div class="table-responsive">
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
                                                        <td><?= dateIndo($tracking[$i]['created_at']) ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        

<div class="modal fade" id="scanPackage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title f-w-600" id="exampleModalLabel">Scan Paket</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="form">
                    <div style="width: 100%" id="reader"></div>
                    <p style="font-size : 20px" class="badge badge-secondary form-control" id="message"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
        <?php include('../template/footer.php');?>
    </div>

</div>

<?php include('../template/script.php') ?>
<script src="qr.js"></script>
<script>
function onScanSuccess(qrCodeMessage) {
	// handle on success condition with the decoded message
    $.ajax({
        'url' : 'action-terima.php',
        'method' : 'POST',
        'dataType' : 'json',
        'data' : {
            'target_id' : qrCodeMessage
        },
        success : function(data){
            if(typeof data.status !== 'undefined'){
                if(data.status == 1){
                    $('#message').html('Paket berhasil diterima!');
                }
                else if(data.status == 0)
                {
                    $('#message').html('Paket telah di sini!');
                }   
            }
            else {
                $('#message').html('Nomor resi tidak terdaftar!');
            }
            setTimeout(function(){ $('#message').html(''); }, 2000);
        }
    });
}

    var html5QrcodeScanner = new Html5QrcodeScanner(
	"reader", { fps: 7, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);
</script>
</body>
</html>
