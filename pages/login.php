<main class="regMain">
    <h1>BEJELENTKEZÉS</h1>
    
    <form class="max-w-sm mx-auto mt-10" action="." method="post">
        <label for="gondviselo_email">E-mail:</label>
        <div class="flex mb-2">
            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                    <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/>
                    <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/>
                </svg>
            </span>
            <input type="text" id="gondviselo_email" name="email" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5" placeholder="minta@gmail.com">
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
            <input type="password" id="password" name="pass" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5" placeholder="******">
        </div>

        <div class="flex" style="justify-content: space-between;">
            <button type="button" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 mb-2" id="vissza">VISSZA</button>
            <button type="submit" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">BELÉPÉS</button>
        </div>
    </form>
</main>


<script>
    document.getElementById('vissza').addEventListener('click', () => {
        window.location.href = '/'
    });
</script>