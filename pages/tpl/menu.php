<button type="button" id="menuHamburger" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-black rounded-lg lg:hidden hover:bg-gray-100" style="position: absolute;top: 5px;right: 5px;z-index: 10;">
    <span class="sr-only">Open main menu</span>
    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
    </svg>
</button>

<div class="menu">
    <span><?php echo $user__name; ?></span>
    <span <?php print($path == "gyerekek" ? "class='active'" : ""); ?>><a href="/gyerekek/">Gyerekek kezelése</a></span>
    <span <?php print($path == "napkozi" ? "class='active'" : ""); ?>><a href="/napkozi/">Regisztráció a napközire</a></span>
    <span><a href="/kijelentkezes/">Kijelentkezés</a></span>
</div>

<script>
    document.getElementById('menuHamburger').addEventListener('click', () => {
        menu = document.querySelector('.menu')
        if (parseInt(menu.style.height) != 0 && menu.style.height != "") {
            menu.style.height = '0px';
            menu.style.borderBottom = "none";
        } else {
            menu.style.height = menu.scrollHeight + 30 + 'px';
            menu.style.borderBottom = "solid 3px black";
        }
    });
</script>