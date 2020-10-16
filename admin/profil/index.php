<?php 
include('../template/curl.php'); 
include('../../config.php');
include('../template/head.php');
on_system();
$token = $_SESSION['access_token']; 
$message = '';
$message2 ='';
$show = 1;
$badge = 'danger';
$badge2 = 'danger';
if(isset($_POST['btn-save-profile']))
{
    $data = array();
    if(isset($_POST['name']))
        $data['name'] = $_POST['name'];
    if(isset($_POST['email']))
        $data['email'] = $_POST['email'];
    if(isset($_POST['phone']))
        $data['phone'] = $_POST['phone'];
    if(isset($_POST['origin']))
        $data['origin'] = strtoupper($_POST['origin']);
    if(isset($_POST['type']))
        $data['type'] = strtoupper($_POST['type']);    
    
    $saveProfile = getData(api_url()."/api/v1/user/update",$token,$data); 
    $saveProfile = json_decode($saveProfile,true);

    if(isset($saveProfile['errors']))
    {
        if(isset($saveProfile['errors']['email']))
        {
            $badge = 'danger';
            $message = 'Email telah digunakan';   
        }
        else if(isset($saveProfile['errors']['phone']))
        {
            $badge = 'danger';
            $message = 'No Telp/Hp telah digunakan';
        }
    }
    else if(isset($saveProfile['status']))
    {
        if(!empty($data)){
            $badge = 'primary';
            $message = 'Profil berhasil di update';
        }
        else {
            $badge = 'primary';
            $message = 'Tidak ada profil yang diubah';
        }
        
    }
}

if(isset($_POST['btn-update-password']))
{
    $show = 2;

    $data = array(
        'old_password' => $_POST['old_password'],
        'password' => $_POST['password'],
        'password_confirmation' => $_POST['password_confirmation']
    );

    $savePassword = getData(api_url()."/api/v1/user/update-password",$token,$data); 
    $savePassword = json_decode($savePassword,true);

    if(isset($savePassword['errors']))
    {
        if(isset($savePassword['errors']['password']))
        {
            $badge2 = 'danger';
            $message2 = 'Kata sandi minimal 8 karakter';   
        }
    }
    else if(isset($savePassword['status']))
    {
        if($savePassword['status'] == 0)
        {
            $badge2 = 'danger';
            $message2 = 'Kata sandi lama salah';   
        }
        else if($savePassword['status'] == 1)
        {
            $badge2 = 'primary';
            $message2 = 'Kata sandi berhasil di ganti'; 
        }
    }
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
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="page-header-left">
                                <h3>Profile
                                    <small>Padistik Admin panel</small>
                                </h3>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ol class="breadcrumb pull-right">
                                <li class="breadcrumb-item"><a href=""><i data-feather="home"></i></a></li>
                                <li class="breadcrumb-item">Profil</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->

            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="profile-details text-center">
                                    <img src="../assets/images/dashboard/designer.jpg" alt="" class="img-fluid img-90 rounded-circle blur-up lazyloaded">
                                    <h5 class="f-w-600 mb-0"><?= $user_data['name']?></h5>
                                    <span><?= $user_data['email']?></span>
                                </div>
                                <hr>
                                <div class="project-status">
                                    <h5 class="f-w-600">Employee Status</h5>
                                    <div class="media">
                                        <div class="media-body">
                                            <h6>Performance<span class="pull-right">80%</span></h6>
                                            <div class="progress sm-progress-bar">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 90%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="media-body">
                                            <h6>Overtime <span class="pull-right">60%</span></h6>
                                            <div class="progress sm-progress-bar">
                                                <div class="progress-bar bg-secondary" role="progressbar" style="width: 60%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="media-body">
                                            <h6>Leaves taken<span class="pull-right">70%</span></h6>
                                            <div class="progress sm-progress-bar">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 70%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card tab2-card">
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                                    <li class="nav-item"><a class="nav-link <?= $show == 1 ? 'active' : '' ?>" id="top-profile-tab" data-toggle="tab" href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="true"><i data-feather="user" class="mr-2"></i>Profil</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link <?= $show == 2 ? 'active' : '' ?>" id="contact-top-tab" data-toggle="tab" href="#top-contact" role="tab" aria-controls="top-contact" aria-selected="false"><i data-feather="settings" class="mr-2"></i>Kata Sandi</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="top-tabContent">
                                    <div class="tab-pane fade <?= $show == 1 ? 'show active' : '' ?>" id="top-profile" role="tabpanel" aria-labelledby="top-profile-tab">
                                        <h3 class="badge badge-<?= $badge?>"><?= $message?></h3>
                                        <form method="POST" action="" id="formProfile">
                                            <div class="container">
                                                <div class="form">
                                                    <div class="form-group">
                                                        <label>Nama</label>
                                                        <div class="input-group">
                                                            <input type='text' class='form-control form-control-sm form-profil' name='name' data-default='<?= $user_data['name'];?>' value='<?= $user_data['name'];?>' disabled>
                                                            <div class="input-group-prepend">
                                                                <button class="btn btn-primary btn-sm editProfil" type="button" data-name='name'>Edit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <div class="input-group">
                                                            <input type='email' class='form-control form-control-sm form-profil' name='email' data-default='<?= $user_data['email'];?>' value='<?= $user_data['email'];?>' disabled>
                                                            <div class="input-group-prepend">
                                                                <button class="btn btn-primary btn-sm editProfil" type="button" data-name='email'>Edit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>No Telp/Hp</label>
                                                        <div class="input-group">
                                                        <input type='text' class='form-control form-control-sm form-profil' name='phone' data-default='<?= $user_data['phone'];?>' value='<?= $user_data['phone'];?>' disabled>
                                                            <div class="input-group-prepend">
                                                                <button class="btn btn-primary btn-sm editProfil" type="button" data-name='phone'>Edit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Lokasi</label>
                                                        <div class="input-group">
                                                        <input type='text' class='form-control form-control-sm form-profil' name='origin' data-default='<?= $user_data['origin'];?>' value='<?= $user_data['origin'];?>' disabled>
                                                            <div class="input-group-prepend">
                                                                <button class="btn btn-primary btn-sm editProfil" type="button" data-name='origin'>Edit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Jenis</label>
                                                        <div class="input-group">
                                                        <input type='text' class='form-control form-control-sm form-profil' name='type' data-default='<?= $user_data['type'];?>' value='<?= $user_data['type'];?>' disabled>
                                                            <div class="input-group-prepend">
                                                            <button class="btn btn-primary btn-sm editProfil" type="button" data-name='type'>Edit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <button class="btn btn-secondary" name="btn-save-profile">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade <?= $show == 2 ? 'show active' : '' ?>" id="top-contact" role="tabpanel" aria-labelledby="contact-top-tab">
                                        <h3 id="message2" class="badge badge-<?= $badge2?>"><?= $message2?></h3>
                                        <div class="account-setting">
                                            <form method="POST" action="" id="formCheck">
                                                <div class="container">
                                                    <div class="form">
                                                        <div class="form-group">
                                                            <label>Kata sandi lama</label>
                                                            <div class="input-group">
                                                                <input type='password' class='form-control form-control-sm form-password' name='old_password' required>
                                                                <div class="input-group-prepend">
                                                                    <button class="btn btn-primary btn-sm show-password" type="button" data-name='old_password'>Show</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kata sandi baru</label>
                                                            <div class="input-group">
                                                                <input type='password' data-info="fm1" class='form-control form-control-sm form-password' name='password' onkeyup="removeBadge()" required>
                                                                <div class="input-group-prepend">
                                                                    <button class="btn btn-primary btn-sm show-password" type="button" data-name='password'>Show</button>
                                                                </div>
                                                            </div>
                                                            <h3 id="fm1" class="badge badge-danger"></h3>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Ulang kata sandi baru </label>
                                                            <div class="input-group">
                                                                <input type='password' data-info="fm2" class='form-control form-control-sm form-password' name='password_confirmation' onkeyup="removeBadge()" required>
                                                                <div class="input-group-prepend">
                                                                    <button class="btn btn-primary btn-sm show-password" type="button" data-name='password_confirmation'>Show</button>
                                                                </div>
                                                            </div>
                                                            <h3 id="fm2" class="badge badge-danger"></h3>
                                                        </div>
                                                        <div class="form-group">
                                                            <button class="btn btn-secondary" name="btn-update-password">Simpan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->

        </div>
        

        <?php include('../template/footer.php');?>
    </div>

</div>

<?php include('../template/script.php') ?>
<script>
    $('.editProfil').on('click',function(){
        var selected = $(this).data('name');
        $('input[name="'+selected+'"]').removeAttr('disabled');
        $('input[name="'+selected+'"]').focus();
    })

    $('.form-profil').blur(function(){
        var def = $(this).data('default');
        var data = $(this).val();
        if(def == data){
            $(this).attr('disabled',true);
        } 
    })

    $(document).on('click','.show-password',function(){
        var selected = $(this).data('name');
        $(this).removeClass('show-password');
        $(this).addClass('hide-password');
        $(this).html('Hide');
        $('input[name="'+selected+'"]').removeAttr('type');
        $('input[name="'+selected+'"]').attr('type','text');
        
    })

    $(document).on('click','.hide-password',function(){
        var selected = $(this).data('name');
        $(this).removeClass('hide-password');
        $(this).addClass('show-password');
        $(this).html('Show');
        $('input[name="'+selected+'"]').removeAttr('type');
        $('input[name="'+selected+'"]').attr('type','password');
    })

    $(document).on('submit','#formCheck',function(){
        if($('input[name="password"]').val() != $('input[name="password_confirmation"]').val()){
            $('#message2').html('Ulang kata sandi baru salah');
            $('#message2').addClass('badge badge-danger');
            return false;
        }

        if($('input[name="password"]').val().length <8) {
            $('#message2').html('Kata sandi baru minimal 8 karakter');
            return false;
        }
    })

    function removeBadge(){
        $('#message2').html('');
    }

    $('.form-password').blur(function(){
        if($(this).val().length <8){
            var id = $(this).data('info');
            $('#'+id).html('Minimal 8 karakter')
        }
    })

    $('.form-password').focus(function(){
        var id = $(this).data('info');
        $('#'+id).html('')
    })
</script>
</body>
</html>
