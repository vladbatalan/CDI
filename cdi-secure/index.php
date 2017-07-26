<html lang="en">

<head>
	<?php
		include "include/connection/database.php";
	?>
	
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CDI-Centrul de documentare si informare</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/agency.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<style>

.container1{
	background-image:url(img/backgrounds/img1.jpg);
	background-repeat: no-repeat;
	background-position: relative;
	background-attachment: fixed;
	webkit-background-size: cover;
  moz-background-size: cover;
  o-background-size: cover;
  background-size: cover;
}
.container2{
	width:auto;
margin: 0 auto;
position:relative;
	background-image:url(img/backgrounds/img2.jpg);
	background-repeat: no-repeat;
	background-position: center center;
	background-attachment: fixed;
}
.container3{
	background-image:url(img/backgrounds/img3.jpg);
	background-repeat: no-repeat;
	background-position: center center;
	background-attachment: fixed;
	webkit-background-size: cover;
  moz-background-size: cover;
  o-background-size: cover;
  background-size: cover;
}
.container4{
	background-image:url(img/backgrounds/img2.jpg);
	background-repeat: no-repeat;
	background-position: relative;
	background-attachment: fixed;
	webkit-background-size: cover;
  moz-background-size: cover;
  o-background-size: cover;
  background-size: cover;
}
h2{
	color:white;
}
h3{
	color:white;
}
</style>
<body id="page-top" class="index">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" >
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">Colegiul National "A.T. Laurian"</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <?php
                    	if(isset($_SESSION['login'])) {
                            if($_SESSION['login']['rol'] == 'admin' || $_SESSION['login']['rol'] == 'admin_suprem')
                            {
                                echo "
                                <li>
                                    <a class='page-scroll' href='dashboard/admin-home.php'>Dashboard</a>
                                </li>";
                            }
                    		echo "
							<li>
		                        <a class='page-scroll' href='profil.php?user=".$_SESSION['login']['id_user']."'>".$_SESSION['login']['username']."</a>
		                    </li>";
                    	} 
                    ?>
					<li>
                        <a class="page-scroll" href="#services">Servicii</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#portfolio">Săli</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#about">Evenimente</a>
                    </li>
                    <?php 
                    	if(!isset($_SESSION['login']))
                    	{
                    		echo "
                    		<li>
								<a class='page-scroll' href='register.php'>Register</a>
							</li>";
                    	}
                    ?>
					
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <header>
        <div class="container">
            <div class="intro-text">
                <div class="intro-lead-in">Centrul de documentare şi informare</div>
                	<div class="intro-heading">Bine aţi venit!</div>
                	<?php 
                		$log = "Log in";
                    	if(isset($_SESSION['login'])) {
                    		echo "<div class='intro-lead-in'>".$_SESSION['login']['nume']." ".$_SESSION['login']['prenume']."</div>
							";
							$log = "Log out";
                    	} 
                    ?>
               		
				<a href='login.php'>
				<button type='button' class='btn btn-primary' > <?php echo $log; ?></button>
				</a>
            </div>
        </div>
    </header>

    <!-- Services Section -->
    <section id="services">
	
        <div class="container1" >
			<div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading" style="color: white; text-shadow: 1px 1px 1px black;">Servicii</h2>
                </div>
            </div>
            
            <div class="row text-center">
				<div class="col-md-4">
					<a href="include/carti/Book_arhive.php" onclick="window.location.href = 'include/carti/Book_arhive.php';" class="books-link" data-toggle="modal"><img src="img/books.png" class="img-center"></img></a>
					<p class="text-center"></p>
                    <h4 class="service-heading" style="color: white; text-shadow: 1px 1px 1px black;">Imprumută carţi</h4>
                    <p class="text-muted" style="color: white; text-shadow: 1px 1px 1px black;">Daca esti elev al liceului, poti sa imprumuti orice carte disponibila pe stoc.</p>
                </div>
				
                <div class="col-md-4">
                    <a href="#portfolio"><img src="img/rooms.png" class="img-center"></img></a>
					<p class="text-center"></p>
                    <h4 class="service-heading" style="color: white; text-shadow: 1px 1px 1px black;">Rezervă o sală</h4>
                    <p class="text-muted" style="color: white; text-shadow: 1px 1px 1px black;">Daca esti profesor, poti sa rezervi una din cele patru sali multimedia ale liceului pentru ore interactive!</p>
                </div>
                <div class="col-md-4">
                    <img src="img/more.png" class="img-center"></img>
					<p class="text-center"></p>
                    <h4 class="service-heading" style="color: white; text-shadow: 1px 1px 1px black;">Află mai multe despre Laurian</h4>
                    <p class="text-muted" style="color: white; text-shadow: 1px 1px 1px black;">Centrul de dezvoltare si informare</p>
                </div>
				
            </div>
        </div>
    </section>

    <!-- Portfolio Grid Section -->
    <section id="portfolio" class="bg-light-gray">
        <div class="container4">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading" style="color: white; text-shadow: 1px 1px 1px black;">Săli</h2>
                    <h3 class="section-subheading text-muted" style="color: white; text-shadow: 1px 1px 1px black;">Alfa programul fiecarei sali</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6 portfolio-item">
                    <a href="#portfolioModal1" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
						    <img src="img/cdi.gif" width="100%" height="100%" align=""></img>
                        </div>
                        <img src="img/portfolio/cdi.jpg" class="img-responsive" alt="">
                    </a>
                    <div class="portfolio-caption">
                        <h4>CDI</h4>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 portfolio-item">
                    <a href="#portfolioModal2" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
						    <img src="img/aula.gif" width="100%" height="100%" align=""></img>
                        </div>
                        <img src="img/portfolio/aula.jpg" class="img-responsive" alt="">
                    </a>
                    <div class="portfolio-caption">
                        <h4>Aula Magna</h4>
                    </div>
					  
                </div>
                <div class="col-md-4 col-sm-6 portfolio-item">
                    <a href="#portfolioModal3" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
						    <img src="img/amfiteatru.gif" width="100%" height="100%" align=""></img>
                        </div>
                        <img src="img/portfolio/amfiteatru.jpg" class="img-responsive" alt="">
                    </a>
                    <div class="portfolio-caption">
                        <h4>Amfiteatru</h4>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 portfolio-item">
                    <a href="#portfolioModal4" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
							<img src="img/salaproiectie.gif" width="100%" height="100%" align=""></img>
                        </div>
                        <img src="img/portfolio/salaproiectie.jpg" class="img-responsive" alt="">
                    </a>
                    <div class="portfolio-caption">
                        <h4>Sală proiecţie</h4>
                    </div>
                </div>
              
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about">
        <div class="container3">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading" style="color: white; text-shadow: 1px 1px 1px black;">Evenimente</h2>
                    <h3 class="section-subheading text-muted" style="color: white; text-shadow: 1px 1px 1px black;">recent in Laurian</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <ul class="timeline">
                        <li>
                            <div class="timeline-image">
                                <img class="img-circle img-responsive" src="img/octav.png" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>2011-2013</h4>
                                    <h4 class="subheading" style="color: white; text-shadow: 1px 1px 1px black;">Concursul Octav Onicescu</h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted" style="color: white; text-shadow: 1px 1px 1px black;">Motivaţia organizării acestui concurs a fost în primul rând aceea de a aduce un omagiu ilustrului matematician, remarcabilă personalitate ce face parte din elita Colegiului Naţional “August Treboniu  Laurian“, din Botoşani, dar şi ideea de a da o nouă abordare concursurilor de matematică.
										<br>
               Noutatea acestui concurs constă în elaborarea subiectului  unic pentru toţi elevii de liceu, dezvoltând inteligenţa, iscusinţa, de fapt abilităţile matematice pure. Subiectele  suportă abordare din partea elevilor indiferent de anul de studiu, nefiind axate pe tehnică precum subiectele tradiţionale ale olimpiadelor şcolare, ci urmărind găsirea unor strategii de rezolvare, urmărind de fapt creativitatea participanţilor, descoperirea elementului subtil din fiecare problemă. Originalitatea subiectelor şi de fapt atractivitatea lor stimulează participanţii. Subiectele sunt de tipul celor de la proba de baraj a olimpiadelor naţionale și internaţionale, dar având un grad de dificultate mai scăzut, astfel încât să fie accesibile unui număr cât mai mare de elevi. Confirmarea asupra frumuseţii subiectelor am avut-o in momentul in care au participat la concurs elevi componenţi ai lotului olimpic de matematică şi  elevi cu performanţe in matematică.
									</p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-inverted">
                            <div class="timeline-image">
                                <img class="img-circle img-responsive" src="img/mun.jpg" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>2013-1015</h4>
                                    <h4 class="subheading" style="color: white; text-shadow: 1px 1px 1px black;">BTMUN</h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted" style="color: white; text-shadow: 1px 1px 1px black;"> Like hundreds of similar events around the world, Botoşani Model United Nations is a simulation of some of the proceedings of the real United Nations, where students take on the role of various countries’ ambassadors or delegates to the United Nations.</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-image">
                                <img class="img-circle img-responsive" src="img/3cdi.png" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>Martie 2016</h4>
                                    <h4 class="subheading" style="color: white; text-shadow: 1px 1px 1px black;">Deshiderea site-ului pentru CDI</h4>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Contact Section -->

	<!--Login Section-->
  

    <!-- Portfolio Modals -->
    <!-- Use the modals below to showcase details about your portfolio projects! -->

    <!-- Portfolio Modal 1 -->
    <div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <!-- Project Details Go Here -->
                            <h2>Centrul de documentare şi informare </h2>
							<img class="img-responsive img-centered" src="img/2cdi.jpg" alt="CDI">
                            <img class="img-responsive img-centered" src="img/portfolio/roundicons-free.png" alt="">
                            <p><b>CDI</b>-ul este situat la parterul corpului. Loc potrivit pentru activități specifice și complexe.</p>
                           
                            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
							<a href = "include/camere/room_table.php?room=1">
							<button type="button" class="btn btn-primary" ><i class="fa fa-times"></i> Vezi program</button>
							</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	


</body>
</html>


    <!-- Portfolio Modal 2 -->
    <div class="portfolio-modal modal fade" id="portfolioModal2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <h2>Aula Magna</h2>
                            <img class="img-responsive img-centered" src="img/2aula.jpg" alt="Aula Magna">
                            <p><b>Aula</b> este situată la parterul corpului A fiind dotată cu video proiector, laptop și boxe. Se pot organiza conferințe, prezentări, spectacole și multe altele. Are o capacitate de aproximativ 200 de persoane.</p>
                            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
							<a href="include/camere/room_table.php?room=2" class="portfolio-link" data-toggle="modal">
							<button type="button" class="btn btn-primary" ><i class="fa fa-times"></i> Vezi program</button>
							</a>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
    <!-- Portfolio Modal 3 -->
    <div class="portfolio-modal modal fade" id="portfolioModal3" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <!-- Project Details Go Here -->
                            <h2>Amfiteatru</h2>
                            <img class="img-responsive img-centered" src="img/2amfiteatru.jpg" alt="Amfiteatru">
                            <p><b>Amfiteatrul</b> este situat la etajul 1 al corpului B fiind dotat cu video-proiector, laptop, boxe și microfon. Se pot organiza conferințe, prezentări, concursuri. Are o capacitate de aproximativ 200 de persoane.</p>
                            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
							<a href = "include/camere/room_table.php?room=3">
							<button type="button" class="btn btn-primary" ><i class="fa fa-times"></i> Vezi program</button>
							</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Portfolio Modal 4 -->
    <div class="portfolio-modal modal fade" id="portfolioModal4" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <!-- Project Details Go Here -->
                            <h2>Sală proiecţie</h2>
                            <img class="img-responsive img-centered" src="img/2sala.jpg" alt="Sala de proiecție">
                            <p><b>Sala de proiecție</b> este situată în corpul de legătură la etajul 1 fiind dotată cu video proiector este potrivită pentru vizionări de filme și prezentări de proiecte. Are o capacitate de aproximativ 30 de persoane.</p>
                            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
							<a href = "include/camere/room_table.php?room=4">
							<button type="button" class="btn btn-primary" ><i class="fa fa-times"></i> Vezi program</button>
							</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	<!-- Room Formular -->
	<div class="portfolio-modal modal fade" id="roomformular?room_id=2" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-content">
			<div class="container">
			<!-- pun aici codul pt validare id la borrow room -->
</div>
</div>
</div>


</body>
</html>
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="js/classie.js"></script>
    <script src="js/cbpAnimatedHeader.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/agency.js"></script>

</body>

</html>
