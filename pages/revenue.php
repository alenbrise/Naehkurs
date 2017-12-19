<?php checkForAuthorization(true); ?>
<body>
   <?php
   echo getAdminNavbar();
   ?>
</body>

<?php

@$sortieren = $_GET['sortieren'];
if (isset($_POST['txtStartdate']) and ( $_POST['txtEnddate'])) {
    $courseRevenues = getRevenueByCourse($_POST['txtStartdate'], $_POST['txtEnddate']);
    echo getRevenueTable($courseRevenues);    
}
?>

<body>
    <form name ="revenue" method="post" action="index.php?page=revenue">
        <div class="form-group">
            <label for="txtStartdate">Anfangsdatum</label>
            <input type="date" class="form-control" name="txtStartdate" placeholder="01.01.1900">
        </div>
        <div class="form-group">
            <label for="txtEnddate">Enddatum</label>
            <input type="date" class="form-control" name="txtEnddate" placeholder="01.01.1900">
        </div>
        <button type="submit" >Abrechnung erstellen</button>
    </form>
</body>