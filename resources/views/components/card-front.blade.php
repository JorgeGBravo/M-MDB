<div class="min-h-screen min-w-screen bg-gray-100 flex items-center justify-center">
    <div>
        <div class="flex flex-col max-w-md bg-white px-8 py-6 rounded-xl space-y-5 items-center">
            <h3 class="font-serif font-bold text-gray-900 text-xl">${data.name}</h3>
            <img class="w-full rounded-md" src="${data.thumbnail.path}.${data.thumbnail.extension}" alt="motivation" />
            <p class="text-center leading-relaxed">${data.id}</p>
            <p class="text-center leading-relaxed">${data.description}</p>
            <a href="${data.urls[0].url}" class="text-center leading-relaxed">${data.urls[0].type}</a>
            <a href="${data.urls[1].url}" class="text-center leading-relaxed">${data.urls[1].type}</a>
            <span class="text-center">MARVEL</span>
            <button class="px-24 py-1 bg-red-600 rounded-md text-white text-sm focus:border-transparent"><a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a></button>
        </div>
    </div>
</div>
