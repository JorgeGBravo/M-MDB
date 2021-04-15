require('./bootstrap');

require('alpinejs');

    var publicK = "7701abbe011f97d07fd57cbc7599a3b6";
    const privateK = "265976491cc8e9aa0bc0b62b38819bea7b45fb89";
    const ts = Date.now();
    const ts2 = Date.now() + 1;
    const APIKey = "5011e9d9f4f0d149651d30d4df35c971"

    /*let generos = https://api.themoviedb.org/3/genre/movie/list?api_key=5011e9d9f4f0d149651d30d4df35c971&language=es-ES*/

    /* console.log(ts);
    console.log(ts2); */


    function composeStringStart(data) {
    return `<div id="character">
<h2>${data.name}</h2>
<p>${data.id}<p>
<div class="imagen">
<img src="${data.thumbnail.path}.${data.thumbnail.extension}">
</div>
<p>${data.description}</p></div>`
}

    function composeStringComic(data) {
    return `<div id="comic">
<h2>${data.title}</h2>
<div class="imagen">
<img src="${data.thumbnail.path}.${data.thumbnail.extension}">
</div>
<div id="items">
<h4>${data.creators.items.forEach( item => item)}: ${data.creators.items.forEach( item => item)}</h4>
</div>
  <p>${data.description}</p></div>`
}


    function itemListaBusqueda(data) {
    return `
  	<div class="pelicula-lista">
        <h3>${data.original_title}</h3>
        <p>${data.id}<p>
        <img src="${"https://image.tmdb.org/t/p/original/" + data.poster_path}">
  <p>${data.overview}</p>`
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

