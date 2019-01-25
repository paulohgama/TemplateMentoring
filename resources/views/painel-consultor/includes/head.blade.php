<!-- Fav -->
<link rel="icon" type="image/png" href="/images/favicon-32x32.png" sizes="32x32" />
<link rel="icon" type="image/png" href="/images/favicon-16x16.png" sizes="16x16" />

<!-- CSS -->
<link rel="stylesheet" href="/css/vendor.css" type="text/css">
<link rel="stylesheet" href="/css/jquery-ui.css" type="text/css">
<link rel="stylesheet" href="/css/style.min.css" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

<!-- META TAGS -->
<meta name="description" content="@yield('meta-desc', '')" />
<meta name="keywords" content="@yield('meta-keywords', '')">
<meta name="author" content="Tarot Nova Era">
<meta name="copyright" content="">
<meta name="application-name" content="">
<meta name="Robots" content="index, follow">
<meta name="distribution" content="Global">
<meta name="rating" content="General">
<meta name="revisit-after" content="5">
<meta http-equiv="expires" content="0">

<!-- for Facebook -->
<meta property="og:title" content="@yield('meta-title','')">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="@yield('site-name', 'Tarot Nova Era')">
<meta property="og:description" content="@yield('meta-desc', '')">
<meta property="og:image" content="{{ url('/') }}@yield('meta-image', '')">

<!-- for Twitter -->
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="@yield('meta-title','Tarot Nova Era')" />
<meta property="twitter:description" content="@yield('meta-desc', '')">
<meta property="twitter:image" content="{{ url('/') }}@yield('meta-image', '')">

<!-- for Google+ -->	
<meta itemprop="name" content="@yield('meta-title','Tarot Nova Era')">
<meta name="csrf-token" content="{{ csrf_token() }}">


<title>@yield('meta-title', 'Painel Consultor - Tarot Nova Era')</title>

