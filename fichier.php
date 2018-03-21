<html>
<head>
    <title>Test haproxy</title>
    <link rel="stylesheet" href="assets/bootstrap.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
        body, html{
            padding: 0; margin: 0;
            border: 0;
            width: 100%;
        }
        .container{
            font-size:1.4em;margin-top:80px;
        }
        #show_file{
            border:1px solid grey;
            border-radius:5px;
            overflow: auto;
            height:70%;
        }
    </style>
</head>
<body>

 <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href=".">Haproxy</a>
            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto"> 
                     <li class="nav-item active">
                            <a class="nav-link" href="/stats" target="_blank">Voir les stats</a>
                    </li>
                     <li class="nav-item">
                            <a class="nav-link" href="fichier.php">Voir résultat</a>
                    </li>
            </ul>
            </div>
        </nav>

<main role="main" class="container">
    <div class="row">

        <h4>Voir le contenu du fichier</h4>
        <div id="show_file" class="col-sm-12">
            <?php
            echo nl2br(file_get_contents('parts/merge.txt'));
            ?>
        </div>
    </div>
</main>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
