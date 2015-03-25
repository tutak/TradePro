<?php
    include('database.php');
    $db = new dao("root", '', "mtp_db", "mysql", "localhost");
    $db->connect();
    
    // Array containing data for Map Grap
    $sup_array = $db->mapData();
    // Array containing data for Calibro Graph
    $sup_array2 = $db->calibroData();
?>


<html lang="en">
<head>  
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <!--Script to create Map Graph-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["geochart"]});
      google.setOnLoadCallback(drawRegionsMap);
      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable(<?php
        //Passing the graph data from $sup_array, in it's particular format.   
       echo "[['Country','Messages received']";
      foreach($sup_array as $sub) {
        echo",[".$sub[0].",".$sub[1]."]";
    }

    echo"]";
    ?>);
        var options = {colorAxis: {colors: ['lightgreen', 'green', 'darkgreen']}};
        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
        chart.draw(data, options);
      }
    </script>
    <!--Script to create Calibro Graph-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["gauge"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php
      //Passing the graph data from $sup_array2, in it's particular format.   
    echo "[['Label','Value']";
    foreach($sup_array2 as $sub2) {
        echo",['".$sub2[0].",".$sub2[1]."-".$sub2[2]."',".$sub2[3]."]";
    }

    echo"]";
    ?>);
        var options = {
          max:20,
          width: 400, height:400,
          redFrom: 17, redTo: 20,
          yellowFrom:13, yellowTo: 17,
          minorTicks: 5
        };
        var chart = new google.visualization.Gauge(document.getElementById('chart_div'));
        chart.draw(data, options);
        }
    </script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/freelancer.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
</head>
<body id="page-top" class="index">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#page-top">Home</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <a href="#portfolio">Map Graph</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#about">Calibro Graph</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-text">
                        <span class="name">Message Trade Processor</span>
                        <hr class="star-light">
                        <span class="skills">Map graph shows the number of messages received from each country.<br/>
                                             Calibro graph shows the latest message received for a given country along with the currency names and the exchange rate. </span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Map Graph Section -->
    <section id="portfolio">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Map Graph</h2>
                    <hr class="star-primary">
                </div>
            </div>
        </div>
        <div id="regions_div" class="row" style="width: 900px; height: 450px; margin:0 auto; ">
        </div>
    </section>
    <!-- Calibro Graph Section -->
    <section class="success" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Calibro Graph</h2>
                    <hr class="star-light">
                </div>
            </div>
        </div>
        <div id="chart_div" style="width: 1000px; height: 500px; margin:0 auto;">
        </div>
    </section>
    <!-- Footer -->
    <footer class="text-center">
        <div class="footer-above">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-4">
                        <ul class="list-inline">
                            <li>
                                <a href="https://www.facebook.com/abdul.tutakhail" class="btn-social btn-outline"><i class="fa fa-fw fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="https://plus.google.com/113879911644318409913" class="btn-social btn-outline"><i class="fa fa-fw fa-google-plus"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Copyright &copy; Message Trade Processor 2015
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-top page-scroll visible-xs visble-sm">
        <a class="btn btn-primary" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="js/classie.js"></script>
    <script src="js/cbpAnimatedHeader.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/freelancer.js"></script>
</body>
</html>