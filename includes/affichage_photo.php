<?php if(!empty($nomPhoto))
    {
    ?>


    <style type="text/css">
    .roundedImage, .roundedImageShadow, .roundedImageBorder{
  overflow:hidden;
  -webkit-border-radius:80px;
  -moz-border-radius: 80%;
  border-radius:80px;
  width:150px;
  height:150px;
  text-align: center;
 }
.roundedImageShadow{
  -moz-box-shadow: 0px 0px 10px #343434;
  -webkit-box-shadow: 0px 0px 10px #343434;
  -o-box-shadow: 0px 0px 10px #343434;
  box-shadow: 0px 0px 10px #343434;
}
.roundedImageBorder{
  border: 1px solid #006699;
}
    }
    </style>
    <center>
    <div class="roundedImageShadow" style="background:url(../Utilisateur/Photo_Profil/<?php echo $nomPhoto ?>) no-repeat 0px 0px;">
        &nbsp;
    </div>
    </center>
    <?php
    }
    else
    {
      ?>
       <img src="../Utilisateur/Photo_Profil/photo-default.png" width="150" height="150">
    <?php  
    }
    ?>