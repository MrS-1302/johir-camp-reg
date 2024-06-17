<?php
    $honapok_nev = array(
        array('Név' => 'Január', 'Napok' => 31),
        array('Név' => 'Február', 'Napok' => 28), // 2024 nem szökőév
        array('Név' => 'Március', 'Napok' => 31),
        array('Név' => 'Április', 'Napok' => 30),
        array('Név' => 'Május', 'Napok' => 31),
        array('Név' => 'Június', 'Napok' => 30),
        array('Név' => 'Július', 'Napok' => 31),
        array('Név' => 'Augusztus', 'Napok' => 31),
        array('Név' => 'Szeptember', 'Napok' => 30),
        array('Név' => 'Október', 'Napok' => 31),
        array('Név' => 'November', 'Napok' => 30),
        array('Név' => 'December', 'Napok' => 31)
    );
    $napok_nev = array('Hétfő', 'Kedd', 'Szerda', 'Csütörtök', 'Péntek', 'Szombat', 'Vasárnap');

    $gyerekek = $db->query('SELECT * FROM gyerek WHERE szulo = '.$user__id.' ORDER BY hozzaadva')->fetchAll();
    $naptar = $db->query('SELECT id, YEAR(nap) AS ev, MONTH(nap) AS honap, WEEK(nap) AS het, DAY(nap) AS nap, WEEKDAY(nap) AS napaheten, maxember FROM tabor WHERE active = 1 ORDER BY tabor.nap;')->fetchAll();

    //in_array('Zöld', array_column($tomb, 1))

    $napok = array();
    foreach($naptar as $nap) {
        if (!isset($napok[$nap['ev']][$nap['honap']][$nap['het']])) {
            $napok[$nap['ev']][$nap['honap']][$nap['het']] = array();
            for ($i = 0; $i < 7; $i++) {
                $napok[$nap['ev']][$nap['honap']][$nap['het']][$i] = 'nincs';
            }
        }
        $napok[$nap['ev']][$nap['honap']][$nap['het']][$nap['napaheten']] = array('id' => $nap['id'], 'nap' => $nap['nap'], 'maxember' => $nap['maxember']);
    } 
?>
<main class="defaultMain">
    <?php  require($_SERVER["DOCUMENT_ROOT"]."/pages/tpl/menu.php"); ?>
    <div class="parent">
        <select id="childs" onchange="checkChecked()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 text-center">
            <?php 
            $i = 0;
            foreach($gyerekek as $gyerek) { 
                echo "<option value='".$gyerek['id']."' ".($i == 0 ? 'selected' : '').">".$gyerek['nev']."</option>";
                $i++;
            } ?>
        </select>
        <?php
            foreach(array_keys($napok) as $ev) {
                foreach(array_keys($napok[$ev]) as $honap) { ?>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg my-6">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-600">
                            <thead class="text-xs text-white uppercase bg-gray-500">
                                <tr>
                                    <th colspan=7 scope="col" class="px-6 py-3 text-center"><?php echo $ev.' - '.$honapok_nev[$honap - 1]['Név']?></th>
                                </tr>
                                <tr>
                                    <?php 
                                        foreach($napok_nev as $nap) {
                                            echo '<th scope="col" class="px-6 py-3 text-center">'.$nap.'</th>';
                                        }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach(array_keys($napok[$ev][$honap]) as $het) {
                                        echo '<tr class="bg-white border-b hover:bg-gray-200">';
                                        $i = 1;
                                        foreach($napok[$ev][$honap][$het] as $nap) {
                                            if ($nap == 'nincs') {
                                                echo '<td scope="col" class="px-6 py-3 '.($i % 2 == 0 ? "bg-gray-50" : "").'"></td>';
                                            } else {
                                                echo '<td scope="col" class="px-6 py-3 text-center '.($i % 2 == 0 ? "bg-gray-50" : "").'"><b>'.$nap['nap'].'.</b><br>'.
                                                        '<span id="span_d_'.$nap['id'].'">0</span>/'.$nap['maxember'].'<br>'.
                                                        '<input id="checkbox_d_'.$nap['id'].'" onchange="reg(this)" data-id="'.$nap['id'].'" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">'.
                                                    '</td>';
                                            }
                                            $i++;
                                        }
                                        echo '</tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php }
            }
        ?>
    </div>
</main>

<script>
    function autoReload(day = 0) {
        var formData = new FormData();
        formData.append('method', 'child_napok_status');
        if (day > 0) formData.append('dayID', day);

        const options = {
            method: 'POST',
            body: formData
        };
        fetch('/api/', options)
        .then(resp => resp.json())
        .then(resp => {
            console.log(resp.mess);
            if (resp.status == 1) {
                if (resp.datas.length == 0 && day != 0) {
                    span = document.getElementById('span_d_' + day);
                    if (parseInt(span).innerText != 0) span.innerHTML = 0;
                } else {
                    for (i of resp.datas) {
                        span = document.getElementById('span_d_' + i.taborID);
                        chckbox = document.getElementById('checkbox_d_' + i.taborID);
                        if (parseInt(span).innerText != i.emberek) span.innerHTML = i.emberek;
                        if (parseInt(span.parentElement.innerText.split('\n')[1].split('/')[1]) == i.emberek && chckbox.checked == false) {
                            chckbox.disabled = true;
                        } else {
                            chckbox.disabled = false;
                        }
                    }
                }
            }
        });

        if (day == 0) setTimeout(autoReload, 2000);
    }

    let START = true;
    function checkChecked() {
        var formData = new FormData();
        formData.append('method', 'child_napok_feliratkozasok');
        formData.append('childID', parseInt(document.getElementById('childs').value));
        
        const options = {
            method: 'POST',
            body: formData
        };
        fetch('/api/', options)
        .then(resp => resp.json())
        .then(resp => {
            console.log(resp.mess);
            if (resp.status == 1) {
                inputs = document.querySelectorAll("input")
                for (input of inputs) {
                    input.checked = false;
                }
                for (data of resp.datas) {
                    document.getElementById('checkbox_d_' + data.tabor).checked = true;
                }
            }
        });

        if (START) {
            START = false;
            autoReload();
        } else {
            autoReload(-1);
        }
    }
    checkChecked();

    function reg(input) {
        input.checked = !input.checked;
        day = parseInt(input.getAttribute("data-id"));
        
        var formData = new FormData();
        formData.append('method', 'child_napra_reg');
        formData.append('childID', parseInt(document.getElementById('childs').value));
        formData.append('dayID', day);
        
        const options = {
            method: 'POST',
            body: formData
        };
        fetch('/api/', options)
        .then(resp => resp.json())
        .then(resp => {
            console.log(resp.mess);
            autoReload(day);
            if (resp.status == 1) {
                input.checked = !input.checked;
            }
        });
    }
</script>