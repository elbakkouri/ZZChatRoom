<!DOCTYPE html>
<html>
  <head>
    <title>zzChat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/myCss.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <meta name="description" content="zzChat site de chat en ligne">
    <meta name="keywords" content="chat,room,private,public">
    <meta charset="utf8">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/ckeditor/ckeditor.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-default" role="navigation">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">ChatRoomZZ2</a>
      </div>
       
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= _t('lang') ?><b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="index.php?request=lang&lang=fr">Français</a></li>
              <li><a href="index.php?request=lang&lang=en">English</a></li>
            </ul>
          </li>
          <?php if(isset($_SESSION['username'])) echo '<li><a href="logout.php">'._t("logout").'</a></li>'; ?>
        </ul>
      </div><!-- /.navbar-collapse -->
    </nav>