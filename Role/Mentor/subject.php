<?php

session_start();

$loginPath = "../../login.php";

if(!isset($_SESSION['user_data'])) {
    header("location: " . $loginPath);
    die;
}

switch($_SESSION['user_data']->{'user'}->{'role_id'}) {
    case 1:
        echo "
        <script>
            alert('Akses ditolak!');
            location.replace('../Admin/');
        </script>
        ";
        break;
    case 3:
        echo "
        <script>
            alert('Akses ditolak!');
            location.replace('../Student/');
        </script>
        ";
        break;
    default:
        break;
}

require_once "../../api/get_api_data.php";
require_once "../../api/get_request.php";

$subjectData = array();
$courseData = array();

$modulJSON = json_decode(http_request("https://lessons.lumintulogic.com/api/modul/read_modul_rows.php"));

for($i = 0; $i < count($modulJSON->{'data'}); $i++) {
    if($modulJSON->{'data'}[$i]->{'parent_id'} == $_GET['course_id']) {
        array_push($subjectData, $modulJSON->{'data'}[$i]);
    }
}

for($i = 0; $i < count($modulJSON->{'data'}); $i++) {
    if($modulJSON->{'data'}[$i]->{'id'} == $_GET['course_id']) {
        array_push($courseData, $modulJSON->{'data'}[$i]);
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $courseData[0]->{'modul_name'}; ?></title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Jqueey -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">


    <!-- CSS -->
    <!-- <link rel="stylesheet" href="./CSS/UploafField.css"> -->


    <!-- Tailwindcss -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.1/dist/flowbite.min.css" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        montserrat: ["Montserrat"],
                    },
                    colors: {
                        "dark-green": "#1E3F41",
                        "light-green": "#659093",
                        "cream": "#DDB07F",
                        "cgray": "#F5F5F5",
                    }
                }
            }
        }
    </script>
    <style>
        .in-active{
            width: 80px !important;
            padding: 20px 15px !important;
            transition: .5s ease-in-out;
        }
        .in-active ul li p{
            display: none !important;
        }

        .in-active ul li a{
            padding: 15px !important;
        }

        .in-active h2,
        .in-active h4,
        .in-active .logo-incareer{
            display: none !important;
        }
        .hidden{
            display: none !important;
        }
        .sidebar{
            transition: .5s ease-in-out;
        }
    </style>

</head>
<body>
    <div class="flex items-center">
        <!-- Left side (Sidebar) -->
        <div class="bg-white w-[350px] h-screen px-8 py-6 flex flex-col justify-between sidebar in-active">
            <!-- Top nav -->
            <div class="flex flex-col gap-y-6">
                <!-- Header -->
                <div class="flex items-center space-x-4 px-2">
                   <img src="../../Img/icons/toggle_icons.svg" alt="toggle_dashboard" class="w-8 cursor-pointer" id="btnToggle">
                     <img class="w-[150px] logo-incareer" src="../../Img/logo/logo_primary.svg" alt="Logo In Career">
                </div>

                <hr class="border-[1px] border-opacity-50 border-[#93BFC1]">

                <!-- List Menus -->
                <div>
                    <ul class="flex flex-col gap-y-1">
                        <li>
                            <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../../Img/icons/home_icon.svg" alt="Dashboard Icon">
                                <p class="font-semibold">Dashboard</p>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 bg-cream">
                                <img class="w-5" src="../../Img/icons/course_icon.svg" alt="Course Icon">
                                <p class="text-white font-semibold">Courses</p>
                            </a>
                        </li>
                        <li>
                            <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../../Img/icons/discussion_icon.svg" alt="Forum Icon">
                                <p class="font-semibold">Forum Dicussion</p>
                            </a>
                        </li>
                        <li>
                            <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../../Img/icons/schedule_icon.svg" alt="Schedule Icon">
                                <p class="font-semibold">Schedule</p>
                            </a>
                        </li>
                        <li>
                            <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../../Img/icons/attendance_icon.svg" alt="Attendance Icon">
                                <p class="font-semibold">Attendance</p>
                            </a>
                        </li>
                        <li>
                            <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../../Img/icons/score_icon.svg" alt="Score Icon">
                                <p class="font-semibold">Score</p>
                            </a>
                        </li>
                        <li>
                            <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../../Img/icons/consult_icon.svg" alt="Consult Icon">
                                <p class="font-semibold">Consult</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom nav -->
            <div>
                <ul class="flex flex-col ">
                    <li>
                        <a href="#" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                            <img class="w-5" src="../../Img/icons/help_icon.svg" alt="Help Icon">
                            <p class="font-semibold">Help</p>    
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                            <img class="w-5" src="../../Img/icons/logout_icon.svg" alt="Log out Icon">
                            <p class="font-semibold">Log out</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

       

        <!-- Right side -->
        <div class="bg-cgray w-full h-screen px-10 py-6 flex flex-col gap-y-6 overflow-y-scroll">
            <!-- Header / Profile -->
            <div class="flex items-center gap-x-4 justify-end">
                <img class="w-10" src="../../Img/icons/default_profile.svg" alt="Profile Image">
                <p class="text-dark-green font-semibold"><?=$_SESSION['user']->{'user_username'}?></p>
            </div>

            <!-- Breadcrumb -->
            <div>
                <ul class="flex items-center gap-x-4">
                    <li>
                        <a class="text-light-green hover:text-dark-green hover:font-semibold" href="#">Home</a>
                    </li>
                    <li>
                        <span class="text-light-green">/</span>
                    </li>
                    <li>
                        <a class="text-light-green hover:text-dark-green hover:font-semibold" href="index.php">Courses</a>
                    </li>
                    <li>
                        <span class="text-light-green">/</span>
                    </li>
                    <li>
                        <a class="text-dark-green font-semibold" href="#">Sub Topic</a>
                    </li>
                </ul>
            </div>
            
            <div class="p-4">
                <p class="text-4xl text-dark-green font-semibold">List Sub Topic of <?= $courseData[0]->{'modul_name'}; ?></p>
            </div>

            <div class="p-4 mt-10 grid grid-cols-4 gap-4">
                <?php foreach ($subjectData as $row => $subject) : ?>
                    <a href="assignment.php?subject_id=<?= $subject->{'id'};?>&course_id=<?=$_GET['course_id']?>" class="block p-6 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 w-100">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900"><?= $subject->{'modul_name'}; ?></h5>
                        <p class="font-normal text-gray-700 flex flex-row items-center gap-4 mt-5">
                            <img src="../../Img/icons/dokumen_icon.svg" alt="dokumen"><?= $subject->{'id'}; ?>
                        </p>
                    </a>
                <?php endforeach ?>
            </div>
        </div>
    </div>
     
    <script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>
    <script>
        let btnToggle = document.getElementById('btnToggle');
        let sidebar = document.querySelector('.sidebar');
        btnToggle.onclick = function(){
            sidebar.classList.toggle('in-active');
        }
        
    </script>

    
</body>
</html>