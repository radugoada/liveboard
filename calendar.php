<?php
// Initialize the session
session_start();
include_once 'common.php';

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
   header("location: index.php");
   exit;
}
?>

<!DOCTYPE html>
<html>
 <head>
  <meta name="Radu Goada" content="author">
    <link rel="Shortcut Icon" href="resources/images/favicon_liveboard.ico">
  	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title><?php echo $lang['NAVRBAR_CALENDAR']; ?></title>
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Material Design Lite">
    <!-- My bootstrap -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.cyan-light_blue.min.css">
   <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> 
   <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> 
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> 
    <link rel="stylesheet" href="resources/css/calendar.css">
    
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script> 
 <script>
   
  $(document).ready(function() {
   var calendar = $('#calendar').fullCalendar({
    editable:true,
    header:{
     left:'prev,next today',
     center:'title',
     right:'month,agendaWeek,agendaDay'
    },
    events: 'load.php',
    selectable:true,
    selectHelper:true,
    select: function(start, end, allDay)
    {
     var title = prompt("Please enter Event title:");
     if(title)
     {
      var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
      var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
      $.ajax({
       url:"insert.php",
       type:"POST",
       data:{title:title, start:start, end:end},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        alert("Event added successfully!");
       }
      })
     }
    },
    editable:true,
    eventResize:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;
     $.ajax({
      url:"update.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function(){
       calendar.fullCalendar('refetchEvents');
       alert('Event Update');
      }
     })
    },

    eventDrop:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;
     $.ajax({
      url:"update.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function()
      {
       calendar.fullCalendar('refetchEvents');
       alert("Event Updated");
      }
     });
    },

    eventClick:function(event)
    {
     if(confirm("Are you sure you want to remove it?"))
     {
      var id = event.id;
      $.ajax({
       url:"delete.php",
       type:"POST",
       data:{id:id},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        alert("Event Removed");
       }
      })
     }
    },

   });
  });
   
  </script>
 </head>
 
 
 
 <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">

<body class="home">

 <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
     
    <header class="demo-header mdl-layout__header mdl-color--grey-100 mdl-color-text--grey-600">
       
        <div class="mdl-layout__header-row">
               
        <span class="mdl-layout-title"><?php echo $lang['NAVRBAR_CALENDAR']; ?></span>
          <div class="mdl-layout-spacer"></div>
             <a id="flag" href="calendar.php?select-language" class="dropdown-toggle" data-toggle="dropdown"><i style="list-style: none;" class="fa fa-globe fa-2x"></i></a>
                            
                                <ul class="dropdown-menu dropdown-menu-flag" role="menu">
                                  <li>
                                        <a href="calendar.php?lang=ro">
                                            <img src="http://www.country-dialing-codes.net/img/png-country-4x2-flat-res-640x480/ro.png" alt="Romana" width="28px" height="18px">
                                            <span>Romana</span>
                                        </a>
                                  </li>
                                  <li>
                                        <a href="calendar.php?lang=en">
                                            <img src="http://www.country-dialing-codes.net/img/png-country-4x2-flat-res-640x480/gb.png" alt="English" width="28px" height="18px">
                                            <span>English</span>
                                        </a>
                                  </li>       
                                </ul>
                    </li>
          <!--</div> -->
          
        </header>   
        <!-- </div> -->
      
      <div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
        <header class="demo-drawer-header">
        
         <center> <img src="resources/images/liveboard_logo_small.png" class="demo-avatar"> </center>     
      
             <center><h6><?php echo $lang['NAVBAR_WELCOME_TITLE']; ?>, <?php echo htmlspecialchars($_SESSION["username"]); ?> <img src="resources/images/online_green_icon.png" alt="small-green-icon" border="0"></h6></center>
           <!--   <li class="mdl-menu__item">info@example.com</li>
              <li class="mdl-menu__item"><i class="material-icons">add</i>Add another account...</li>
            </ul> -->
        <!--  </div> -->

      </header>
        <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
          <a class="mdl-navigation__link" href="dashboard.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">dashboard</i><?php echo $lang['MAIN_DASHBOARD']; ?></a>
          <a class="mdl-navigation__link" href="#"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">developer_board</i><?php echo $lang['NAVRBAR_BOARD']; ?></a>
          <a class="mdl-navigation__link" href="unitConverter.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">swap_horiz</i><?php echo $lang['NAVRBAR_CONVERTER']; ?></a>
          <a class="mdl-navigation__link" href="shortcuts.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">keyboard</i><?php echo $lang['NAVRBAR_SHORTCUTS']; ?></a>
          <a class="mdl-navigation__link" href="currency.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">euro_symbol</i><?php echo $lang['NAVRBAR_CURRENCY']; ?></a>
          <a class="mdl-navigation__link" href="calendar.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">perm_contact_calendar</i><?php echo $lang['NAVRBAR_CALENDAR']; ?></a>
          <a class="mdl-navigation__link" href="maps.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">map</i><?php echo $lang['NAVRBAR_MAPS']; ?></a>
          <a class="mdl-navigation__link" href="links.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">link</i><?php echo $lang['NAVRBAR_LINKS']; ?></a>
          <a class="mdl-navigation__link" href="logout.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">exit_to_app</i><?php echo $lang['NAVRBAR_LOGOUT']; ?></a>
        </nav>
       </nav> <!-- End of SIDEBAR Navigation -->
          
      </div> <!-- End of DEMO DRAWER  -->  
     
 <main class="mdl-layout__content mdl-color--grey-100">
     <div class="mdl-grid demo-content">

         
    
 
  <br />
  <div class="container">
   <div id="calendar"></div>
  </div>
  
  
 
  
      </main> <!--END OF MAIN CLASS -->
      
    </div> 

 <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
  <script>
  var button = document.createElement('button');
  var textNode = document.createTextNode('Click Me!');
  button.appendChild(textNode);
  button.className = 'mdl-button mdl-js-button mdl-js-ripple-effect';
  componentHandler.upgradeElement(button);
  document.getElementById('container').appendChild(button);
</script> 

</body>

</html>
 
 


