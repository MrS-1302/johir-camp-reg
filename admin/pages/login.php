<main class="regMain">
    <h1>ADMIN BEJELENTKEZÉS</h1>
    
    <form class="max-w-sm mx-auto mt-10" action="." method="post">
        <label for="gondviselo_email">Felhasználónév:</label>
        <div class="flex mb-2">
            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md">
                <svg class="w-4 h-4 text-gray-500" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                    viewBox="0 0 60.671 60.671" xml:space="preserve">
                        <ellipse style="fill:#6B7280;" cx="30.336" cy="12.097" rx="11.997" ry="12.097"/>
                        <path style="fill:#6B7280;" d="M35.64,30.079H25.031c-7.021,0-12.714,5.739-12.714,12.821v17.771h36.037V42.9
                            C48.354,35.818,42.661,30.079,35.64,30.079z"/>
                </svg>
            </span>
            <input type="text" name="username" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5" placeholder="username">
        </div>

        <label for="gondviselo_email">Jelszó:</label>
        <div class="flex mb-4">
            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md">
                <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" aria-labelledby="title"
                    aria-describedby="desc" role="img" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <path data-name="layer1"
                    d="M53.5 0h-43A10.5 10.5 0 0 0 0 10.5v43A10.5 10.5 0 0 0 10.5 64h43A10.5 10.5 0 0 0 64 53.5v-43A10.5 10.5 0 0 0 53.5 0zm-15 48h-13l2.2-17.1a9 9 0 1 1 8.7 0z"
                    fill="#6B7280"></path>
                </svg>
            </span>
            <input type="password" name="password" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5" placeholder="******">
        </div>

        <div class="flex" style="justify-content: flex-end;">
            <button type="submit" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">BELÉPÉS</button>
        </div>
    </form>
</main>