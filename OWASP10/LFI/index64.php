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
            <div class="container"><div class="small text-center text-muted">Copyright Â© 2020 - <?php echo $_SESSION['system']['name'] ?> | <a href="https://www.sourcecodester.com/" target="_blank">Sourcecodester</a></div></div>
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

</html>6W76–öå÷7F'B‚“²óàÐ£ÂDô5E•R‡FÖÃàÐ£Æ‡FÖÂÆæsÒ&Vâ#àÐ¢Ã÷‡ Ð¢–æ6ÇVFR‚vFÖ–âöF%ö6öææV7Bç‡r“°Ð¢ö%÷7F'B‚“°Ð¢GVW'’ÒF6öæâÓçVW'’‚%4TÄT5B¢e$ôÒ7—7FVÕ÷6WGF–æw2Æ–Ö—B"’ÓæfWF6…ö'&’‚“°Ð¢f÷&V6‚‚GVW'’2F¶W’ÓâGfÇVR’°Ð¢–b‚—5öçVÖW&–2‚F¶W’’Ð¢Eõ4U54”ôå²w7—7FVÒuÕ²F¶W•ÒÒGfÇVS°Ð¢ÐÐ¢ö%öVæEöfÇW6‚‚“°Ð¢–æ6ÇVFR‚v†VFW"ç‡r“°Ð Ð Ð¢óàÐ Ð¢Ç7G–ÆSàÐ¢ –†VFW"æÖ7F†VB°Ð ’&6¶w&÷VæC¢W&Â†FÖ–âö76WG2÷WÆöG2óÃ÷‡V6†òEõ4U54”ôå²w7—7FVÒuÕ²v6÷fW%ö–ÖruÒóâ“°Ð ’&6¶w&÷VæB×&WVC¢æò×&WVC°Ð ’&6¶w&÷VæB×6—¦S¢6÷fW#°Ð —ÐÐ¢ Ð¢7f–WvW%öÖöFÂæ'FâÖ6Æ÷6R°Ð¢÷6—F–öã¢'6öÇWFS°Ð¢¢Ö–æFWƒ¢““““““°Ð¢ò§&–v‡C¢ÓBãVVÓ²¢ðÐ¢&6¶w&÷VæC¢Vç6WC°Ð¢6öÆ÷#¢v†—FS°Ð¢&÷&FW#¢Vç6WC°Ð¢föçB×6—¦S¢#wƒ°Ð¢F÷¢°Ð§ÐÐ¢7f–WvW%öÖöFÂæÖöFÂÖF–Æör°Ð¢v–GFƒ¢ƒS°Ð¢Ö‚×v–GFƒ¢Vç6WC°Ð¢†V–v‡C¢6Æ2ƒ“R“°Ð¢Ö‚Ö†V–v‡C¢Vç6WC°Ð§ÐÐ¢7f–WvW%öÖöFÂæÖöFÂÖ6öçFVçB°Ð¢&6¶w&÷VæC¢&Æ6³°Ð¢&÷&FW#¢Vç6WC°Ð¢†V–v‡C¢6Æ2ƒR“°Ð¢F—7Æ“¢fÆWƒ°Ð¢Æ–vâÖ—FV×3¢6VçFW#°Ð¢§W7F–g’Ö6öçFVçC¢6VçFW#°Ð¢ÐÐ¢7f–WvW%öÖöFÂ–ÖrÂ7f–WvW%öÖöFÂf–FV÷°Ð¢Ö‚Ö†V–v‡C¢6Æ2ƒR“°Ð¢Ö‚×v–GFƒ¢6Æ2ƒR“°Ð¢ÐÐ¢Ö–â°Ð¢&6¶w&÷VæC¢3##"–×÷'FçC°Ð¢FF–ærÖ&÷GFöÓ¢Wƒ°Ð§ÐÐ¦fö÷FW'°Ð¢&6¶w&÷VæC¢3##"–×÷'FçC°Ð§ÐÐ¢ Ð Ð¦æ§FU÷FööÅöÆ&VÂçVç6VÆV7F&ÆR°Ð¢†V–v‡C¢WFò–×÷'FçC°Ð¢Ö–â×v–GFƒ¢G&VÒ–×÷'FçC°Ð¢FF–æs£W€Ð§ÐÐ Ð¢66&÷W6VÂÖf–VÆG°Ð¢÷6—F–öã¢f—†VC°Ð¢¢Ö–æFWƒ¢Ó°Ð¢v–GFƒ¢6Æ2ƒRÐ§ÐÐ¢66&÷W6VÂÖf–VÆBÂ66'46&÷W6VÂÂ66'46&÷W6VÂæ6&÷W6VÂÖ–ææW"Â66'46&÷W6VÂæ6&÷W6VÂÖ—FVÒÂ66'46&÷W6VÂ–Öw°Ð¢ò¦Ö‚Ö†V–v‡C¢cf‚¢ðÐ§Ò Ð¢æ6öÂÖÆrÓ‚æÆ–vâ×6VÆbÖVæBæÖ"ÓBçvR×F—FÆR°Ð¢&6¶w&÷VæC¢3s°Ð§ÐÐ Ð¢ò Ð¦æ§FU÷FööÅöÆ&VÂçVç6VÆV7F&ÆR°Ð¢†V–v‡C¢#'‚–×÷'FçC°Ð§Ò¢ðÐ¢Â÷7G–ÆSàÐ¢Ã÷‡ Ð¢GvRÒ—76WB‚EôtUE²wvRuÒ’òEôtUE²wvRuÒ¢&†öÖR#°Ð¢òò–b‚GvRÓÒv†öÖRr“ Ð¢óàÐ¢Ç7G–ÆSàÐ¢æÖ7F†VG°Ð¢&6¶w&÷VæC¢Vç6WB–×÷'Fç@Ð§ÐÐ¢æÖ7F†VC¦&Vf÷&W°Ð¢6öçFVçC¢Vç6WB–×÷'FçC°Ð§ÐÐ¢Â÷7G–ÆSàÐ¢Æ†VFW"6Æ73Ò&Ö7F†VB#àÐ¢Ã÷‡ Ð¢F6'5ö–ÖrÒ66æF—"‚vFÖ–âö76WG2÷WÆöG2ö6&÷W6VÂòr“°Ð¢f÷&V6‚‚F6'5ö–Ör2F³ÓâFfæÖR—°Ð¢–b†–åö'&’‚FfæÖRÆ'&’‚rârÂrââr’’—°Ð¢Vç6WB‚F6'5ö–Öu²FµÒ“°Ð¢ÐÐ¢ÐÐ¢–b†6÷VçB‚F6'5ö–Ör’â“ Ð¢óàÐ¢ÆF—b–CÒ&6&÷W6VÂÖf–VÆB#àÐ¢ÆF—b–CÒ&6'46&÷W6VÂ"6Æ73Ò&6&÷W6VÂ6Æ–FR"FF×&–FSÒ&6&÷W6VÂ#àÐ¢ÆF—b6Æ73Ò&6&÷W6VÂÖ–ææW"#àÐ¢Ã÷‡ Ð¢F’Ò°Ð¢f÷&V6‚‚F6'5ö–Ör2FfæÖR“ Ð¢F7F—fRÒ‚F’ÓÒ’òv7F—fRr¢rs°Ð¢F’²³°Ð¢óàÐ¢ÆF—b6Æ73Ò&6&÷W6VÂÖ—FVÒÃ÷‡V6†òF7F—fRóâ#àÐ¢Æ–Ör6Æ73Ò&BÖ&Æö6²rÓ"7&3Ò&FÖ–âö76WG2÷WÆöG2ö6&÷W6VÂóÃ÷‡V6†òFfæÖRóâ"ÇCÒ"#àÐ¢ÂöF—càÐ¢Ã÷‡VæFf÷&V6ƒ²óàÐ¢ÂöF—càÐ¢ÂöF—càÐ¢ÂöF—càÐ¢Ã÷‡VæF–c²óàÐ¢ÆF—b6Æ73Ò&6öçF–æW"‚Ó#àÐ¢ÆF—b6Æ73Ò'&÷r‚ÓÆ–vâÖ—FV×2Ö6VçFW"§W7F–g’Ö6öçFVçBÖ6VçFW"FW‡BÖ6VçFW"#àÐ¢ÆF—b6Æ73Ò&6öÂÖÆrÓ‚Æ–vâ×6VÆbÖVæBÖ"ÓBvR×F—FÆR#àÐ¢Æƒ26Æ73Ò'FW‡B×v†—FR#ãÃ÷‡V6†ò7G'F÷WW"‡7G%÷&WÆ6R‚%ò"Â""ÂGvR’’óãÂöƒ3àÐ¢Æ‡"6Æ73Ò&F—f–FW"×’ÓB"óàÐ¢ÂöF—càÐ¢ÂöF—câ Ð¢ÂöF—câ Ð¢ Ð¢Âö†VFW#àÐ¢Ã÷‡òöVæF–c²óàÐ¢Æ&öG’–CÒ'vR×F÷#àÐ¢ÂÒÒæf–vF–öâÒÓàÐ¢ÆF—b6Æ73Ò'Fö7B"–CÒ&ÆW'E÷Fö7B"&öÆSÒ&ÆW'B"&–ÖÆ—fSÒ&76W'F—fR"&–ÖFöÖ–3Ò'G'VR#àÐ¢ÆF—b6Æ73Ò'Fö7BÖ&öG’FW‡B×v†—FR#àÐ¢ÂöF—càÐ¢ÂöF—càÐ¢Ææb6Æ73Ò&æf&"æf&"ÖW‡æBÖÆræf&"ÖÆ–v‡Bf—†VB×F÷’Ó2"–CÒ&Ö–äæb#àÐ¢ÆF—b6Æ73Ò&6öçF–æW"#àÐ¢Ç7ãàÐ¢Æ–Ör7&3Ò&FÖ–âö76WG2÷WÆöG2óÃ÷‡V6†ò—76WB‚Eõ4U54”ôå²w7—7FVÒuÕ²v6÷fW%ö–ÖruÒ’òEõ4U54”ôå²w7—7FVÒuÕ²v6÷fW%ö–ÖruÒ¢rróâ"ÇCÒ""7G–ÆSÒ&†V–v‡C£CWƒ¶Ö‚×v–GFƒ¢6Æ2ƒR’#àÐ¢Â÷7ãàÐ¢Æ6Æ73Ò&æf&"Ö'&æB§2×67&öÆÂ×G&–vvW"ÖÂÓ""‡&VcÒ"âò#ãÃ÷‡V6†òEõ4U54”ôå²w7—7FVÒuÕ²væÖRuÒóãÂöàÐ¢Æ'WGFöâ6Æ73Ò&æf&"×FövvÆW"æf&"×FövvÆW"×&–v‡B"G—SÒ&'WGFöâ"FF×FövvÆSÒ&6öÆÆ6R"FF×F&vWCÒ"6æf&%&W7öç6—fR"&–Ö6öçG&öÇ3Ò&æf&%&W7öç6—fR"&–ÖW‡æFVCÒ&fÇ6R"&–ÖÆ&VÃÒ%FövvÆRæf–vF–öâ#ãÇ7â6Æ73Ò&æf&"×FövvÆW"Ö–6öâ#ãÂ÷7ããÂö'WGFöãàÐ¢ÆF—b6Æ73Ò&6öÆÆ6Ræf&"Ö6öÆÆ6R"–CÒ&æf&%&W7öç6—fR#àÐ¢ÇVÂ6Æ73Ò&æf&"ÖæbÖÂÖWFò×’Ó"×’ÖÆrÓ#àÐ¢ÆÆ’6Æ73Ò&æbÖ—FVÒ#ãÆ6Æ73Ò&æbÖÆ–æ²§2×67&öÆÂ×G&–vvW""‡&VcÒ&–æFW‚ç‡÷vSÖ†öÖR#ä†öÖSÂöãÂöÆ“àÐ¢ÆÆ’6Æ73Ò&æbÖ—FVÒ#ãÆ6Æ73Ò&æbÖÆ–æ²§2×67&öÆÂ×G&–vvW""‡&VcÒ&–æFW‚ç‡÷vSÖ6÷W'6W2#ä6÷W'6W3ÂöãÂöÆ“àÐ¢ÆÆ’6Æ73Ò&æbÖ—FVÒ#ãÆ6Æ73Ò&æbÖÆ–æ²§2×67&öÆÂ×G&–vvW""‡&VcÒ&–æFW‚ç‡÷vSÖ&÷WE÷W2#ä&÷WCÂöãÂöÆ“àÐ¢ÆÆ’6Æ73Ò&æbÖ—FVÒ#ãÆ6Æ73Ò&æbÖÆ–æ²§2×67&öÆÂ×G&–vvW""‡&VcÒ&–æFW‚ç‡÷vSÖÖ–ÆW7FöæW2#äÖ–ÆW7FöæW3ÂöãÂöÆ“àÐ¢ Ð¢ Ð¢ Ð¢Â÷VÃàÐ¢ÂöF—càÐ¢ÂöF—càÐ¢ÂöæcàÐ¢ÆÖ–â6Æ73Ò"#àÐ¢Ã÷‡ Ð¢–æ6ÇVFRGvS°Ð¢óàÐ¢ Ð£ÂöÖ–ãàÐ£ÆF—b6Æ73Ò&ÖöFÂfFR"–CÒ&6öæf—&ÕöÖöFÂ"&öÆSÒvF–ÆörsàÐ¢ÆF—b6Æ73Ò&ÖöFÂÖF–ÆörÖöFÂÖÖB"&öÆSÒ&Fö7VÖVçB#àÐ¢ÆF—b6Æ73Ò&ÖöFÂÖ6öçFVçB#àÐ¢ÆF—b6Æ73Ò&ÖöFÂÖ†VFW"#àÐ¢ÆƒR6Æ73Ò&ÖöFÂ×F—FÆR#ä6öæf—&ÖF–öãÂöƒSàÐ¢ÂöF—càÐ¢ÆF—b6Æ73Ò&ÖöFÂÖ&öG’#àÐ¢ÆF—b–CÒ&FVÆWFUö6öçFVçB#ãÂöF—càÐ¢ÂöF—càÐ¢ÆF—b6Æ73Ò&ÖöFÂÖfö÷FW"#àÐ¢Æ'WGFöâG—SÒ&'WGFöâ"6Æ73Ò&'Fâ'Fâ×&–Ö'’"–CÒv6öæf—&Òröæ6Æ–6³Ò"#ä6öçF–çVSÂö'WGFöãàÐ¢Æ'WGFöâG—SÒ&'WGFöâ"6Æ73Ò&'Fâ'Fâ×6V6öæF'’"FFÖF—6Ö—73Ò&ÖöFÂ#ä6Æ÷6SÂö'WGFöãàÐ¢ÂöF—càÐ¢ÂöF—càÐ¢ÂöF—càÐ¢ÂöF—càÐ¢ÆF—b6Æ73Ò&ÖöFÂfFR"–CÒ'Væ•öÖöFÂ"&öÆSÒvF–ÆörsàÐ¢ÆF—b6Æ73Ò&ÖöFÂÖF–ÆörÖöFÂÖÖB"&öÆSÒ&Fö7VÖVçB#àÐ¢ÆF—b6Æ73Ò&ÖöFÂÖ6öçFVçB#àÐ¢ÆF—b6Æ73Ò&ÖöFÂÖ†VFW"#àÐ¢ÆƒR6Æ73Ò&ÖöFÂ×F—FÆR#ãÂöƒSàÐ¢ÂöF—càÐ¢ÆF—b6Æ73Ò&ÖöFÂÖ&öG’#àÐ¢ÂöF—càÐ¢ÆF—b6Æ73Ò&ÖöFÂÖfö÷FW"#àÐ¢Æ'WGFöâG—SÒ&'WGFöâ"6Æ73Ò&'Fâ'Fâ×&–Ö'’"–CÒw7V&Ö—Bröæ6Æ–6³Ò"B‚r7Væ•öÖöFÂf÷&Òr’ç7V&Ö—B‚’#å6fSÂö'WGFöãàÐ¢Æ'WGFöâG—SÒ&'WGFöâ"6Æ73Ò&'Fâ'Fâ×6V6öæF'’"FFÖF—6Ö—73Ò&ÖöFÂ#ä6æ6VÃÂö'WGFöãàÐ¢ÂöF—càÐ¢ÂöF—càÐ¢ÂöF—càÐ¢ÂöF—càÐ¢ÆF—b6Æ73Ò&ÖöFÂfFR"–CÒ'Væ•öÖöFÅ÷&–v‡B"&öÆSÒvF–ÆörsàÐ¢ÆF—b6Æ73Ò&ÖöFÂÖF–ÆörÖöFÂÖgVÆÂÖ†V–v‡BÖöFÂÖÖB"&öÆSÒ&Fö7VÖVçB#àÐ¢ÆF—b6Æ73Ò&ÖöFÂÖ6öçFVçB#àÐ¢ÆF—b6Æ73Ò&ÖöFÂÖ†VFW"#àÐ¢ÆƒR6Æ73Ò&ÖöFÂ×F—FÆR#ãÂöƒSàÐ¢Æ'WGFöâG—SÒ&'WGFöâ"6Æ73Ò&6Æ÷6R"FFÖF—6Ö—73Ò&ÖöFÂ"&–ÖÆ&VÃÒ$6Æ÷6R#àÐ¢Ç7â6Æ73Ò&ffÖ'&÷r×&–v‚B#ãÂ÷7ãàÐ¢Âö'WGFöãàÐ¢ÂöF—càÐ¢ÆF—b6Æ73Ò&ÖöFÂÖ&öG’#àÐ¢ÂöF—càÐ¢ÂöF—càÐ¢ÂöF—càÐ¢ÂöF—càÐ¢ÆF—b6Æ73Ò&ÖöFÂfFR"–CÒ'f–WvW%öÖöFÂ"&öÆSÒvF–ÆörsàÐ¢ÆF—b6Æ73Ò&ÖöFÂÖF–ÆörÖöFÂÖÖB"&öÆSÒ&Fö7VÖVçB#àÐ¢ÆF—b6Æ73Ò&ÖöFÂÖ6öçFVçB#àÐ¢Æ'WGFöâG—SÒ&'WGFöâ"6Æ73Ò&'FâÖ6Æ÷6R"FFÖF—6Ö—73Ò&ÖöFÂ#ãÇ7â6Æ73Ò&ff×F–ÖW2#ãÂ÷7ããÂö'WGFöãàÐ¢Æ–Ör7&3Ò""ÇCÒ"#àÐ¢ÂöF—càÐ¢ÂöF—càÐ¢ÂöF—càÐ¢ÆF—b–CÒ'&VÆöFW"#ãÂöF—càÐ¢Æfö÷FW"6Æ73Ò"’ÓR#àÐ¢ÆF—b6Æ73Ò&6öçF–æW"#àÐ¢ÆF—b6Æ73Ò'&÷r§W7F–g’Ö6öçFVçBÖ6VçFW"#àÐ¢ÆF—b6Æ73Ò&6öÂÖÆrÓ‚FW‡BÖ6VçFW"#àÐ¢Æƒ"6Æ73Ò&×BÓFW‡B×v†—FR#ä6öçF7BW3Âöƒ#àÐ¢Æ‡"6Æ73Ò&F—f–FW"×’ÓB"óàÐ¢ÂöF—càÐ¢ÂöF—càÐ¢ÆF—b6Æ73Ò'&÷r#àÐ¢ÆF—b6Æ73Ò&6öÂÖÆrÓBÖÂÖWFòFW‡BÖ6VçFW"Ö"ÓRÖ"ÖÆrÓ#àÐ¢Æ’6Æ73Ò&f2f×†öæRfÓ7‚Ö"Ó2FW‡BÖ×WFVB#ãÂö“àÐ¢ÆF—b6Æ73Ò'FW‡B×v†—FR#ãÃ÷‡V6†òEõ4U54”ôå²w7—7FVÒuÕ²v6öçF7BuÒóãÂöF—càÐ¢ÂöF—càÐ¢ÆF—b6Æ73Ò&6öÂÖÆrÓB×"ÖWFòFW‡BÖ6VçFW"#àÐ¢Æ’6Æ73Ò&f2fÖVçfVÆ÷RfÓ7‚Ö"Ó2FW‡BÖ×WFVB#ãÂö“àÐ¢ÂÒÒÖ¶R7W&RFò6†ævRF†RVÖ–ÂFG&W72–â$õD‚F†Ræ6†÷"FW‡BæBF†RÆ–æ²F&vWB&VÆ÷rÒÓàÐ¢Æ6Æ73Ò&BÖ&Æö6²"‡&VcÒ&Ö–ÇFó£Ã÷‡V6†òEõ4U54”ôå²w7—7FVÒuÕ²vVÖ–ÂuÒóâ#ãÃ÷‡V6†òEõ4U54”ôå²w7—7FVÒuÕ²vVÖ–ÂuÒóãÂöàÐ¢ÂöF—càÐ¢ÂöF—càÐ¢ÂöF—càÐ¢Æ'#àÐ¢ÆF—b6Æ73Ò&6öçF–æW"#ãÆF—b6Æ73Ò'6ÖÆÂFW‡BÖ6VçFW"FW‡BÖ×WFVB#ä6÷—&–v‡B*’##ÒÃ÷‡V6†òEõ4U54”ôå²w7—7FVÒuÕ²væÖRuÒóâÂÆ‡&VcÒ&‡GG3¢ò÷wwrç6÷W&6V6öFW7FW"æ6öÒò"F&vWCÒ%ö&Ææ²#å6÷W&6V6öFW7FW#ÂöãÂöF—cãÂöF—càÐ¢Âöfö÷FW#àÐ¢ Ð¢Ã÷‡–æ6ÇVFR‚vfö÷FW"ç‡r’óàÐ¢Âö&öG“àÐ¢Ç67&—BG—SÒ'FW‡Bö¦f67&—B#àÐ¢B‚r6Æöv–âr’æ6Æ–6²†gVæ7F–öâ‚—°Ð¢Væ•öÖöFÂ‚$Æöv–â"ÂvÆöv–âç‡rÐ¢ÒÐ¢B‚ræFFWF–ÖW–6¶W"r’æFFWF–ÖW–6¶W"‡°Ð¢f÷&ÖC¢u’ÖÒÖBƒ¦’rÀÐ¢ÒÐ¢B‚r6f–æBÖ6"r’ç7V&Ö—B†gVæ7F–öâ†R—°Ð¢Rç&WfVçDFVfVÇB‚Ð¢Æö6F–öâæ‡&VbÒv–æFW‚ç‡÷vS×6V&6‚br²B‡F†—2’ç6W&–Æ—¦R‚Ð¢ÒÐ¢Â÷67&—CàÐ¢Ã÷‡F6öæâÓæ6Æ÷6R‚’óàÐ Ð£Âö‡FÖÃàÐ