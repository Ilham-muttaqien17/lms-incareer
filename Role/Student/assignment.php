<?php

session_start();

$loginPath = "../../login.php";

if (!isset($_SESSION['user'])) {
    header("location: " . $loginPath);
}

switch ($_SESSION['user']->{'role_id'}) {
    case 1:
        echo "
        <script>
            alert('Akses Ditolak');
            location.replace('../Admin/index.php')
        </script>";
        break;
    case 2:
        echo "
        <script>
            alert('Akses Ditolak');
            location.replace('../Mentor/login.php')
        </script>";
        break;

    default:
        break;
}

require_once('../../Model/Assignments.php');
$objAssign = new Assignments;

$allAssignments = $objAssign->getAssignmentBySubjectId($_GET['subject_id']);
// var_dump($allAssignments);

require "../../api/get_api_data.php";


$subModulData = json_decode(http_request("https://ppww2sdy.directus.app/items/modul_name"));
$lectureData = array();
$modulJSON = json_decode(http_request("https://ppww2sdy.directus.app/items/modul_name"));
$userBatchJSON = json_decode(http_request("https://i0ifhnk0.directus.app/items/user_batch"));
$userJSON = json_decode(http_request("https://i0ifhnk0.directus.app/items/user"));


for ($i = 0; $i < count($modulJSON->{'data'}); $i++) {
    if ($modulJSON->{'data'}[$i]->{'id'} == $_GET['subject_id']) {
        for ($j = 0; $j < count($userBatchJSON->{'data'}); $j++) {
            if ($modulJSON->{'data'}[$i]->{'batch_id'} == $userBatchJSON->{'data'}[$j]->{'batch_batch_id'}) {
                for ($k = 0; $k < count($userJSON->{'data'}); $k++) {
                    if ($userBatchJSON->{'data'}[$j]->{'user_user_id'} == $userJSON->{'data'}[$k]->{'user_id'} && $userJSON->{'data'}[$k]->{'role_id'} == 2) {
                        array_push($lectureData, $userJSON->{'data'}[$k]);
                    }
                }
            }
        }
    }
}

$subModul = array();

for($i = 0; $i < count($subModulData->{'data'}); $i++) {
    if($subModulData->{'data'}[$i]->{'id'} == $_GET['subject_id']) {
        array_push($subModul, $subModulData->{'data'}[$i]);
    }
}

echo "<input type='hidden' id='student_id' value='" . $_SESSION['user']->{'user_id'} . "'/>";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment Page</title>

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
        .in-active {
            width: 80px !important;
            padding: 20px 15px !important;
            transition: .5s ease-in-out;
        }

        .in-active ul li p {
            display: none !important;
        }

        .in-active ul li a {
            padding: 15px !important;
        }

        .in-active h2,
        .in-active h4,
        .in-active .logo-incareer {
            display: none !important;
        }

        .hidden {
            display: none !important;
        }

        .sidebar {
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
                <p class="text-dark-green font-semibold"><?= $_SESSION['user']->{'user_username'} ?></p>
            </div>

            <!-- Breadcrumb -->
            <div>
                <ul class="flex items-center gap-x-4">
                    <li>
                        <a class="text-light-green" href="#">Home</a>
                    </li>
                    <li>
                        <span class="text-light-green">/</span>
                    </li>
                    <li>
                        <a class="text-light-green" href="#">Courses</a>
                    </li>
                    <li>
                        <span class="text-light-green">/</span>
                    </li>
                    <li>
                        <a class="text-light-green" href="#">Sub Topic</a>
                    </li>
                    <li>
                        <span class="text-light-green">/</span>
                    </li>
                    <li>
                        <a class="text-dark-green font-semibold" href="#">Assignment</a>
                    </li>
                </ul>
            </div>

            <!-- Topic Title -->
            <div>
                <p class="text-4xl text-dark-green font-semibold">Session#1 <?= $subModul[0]->{'modul_name'}; ?></p>
            </div>

            <!-- Mentor -->
            <div class="flex items-center gap-x-4 w-full bg-white py-4 px-10 rounded-xl">
                <img class="w-14" src="../../Img/icons/default_profile.svg" alt="Profile Image">
                <div class="">
                    <p class="text-dark-green text-base font-semibold"><?= $lectureData[0]->{'user_first_name'} . " " . $lectureData[0]->{'user_last_name'}?> | Mentor Code</p>
                    <p class="text-light-green">Mentor Specialization</p>
                </div>
            </div>

            <!-- Tab -->
            <div class="bg-white w-full h-[50px] flex content-center px-10">
                <ul class="flex items-center gap-x-8">
                    <li class="text-dark-green hover:text-cream hover:border-b-4 hover:border-cream h-[50px] flex items-center font-semibold  cursor-pointer">
                        <p>Session</p>
                    </li>
                    <li class="text-dark-green hover:text-cream hover:border-b-4 hover:border-cream h-[50px] flex items-center font-semibold  cursor-pointer">
                        <p>Assignment</p>
                    </li>
                </ul>
            </div>

            <!-- Direction -->
            <div class="bg-white w-full p-6">
                <p class="text-dark-green font-semibold">Directions :</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex quo dolore atque eveniet iusto iste accusantium sint, obcaecati unde totam labore omnis sit laborum, architecto quia ea laboriosam libero soluta accusamus modi laudantium quod neque rerum quaerat. Quasi eaque officiis, commodi maiores, nisi asperiores distinctio magni quas, itaque facere consequuntur eos pariatur voluptatum illum tenetur esse. Provident excepturi velit maxime non officia voluptas nisi. Quod dolorum quisquam obcaecati ad laudantium maiores, aperiam eveniet voluptate ab. Asperiores ducimus, minus impedit enim reiciendis sit aperiam ut labore, facere rerum tempora. Molestias nesciunt beatae consequatur minus dolorum tempora culpa cum, tenetur corrupti facilis.</p>
            </div>

            <!-- Table Assignment -->
            <div>
                <table class="shadow-lg bg-white" style="width: 100%">
                    <colgroup>
                        <col span="1" style="width: 15%">
                        <col span="1" style="width: 10%">
                        <col span="1" style="width: 10%">
                        <col span="1" style="width: 10%">
                        <col span="1" style="width: 10%">
                        <col span="1" style="width: 10%">
                        <col span="1" style="width: 15%">
                        <col span="1" style="width: 10%">
                    </colgroup>
                    <thead>
                        <tr class="text-dark-green">
                            <th class="border-b text-left px-4 py-2">Title</th>
                            <th class="border-b text-center px-4 py-2">Start Date</th>
                            <th class="border-b text-center px-4 py-2">Due Date</th>
                            <th class="border-b text-center px-4 py-2">Due Time</th>
                            <th class="border-b text-center px-4 py-2">Description</th>
                            <th class="border-b text-center px-4 py-2">Questions</th>
                            <th class="border-b text-center px-4 py-2">Upload</th>
                            <th class="border-b text-center px-4 py-2">Assignment History</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allAssignments as $row => $assignment) : ?>
                            <?php
                            $arrStartDate = explode(" ", $assignment['assignment_start_date']);
                            $arrEndDate = explode(" ", $assignment['assignment_end_date']);

                            // var_dump($arrEndDate);
                            $startDate = $arrStartDate[0];
                            $dueDate = $arrEndDate[0];
                            $dueTime = $arrEndDate[1];
                            ?>
                            <tr>
                                <td class="border-b px-4 py-2"><?= $assignment['assignment_name']; ?></td>
                                <td class="border-b px-4 py-2 text-center"><?= $startDate; ?></td>
                                <td class="border-b px-4 py-2 text-center"><?= $dueDate; ?></td>
                                <td class="border-b px-4 py-2 text-center"><?= $dueTime; ?></td>
                                <td class="border-b px-4 py-2 text-center"><a href="#"><img class="w-7 mx-auto cursor-pointer" src="../../Img/icons/detail_icon.svg" alt="Download Icon" type="button" data-modal-toggle="medium-modal<?= "medium-modal" . $assignment['assignment_id'] ?>" id="showDesc" data-desc="<?= $assignment['assignment_desc'] ?>"></a></td>
                                <td class="border-b px-4 py-2">
                                    <?php
                                    require_once('../../Model/AssignmentQuestion.php');
                                    $asq = new AssignmentQuestion;
                                    $asq->setAssignmentId($assignment['assignment_id']);
                                    $question = $asq->getQuestionsByAssignmentId();
                                    ?>
                                    <a href="download.php?file=<?= $question['question_filename'] . '&type=q'; ?>"><img class=" w-7 mx-auto cursor-pointer" src="../../Img/icons/download_icon.svg" alt="Download Icon"></a>
                                </td>
                                <td class="border-b px-4 py-2">
                                    <?php 
                                    require_once "../../Model/AssignmentSubmission.php";
                                    $objsubmit = new AssignmentSubmission;
                                    $objsubmit->setStudentId($_SESSION['user']->{'user_id'});
                                    $objsubmit->setAssignmentId($assignment['assignment_id']);
                                    $initsubmit = $objsubmit->getInitSubmit();
                                    $now = $objsubmit->getCurrentDate();
                                    $msg = '';
                                    $csub = $objsubmit->getSubmissionByAssignIdAndStudentIdGroupBy();

                                    if (count($initsubmit) == 1) { 

                                        if((strtotime($now['now()']) >= strtotime($assignment['assignment_end_date']))){
                                            ?> 
                                                <img class="w-7 mx-auto " data-tooltip-target="tooltip-default1" src="../../Img/icons/create_iconred.svg" alt="Create Icon" name="btnup" id="btnup">
                                                <div id="tooltip-default1" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-red-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-red-700">
                                                    You can't submit your work 
                                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                                </div>
                                            <?php
                                        } else {
                                            ?>
                                                <img class="w-7 mx-auto cursor-pointer modalUpload" src="../../Img/icons/create_icon.svg" alt="Create Icon" type="button" data-modal-toggle="defaultModal<?= $assignment['assignment_id']; ?>" data-assignid="<?= $assignment['assignment_id']; ?>" id="uploadModal">
                                            <?php 
                                        } 
                                    } else { 
                                        if (count($csub) < 3) { ?>
                                                <img class="w-7 mx-auto cursor-pointer modalUpload" data-tooltip-target="tooltip-default" src="../../Img/icons/create_icon.svg" alt="Create Icon" type="button" data-modal-toggle="defaultModal<?= $assignment['assignment_id']; ?>" data-assignid="<?= $assignment['assignment_id']; ?>" id="uploadModal">
                                                <div id="tooltip-default" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-black rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip ">
                                                   Already submit !!
                                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                                </div>
                                            <?php
                                            
                                        } else if (count($csub) >= 3 || (strtotime($now['now()']) >= strtotime($assignment['assignment_end_date']))){
                                            ?> 
                                                <img class="w-7 mx-auto " data-tooltip-target="tooltip-default1" src="../../Img/icons/create_iconred.svg" alt="Create Icon" name="btnup" id="btnup">
                                                <div id="tooltip-default1" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-red-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-red-700">
                                                    You can't submit your work 
                                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                                </div>
                                            <?php
                                        }
                                        
                                    ?>
                                        
                                    <?php } ?>

                                </td>
                                <td class="border-b px-4 py-2">
                                    <img class="w-7 mx-auto cursor-pointer" src="../../Img/icons/history_icon.svg" alt="History Icon" type="button" data-modal-toggle="historymodal<?= $assignment['assignment_id']; ?>">
                                </td>

                            </tr>
                            <!-- modal ASSIGNMENT HISTORY -->
                            <div id="historymodal<?= $assignment['assignment_id']; ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                                <div class="relative p-4 w-full max-w-xl h-full md:h-auto">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow ">
                                        <!-- Modal header -->
                                        <div class="flex justify-center items-start p-5 rounded-t ">
                                            <h3 class="text-xl font-bold  lg:text-2xl text-dark-green">
                                                ASSIGNMENT HISTORY
                                            </h3>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="px-6 space-y-6">
                                            <div class="mb-6 relative overflow-x-auto sm:rounded-lg border border-gray-400 px-4 py-2">
                                                <div class="relative w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                                    <ul class="grid grid-cols-12 border-b border-gray-400 py-2">
                                                        <li><b>No</b></li>
                                                        <li class="col-span-5"><b>Submission Time</b></li>
                                                        <li class="col-span-5"><b>Title</b></li>
                                                        <li><b>Files</b></li>
                                                    </ul>
                                                    <?php
                                                        require_once "../../Model/AssignmentSubmission.php";
                                                        $objSub = new AssignmentSubmission;
                                                        $objSub->setStudentId($_SESSION['user']->{'user_id'});
                                                        $objSub->setAssignmentId($assignment['assignment_id']);
                                                        $submissions = $objSub->getSubmissionByAssignIdAndStudentId();

                                                        $i = 1;

                                                        foreach($submissions as $val => $submission) :
                                                    ?>
                                                    <ul class="grid grid-cols-12 border-b border-gray-400 py-2">
                                                        <li><?= $i; ?></li>
                                                        <li class="col-span-5"><?=$submission['submitted_date'];?></li>
                                                        <li class="col-span-5 truncate"><?= $submission['submission_filename'];?></li>
                                                        <li><a href="download.php?file=<?= $submission['submission_filename'] . '&type=s'; ?>"><img class=" w-7 mx-auto cursor-pointer" src="../../Img/icons/download_icon.svg" alt="Download Icon"></a></li>
                                                    </ul>

                                                    <?php 
                                                        $i++;
                                                        endforeach     
                                                    ?>
                                                    
                                                </div>
                                            </div>
                                            <div class="flex justify-end p-6 space-x-3 rounded-b ">
                                                <button data-modal-toggle="historymodal<?= $assignment['assignment_id']; ?>" class="w-32 bg-yellow-400 text-center py-1 text-white rounded-md hover:bg-yellow-600" type="button">Confirm</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END MODAL -->


                            <!-- Main modal -->
                            <div id="defaultModal<?= $assignment['assignment_id']; ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                                <div class="relative p-4 w-full max-w-xl h-full md:h-auto">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow ">
                                        <!-- Modal header -->
                                        <div class="flex justify-center items-start p-5 rounded-t ">
                                            <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl dark:text-dark">
                                                Upload Submission
                                            </h3>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="px-6 space-y-6">
                                            <form class="flex flex-col gap-y-4" action="" method="POST" enctype="multipart/form-data">
                                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border rounded-md">
                                                    <div class="space-y-2 text-center">
                                                        <svg class="mx-auto h-20 w-20 text-gray-400" id="downloadIcon" viewBox="0 0 150 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M118.75 56.25H93.75V18.75H56.25V56.25H31.25L75 106.25L118.75 56.25ZM25 118.75H125V131.25H25V118.75Z" fill="#DDB07F" />
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" id="prevDoc" class="mx-auto h-20 w-20 hidden" viewBox="0 0 20 20" fill="#DDB07F">
                                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                                        </svg>
                                                        <p class="text-gray-600" id="countFile"></p>
                                                        <div class="flex text-lg text-gray-600">
                                                            <label for="fileInput" class="relative cursor-pointer bg-white rounded-md font-medium font-semibold hover:text-gray-500">
                                                                <span>Choose a file</span>
                                                                <input id="fileInput" name="fileInput" type="file" class="sr-only dropzone" onchange="readFile(event)" multiple>
                                                                <input type="hidden" name="assignId" id="assignId">
                                                                <input type="hidden" name="cf" id="cf">
                                                            </label>
                                                            <p class="pl-1">or drag it here</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex justify-end p-6 space-x-2 rounded-b border-gray-200 dark:border-gray-600">
                                                    <button data-modal-toggle="defaultModal<?= $assignment['assignment_id']; ?>" type="button" class="text-gray-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center hover:ring-2 hover:ring-gray-400">Close</button>
                                                    <button class="bg-dark-green text-[#F3D0AA] w-[120px] py-2 rounded font-medium ml-auto hover:bg-gray-800" type="submit" name="submit" id="uploadSubmission">Submit</button>
                                                </div>
                                            </form>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- Description Modal -->
                            <div id="medium-modal<?= "medium-modal" . $assignment['assignment_id'] ?>" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                                <div class="relative p-4 w-full max-w-lg h-full md:h-auto">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow ">
                                        <!-- Modal header -->
                                        <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                                            <h3 class="text-xl font-medium text-center">
                                                Description
                                            </h3>
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="medium-modal<?= "medium-modal" . $assignment['assignment_id'] ?>">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="p-6 space-y-6">
                                            <p class="text-base leading-relaxed">
                                                <?= $assignment['assignment_desc'] ?>
                                            </p>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="flex justify-end p-6 space-x-2 rounded-b border-gray-200 dark:border-gray-600">
                                            <button data-modal-toggle="medium-modal<?= "medium-modal" . $assignment['assignment_id'] ?>" type="button" class="text-gray bg-cream focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-transparent hover:text-white hover:bg-gray-600 dark:focus:ring-dark-800">Close</button>
                                            <!-- <button data-modal-toggle="medium-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Decline</button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END MODAL -->
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>




    <script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>
    <script>
        let btnToggle = document.getElementById('btnToggle');
        let sidebar = document.querySelector('.sidebar');
        btnToggle.onclick = function() {
            sidebar.classList.toggle('in-active');
        }

        function readFile(e) {
            let documentPrev = document.getElementById("prevDoc");
            let downloadIcon = document.getElementById("downloadIcon");
            let file = document.getElementById("fileInput");
            let countFile = document.getElementById("countFile");
            let cf = document.getElementById("cf");
            cf.value = file.files.length;

            downloadIcon.classList.add("hidden");
            documentPrev.classList.remove("hidden");

            countFile.innerHTML = "Selected " + file.files.length;

        }
        $(document).ready(function() {
            $(document).on("click", "#uploadModal", function(evt) {
                evt.preventDefault();

                let studentId = document.getElementById("student_id");
                let assignment_id = $(this).data("assignid");
                let student_id = studentId.value;
                let fileData = document.getElementById("fileInput");

                
                $(document).on("click", "#uploadSubmission", function(evt) {
                    evt.preventDefault();
                    let cf = document.getElementById("cf");

                    let cfile = cf.value;
                    let data = {
                        assigId: assignment_id,
                        studId: student_id,
                        count: cfile
                    }
                    // console.log(data);

                    $.ajax({
                        url: "insert_submission.php",
                        type: "post",
                        data: data,
                        // xhr: function() {
                        //     let xhr = new window.XMLHttpRequest();

                        //     xhr.upload.addEventListener("progress", function(evt) {
                        //         loader.style.display = "block";
                        //     })
                        // },
                        // console.log(data);
                        success: function(data) {
                            // console.log(data);
                            let dataJson = JSON.parse(data);
                            // loader.style.display = "none";

                            // console.log(dataJson[0].submission_id);
                            for (i = 0; i < fileData.files.length; i++) {
                                let formData = new FormData();
                                formData.append("data", fileData.files[i]);
                                formData.append("submission_id", dataJson[i].submission_id);

                                $.ajax({
                                    url: "upload_submission.php",
                                    type: "post",
                                    data: formData,
                                    contentType: false,
                                    cache: false,
                                    processData: false,
                                    success: function(data) {
                                        // console.log(data);
                                        let val = JSON.parse(data);
                                        alert(val.msg);
                                        location.replace("index.php");
                                    }
                                })
                            }
                        }
                    })

                })



            })
        })
    </script>


</body>

</html>