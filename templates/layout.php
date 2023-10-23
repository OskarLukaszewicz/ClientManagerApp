<!doctype html>
<html lang="en">
  <head>
  	<title>Client Manager App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script src="./public/js/jquery.min.js"></script>
    <script src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#myTable').dataTable();
        })
    </script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" >
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./public/styles/layoutBootstrap.css">
    <link rel="stylesheet" href="/styles/layoutBootstrap.css">
  </head>
  <body>
    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="custom-menu">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
            <i class="fa fa-bars"></i>
            <span class="sr-only">Toggle Menu</span>
        </button>
    </div>
    <h1><a href="." class="logo">Client Manager App</a></h1>
    <ul class="list-unstyled components mb-5">
        <?php $params['entity'] == "Client" ? print('<li class="active">') : print("<li>") ?>
            <a href="./?entity=Client&action=list"><span class="fa fa-dollar mr-3"></span>Klienci</a>
        </li>
        <?php $params['entity'] == "Employee" ? print('<li class="active">') : print("<li>") ?>
            <a href="./?entity=Employee&action=list"><span class="fa fa-user mr-3"></span>Pracownicy</a>
        </li>
        <?php $params['entity'] == "ContactPerson" ? print('<li class="active">') : print("<li>") ?>
            <a href="./?entity=ContactPerson&action=list"><span class="fa fa-user mr-3"></span>Osoby kontaktowe</a>
        </li>
        <?php $params['entity'] == "PackageType" ? print('<li class="active">') : print("<li>") ?>
            <a href="./?entity=PackageType&action=list"><span class="fa fa-star mr-3"></span>Pakiety</a>
        </li>
        <?php $params['entity'] == "Migration" ? print('<li class="active">') : print("<li>") ?>
            <a href="./?entity=Migration&action=list"><span class="fa fa-database mr-3"></span>Baza Danych</a>
        </li>
    </ul>
    </nav>

      <div id="content" class="p-4 p-md-5 pt-5">
        <?php require_once("templates/pages/$page.php"); ?>
      </div>
      
	</div>

    <script src="./public/js/bootstrap.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./public/js/main.js"></script>
    <script src="./js/main.js"></script>

  </body>
</html>