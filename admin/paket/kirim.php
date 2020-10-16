<?php 
include('../template/curl.php'); 
include('../../config.php');
include('../template/head.php');
on_system();
$token = $_SESSION['access_token']; 
$message = '';
$badge = 'success';

if(isset($_POST['btn-kirim']))
{
    $packageSend = getData(api_url()."/api/v1/tracking/send",$token,$_POST);
    $packageSend = json_decode($packageSend,true);

    // $send = array(
    //     'target_id' => $_POST['target_id']
    // );

    
}

if(isset($_POST['btn-mass-kirim']))
{
    $testing = array(
        'list' => $_POST['checkPackage'],
        'destination' => $_POST['destination2']
    );
    $multiple = getData(api_url()."/api/v1/tracking/mutiple-send",$token,$testing);
    $multiple = json_decode($multiple,true);
}
$package = getData(api_url()."/api/v1/package/all",$token,NULL);
$package = json_decode($package,true);

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
                                <h5>Kirim Paket</h5><br>                   
                                <form method="POST" id="formCheckSingle">
                                    <div class="form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nomor Resi</label>
                                                    <input type="text" class="form-control" name="target_id" placeholder="Masukkan nomor resi" required>
                                                    <?php 
                                                        if(isset($_POST['btn-mass-kirim'])){
                                                            if(isset($multiple['status']))
                                                            {
                                                                if($multiple['status']==1){
                                                                    $message = 'Sukses!';
                                                                }
                                                            }
                                                        }
                                                        if(isset($_POST['btn-kirim'])){
                                                            if(isset($packageSend['status'])){
                                                                if($packageSend['status']==0){
                                                                    $badge = 'warning';
                                                                    $message = 'Paket tidak disini!';
                                                                }
                                                                else if($packageSend['status']==1){
                                                                    $message= 'Paket berhasil dikirim!';
                                                                }
                                                            }
                                                            else {
                                                                $message = 'Nomor resi tidak ditemukan!';
                                                                $badge = 'danger';
                                                            }
                                                        }
                                                    ?>
                                                    <p id='resi_message' class="badge badge-<?= $badge?>"><?= $message?></p>
                                                </div>
                                                <div class="form-group">
                                                    <label>Destinasi</label>
                                                    <select name="destination" id="destination" class="form-control" required>
                                                        <option disabled selected>-- Silahkan pilih destinasi paket --</option>
                                                        <?php 
                                                        $data = getData(api_url()."/api/v1/destination/all",$token,NULL);
                                                        $data = json_decode($data,true);
                                                        if(isset($data['data'])){
                                                            $data = $data['data'];
                                                            for($i=0; $i<sizeof($data); $i++)
                                                            {
                                                        ?>
                                                        <option value="<?= $data[$i]['city']?>"><?= $data[$i]['city'].' ['.$data[$i]['country'].', '.$data[$i]['province'].']'?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <button class="btn btn-primary btn-sm" name="btn-kirim">Kirim Paket</button>
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
                                    
                                    if(!empty($package['data'])){ 
                                        $package = $package['data'];
                                        ?>   
                                        <p style="font-size : 15px" class="badge badge-warning form-control" id="message2"></p>
                                        <form method="POST" id="formMultiSend">
                                            <input type="hidden" name="destination2" id="destination2">
                                            <div class="table-responsive">
                                                <table id="example" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th><button class="btn btn-primary btn-sm" name="btn-mass-kirim">Kirim Paket</button></th>
                                                            <th>No Resi</th>
                                                            <th>Asal</th>
                                                            <th>Tujuan</th>
                                                            <th>Waktu</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            for($i=0; $i<sizeof($package); $i++)
                                                            {
                                                        ?>
                                                    
                                                        <tr>
                                                            <td><input type="checkbox" value="<?= $package[$i]['no_resi'] ?>" name="checkPackage[]"></td>
                                                            <td><?= $package[$i]['no_resi'] ?></td>
                                                            <td><?= $package[$i]['origin'] ?></td>
                                                            <td><?= $package[$i]['receiver_city'] ?></td>
                                                            <td><?= dateIndo($package[$i]['created_at']) ?></td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<div class="modal fade" id="scanPackage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" id="scanPackage2">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title f-w-600" id="exampleModalLabel">Scan Paket</h5>
                <input type="hidden" id="reloadChecker" value="0">
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
    $(function(){
        $('#scanPackage').on('hide.bs.modal',function(e){
            if($('#reloadChecker').val()=="1")
            {
                window.location.href = 'kirim';
            }
        })
    })

    $('#destination').on('change',function(){
        $('#destination2').val($('#destination').val());
        $('#message2').html('');
    })

    $('#formCheckSingle').on('submit',function(){
        if($('input[name="target_id"').val() == ''){
            return false;
        }
    })

    $('#formMultiSend').on('submit',function(){
        if($('#destination').val()===null){
            $('#message2').html('Silahkan pilih destinasi!')
            return false;
        }
        else {
            if(!$('input[name="checkPackage[]"]').is(":checked")){
                $('#message2').html('Silahkan ceklis minimal 1 paket!')
                return false;
            }
        }
    })

    function onScanSuccess(qrCodeMessage) {
	// handle on success condition with the decoded message
    if($('#destination').val() !== null)
    {
        $.ajax({
            'url' : 'action-kirim.php',
            'method' : 'POST',
            'dataType' : 'json',
            'data' : {
                'target_id' : qrCodeMessage,
                'destination' : $('#destination').val(),
            },
            success : function(data){
                if(typeof data.status !== 'undefined'){
                    if(data.status == 1){
                        $('#message').html('Paket berhasil dikirim!');
                        $('#message').removeClass('badge-danger');
                        $('#message').addClass('badge-secondary');
                        $('#reloadChecker').val("1");
                    }
                    else if(data.status == 0)
                    {
                        $('#message').html('Paket tidak disini!');
                        $('#message').removeClass('badge-secondary');
                        $('#message').addClass('badge-danger');
                    }   
                }
                else {
                    $('#message').html('Nomor resi tidak terdaftar!');
                    $('#message').removeClass('badge-secondary');
                    $('#message').addClass('badge-danger');
                }
                setTimeout(function(){ $('#message').html(''); }, 2000);
            }
        });
    }
    else {
        $('#message').html('Silahkan pilih destinasi terlebih dahulu!');
        $('#message').removeClass('badge-secondary');
        $('#message').addClass('badge-danger');
        setTimeout(function(){ $('#message').html(''); }, 2000);
    }
}

    var html5QrcodeScanner = new Html5QrcodeScanner(
	"reader", { fps: 7, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);
</script>
</body>
</html>
