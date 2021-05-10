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
<body class="antialiased bg-gray-200 dark:bg-gray-900">
<div class="relative flex items-top justify-end  md:h-24 bg-gray-200 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
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
<div class="flex flex-col  bg-gray-200 dark:bg-gray-900">
    <div class="text-center"><h1 class=" text-red-600 text-4xl font-roboto">The MARVEL and DataBaseMovie</h1></div>

        <div class="flex-col "><img class="justify-center h-2/6 w-2/6" src=https://i.ibb.co/FzmsMgP/M-Mdb-1.gif" alt="M-Mdb-1" border="0" style="margin-left: 540px;"></div>

    <div id="buscador" class="text-center mb-10">
        <label for="busqueda"></label><input id="busqueda" onchange="buscar()"  type="text" placeholder="Busca tu personaje...">
    </div>

    <div id="visor" class="flex-col"></div>
</div>
</body>
</html>
<script>
    function limpiar() {
        document.getElementById("prueba").value = "";
    }


    const publicK = "7701abbe011f97d07fd57cbc7599a3b6";
    const privateK = "265976491cc8e9aa0bc0b62b38819bea7b45fb89";
    const ts = Date.now();
    const ts2 = Date.now() + 1;
    const APIKey = "5011e9d9f4f0d149651d30d4df35c971"

    function composeStringUrls(data){
       return `<button class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-1 px-3 border border-gray-400 rounded shadow">
<a class="" href="${data.url}">${data.type}</a>
</button>`;
    }


    function arrayurls(data){
        let arrayurl = [];
        data.forEach(item => arrayurl.push(item));
        //console.log(arrayurl);
        return arrayurl;
    }


    function composeStringStart(data) {
        console.log("Aquí...")
        let urlStart = `/datacharacter`;



        axios({
            method: 'post',
            url: urlStart,
            data: {
                idPlatform: data.id,
                json: data,
                platform: "Marvel-Char",
                name: data.name,
                description: data.description,
                image: data.thumbnail.path + '.' + data.thumbnail.extension,
                urlLinks: arrayurls(data.urls),
                charComics: arrayurls(data.comics.items),
                charSeries: arrayurls(data.series.items),
                searchQuery: document.getElementById("busqueda").value,
            }

        });

        return `<div class="min-h-screen min-w-screen bg-gray-200 dark:bg-gray-900 flex items-center justify-center">
            <div>
                <div class="flex flex-col max-w-md bg-white px-8 py-6 rounded-xl space-y-5 items-center">
                    <h3 class="font-serif font-bold text-gray-900 text-xl">${data.name}</h3>
                    <img class="w-full rounded-md" src="${data.thumbnail.path}.${data.thumbnail.extension}" alt="motivation" />
                    <!-- <p class="text-center leading-relaxed">${data.id}</p> -->
                    <p class="text-center leading-relaxed">${data.description}</p>
                    ${data.urls.map(composeStringUrls).join("")}
                    <span class="text-center">MARVEL</span>
                    <button class="px-24 py-1 bg-red-600 rounded-md text-white text-sm focus:border-transparent"><a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a></button>
                </div>
            </div>
        </div>`
    }

    function composeStringComic(data) {
        console.log("data.....");
        console.log(data.characters.items);
        console.log("...............");

        let urlStart = `/datacharacter`;


        axios({
            method: 'post',
            url: urlStart,
            data: {
                idPlatform: data.id,
                json: data,
                platform: "Marvel-Comics",
                name: data.title,
                description: data.description,
                image: data.thumbnail.path + '.' + data.thumbnail.extension,
                diamondCode: data.diamondCode,
                creators: data.creators,
                charComics: arrayurls(data.characters.items),
                dateComics: arrayurls(data.dates),
                urlLinks: arrayurls(data.urls),
                searchQuery: document.getElementById("busqueda").value,
            }

        });

    /* return `<div class="min-h-screen min-w-screen bg-gray-200 dark:bg-gray-900 flex items-center justify-center">
         <div>
             <div class="flex flex-col max-w-md bg-white px-8 py-6 rounded-xl space-y-5 items-center">
                 <h3 class="font-serif font-bold text-gray-900 text-xl">${data.title}</h3>
                 <img class="w-full rounded-md" src="${data.thumbnail.path}.${data.thumbnail.extension}" alt="motivation" />
                 <!-- <p class="text-center leading-relaxed">${data.id}</p> -->
                 <p class="text-center leading-relaxed">${data.description}</p>
                 ${data.urls.map(composeStringUrls).join("")}
                 <span class="text-center">MARVEL</span>
                 <button class="px-24 py-1 bg-red-600 rounded-md text-white text-sm focus:border-transparent"><a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a></button>
                </div>
            </div>
        </div>` */
    }


    function composeTmdb(data) {

        let urlStart = `/datacharacter`;


        axios({
            method: 'post',
            url: urlStart,
            data: {
                idPlatform: data.id,
                json: data,
                platform: "TMDb",
                name: data.original_title,
                description: data.overview,
                image: data.poster_path,
                imageBackground: data.backdrop_path,
                vote_average: data.vote_average,
                vote_count: data.vote_count,
                release_date: data.release_date,
                searchQuery: document.getElementById("busqueda").value,
            }

        });
    /* return `<div class="min-h-screen min-w-screen bg-gray-200 dark:bg-gray-900 flex items-center justify-center">
        <div>
            <div class="flex flex-col max-w-md bg-white px-8 py-6 rounded-xl space-y-5 items-center">
                <h3 class="font-serif font-bold text-gray-900 text-xl">${data.original_title}</h3>
                <img class="w-full rounded-md" src="${"https://image.tmdb.org/t/p/original/" + data.poster_path}" alt="motivation" />
                <!-- <p class="text-center leading-relaxed">${data.id}</p> -->
                <p class="text-center leading-relaxed">${data.overview}</p>
                <span class="text-center">TheMovieDB</span>
                <button class="px-24 py-1 bg-red-600 rounded-md text-white text-sm focus:border-transparent"><a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a></button>
                </div>
            </div>
        </div>` */

    }

  function composeStringUrlsBack(data){

        return `<button class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-1 px-3 border border-gray-400 rounded shadow">
<a class="" href="${data.url}">${data.type}</a>
</button>`;
    }

    function composeStringDataBack(dataResult){
        let data = JSON.parse(dataResult.json)

        console.log("-------------------------------------------")
        console.log(data);
        console.log("-------------------------------------------")
        if (data.description != null){
            return `<div class="min-h-screen min-w-screen bg-gray-200 dark:bg-gray-900 flex items-center justify-center">
            <div>
                <div class="flex flex-col max-w-md bg-white px-8 py-6 rounded-xl space-y-5 items-center">
                    <h3 class="font-serif font-bold text-gray-900 text-xl">${data.name}</h3>
                    <img class="w-full rounded-md" src="${data.thumbnail.path}.${data.thumbnail.extension}" alt="motivation" />
                    <!-- <p class="text-center leading-relaxed">${data.id}</p> -->
                    <p class="text-center leading-relaxed">${data.description}</p>
                    ${data.urls.map(composeStringUrls).join("")}
                    <span class="text-center">MARVEL</span>
                    <button class="px-24 py-1 bg-red-600 rounded-md text-white text-sm focus:border-transparent"><a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a></button>
                </div>
            </div>
        </div>`
        }
        else {
            return `<div class="min-h-screen min-w-screen bg-gray-200 dark:bg-gray-900 flex items-center justify-center">
            <div>
                <div class="flex flex-col max-w-md bg-white px-8 py-6 rounded-xl space-y-5 items-center">
                    <h3 class="font-serif font-bold text-gray-900 text-xl">${data.name}</h3>
                    <img class="w-full rounded-md" src="${data.thumbnail.path}.${data.thumbnail.extension}" alt="motivation" />
                    <!-- <p class="text-center leading-relaxed">${data.id}</p> -->
                    ${data.urls.map(composeStringUrls).join("")}
                    <span class="text-center">MARVEL</span>
                    <button class="px-24 py-1 bg-red-600 rounded-md text-white text-sm focus:border-transparent"><a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a></button>
                </div>
            </div>
        </div>`
        }
    }


    async function buscar() {
        const busqueda = document.getElementById("busqueda").value.toLowerCase();
        console.log(busqueda);

        const md5ComposeA = CryptoJS.MD5(ts + privateK + publicK).toString();
        const md5ComposeB = CryptoJS.MD5(ts2 + privateK + publicK).toString();

        let urlStart = `https://gateway.marvel.com:443/v1/public/characters?nameStartsWith=${busqueda}&ts=${ts}&apikey=${publicK}&hash=${md5ComposeA}`;
        let urlComic = `https://gateway.marvel.com:443/v1/public/comics?format=comic&formatType=comic&title=${busqueda}&ts=${ts2}&apikey=${publicK}&hash=${md5ComposeB}`;
        let urlTmdb = `https://api.themoviedb.org/4/search/movie?api_key=5011e9d9f4f0d149651d30d4df35c971&language=es-ES&query=${busqueda}`;



        let urlQuery = `/datacharacter/${busqueda}`;

        //document.getElementById("busqueda").addEventListener('click',limpiar);


        const resultado = await  axios.get(urlQuery);

        console.log("resultado urlQuery");
        console.log(resultado);
        console.log("hasta aqui");
        console.log(resultado.data.length);

        if(resultado.data != 0){
            console.log("BackData en función")
            document.getElementById("visor").innerHTML = resultado.data.map(composeStringDataBack).join(" ");
        }
        else {


            const requestStart = await axios.get(urlStart);
            //console.log("startKey");
            //console.log(requestStart);
            //console.log("-------------")
            const requestComic = await axios.get(urlComic);
            //console.log("comics");
            //console.log(requestComic.data.data);
            //console.log("-------------")
            const respuesta = await axios.get(urlTmdb);
            console.log("Tmdb");
            console.log(respuesta.data);
            console.log("-------------")



            if (requestStart.status === 200) {

                document.getElementById("visor").innerHTML = requestStart.data.data.results.map(composeStringStart).join(" ");
                document.getElementById("visor").innerHTML += requestComic.data.data.results.map(composeStringComic).join(" ");
                document.getElementById("visor").innerHTML += respuesta.data.results.map(composeTmdb).join(" ");

            } else {
                document.getElementById("visor").innerHTML = "Hay algún problema";
            }
        }
    }

</script>
