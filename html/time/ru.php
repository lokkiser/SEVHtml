<?php
$changeSecs = "";
$path_to_source = "/etc/chrony/sources.d/default.sources";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($_POST["secs"]=="") {
    die("<h1>Ошибка обработчика ED1;;</h1>");
  } else {
     $changeSecs = (int)($_POST["secs"]);
     $offset_time = $changeSecs.".0";
     
  print(!is_readable($path_to_source));
  if (is_readable($path_to_source)){
      $handle = fopen($path_to_source, "r+") or die("Ошибка открытия настроек!");
      
      $u="";
      while (($buffer = fgets($handle)) !== false) {
        $sss = preg_match('/(?<=offset )[0-9.-]+/',$buffer,$found);
      	$s=($found[0]);

      	$temp_buf = str_replace($s, $offset_time, $buffer);
      	$u=$u.$temp_buf;
      }
      
      fclose($handle);
    
      file_put_contents($path_to_source, $u);
  }
     shell_exec('sudo chronyc reload sources');
     sleep(1);
     shell_exec('sudo chronyc makestep 0.1 -1');
     die("<meta http-equiv='refresh' content='2; URL=/' /><h1>Успешно!</h1>");
  }  
}else{
  print(!is_readable($path_to_source));
  if (is_readable($path_to_source)){
      $handle = fopen($path_to_source, "r+") or die("Ошибка открытия настроек!!");

      $temp_buf = fgets($handle);

      $sss = preg_match('/(?<=offset )[0-9.-]+/',$temp_buf,$found);
      $s=(int)($found[0]);
      fclose($handle);
  }
  $changeSecs=$s;
}
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Смена времени</title>
<link href="/bootstrap.min.css" rel="stylesheet">
<script src="/jquery3.min.js"></script>
</head>
<body>

    <div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5" tabindex="-1" role="dialog" id="modalSignin">
        <div class="modal-dialog" role="document">
          <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
              <h1 class="fw-bold mb-0 fs-2">Смена времени</h1>
            </div>
      
            <div class="modal-body p-5 pt-0">
                <div class="form-floating mb-3">
                    <h2 class="fs-5 fw-bold mb-3">
                    Часов: <b id="change1"> </b> <button class="py-1 mb-2 btn btn-outline-primary rounded-3" onclick="hourp()">+</button> <button class="py-1 mb-2 btn btn-outline-primary rounded-3" onclick="hourm()">−</button><br><br>
                    Минут: <b id="change2"> </b> <button class="py-1 mb-2 btn btn-outline-primary rounded-3" onclick="minp()">+</button> <button class="py-1 mb-2 btn btn-outline-primary rounded-3" onclick="minm()">−</button><br><br>
                    Секунд: <b id="change3"> </b> <button class="py-1 mb-2 btn btn-outline-primary rounded-3" onclick="secsp()">+</button> <button class="py-1 mb-2 btn btn-outline-primary rounded-3" onclick="secsm()">−</button><br><br>
                    </h2>
                </div>
              <form method="POST">
                <input id="chaaange" name="secs" value="<?=$changeSecs;?>" hidden required/>
                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Сохранить</button>
                <small class="text-body-secondary">Какая-то интересная надпись.</small>
              </form>
            </div>
          </div>
        </div>
      </div>

    <script>
        $(document).ready(function () {
            validate();
        });

        function validate() {
            var secs = $('#chaaange').val();
            var v1 = parseInt(secs / 3600);
            var v2 = parseInt((secs % 3600) / 60);
            var v3 = (secs % 3600) % 60;
            $('#change1')[0].innerHTML = v1;
            $('#change2')[0].innerHTML = v2;
            $('#change3')[0].innerHTML = v3;
        }

        function hourp() {
            var secs = parseInt($('#chaaange').val());
            secs+=3600;
            $('#chaaange').attr('value',secs);
            validate();
        }
        function hourm() {
            var secs = parseInt($('#chaaange').val());
            secs-=3600;
            $('#chaaange').attr('value',secs);
            validate();
        }
        function minp() {
            var secs = parseInt($('#chaaange').val());
            secs+=60;
            $('#chaaange').attr('value',secs);
            validate();
        }
        function minm() {
            var secs = parseInt($('#chaaange').val());
            secs-=60;
            $('#chaaange').attr('value',secs);
            validate();
        }
        function secsp() {
            var secs = parseInt($('#chaaange').val());
            secs+=1;
            $('#chaaange').attr('value',secs);
            validate();
        }
        function secsm() {
            var secs = parseInt($('#chaaange').val());
            secs-=1;
            $('#chaaange').attr('value',secs);
            validate();
        }
    </script>
<script src="/bootstrap.bundle.min.js"></script>
</body>
</html>
