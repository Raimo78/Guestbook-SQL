<!DOCTYPE html>
<html>
  <head>
    <title>Calendar Demo</title>
    <link rel="stylesheet" href="CSS/calendar.css">
    <script src="js/calender.js"></script>
  </head>
  <body>
   
    <div id="calPeriod"><?php
    
      $months = [
        1 => "January", 2 => "Febuary", 3 => "March", 4 => "April",
        5 => "May", 6 => "June", 7 => "July", 8 => "August",
        9 => "September", 10 => "October", 11 => "November", 12 => "December"
      ];
      $monthNow = date("m");
      echo "<select id='calmonth'>";
      foreach ($months as $m=>$mth) {
        printf("<option value='%s'%s>%s</option>", 
          $m, $m==$monthNow?" selected":"", $mth
        );
      }
      echo "</select>";

      echo "<input type='number' id='calyear' value='".date("Y")."'/>";
    ?></div>

    <div id="calwrap"></div>

    <div id="calblock"><form id="calform">
      <input type="hidden" id="evtid"/>  
      <label for="start">Date Start</label>
      <input type="date" id="evtstart" required/>
      <label for="end">Date End</label>
      <input type="date" id="evtend" required/>
      <label for="txt">Event</label>
      <textarea id="evttxt" required></textarea>
      <label for="color">Color</label>
      <input type="color" id="evtcolor" required/>
      <input type="submit" id="calformsave" value="Save"/>
      <input type="button" id="calformdel" value="Delete"/>
      <input type="button" id="calformcx" value="Cancel"/>
    </form></div>
  </body>
</html>