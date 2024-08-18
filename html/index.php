<?php
   //get-satellite
   $s1_write="red";
   $s2_write="yellow";
   $s3_write="green";

  //time
  $tttttime=(new DateTime())->format("H:i:s");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Control panel of System of Uniform Time</title>
<link href="bootstrap.min.css" rel="stylesheet">
<script src="jquery3.min.js"></script>
<style>
   .st {
    border-radius: 10px;
    height: 50px;
    width: 50px;
    margin-right: 20px;
    display: inline-block;
   }
  </style>
</head>
<body>
    <div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5" tabindex="-1" role="dialog" id="modalSignin">
        <div class="modal-dialog" role="document">
          <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
              <br><br>
              <h1 class="fw-bold mb-0 fs-5"><center>Панель управления Системой Судового Единого Времени (ССЕВ)<br><br> Control panel of System of Uniform Time<br><br></center></h1>
            </div>
      
            <div class="modal-body p-5 pt-0">
                <h1 class="mb-0 fs-5"><center>Current time / Текущее время:<br>HH:MM:SS <?=$tttttime;?></center></h1>
                <br> <br>
                <a href="/time/" class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Change offset / Установка сдвига времени offset</button>
                </a>
		            <a href="/time-set/" class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Set fix time / Установка фиксированного времени</button>
                </a>
                <a href="/address/" class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Change address / Смена адреса</button>
		            </a>
              <br><br>
              <center>
                <div class="container">
                  <div class="st" style="background: <?=$s1_write;?>;"><img src="satellite.png" width="47px"/>NTP1</div>
                  <div class="st" style="background: <?=$s2_write;?>;"><img src="satellite.png" width="47px"/>NTP2</div>
                  <div class="st" style="background: <?=$s3_write;?>;"><img src="satellite.png" width="47px"/>NTP3</div>
                </div>
              </center>
            </div>
          </div>
        </div>
      </div>
<script src="bootstrap.bundle.min.js"></script>
<meta http-equiv='refresh' content='1; URL=/' />
</body>
</html>
