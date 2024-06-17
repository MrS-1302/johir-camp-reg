<main class="regMain">
    <div class="grid grid-cols-1 lg:grid-cols-2 justify-items-center content-evenly" style="height: 100%;">
        <div>
            <button class="button-53" role="button">Bejelentkezés</button>
        </div>
        <div>
            <button class="button-53" role="button">Regisztráció</button>
        </div>
    </div>
</main>

<script>
    document.querySelectorAll('.button-53')[0].addEventListener('click', () => {
        window.location.href = '/login'
    });

    document.querySelectorAll('.button-53')[1].addEventListener('click', () => {
        window.location.href = '/reg'
    });
</script>
