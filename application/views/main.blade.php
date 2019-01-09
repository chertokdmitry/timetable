<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
      <style>
          .bd-placeholder-img {
              font-size: 1.125rem;
              text-anchor: middle;
          }

          .container {
              max-width: 960px;
          }

          .lh-condensed { line-height: 1.25; }

          @media (min-width: 768px) {
              .bd-placeholder-img-lg {
                  font-size: 3.5rem;
              }
          }
      </style>
    <title>Логистика</title>
  </head>
  <body class="bg-light">
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/">IT logistics</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a  class="nav-link"  href="/index/add/schedule">Создать</a>
            </li>
            <li class="nav-item">
                <a  class="nav-link"  href="/index/view/couriers">Транспорт</a>
            </li>
            <li class="nav-item">
                <a  class="nav-link"  href="/index/view/regions">Бизнес-центры</a>
            </li>
            <li class="nav-item">
                <a  class="nav-link"  href="/index/view/schedule">Расписание</a>
            </li>
        </ul>
    </div>
    </nav>
  </div>

      <div class="container">
          @section('content')

          @show
      </div>

  @section('footer')

      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
@show
