<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>RESET PASSWORD GOMASGO</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<style type="text/css">
	/* Space out content a bit */
	body {
	  padding-top: 1.5rem;
	  padding-bottom: 1.5rem;
	}

	/* Everything but the jumbotron gets side spacing for mobile first views */
	.header,
	.marketing,
	.footer {
	  padding-right: 1rem;
	  padding-left: 1rem;
	}

	/* Custom page header */
	.header {
	  padding-bottom: 1rem;
	  border-bottom: .05rem solid #e5e5e5;
	}

	/* Make the masthead heading the same height as the navigation */
	.header {
	  margin-top: 0;
	  margin-bottom: 0;
	  line-height: 3rem;
	  text-align: center;
	}

	/* Custom page footer */
	.footer {
	  padding-top: 1.5rem;
	  color: #777;
	  border-top: .05rem solid #e5e5e5;
	}

	/* Customize container */
	@media (min-width: 48em) {
	  .container {
	    width: 1000px
	  }
	}
	.container-narrow > hr {
	  margin: 2rem 0;
	}

	/* Main marketing message and sign up button */
	.jumbotron {
	  text-align: center;
	  border-bottom: .05rem solid #e5e5e5;
	}
	.jumbotron .btn {
	  padding: .75rem 1.5rem;
	  font-size: 1.5rem;
	}

	/* Supporting marketing content */
	.marketing {
	  margin: 3rem 0;
	}
	.marketing p + h4 {
	  margin-top: 1.5rem;
	}

	/* Responsive: Portrait tablets and up */
	@media screen and (min-width: 48em) {
	  /* Remove the padding we set earlier */
	  .header,
	  .marketing,
	  .footer {
	    padding-right: 0;
	    padding-left: 0;
	  }

	  /* Space out the masthead */
	  .header {
	    margin-bottom: 2rem;
	  }

	  /* Remove the bottom border on the jumbotron for visual effect */
	  .jumbotron {
	    border-bottom: 0;
	  }
	}
	</style>
  </head>

  <body>

    <div class="container">
      <header class="header clearfix">
        <h1>GAMASGO UMROH</h1>
      </header>

      <main role="main">
        <center>
          <h3 class="text-muted">Silahkan Klik Link Berikut Untuk Reset Ulang Password Anda.</h3>
        <center>
        <div class="jumbotron">
          <a href="<?=base_url()?>auth/reset/<?=$token_forgot_password?>" class="btn btn-success" role="button">Reset Password</a>
        </div>

      </main>

      <footer class="footer">
        <p>&copy; GOMASGO 2018</p>
      </footer>

    </div> <!-- /container -->
  </body>
</html>
