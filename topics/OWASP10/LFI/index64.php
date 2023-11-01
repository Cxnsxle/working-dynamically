<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <?php
    include('admin/db_connect.php');
    ob_start();
        $query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
         foreach ($query as $key => $value) {
          if(!is_numeric($key))
            $_SESSION['system'][$key] = $value;
        }
    ob_end_flush();
    include('header.php');

	
    ?>

    <style>
    	header.masthead {
		  background: url(admin/assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>);
		  background-repeat: no-repeat;
		  background-size: cover;
		}
    
  #viewer_modal .btn-close {
    position: absolute;
    z-index: 999999;
    /*right: -4.5em;*/
    background: unset;
    color: white;
    border: unset;
    font-size: 27px;
    top: 0;
}
#viewer_modal .modal-dialog {
        width: 80%;
    max-width: unset;
    height: calc(90%);
    max-height: unset;
}
  #viewer_modal .modal-content {
       background: black;
    border: unset;
    height: calc(100%);
    display: flex;
    align-items: center;
    justify-content: center;
  }
  #viewer_modal img,#viewer_modal video{
    max-height: calc(100%);
    max-width: calc(100%);
  }
  main {
    background: #121212 !important;
    padding-bottom: 15px;
}
footer{
  background: #020202 !important;
}
 

a.jqte_tool_label.unselectable {
    height: auto !important;
    min-width: 4rem !important;
    padding:5px
}

#carousel-field{
    position: fixed;
    z-index: -1;
    width: calc(100%)
}
#carousel-field, #carsCarousel, #carsCarousel .carousel-inner,#carsCarousel .carousel-item,#carsCarousel img{
    /*max-height: 60vh*/
} 
.col-lg-8.align-self-end.mb-4.page-title {
    background: #00000070;
}

/*
a.jqte_tool_label.unselectable {
    height: 22px !important;
}*/
    </style>
    <?php 
        $page = isset($_GET['page']) ?$_GET['page'] : "home";
        // if($page == 'home'):
     ?>
     <style>
       .masthead{
    background: unset!important
}
.masthead:before{
    content: unset!important;
}
     </style>
  <header class="masthead">
        <?php 
        $cars_img = scandir('admin/assets/uploads/carousel/');
            foreach($cars_img as $k=> $fname){
                if(in_array($fname,array('.','..'))){
                    unset($cars_img[$k]);
                }
            }
            if(count($cars_img) > 0):
        ?>
        <div id="carousel-field">
        <div id="carsCarousel" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <?php
            $i = 0 ;
             foreach($cars_img as $fname):
                $active = ($i == 0) ? 'active' : '';
                $i++;
            ?>
            <div class="carousel-item <?php echo $active ?>">
              <img class="d-block w-100" src="admin/assets/uploads/carousel/<?php echo $fname ?>" alt="">
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        </div>
    <?php endif; ?>
      <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end mb-4 page-title">
                  <h3 class="text-white"><?php echo strtoupper(str_replace("_", " ", $page)) ?></h3>
                    <hr class="divider my-4" />
                </div>
            </div>  
      </div>  
        
    </header>
    <?php //endif; ?>
    <body id="page-top">
        <!-- Navigation-->
        <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-white">
        </div>
      </div>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
            <div class="container">
                <span>
                  <img src="admin/assets/uploads/<?php echo isset($_SESSION['system']['cover_img']) ? $_SESSION['system']['cover_img'] : '' ?>" alt="" style="height:45px;max-width: calc(100%)">
                </span>
                <a class="navbar-brand js-scroll-trigger ml-2" href="./"><?php echo $_SESSION['system']['name'] ?></a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto my-2 my-lg-0">
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=home">Home</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=courses">Courses</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=about_us">About</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=milestones">Milestones</a></li>
                       
                        
                     
                    </ul>
                </div>
            </div>
        </nav>
  <main class="">
        <?php 
        include $page;
        ?>
       
</main>
<div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height  modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="fa fa-arrow-righ t"></span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
              <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
              <img src="" alt="">
      </div>
    </div>
  </div>
  <div id="preloader"></div>
        <footer class=" py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h2 class="mt-0 text-white">Contact us</h2>
                        <hr class="divider my-4" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 ml-auto text-center mb-5 mb-lg-0">
                        <i class="fas fa-phone fa-3x mb-3 text-muted"></i>
                        <div class="text-white"><?php echo $_SESSION['system']['contact'] ?></div>
                    </div>
                    <div class="col-lg-4 mr-auto text-center">
                        <i class="fas fa-envelope fa-3x mb-3 text-muted"></i>
                        <!-- Make sure to change the email address in BOTH the anchor text and the link target below!-->
                        <a class="d-block" href="mailto:<?php echo $_SESSION['system']['email'] ?>"><?php echo $_SESSION['system']['email'] ?></a>
                    </div>
                </div>
            </div>
            <br>
            <div class="container"><div class="small text-center text-muted">Copyright © 2020 - <?php echo $_SESSION['system']['name'] ?> | <a href="https://www.sourcecodester.com/" target="_blank">Sourcecodester</a></div></div>
        </footer>
        
       <?php include('footer.php') ?>
    </body>
    <script type="text/javascript">
      $('#login').click(function(){
        uni_modal("Login",'login.php')
      })
      $('.datetimepicker').datetimepicker({
          format:'Y-m-d H:i',
      })
      $('#find-car').submit(function(e){
        e.preventDefault()
        location.href = 'index.php?page=search&'+$(this).serialize()
      })
    </script>
    <?php $conn->close() ?>

</html>6W76����7F'B�����У�D�5E�R�F���УƇF����s�&V�#�Т��� Т��6�VFR�vF֖��F%�6���V7B��r��Т�%�7F'B���ТGVW'��F6�����VW'��%4T�T5B�e$��7�7FV��6WGF��w2Ɩ֗B"���fWF6��'&����Тf�&V6��GVW'�2F�W���Gf�VR��Т�b��5��V�W&�2�F�W���ТE�4U54���w7�7FV�uղF�W���Gf�VS�Т�Т�%�V�E�f�W6����Т��6�VFR�v�VFW"��r��РР�Т��РТ�7G��S�Т ��VFW"��7F�VB�Р��&6�w&�V�C�W&F֖��76WG2�W��G2����V6��E�4U54���w7�7FV�uղv6�fW%���ru��⓰Р��&6�w&�V�B�&WVC����&WVC�Р��&6�w&�V�B�6��S�6�fW#�Р���Т Т7f�WvW%���F��'F��6��6R�Т�6�F���'6��WFS�Т�֖�FW���������Т�&�v�C��B�VVӲ��Т&6�w&�V�C�V�6WC�Т6���#�v��FS�Т&�&FW#�V�6WC�Тf��B�6��S�#w��ТF���Ч�Т7f�WvW%���F����F��F���r�Тv�GF���S�Т���v�GF��V�6WC�Т�V�v�C�6�2��R��Т��ֆV�v�C�V�6WC�Ч�Т7f�WvW%���F����F��6��FV�B�Т&6�w&�V�C�&�6��Т&�&FW#�V�6WC�Т�V�v�C�6�2�R��ТF�7���f�W��ТƖv�֗FV�3�6V�FW#�Т�W7F�g��6��FV�C�6V�FW#�Т�Т7f�WvW%���F���r�7f�WvW%���F�f�FV��Т��ֆV�v�C�6�2�R��Т���v�GF��6�2�R��Т�Т����Т&6�w&�V�C�3##"���'F�C�ТFF��r�&�GF�ӢW��Ч�Цf��FW'�Т&6�w&�V�C�3##"���'F�C�Ч�Т РЦ�FU�F�����&V��V�6V�V7F&�R�Т�V�v�C�WF����'F�C�Т֖��v�GF��G&V����'F�C�ТFF��s�W�Ч�РТ66&�W6V��f�V�G�Т�6�F���f��VC�Т�֖�FW����Тv�GF��6�2�R�Ч�Т66&�W6V��f�V�B�66'46&�W6V��66'46&�W6V��6&�W6V�֖��W"�66'46&�W6V��6&�W6V�֗FV��66'46&�W6V���w�Т���ֆV�v�C�cf���Ч� Т�6����rӂ�Ɩv��6V�b�V�B��"�B�vR�F�F�R�Т&6�w&�V�C�3s�Ч�РТ�Ц�FU�F�����&V��V�6V�V7F&�R�Т�V�v�C�#'����'F�C�ЧҢ�Т��7G��S�Т��� ТGvR��76WB�E�tUE�wvRuҒ�E�tUE�wvRu��&���R#�Т���b�GvR��v���Rr��Т��Т�7G��S�Т��7F�VG�Т&6�w&�V�C�V�6WB���'F�@Ч�Т��7F�VC�&Vf�&W�Т6��FV�C�V�6WB���'F�C�Ч�Т��7G��S�ТƆVFW"6�73�&�7F�VB#�Т��� ТF6'5���r�66�F�"�vF֖��76WG2�W��G2�6&�W6V��r��Тf�&V6��F6'5���r2F���Ff��R��Т�b����'&��Ff��R�'&��r�r�r��r����ТV�6WB�F6'5���u�F�ғ�Т�Т�Т�b�6�V�B�F6'5���r����Т��Т�F�b�C�&6&�W6V��f�V�B#�Т�F�b�C�&6'46&�W6V�"6�73�&6&�W6V�6ƖFR"FF�&�FS�&6&�W6V�#�Т�F�b6�73�&6&�W6V�֖��W"#�Т��� ТF���Тf�&V6��F6'5���r2Ff��R��ТF7F�fR��F�����v7F�fRr�rs�ТF����Т��Т�F�b6�73�&6&�W6V�֗FV����V6��F7F�fR��#�ТƖ�r6�73�&B�&��6�r�"7&3�&F֖��76WG2�W��G2�6&�W6V�����V6��Ff��R��"�C�"#�Т��F�c�Т���V�Ff�&V6����Т��F�c�Т��F�c�Т��F�c�Т���V�F�c���Т�F�b6�73�&6��F��W"��#�Т�F�b6�73�'&�r��Ɩv�֗FV�2�6V�FW"�W7F�g��6��FV�B�6V�FW"FW�B�6V�FW"#�Т�F�b6�73�&6����rӂƖv��6V�b�V�B�"�BvR�F�F�R#�Тƃ26�73�'FW�B�v��FR#����V6��7G'F�WW"�7G%�&W�6R�%�"�""�GvR�������3�ТƇ"6�73�&F�f�FW"ג�B"��Т��F�c�Т��F�c� Т��F�c� Т Т���VFW#�Т�����V�F�c���Т�&�G��C�'vR�F�#�Т����f�vF������Т�F�b6�73�'F�7B"�C�&�W'E�F�7B"&��S�&�W'B"&��ƗfS�&76W'F�fR"&��F�֖3�'G'VR#�Т�F�b6�73�'F�7B�&�G�FW�B�v��FR#�Т��F�c�Т��F�c�Т��b6�73�&�f&"�f&"�W��B��r�f&"�Ɩv�Bf��VB�F���2"�C�&����b#�Т�F�b6�73�&6��F��W"#�Т�7��ТƖ�r7&3�&F֖��76WG2�W��G2����V6���76WB�E�4U54���w7�7FV�uղv6�fW%���ruҒ�E�4U54���w7�7FV�uղv6�fW%���ru��rr��"�C�""7G��S�&�V�v�C�CW�����v�GF��6�2�R�#�Т��7��Т�6�73�&�f&"�'&�B�2�67&����G&�vvW"���""�&Vc�"��#����V6��E�4U54���w7�7FV�uղv��Ru������Т�'WGF��6�73�&�f&"�F�vv�W"�f&"�F�vv�W"�&�v�B"G�S�&'WGF��"FF�F�vv�S�&6���6R"FF�F&vWC�"6�f&%&W7��6�fR"&��6��G&��3�&�f&%&W7��6�fR"&��W��FVC�&f�6R"&���&V��%F�vv�R�f�vF���#��7�6�73�&�f&"�F�vv�W"֖6��#���7����'WGF���Т�F�b6�73�&6���6R�f&"�6���6R"�C�&�f&%&W7��6�fR#�Т�V�6�73�&�f&"��b���WF�ג�"ג��r�#�Т�ƒ6�73�&�b֗FV�#��6�73�&�b�Ɩ��2�67&����G&�vvW""�&Vc�&��FW����vSֆ��R#���S�����Ɠ�Т�ƒ6�73�&�b֗FV�#��6�73�&�b�Ɩ��2�67&����G&�vvW""�&Vc�&��FW����vS�6�W'6W2#�6�W'6W3�����Ɠ�Т�ƒ6�73�&�b֗FV�#��6�73�&�b�Ɩ��2�67&����G&�vvW""�&Vc�&��FW����vS�&�WE�W2#�&�WC�����Ɠ�Т�ƒ6�73�&�b֗FV�#��6�73�&�b�Ɩ��2�67&����G&�vvW""�&Vc�&��FW����vS�֖�W7F��W2#�֖�W7F��W3�����Ɠ�Т Т Т Т��V��Т��F�c�Т��F�c�Т���c�Т����6�73�"#�Т��� Т��6�VFRGvS�Т��Т У������У�F�b6�73�&��F�fFR"�C�&6��f�&����F�"&��S�vF���rs�Т�F�b6�73�&��F��F���r��F���B"&��S�&F�7V�V�B#�Т�F�b6�73�&��F��6��FV�B#�Т�F�b6�73�&��F�ֆVFW"#�ТƃR6�73�&��F��F�F�R#�6��f�&�F������S�Т��F�c�Т�F�b6�73�&��F��&�G�#�Т�F�b�C�&FV�WFU�6��FV�B#���F�c�Т��F�c�Т�F�b6�73�&��F��f��FW"#�Т�'WGF��G�S�&'WGF��"6�73�&'F�'F��&��'�"�C�v6��f�&�r��6Ɩ6��"#�6��F��VS��'WGF���Т�'WGF��G�S�&'WGF��"6�73�&'F�'F��6V6��F'�"FF�F�6֗73�&��F�#�6��6S��'WGF���Т��F�c�Т��F�c�Т��F�c�Т��F�c�Т�F�b6�73�&��F�fFR"�C�'V����F�"&��S�vF���rs�Т�F�b6�73�&��F��F���r��F���B"&��S�&F�7V�V�B#�Т�F�b6�73�&��F��6��FV�B#�Т�F�b6�73�&��F�ֆVFW"#�ТƃR6�73�&��F��F�F�R#����S�Т��F�c�Т�F�b6�73�&��F��&�G�#�Т��F�c�Т�F�b6�73�&��F��f��FW"#�Т�'WGF��G�S�&'WGF��"6�73�&'F�'F��&��'�"�C�w7V&֗Br��6Ɩ6��"B�r7V����F�f�&�r��7V&֗B��#�6fS��'WGF���Т�'WGF��G�S�&'WGF��"6�73�&'F�'F��6V6��F'�"FF�F�6֗73�&��F�#�6�6V���'WGF���Т��F�c�Т��F�c�Т��F�c�Т��F�c�Т�F�b6�73�&��F�fFR"�C�'V����F��&�v�B"&��S�vF���rs�Т�F�b6�73�&��F��F���r��F��gV��ֆV�v�B��F���B"&��S�&F�7V�V�B#�Т�F�b6�73�&��F��6��FV�B#�Т�F�b6�73�&��F�ֆVFW"#�ТƃR6�73�&��F��F�F�R#����S�Т�'WGF��G�S�&'WGF��"6�73�&6��6R"FF�F�6֗73�&��F�"&���&V��$6��6R#�Т�7�6�73�&ff�'&�r�&�v�B#���7��Т��'WGF���Т��F�c�Т�F�b6�73�&��F��&�G�#�Т��F�c�Т��F�c�Т��F�c�Т��F�c�Т�F�b6�73�&��F�fFR"�C�'f�WvW%���F�"&��S�vF���rs�Т�F�b6�73�&��F��F���r��F���B"&��S�&F�7V�V�B#�Т�F�b6�73�&��F��6��FV�B#�Т�'WGF��G�S�&'WGF��"6�73�&'F��6��6R"FF�F�6֗73�&��F�#��7�6�73�&ff�F��W2#���7����'WGF���ТƖ�r7&3�""�C�"#�Т��F�c�Т��F�c�Т��F�c�Т�F�b�C�'&V��FW"#���F�c�Т�f��FW"6�73�"��R#�Т�F�b6�73�&6��F��W"#�Т�F�b6�73�'&�r�W7F�g��6��FV�B�6V�FW"#�Т�F�b6�73�&6����rӂFW�B�6V�FW"#�Тƃ"6�73�&�B�FW�B�v��FR#�6��F7BW3���#�ТƇ"6�73�&F�f�FW"ג�B"��Т��F�c�Т��F�c�Т�F�b6�73�'&�r#�Т�F�b6�73�&6����r�B���WF�FW�B�6V�FW"�"�R�"��r�#�Тƒ6�73�&f2f����Rf�7��"�2FW�B��WFVB#�����Т�F�b6�73�'FW�B�v��FR#����V6��E�4U54���w7�7FV�uղv6��F7Bu�����F�c�Т��F�c�Т�F�b6�73�&6����r�B�"�WF�FW�B�6V�FW"#�Тƒ6�73�&f2f�V�fV��Rf�7��"�2FW�B��WFVB#�����Т�����R7W&RF�6��vRF�RV���FG&W72��$�D�F�R�6��"FW�B�BF�RƖ�F&vWB&V��r���Т�6�73�&B�&��6�"�&Vc�&���F����V6��E�4U54���w7�7FV�uղvV���u���#����V6��E�4U54���w7�7FV�uղvV���u������Т��F�c�Т��F�c�Т��F�c�Т�'#�Т�F�b6�73�&6��F��W"#��F�b6�73�'6���FW�B�6V�FW"FW�B��WFVB#�6��&�v�B*�##����V6��E�4U54���w7�7FV�uղv��Ru������&Vc�&�GG3���wwr�6�W&6V6�FW7FW"�6���"F&vWC�%�&��#�6�W&6V6�FW7FW#�����F�c���F�c�Т��f��FW#�Т Т�����6�VFR�vf��FW"��r���Т��&�G��Т�67&�BG�S�'FW�B��f67&�B#�ТB�r6��v��r��6Ɩ6��gV�7F��ₗ�ТV����F$��v��"�v��v����r�ТҐТB�r�FFWF��W�6�W"r��FFWF��W�6�W"��Тf�&�C�u����B���r�ТҐТB�r6f��B�6"r��7V&֗B�gV�7F���R��ТR�&WfV�DFVfV�B��Т��6F����&Vb�v��FW����vS�6V&6�br�B�F��2��6W&�Ɨ�R��ТҐТ��67&�C�Т���F6�����6��6R����РУ���F����