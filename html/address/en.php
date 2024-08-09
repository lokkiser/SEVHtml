<?php
$sship = "192.168.0.1";
$sshport = "22";
$sshlogin = "kurs";
$sshpass = "kurs";
$mac="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($_POST["ip"]=="" OR $_POST["gw"]=="")  {
    die("<h1>Error RVH1;;</h1>");
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
	    die('<h1>Cannot connect (maybe invalid login or password?)</h1>');
     }
     
     die("<meta http-equiv='refresh' content='2; URL=/' /><h1>Success!</h1>");
  }  
}else{
  
}
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Change address</title>
<link href="/bootstrap.min.css" rel="stylesheet">
<script src="/jquery3.min.js"></script>
</head>
<body>

    <div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5" tabindex="-1" role="dialog" id="modalSignin">
        <div class="modal-dialog" role="document">
          <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
              <h1 class="fw-bold mb-0 fs-2">Change address</h1>
            </div>
      
            <div class="modal-body p-5 pt-0">
                <div class="form-floating mb-3">
                  <form method="POST">
                    <div class="col-12">
              		<label for="address" class="form-label">IP Address</label>
              		<input type="text" name="ip" class="form-control" id="ip" placeholder="192.168.0.123" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" required="">
              		<div class="invalid-feedback">
                	Please enter your IP address.
              		</div>
            	    </div><br>
            	    <div class="col-12">
              		<label for="gw" class="form-label">Gateway</label>
              		<input type="text" name="gw" class="form-control" id="gw" placeholder="192.168.0.1" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" required="">
              		<div class="invalid-feedback">
                	Please enter your gateway address.
              		</div>
            	    </div><br>
            	    <div class="col-12">
              		<label for="mac" class="form-label">Mac Address (ex. 00:01:23:45:67:89)</label>
              		<input type="text" name="mac" class="form-control" id="mac" pattern="^([0-9A-Fa-f]{2}[:\-]){5}([0-9A-Fa-f]{2})$">
              		<div class="invalid-feedback">
                	Please enter your Mac Address.
              		</div>
            	    </div>
                </div>
                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Save</button>
                <small class="text-body-secondary">Do not enter MAC address, if it's change is not required</small>
              </form>
            </div>
          </div>
        </div>
      </div>
<script src="/bootstrap.bundle.min.js"></script>
</body>
</html>