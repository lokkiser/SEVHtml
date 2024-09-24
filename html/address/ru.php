<?php
$path_to_source = "/var/www/html/addressdb.key";
if (is_readable($path_to_source)){
	$handle = fopen($path_to_source, "r+") or die("Error opening!");
	
	$u="";
	$buffer = fgets($handle);
	$u=$buffer;
	
	fclose($handle);
}

$sship = $u;
$sshport = "22";
$sshlogin = "kurs";
$sshpass = "kurs";
$mac="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($_POST["ip"]=="" OR $_POST["gw"]=="")  {
    die("<h1>Ошибка обработчика RVH1;;</h1>");
  } else {
     $ip = htmlspecialchars(($_POST["ip"]));
     $gw = htmlspecialchars(($_POST["gw"]));
     if ($_POST["mac"]!=""){
     	$mac_change=True;
     	$mac = htmlspecialchars(($_POST["mac"]));
     }
     
     $connection = ssh2_connect($sship, $sshport);
     if (ssh2_auth_password($connection, $sshlogin, $sshpass)) {
     	$cmd="/ip address remove [find comment=address];";
     	ssh2_exec($connection, $cmd);
     	$cmd="/ip address add address=$ip/24 interface=ether1 comment=address;";
     	ssh2_exec($connection, $cmd);
     	if ($mac_change){
     	  $cmd="/interface ethernet set ether1 mac-address=$mac;";
     	  ssh2_exec($connection, $cmd);
     	}
     	$cmd="/ip route remove [find comment=gate];";
     	ssh2_exec($connection, $cmd);
     	$cmd="/ip route add dst-address=0.0.0.0/0 gateway=$gw comment=gate";
	    ssh2_exec($connection, $cmd);
	
	    ssh2_disconnect($connection);
     } else {
	    die('<h1>Невозможно подключиться (возможно неверный логин или пароль?)</h1>');
     }
	 # file_put_contents($path_to_source, $ip);
     
     die("<meta http-equiv='refresh' content='2; URL=http://$ip/' /><h1>Успешно!</h1>");
  }  
}else{
  
}
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Смена адреса</title>
<link href="/bootstrap.min.css" rel="stylesheet">
<script src="/jquery3.min.js"></script>
</head>
<body>

    <div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5" tabindex="-1" role="dialog" id="modalSignin">
        <div class="modal-dialog" role="document">
          <div class="modal-content rounded-4 shadow">
		  	<div class="modal-body border-bottom-0">
              <a href="/" class="mb-2 btn btn-lg rounded-3 btn-outline-primary"><img src="/home.png" width="30px" /></a>
              <a href="<?=$_SERVER['HTTP_REFERER'];?>" class="mb-2 btn btn-lg rounded-3 btn-outline-primary" style="float: right;"><img src="/back.png" width="30px" /></a>
            </div>

            <div class="modal-header p-5 pb-4 border-bottom-0">
              <h1 class="fw-bold mb-0 fs-2">Смена адреса</h1>
            </div>
      
            <div class="modal-body p-5 pt-0">
                <div class="form-floating mb-3">
                  <form method="POST">
                    <div class="col-12">
              		<label for="address" class="form-label">IP Адрес</label>
              		<input type="text" name="ip" class="form-control" id="ip" placeholder="<?=$u;?>" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" required="">
              		<div class="invalid-feedback">
                	Please enter your IP address.
              		</div>
            	    </div><br>
            	    <div class="col-12">
              		<label for="gw" class="form-label">Gateway (Шлюз)</label>
              		<input type="text" name="gw" class="form-control" id="gw" placeholder="192.168.0.1" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" required="">
              		<div class="invalid-feedback">
                	Please enter your gateway address.
              		</div>
            	    </div><br>
            	    <div class="col-12">
              		<label for="mac" class="form-label">Mac Адрес (напр. 00:01:23:45:67:89)</label>
              		<input type="text" name="mac" class="form-control" id="mac" pattern="^([0-9A-Fa-f]{2}[:\-]){5}([0-9A-Fa-f]{2})$">
              		<div class="invalid-feedback">
                	Please enter your Mac Address.
              		</div>
            	    </div>
                </div>
                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Сохранить</button>
                <small class="text-body-secondary">Не вводите MAC-адрес, если его изменение не требуется.</small>
              </form>
            </div>
          </div>
        </div>
      </div>
<script src="/bootstrap.bundle.min.js"></script>
</body>
</html>
