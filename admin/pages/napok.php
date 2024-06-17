<?php 
$napok = $db->query('SELECT tabor.nap, tabor.maxember, gyerek.nev AS gyerekNev, gyerek.szuletett, gyerek.egyeb, gondviselo.nev AS szuloNev, gondviselo.email, gondviselo.telefon FROM regisztracio '.
                    'INNER JOIN tabor ON regisztracio.tabor = tabor.id '.
                    'INNER JOIN gyerek ON regisztracio.gyerek = gyerek.id '.
                    'INNER JOIN gondviselo ON gyerek.szulo = gondviselo.id '.
                    'WHERE tabor.active IS TRUE AND regisztracio.active IS TRUE '.
                    'ORDER BY nap, szuloNev, gyerekNev')->fetchAll();

$adatok = array();
foreach ($napok as $nap) {
    if (!isset($adatok[$nap['nap']]['maxember'])) {
        $adatok[$nap['nap']] = array('maxember' => $nap['maxember'], 'emberek' => array());
    }
    if (!isset($adatok[$nap['nap']]['emberek'][$nap['szuloNev']]['telefon'])) {
        $adatok[$nap['nap']]['emberek'][$nap['szuloNev']]['telefon'] = $nap['telefon'];
        $adatok[$nap['nap']]['emberek'][$nap['szuloNev']]['email'] = $nap['email'];
    }
    if (!isset($adatok[$nap['nap']]['emberek'][$nap['szuloNev']]['gyerekek'])) {
        $adatok[$nap['nap']]['emberek'][$nap['szuloNev']]['gyerekek'] = array();
    }
    $adatok[$nap['nap']]['emberek'][$nap['szuloNev']]['gyerekek'][$nap['gyerekNev']]['szuletett'] = $nap['szuletett'];
    $adatok[$nap['nap']]['emberek'][$nap['szuloNev']]['gyerekek'][$nap['gyerekNev']]['egyeb'] = $nap['egyeb'];
}


foreach (array_keys($adatok) as $nap) {
    $i = 0;
    foreach (array_keys($adatok[$nap]['emberek']) as $szulo) {
        $i += count($adatok[$nap]['emberek'][$szulo]['gyerekek']);
    }
    $adatok[$nap]['jelentkezes'] = $i;
}
?>

<main class="defaultMain">
    <?php  require($_SERVER["DOCUMENT_ROOT"]."/admin/pages/tpl/menu.php"); ?>
    <div class="parent">
        <?php
            foreach (array_keys($adatok) as $nap) { ?>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg my-6">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-600">
                            <thead class="text-xs text-white uppercase bg-gray-500">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-center" style="font-size: 1rem;"><?php echo $nap.' | '.$adatok[$nap]['jelentkezes'].'/'.$adatok[$nap]['maxember']; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_keys($adatok[$nap]['emberek']) as $szulo) { ?>
                                    <tr class="bg-gray-400 border-b">
                                        <td scope="col" class="text-center">
                                            <table class="w-full text-sm text-left rtl:text-right text-gray-600" style="margin: 15px 0px;">
                                                <thead class="text-xs text-white bg-gray-500">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3 text-center"><?php echo $szulo;?></th>
                                                        <th scope="col" class="px-6 py-3 text-center">Tel: <?php echo $adatok[$nap]['emberek'][$szulo]['telefon'];?></th>
                                                        <th scope="col" class="px-6 py-3 text-center">Email: <?php echo $adatok[$nap]['emberek'][$szulo]['email'];?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach (array_keys($adatok[$nap]['emberek'][$szulo]['gyerekek']) as $gyerek) {?>
                                                    <tr class="bg-white border-b hover:bg-gray-200">
                                                        <td scope="col" class="px-6 py-3 text-center"><?php echo $gyerek;?></td>
                                                        <td scope="col" class="px-6 py-3 text-center"><?php echo $adatok[$nap]['emberek'][$szulo]['gyerekek'][$gyerek]['szuletett'];?></td>
                                                        <td scope="col" class="px-6 py-3 text-center"><?php echo $adatok[$nap]['emberek'][$szulo]['gyerekek'][$gyerek]['egyeb'];?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php }
        ?>
    </div>
</main>