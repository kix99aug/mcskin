<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>上傳結果</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js" integrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ" crossorigin="anonymous"></script>
</head>
<body background="img/upload.png" onload="$('#main').modal({backdrop: 'static', keyboard: false},'show');">
<div class="modal" id="main" tabindex="-1" role="dialog" aria-hidden="true" >
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
		<div class="modal-body" style="text-align:center;">
<form>
<center><h3><i class="fas fa-cloud-upload-alt"></i> 上傳結果</h3></center></p><HR>
<?php
$ch = array("皮膚","披風","鞘翅");
$dirs = array("skin","cape","elytra");
$total_uploads = 3;
$size_bytes =1024 * 1024;
$limitedext = ".png";
for ($i = 0; $i < $total_uploads; $i++) {
	$new_file = $_FILES[$dirs[$i]];
    $file_tmp = $new_file['tmp_name'];
    if(file_exists($file_tmp)) list($width,$height,$type,$attr)=getimagesize($file_tmp);
    $file_size = $new_file['size'];
    if (!is_uploaded_file($file_tmp)) {
      $flag = 1;
    }
    else{
      $ext = strrchr($new_file['name'],'.');
      if (strcmp(strtolower($ext),$limitedext)) {
        $flag = 2;
      }else{
        if ($file_size > $size_bytes){
          $flag = 3;
        }else{
			if(!(($i==0&&($width==$height&&$height%64==0))||($width/$height==2&&$height%32==0))){
			if($i==0) $flag = 4;
			else $flag = 5;
			}
			else{
				if (move_uploaded_file($file_tmp,'mc/'.$dirs[$i].'s/'.$_POST[ID].$ext)) {
            $flag = 6;
          }else{
            $flag = 7;
          }
       }
       }
     }
  }
  echo '<button type="button" class="btn btn-';
  if ($flag == 6) echo 'success';
  else if ($flag == 1) echo 'warning';
  else echo 'danger';
  echo ' btn-lg btn-block" disabled>';
  if ($flag == 1) echo '<i class="fas fa-minus"></i> ';
  else if ($flag == 6) echo '<i class="fas fa-check"></i> ';
  else echo '<i class="fas fa-times"></i> ';
  if ($flag == 1) echo "$ch[$i]未更新！";
  else if ($flag == 2) echo "$ch[$i]的檔案類型有誤（只允許PNG檔）";
  else if ($flag == 3) echo "$ch[$i]無法上傳，請檢查檔案是否小於 ". $size_bytes / 1024 / 1024 ." MB。";
  else if ($flag == 4) echo "$ch[$i]無法上傳，請檢查圖片長寬是否符合<b>64*32<br> (單層)或64*64 (雙層)</b>的整數倍。";
  else if ($flag == 5) echo "$ch[$i]無法上傳，請檢查圖片長寬是否符合<b>64*32<br></b>的整數倍。";
  else if ($flag == 6) echo "$ch[$i]已更新！";
  else if ($flag == 7) echo "$ch[$i]無法上傳。";
  echo "</button>";
  if ($i!=2) echo "</p><HR>";
}
?>
</form>
			</div>			
		</div>
	</div>
</div>
</body>
</html>