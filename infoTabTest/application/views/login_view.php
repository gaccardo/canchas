
<body>
<div class="header-bg" id="header">
   <div id="headerSup"> 
     <div id="logo"><a href="index.php"><img border="0" alt="logo" width="307" height="135" src="<?= base_url() .APPPATH ?>images/logoEhead.png"></a></div> 
    </div> 
    <div id="headerTitle"></div>

</div>
<div class="content">

      <div class="heading"><img src="<?= base_url() .APPPATH ?>images/login.png" alt="Administrative Console Login" width="48" height="48" />
        <h1>Administrative Console Login</h1>
      </div>
      <div class="inner">
          <?php $attributes = array('name' => 'login', 'id' => 'login');
        echo form_open('login',$attributes)?>
        <?=form_fieldset('Login Form')?>
		<!-- <form method="post" name="login" id="login" action="<=$_SERVER['PHP_SELF']?>" >-->
			<table align="center" cellpadding="0" cellspacing="10" class="login-table">
			  <tr>
				<td><?=form_label('username', 'user_name')?></td>
				<td><?=form_error('username')?> 
				    
				    <?$data = array('name'=>'username','id'=>'username','value'=>'demo','maxlength'=>'32','size'=>'34',);
				echo form_input($data )?></td>
			  </tr>
			  <tr>
				<td> <?=form_label('password', 'user_pass')?></td>
				    <?=form_error('userpass')?> 
				<td><?$data = array('name'=>'userpass','id'=>'userpass','value'=>'demo','maxlength'=>'32','size'=>'34',);
				    echo form_password($data)?></td>
			  </tr>
			  <tr>
				<td></td>
				<td colspan="2" align="center">  
				    <?$data = array('name'=>'login','id'=>'login_button','value'=>'Login','class'=>'image_button',);
				   echo form_submit($data)?></td>
				
				 <?=form_fieldset_close()?>
                <?=form_close();?>
				
			  </tr>
			</table>
		  <!--</form>-->
	
      </div>
     
		<div class="error_msg" style="display:<?=$display?>;"> 
			<?=$errorMsg?>
		</div>
      

</div>


	<br clear="both" />
	
	<div style="overflow:hidden;align:center;" align="center">
		
		<div class="copyright">Copyright &copy; 2012 Infocentro-Sistemas.&nbsp;&nbsp;&nbsp;
			Website by <a style="font-size:12px;" href="http://www.ehead.com.ar" target="_blank">Ehead-Systems</a>
		</div>
			
	</div>
</body>
</html>
<script>
$(document).ready(function(){

    $("#login").validate({
        rules: {
            username: {
                required: true
            },
            userpass: {
                required: true,
                minlength: 1
            }
        }
    });
      
});
</script>
