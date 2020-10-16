<!-- Page Sidebar Start-->
<div class="page-sidebar">
            <div class="sidebar custom-scrollbar">
                <div class="sidebar-user text-center">
                    <div><img class="img-60 rounded-circle lazyloaded blur-up" src="<?= base_url()?>/assets/images/dashboard/man.png" alt="#">
                    </div>
                    <?php 
                        $user_data = getData(api_url()."/api/v1/user",$token,NULL);
                        $user_data = json_decode($user_data,true);
                    ?>
                    <h6 class="mt-3 f-14"><?= $user_data['name']?></h6>
                    <p><?= $user_data['type']?></p>
                </div>
                <ul class="sidebar-menu">
                    <li><a class="sidebar-header" href="<?= base_url().'/admin/dashboard'?>"><i data-feather="home"></i><span>Dashboard</span></a></li>
                    <li><a class="sidebar-header" href=""><i data-feather="box"></i><span>Paket</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?= base_url().'/admin/paket'?>"><i class="fa fa-circle"></i>Daftar Paket</a></li>
                            <li><a href="<?= base_url().'/admin/paket/terima'?>"><i class="fa fa-circle"></i>Terima Paket</a></li>
                            <li><a href="<?= base_url().'/admin/paket/kirim'?>"><i class="fa fa-circle"></i>Kirim Paket</a></li>
                        </ul>
                    </li>
                    <li><a class="sidebar-header" href="<?= base_url().'/admin/lacak'?>"><i data-feather="search"></i><span>Lacak</span></a></li>
                    <li><a class="sidebar-header" href="<?= base_url().'/admin/layanan'?>"><i data-feather="clipboard"></i><span>Layanan</span></a></li>
                    <li><a class="sidebar-header" href="<?= base_url().'/admin/profil'?>"><i data-feather="user"></i><span>Profil</span></a></li>
                </ul>
            </div>
        </div>
        <!-- Page Sidebar Ends-->