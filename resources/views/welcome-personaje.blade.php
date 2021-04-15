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

        <div><img class="h-2/6 w-2/6" src=https://i.ibb.co/FzmsMgP/M-Mdb-1.gif" alt="M-Mdb-1" border="0"></div>

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

    function composeStringUrls(data){
       return `<button class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-1 px-3 border border-gray-400 rounded shadow">
<a class="" href="${data.url}">${data.type}</a>
</button>`;
    }

    function urls (results){
        let arrayItems =[];
        results.forEach(element => element.urls.forEach(item => arrayItems.push(item)));
        return arrayItems;
    }


    function composeStringStart(data) {

        console.log("Aquí...")

        function arrayurls(data){
            let arrayurl = [];
            data.forEach(item => arrayurl.push(item));


            console.log(arrayurl);
            console.log(arrayurl.toString());
            return arrayurl;
            //(item => item.forEach(item => arrayurl.push(`["${item.type}":"${item.url}"]`))
            //
        }


        console.log("despues")

        let urlStart = `/datacharacter`;
        axios({
            method: 'post',
            url: urlStart,
            data: {
                idMarvel: data.id,
                json: data.serializeArray(),
                platform: "Marvel",
                charName: data.name,
                charDescription: data.description,
                charImage: data.thumbnail.path + '.' + data.thumbnail.extension,
                searchQuery: document.getElementById("busqueda").value,
                //urlLinks: arrayurls(data.urls),


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

  function composeStringUrlsBack(data){
        return `<button class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-1 px-3 border border-gray-400 rounded shadow">
<a class="" href="${data.url}">${data.type}</a>
</button>`;
    }

    function composeStringDataBack(data){

        if (data.charDescription != null){
            return `<div class="min-h-screen min-w-screen bg-gray-200 dark:bg-gray-900 flex items-center justify-center">
            <div>
                <div class="flex flex-col max-w-md bg-white px-8 py-6 rounded-xl space-y-5 items-center">
                    <h3 class="font-serif font-bold text-gray-900 text-xl">${data.charName}</h3>
                    <img class="w-full rounded-md" src="${data.charImage}" alt="motivation" />
                    <p class="text-center leading-relaxed">${data.charDescription}}</p>
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
                    <h3 class="font-serif font-bold text-gray-900 text-xl">${data.charName}</h3>
                    <img class="w-full rounded-md" src="${data.charImage}" alt="motivation" />

                    <span class="text-center">MARVEL</span>
                    <button class="px-24 py-1 bg-red-600 rounded-md text-white text-sm focus:border-transparent"><a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a></button>
                </div>
            </div>
        </div>`
        }

    }


    async function buscar() {
        const busqueda = document.getElementById("busqueda").value;

        const md5Compose = CryptoJS.MD5(ts + privateK + publicK).toString();

        let urlStart = `https://gateway.marvel.com:443/v1/public/characters?nameStartsWith=${busqueda}&ts=${ts}&apikey=${publicK}&hash=${md5Compose}`;

        let urlQuery = `/datacharacter/${busqueda}`;

        //document.getElementById("busqueda").addEventListener('click',limpiar);

        const resultado = await  axios.get(urlQuery);

        console.log(resultado)

        if(resultado.data.length > 0){

            const requestQuery = resultado;

            console.log(requestQuery);
            document.getElementById("visor").innerHTML = resultado.data.map(composeStringDataBack).join(" ");


        }
        else {


            const requestStart = await axios.get(urlStart);

            console.log(requestStart.data.data.results);
            console.log("aqui")

            if (requestStart.status === 200) {

                document.getElementById("visor").innerHTML = requestStart.data.data.results.map(composeStringStart).join(" ");

            } else {
                document.getElementById("visor").innerHTML = "Hay algún problema";
            }

        }



    }

    function change_message() {
        axios.get('/cliente/message')
            .then(function (response) {
                // handle success
                console.log(response);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });
    }


    /*
,
urls: [{
type: "detail",
url: "http://marvel.com/comics/characters/1009351/hulk?utm_campaign=apiRef&amp;utm_source=7701abbe011f97d07fd57cbc7599a3b6"
}, {
type: "wiki",
url: "http://marvel.com/universe/Hulk_(Bruce_Banner)?utm_campaign=apiRef&amp;utm_source=7701abbe011f97d07fd57cbc7599a3b6"
}, {
type: "comiclink",
url: "http://marvel.com/comics/characters/1009351/hulk?utm_campaign=apiRef&amp;utm_source=7701abbe011f97d07fd57cbc7599a3b6"
}]
*/

</script>
