<?php
    require_once($_SERVER["DOCUMENT_ROOT"]."/core/login.php");
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($user__id)) {
        require_once($_SERVER["DOCUMENT_ROOT"]."/core/db.handle.php");
        require($_SERVER["DOCUMENT_ROOT"]."/core/antiXSS.php");

        if (isset($_POST['method']) && !empty($_POST['method'])) {
            $method = $_POST['method'];
            if ($method == "child_new") {
                if (isset($_POST['name']) && !empty($_POST['name'])) {
                    if (isset($_POST['born']) && !empty($_POST['born'])) {
                        if (isset($_POST['etc']) && !empty($_POST['etc'])) {
                            $szulo = $user__id;
                            $nev = antixss($_POST['name']);
                            $szuletett = $_POST['born'];
                            $egyeb = antixss($_POST['etc']);
                            
                            $check = $db->query("SELECT * FROM gyerek WHERE szulo = ".$szulo." AND nev = '".$nev."'")->numRows();

                            if ($check == 0) {
                                $ins = $db->query("INSERT INTO gyerek (szulo, nev, szuletett, egyeb) VALUES (".$szulo.", '".$nev."', '".$szuletett."', '".$egyeb."')");
                                if ($ins) {
                                    $resp['status'] = 1;
                                    $resp['mess'] = 'Az új gyerek sikeresen rögzítve lett.';
                                } else {
                                    $resp['status'] = 0;
                                    $resp['mess'] = 'Insert error.';
                                }
                            } else {
                                $resp['status'] = 2;
                                $resp['mess'] = 'Már lett önhöz ilyen nevű gyerek regisztrálva.';
                            }
                        } else {
                            $resp['status'] = 0;
                            $resp['mess'] = 'Missing etc.';
                        }
                    } else {
                        $resp['status'] = 0;
                        $resp['mess'] = 'Missing born.';
                    }
                } else {
                    $resp['status'] = 0;
                    $resp['mess'] = 'Missing name.';
                }
            } else if ($method == "child_edit") {
                if (isset($_POST['childID']) && !empty($_POST['childID'])) {
                    if (isset($_POST['name']) && !empty($_POST['name'])) {
                        if (isset($_POST['born']) && !empty($_POST['born'])) {
                            if (isset($_POST['etc']) && !empty($_POST['etc'])) {
                                $szulo = $user__id;
                                $childID = $_POST['childID'];
                                $nev = antixss($_POST['name']);
                                $szuletett = $_POST['born'];
                                $egyeb = antixss($_POST['etc']);
                                
                                $check = $db->query("SELECT * FROM gyerek WHERE szulo = ".$szulo." AND id = '".$childID."'")->numRows();

                                if ($check == 1) {
                                    $upd = $db->query("UPDATE gyerek SET nev = '".$nev."', szuletett = '".$szuletett."', egyeb = '".$egyeb."' WHERE szulo = ".$szulo." AND id = '".$childID."'");
                                    if ($upd) {
                                        $resp['status'] = 1;
                                        $resp['mess'] = 'Az új gyerek adatai sikeresen módosítva lettek.';
                                    } else {
                                        $resp['status'] = 0;
                                        $resp['mess'] = 'Update error.';
                                    }
                                } else {
                                    $resp['status'] = 2;
                                    $resp['mess'] = 'Hiba a gyerek beazonosításánál.';
                                }
                            } else {
                                $resp['status'] = 0;
                                $resp['mess'] = 'Missing etc.';
                            }
                        } else {
                            $resp['status'] = 0;
                            $resp['mess'] = 'Missing born.';
                        }
                    } else {
                        $resp['status'] = 0;
                        $resp['mess'] = 'Missing name.';
                    }
                } else {
                    $resp['status'] = 0;
                    $resp['mess'] = 'Missing childID.';
                }
            } else if ($method == "child_del") {
                if (isset($_POST['childID']) && !empty($_POST['childID'])) {
                    $szulo = $user__id;
                    $childID = $_POST['childID'];

                    $check = $db->query("SELECT * FROM gyerek WHERE szulo = ".$szulo." AND id = '".$childID."'")->numRows();

                    if ($check == 1) {
                        $del = $db->query("DELETE FROM gyerek WHERE szulo = ".$szulo." AND id = '".$childID."'");
                        if ($del) {
                            $resp['status'] = 1;
                            $resp['mess'] = 'A gyerek adatai sikeresen törölve lettek.';
                        } else {
                            $resp['status'] = 0;
                            $resp['mess'] = 'Delete error.';
                        }
                    } else {
                        $resp['status'] = 2;
                        $resp['mess'] = 'Hiba a gyerek beazonosításánál.';
                    }
                } else {
                    $resp['status'] = 0;
                    $resp['mess'] = 'Missing childID.';
                }
            } else if ($method == "child_napra_reg") {
                if (isset($_POST['childID']) && !empty($_POST['childID'])) {
                    if (isset($_POST['dayID']) && !empty($_POST['dayID'])) {
                        $dayID = $_POST['dayID'];
                        $childID = $_POST['childID'];

                        $check = $db->query("SELECT * FROM gyerek ".
                                            "INNER JOIN gondviselo ON gondviselo.id = gyerek.szulo ".
                                            "INNER JOIN tabor ON tabor.id = ".$dayID." ".
                                            "WHERE gyerek.id = ".$childID)->numRows();

                        if ($check == 1) {
                            $check2 = $db->query("SELECT * FROM regisztracio WHERE gyerek = ".$childID." AND tabor = ".$dayID)->numRows();
                            if ($check2 == 1) {
                                $finish = $db->query("UPDATE regisztracio SET active = !active WHERE gyerek = ".$childID." AND tabor = ".$dayID);
                                if ($finish) {
                                    $resp['status'] = 1;
                                    $resp['mess'] = 'Napravaló regisztráció módosítva';
                                } else {
                                    $resp['status'] = 0;
                                    $resp['mess'] = 'Update error.';
                                }
                            } else {
                                $check3 = $db->query("SELECT tabor.id AS taborID, tabor.maxember, coalesce(reg.emberek, 0) AS emberek FROM tabor ".
                                                    "LEFT JOIN (SELECT regisztracio.tabor AS taborID, COUNT(regisztracio.tabor) AS emberek ".
                                                    "FROM regisztracio ".
                                                    "WHERE regisztracio.active ".
                                                    "GROUP BY regisztracio.tabor) reg ON reg.taborID = tabor.id ".
                                                    "WHERE tabor.id = ".$dayID)->fetchAll();
                                if ($check3[0]['maxember'] != $check3[0]['emberek']) {
                                    $finish = $db->query("INSERT INTO regisztracio (gyerek, tabor, active) VALUES (".$childID.", ".$dayID.", 1)");
                                    if ($finish) {
                                        $resp['status'] = 1;
                                        $resp['mess'] = 'Napravaló regisztráció rögzítve';
                                    } else {
                                        $resp['status'] = 0;
                                        $resp['mess'] = 'Insert error.';
                                    }
                                } else {
                                    $resp['status'] = 0;
                                    $resp['mess'] = 'This day registrations is full.';
                                }
                            }
                        } else {
                            $resp['status'] = 0;
                            $resp['mess'] = 'Az adatok nem okésak :(';
                        }
                    } else {
                        $resp['status'] = 0;
                        $resp['mess'] = 'Missing dayID.';
                    }
                } else {
                    $resp['status'] = 0;
                    $resp['mess'] = 'Missing childID.';
                }
            } else if ($method == "child_napok_status") {
                if (isset($_POST['dayID']) && !empty($_POST['dayID'])) {
                    $result = $db->query("SELECT tabor.id AS taborID, COUNT(tabor.id) AS emberek FROM tabor ".
                                        "LEFT JOIN regisztracio ON regisztracio.tabor = tabor.id ".
                                        "WHERE tabor.active AND regisztracio.active AND tabor.id = ".$_POST['dayID']." ".
                                        "GROUP BY tabor.id")->fetchAll();
                                        $resp['status'] = 1;
                                        $resp['mess'] = 'Okés';
                                        $resp['datas'] = $result;
                } else {
                    $result = $db->query("SELECT tabor.id AS taborID, COUNT(tabor.id) AS emberek FROM tabor ".
                                        "INNER JOIN regisztracio ON regisztracio.tabor = tabor.id ".
                                        "WHERE tabor.active AND regisztracio.active ".
                                        "GROUP BY tabor.id")->fetchAll();
                                        $resp['status'] = 1;
                    $resp['mess'] = 'Okés';
                    $resp['datas'] = $result;
                }
            } else if ($method == "child_napok_feliratkozasok") {
                if (isset($_POST['childID']) && !empty($_POST['childID'])) {
                    $result = $db->query("SELECT tabor FROM regisztracio WHERE active IS TRUE AND gyerek = ".$_POST['childID'])->fetchAll();
                    $resp['status'] = 1;
                    $resp['mess'] = 'Okés';
                    $resp['datas'] = $result;
                } else {
                    $resp['status'] = 0;
                    $resp['mess'] = 'Missing childID.';
                }
            } else {
                $resp['status'] = 0;
                $resp['mess'] = 'Wrong method.';
            }
        } else {
            header("HTTP/1.0 418 I'm A Teapot");
            die;
        }
    } else {
        header("HTTP/1.0 418 I'm A Teapot");
        die;
    }

    header('Content-Type: application/json');
    echo json_encode($resp, JSON_UNESCAPED_UNICODE);
?>