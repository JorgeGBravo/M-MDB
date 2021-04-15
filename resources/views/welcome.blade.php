<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"
            integrity="sha512-nOQuvD9nKirvxDdvQ9OMqe2dgapbPB7vYAMrzJihw5m+aNcf0dX53m6YxM4LgA9u8e9eg9QX+/+mPu8kCNpV2A=="
            crossorigin="anonymous"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/css/app.css" rel="stylesheet">
    <title>{{env('app_name')}}</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
</head>
<body class="antialiased">
<div class="relative flex items-top justify-end  md:h-20 bg-gray-200 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
    @if (Route::has('login'))
        <div class="hidden fixed  top-0  right-100 px-6 py-4 sm:block">
            @auth
                <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
            @else
                <button
                    class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>
                </button>
                @if (Route::has('register'))
                    <button
                        class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                        <a href="{{ route('register') }}" class="text-sm text-gray-700 underline">Register</a>
                    </button>
                @endif
            @endauth
        </div>
    @endif
</div>
<br>
<div class="flex flex-col ">
    <div class="text-center"><h1 class=" text-red-600 text-4xl font-roboto">The MARVEL and DataBaseMovie</h1></div>
    <div>
        <img class="justify-items-center" src=https://i.ibb.co/tLVNbmQ/M-Mdb-1.gif" alt="M-Mdb-1" border="0">
    </div>
    <div id="buscador" class="text-center">
        <label for="busqueda"></label><input id="busqueda" onchange="buscar()"  type="text" placeholder="Busca tu personaje...">
    </div>
    <div id="visor" class="flex-col"></div>
</div>


</body>
</html>
<script>
    var publicK = "7701abbe011f97d07fd57cbc7599a3b6";
    const privateK = "265976491cc8e9aa0bc0b62b38819bea7b45fb89";
    const ts = Date.now();
    const ts2 = Date.now() + 1;
    const APIKey = "5011e9d9f4f0d149651d30d4df35c971"

    /*let generos = https://api.themoviedb.org/3/genre/movie/list?api_key=5011e9d9f4f0d149651d30d4df35c971&language=es-ES*/

    /* console.log(ts);
    console.log(ts2); */


    function composeStringStart(data) {
        return `<div class="min-h-screen min-w-screen bg-gray-100 flex items-center justify-center">
            <div>
                <div class="flex flex-col max-w-md bg-white px-8 py-6 rounded-xl space-y-5 items-center">
                    <h3 class="font-serif font-bold text-gray-900 text-xl">${data.name}-${data.id}</h3>
                    <img class="w-full rounded-md" src="${data.thumbnail.path}.${data.thumbnail.extension}" alt="motivation" />
                    <p class="text-center leading-relaxed">${data.description}</p>
                    <span class="text-center">MARVEL</span>
                    <button class="px-24 py-1 bg-red-600 rounded-md text-white text-sm focus:border-transparent"><a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a></button>
                </div>
            </div>
        </div>`
    }

    function composeStringComic(data) {
        return `<div class="min-h-screen min-w-screen bg-gray-100 flex items-center justify-center">
            <div>
                <div class="flex flex-col max-w-md bg-white px-8 py-6 rounded-xl space-y-5 items-center">
                    <h3 class="font-serif font-bold text-gray-900 text-xl">${data.title}-${data.id}</h3>
                    <img class="w-full rounded-md" src="${data.thumbnail.path}.${data.thumbnail.extension}" alt="motivation" />
                    <p class="text-center leading-relaxed">${data.description}</p>
                    <span class="text-center">MARVEL</span>
                    <button class="px-24 py-1 bg-red-600 rounded-md text-white text-sm focus:border-transparent"><a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a></button>
                </div>
            </div>
        </div>
        `
    }


    function itemListaBusqueda(data) {

        return `<div class="min-h-screen min-w-screen bg-gray-100 flex items-center justify-center">
            <div>
                <div class="flex flex-col max-w-md bg-white px-8 py-6 rounded-xl space-y-5 items-center">
                    <h3 class="font-serif font-bold text-gray-900 text-xl">${data.original_title}-${data.id}</h3>
                    <img class="w-full rounded-md" src="${"https://image.tmdb.org/t/p/original/" + data.poster_path}" alt="motivation" />
                    <p class="text-center leading-relaxed">${data.overview}</p>
                    <span class="text-center">The Movie Database</span>
                    <button class="px-24 py-1 bg-red-600 rounded-md text-white text-sm focus:border-transparent"><a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a></button>
                </div>
            </div>
        </div>
        `
    }


    async function buscar() {
        const busqueda = document.getElementById("busqueda").value;
        console.log("Buscando..." + busqueda);

        const md5Compose = CryptoJS.MD5(ts + privateK + publicK).toString();
        const md5Compose2 = CryptoJS.MD5(ts2 + privateK + publicK).toString();

        let urlStart = `https://gateway.marvel.com:443/v1/public/characters?nameStartsWith=${busqueda}&ts=${ts}&apikey=${publicK}&hash=${md5Compose}`;
        let urlComic = `https://gateway.marvel.com:443/v1/public/comics?format=comic&formatType=comic&title=${busqueda}&ts=${ts2}&apikey=${publicK}&hash=${md5Compose2}`;
        let urlTmdb = `https://api.themoviedb.org/4/search/movie?api_key=5011e9d9f4f0d149651d30d4df35c971&language=es-ES&query=${busqueda}`;


        console.log(urlStart);
        console.log(urlComic);

        const busquedaMDB = document.getElementById("busqueda").value;
        console.log("Buscando: " + busqueda)

        const requestStart = await axios.get(urlStart);
        console.log(requestStart.data.data);
        const requestComic = await axios.get(urlComic);

        const respuesta = await axios.get(urlTmdb);
        console.log(respuesta)
        requestComic.data.data.results.forEach(item => item.creators.items.forEach(item => console.log(item.name)));


        if (requestStart.status === 200) {

            document.getElementById("visor").innerHTML = requestStart.data.data.results.map(composeStringStart).join(" ");
            document.getElementById("visor").innerHTML += requestComic.data.data.results.map(composeStringComic).join(" ");
            document.getElementById("visor").innerHTML += respuesta.data.results.map(itemListaBusqueda).join(" ");
            /*     requestComic.data.data.results.forEach(item => document.documentElement.innerHTML += item.creators.items.map(composeStringItem).join("")); */

        } else {
            document.getElementById("visor").innerHTML = "Hay algún problema";
        }
    }
</script>

<!--<div class="vista">
    <h2>The MARVEL and DataBaseMovie</h2>
    <div class="contenedor">
        <img class="top" src="https://i.ibb.co/RH67bmh/tmdbd2.jpg" alt="tmdbd2" border="0"><img class="top" src="https://i.ibb.co/fQXM4Wy/eat-the-Universe.png" alt="eat-the-Universe" border="0" ></div>
</div>-->

<!--        return `<div id="character">
<h2>${data.name}</h2>
<p>${data.id}<p>
<div class="imagen">
<img src="${data.thumbnail.path}.${data.thumbnail.extension}">
</div>
<p>${data.description}</p></div>`-->

<!--
        return `<div id="comic">
<h2>${data.title}</h2>
<div class="imagen">
<img src="${data.thumbnail.path}.${data.thumbnail.extension}">
</div>
<div id="items">
<h4>${data.creators.items.forEach( item => item)}: ${data.creators.items.forEach( item => item)}</h4>
</div>
  <p>${data.description}</p></div>`
-->

<!--
return `
  	<div class="pelicula-lista">
        <h3>${data.original_title}</h3>
        <p>${data.id}<p>
        <img src="${"https://image.tmdb.org/t/p/original/" + data.poster_path}">
  <p>${data.overview}</p>`
-->
