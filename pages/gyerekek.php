<?php
    $gyerekek = $db->query('SELECT * FROM gyerek WHERE szulo = '.$user__id.' ORDER BY hozzaadva')->fetchAll();
?>

<main class="defaultMain">
    <?php  require($_SERVER["DOCUMENT_ROOT"]."/pages/tpl/menu.php"); ?>
    <div class="parent gyerekek">
        <div>
            <h2>Már felvett gyerekek</h2>
            
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg my-6">
                <table class="w-full text-sm text-left rtl:text-right text-gray-600">
                    <thead class="text-xs text-white uppercase bg-gray-500">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Név
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Született
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Egyéb
                            </th>
                            <!--<th scope="col" class="px-6 py-3">
                                <span class="sr-only">Módosítás</span>
                            </th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($gyerekek as $gyerek) { ?>
                            <tr class="bg-white border-b hover:bg-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <?php echo $gyerek['nev']; ?>
                                </th>
                                <td class="px-6 py-4">
                                    <?php echo $gyerek['szuletett']; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $gyerek['egyeb']; ?>
                                </td>
                                <!--<td class="px-6 py-4 text-right">
                                    <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Módosítás</a>
                                </td>-->
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>


        </div>
        <div class='ujGYerek'>
            <h2>Új gyerek felvétele</h2>

            <div class="row mt-6">
                <div class="flex mb-4 col-12 col-md-6">
                    <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                        </svg>
                    </span>
                    <input type="text" id="newChildName" name="gondviselo_neve" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5" placeholder="Gyerek neve" required>
                </div>

                <div class="col-12 mb-4 col-md-6">
                    <div style="position: absolute; top: 13px; left: 27px;">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input datepicker id="newChildBorn" datepicker-format="yyyy-mm-dd" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Született">
                </div>
                
                <div class="col-12">
                    <textarea id="newChildEtc" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Egyéb..."></textarea>
                </div>

                <div class="col-12">
                    <div style="display: flex; flex-direction: row-reverse;">
                        <button type="button" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-400 font-medium rounded-lg text-sm mt-3.5 px-5 py-1.5 mb-2" id="newChildSave">Mentés</button>
                        <div id="resp" class="mt-3.5 pr-5 py-1.5" style="width: 100%; color: white;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.getElementById('newChildBorn').addEventListener('input', (a) => {
        value = a.target.value;
        if (a.data != '-' && isNaN(a.data) || a.data == ' ') a.target.value = value.slice(0,-1);
        if (a.data != null && (value.length == 4 || value.length == 7)) {
            a.target.value = value + '-';
        } else if (a.data == null && (value.length == 4 || value.length == 7)) {
            a.target.value = value.slice(0,-1);
        }
    });

    document.getElementById('newChildSave').addEventListener('click', () => {
        let name = document.getElementById('newChildName');
        let born = document.getElementById('newChildBorn');
        let etc = document.getElementById('newChildEtc');
        
        if (name.validity.valueMissing) {
            name.setCustomValidity('Nem adta meg a gyerek nevét.');
            name.reportValidity();
            return;
        }
        if (born.value == "") {
            born.setCustomValidity('Nem adta meg a gyerek születésnapját.');
            born.reportValidity();
            return;
        }
        
        let etcText = "nincs";
        if (etc.value != "") {
            etcText = etc.value;
        }

        var formData = new FormData();
        formData.append('method', 'child_new');
        formData.append('name', name.value);
        formData.append('born', born.value);
        formData.append('etc', etcText);
        
        const options = {
            method: 'POST',
            body: formData
        };
        fetch('/api/', options)
        .then(resp => resp.json())
        .then(resp => {
            if (resp.status == 0) {
                console.log(resp.mess);
            } else if (resp.status == 1 || resp.status == 2) {
                document.getElementById('resp').innerHTML = resp.mess;
            }

            if (resp.status == 1) {
                var newRow = document.querySelector('tbody').insertRow();
                newRow.setAttribute("class", "bg-white border-b hover:bg-gray-200");
                newRow.innerHTML = `
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                ${name.value}
                </th>
                    <td class="px-6 py-4">
                        ${born.value}
                    </td>
                    <td class="px-6 py-4">
                        ${etcText}
                    </td>
                    <!--<td class="px-6 py-4 text-right">
                    <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Módosítás</a>
                    </td>-->
                `
                name.value = "";
                born.value = "";
                etc.value = "";
            }
        });
    });
</script>