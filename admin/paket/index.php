<?php 
include('../template/curl.php'); 
include('../../config.php');
include('../template/head.php');
on_system();
$token = $_SESSION['access_token']; 

if(isset($_POST['btn-save-package']))
{
    $_POST['weight'] = preg_replace('/\./','',$_POST['weight']);
    $_POST['weight'] = preg_replace('/\,/','',$_POST['weight']);
    $_POST['price'] = preg_replace('/\./','',$_POST['price']);
    $_POST['price'] = preg_replace('/\,/','',$_POST['price']);

    $savePackage = getData(api_url()."/api/v1/package/store",$token,$_POST);    
    $savePackage = json_decode($savePackage,true);
    
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
                                <h3>Paket <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-original-title="test" data-target="#addPackage">Tambah Paket Baru</button>
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

            <?php if(isset($savePackage['resi'])){ 
                ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="badge badge-success">Paket berhasil ditambahkan!</h4><br>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form">
                                            <div class="form-group mb-0">
                                                <label for="validationCustom02" class="mb-1">Nomor Resi : </label>
                                                <input class="form-control" value="<?php echo $savePackage['resi'] ?>" type="text" required readonly>
                                                <img src="<?php echo 'generate.php?id='.$savePackage['resi']; ?>">   
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>

            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Daftar paket </h5>                          
                            </div>
                            <div class="card-body">
                                <div id="basicScenario" class="product-list">
                                    <div class="table-responsive">
                                        <table id="example" class="display jsgrid-table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No Resi</th>
                                                    <th>Penerima</th>
                                                    <th>Kontak Penerima</th>
                                                    <th>Asal</th>
                                                    <th>Alamat </th>
                                                    <th>Tujuan</th>
                                                    <th>Layanan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $data = getData(api_url()."/api/v1/package/all",$token,NULL);
                                                    $data = json_decode($data,true);
                                                    if(!empty($data['data'])){
                                                        $data = $data['data'];
                                                        for($i=0; $i<sizeof($data); $i++)
                                                        {
                                                
                                                ?>
                                            
                                                <tr>
                                                    <td><?= $data[$i]['no_resi'] ?></td>
                                                    <td><?= $data[$i]['receiver']; ?></td>
                                                    <td><?= $data[$i]['receiver_contact']; ?></td>
                                                    <td><?= $data[$i]['receiver_city']; ?></td>
                                                    <td><?= $data[$i]['address'] ?></td>
                                                    <td><?= $data[$i]['origin']; ?></td>
                                                    <td><?= $data[$i]['service_name'] ?></td>
                                                    <td><button type="button" class="btn btn-sm btn-secondary qrbutton" data-toggle="modal" data-original-title="test" data-resi="<?php echo $data[$i]['no_resi']?>" data-target="#showQr">QR</button></td>
                                                    
                                                </tr>
                                                <?php }} ?>
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
                            <select name="service_id" id="service_price" class="form-control" required>
                                <option disabled selected>-- Silahkan pilih layanan --</option>
                            <?php 
                            $data = getData(api_url()."/api/v1/service/all",$token,NULL);
                            $data = json_decode($data,true);
                            $data = $data['data'];
                            
                            for($i=0; $i<sizeof($data); $i++)
                            {
                            ?>
                                <option value='<?= $data[$i]['id'];?>' data-price='<?= $data[$i]['price'];?>'><?= $data[$i]['name'].' ['.$data[$i]['detail'].']'?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Jenis Paket</label>
                            <select class="form-control" name="type" required>
                                <option selected disabled>-- Silahkan Pilih Jenis Paket --</option>
                                <option value="Makanan">Makanan</option>
                                <option value="Elektronik">Elektronik</option>
                                <option value="Pakaian">Pakaian</option>
                            </select>
                        </div>
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Pengirim</label>
                            <input class="form-control" name="sender" type="text" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Kontak Pengirim</label>
                            <input class="form-control phoneNumber" name="sender_contact" type="text" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Penerima</label>
                            <input class="form-control" name="receiver" type="text" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Kontak Penerima</label>
                            <input class="form-control phoneNumber" name="receiver_contact" type="text" required>
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
                            <input class="form-control phoneNumber" name="receiver_post_code" type="text" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Alamat Penerima</label>
                            <input class="form-control" name="address" type="text" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Berat Paket</label>
                            <div class="input-group">
                                <input class="form-control numberFormat" value="0" id="weight" name="weight" type="text" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Kg </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label for="validationCustom02" class="mb-1">Ongkos Kirim</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp </div>
                                </div>
                                <input class="form-control numberFormat" value="0" id="price" name="price" type="text" required readonly>
                            </div>
                        </div>

                    </div>
                
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" name="btn-save-package" id="btn-save-package">Simpan</button>
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="showQr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title f-w-600" id="exampleModalLabel">QR Code</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="form">
                    <div class="form-group mb-0">
                        <p id="lblqr"></p>
                        <img src="" id="qrcode" class="form-group" >
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?php include('../template/script.php') ?>
<script>
    $('#service_price').on('change',function(){
        var price = $('option:selected',this).attr('data-price');
        var weight = parseInt($('#weight').val().replace(/\D/g,''),10); 
        var total = price*weight;
        if(isNaN(total)) total = 0;
        $('#price').val(total.toLocaleString());
    })

    $('#weight').on('keyup',function(){
        var price = $('#service_price option:selected').attr('data-price');
        var weight = parseInt($('#weight').val().replace(/\D/g,''),10); 
        var total = price*weight;

        if(isNaN(total)) total = 0;
        $('#price').val(total.toLocaleString());
    })

    $('.qrbutton').on('click',function(){
        var resi = $(this).data('resi');
        $('#qrcode').attr('src','generate?id='+resi);
        $('#lblqr').html('Nomor Resi : '+resi);
    })
</script>
</body>
</html>
