<!doctype html>
<html lang="en" data-bs-theme="light">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dotlist')</title>
    
    {{-- link icon web --}}
    <link rel="icon" href="{{ asset('img/to-do-list.png') }}">
    
    {{-- link bootsrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    
    {{-- link font --}}
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    
    {{-- link icon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">

    {{-- link css --}}
    <link href="https://dotlist.vercel.app/css/style.css" rel="stylesheet">

    @if(Request::is('profile')) 
    <style>
        .home-section {
            margin-left: 0;
        }
    </style>
    @endif
</head>
  <body>

    <div id="loading-screen">
        <div class="spinner"></div>
    </div>
      
    @auth
    @if(!Request::is('profile'))
        @include('partials.sidebar')
    @endif
    @include('partials.navbar')
    @endauth

    @if(Request::is('login') || Request::is('register'))
        <div class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    @endif

    @yield('auth')

    @if(!(Request::is('login') || Request::is('register')))
        <section class="home-section">
            @yield('content')
        </section>
    @endif

    @if(Request::is('login') || Request::is('register'))
        </div>
    @endif

    @auth
    @endauth
    <div class="sidebar-backdrop"></div>

    <!-- Add link to JavaScript file -->
    <script src="https://dotlist.vercel.app/js/script.js"></script>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
      // sortableJs
      Sortable.create(document.querySelector(".sortable"), {
          animation: 150,
          handle: ".drag-handle",
          onEnd: function (evt) {
              let rows = Array.from(evt.from.children);
              let task_ids = rows.map((row) => row.dataset.taskId);
              let url = "{{ route('tasks.update_order') }}";
              fetch(url, {
                  method: "POST",
                  headers: {
                      "Content-Type": "application/json",
                      "X-CSRF-Token": "{{ csrf_token() }}",
                  },
                  body: JSON.stringify({ task_ids }),
              });
          },
      });
    </script>
  </body>
</html>