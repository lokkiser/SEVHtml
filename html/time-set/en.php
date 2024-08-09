<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($_POST["date"]=="" OR $_POST["h"]=="" OR $_POST["m"]=="" OR $_POST["s"]=="") {
    die("<h1>Error TDD1;;</h1>");
  } else {
     $time = (int)($_POST["h"]).":".(int)($_POST["m"]).":".(int)($_POST["s"]);
     $time = (new DateTime($time))->format("H:i:s");
     $date = (new DateTime($_POST["date"]))->format("Ymd");
     shell_exec('sudo date +%Y%m%d -s "'.$date.'"');
     shell_exec('sudo date +%T -s "'.$time.'"');
     die("<meta http-equiv='refresh' content='2; URL=/' /><h1>Success!</h1>");
  }
}else{
  $h=(new DateTime())->format('H');
  $m=(new DateTime())->format('i');
  $s=(new DateTime())->format('s');
  $date=(new DateTime())->format('Y-m-d');
}
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Set the clock</title>
<link href="/bootstrap.min.css" rel="stylesheet">
<script src="/jquery3.min.js"></script>
</head>
<body>

    <div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5" tabindex="-1" role="dialog" id="modalSignin">
        <div class="modal-dialog" role="document">
          <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
              <h1 class="fw-bold mb-0 fs-2">Set the clock</h1>
            </div>
      
            <div class="modal-body p-5 pt-0">
	      <form method="POST">
                <div class="form-floating mb-3">
                    <h2 class="fs-5 fw-bold mb-3">
                    Date: <input type="date" name="date" class="form-control" placeholder="23" required="" value="<?=$date;?>"><br><br>
                    Hours: <input type="number" min="0" max="23" name="h" class="form-control" placeholder="23" required="" value="<?=$h;?>"><br><br>
                    Minutes: <input type="number" min="0" max="59" name="m" class="form-control" placeholder="59" required="" value="<?=$m;?>"><br><br>
                    Seconds: <input type="number" min="0" max="59" name="s" class="form-control" placeholder="00" required="" value="<?=$s;?>"><br><br>
                    </h2>
                </div>
                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Save</button>
                <small class="text-body-secondary">Some interesting inscription.</small>
              </form>
            </div>
          </div>
        </div>
      </div>
<script src="/bootstrap.bundle.min.js"></script>
</body>
</html>
