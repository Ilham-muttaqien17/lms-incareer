<?php
session_start();
// require('./login.php')
if (!isset($_SESSION['user'])) {
    header("location: ../../login.php");
}

switch ($_SESSION['user']['role']) {
    case 2:
        echo "<script>alert('Akses Ditolak');
    location.replace('../Mentor/index.php')</script>";
        break;
    case 3:
        echo "<script>alert('Akses Ditolak');
    location.replace('../../login.php')</script>";
        break;

    default:
        break;
}
// echo $_GET['assignment_id'];

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../../CSS/UploafField.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <title>Hello, world!</title>
</head>

<body>
    <!-- <form action="" method="POST" enctype="multipart/form-data">
        <div class="container">

            <div class="mb-3 mt-5">
                <label for="formFile" class="form-label">Upload File</label>
                
                <input type="file" class="form-control" id="exampleFormControlFile1" name="filename">
                <button class="btn btn-primary mt-5" type="submit" name="submit">Submit Assignment</button>
            </div>
        </div>
    </form> -->

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Upload File</label>
                        <div class="preview-zone hidden">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <div><b>Preview</b></div>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-danger btn-xs remove-preview">
                                            <i class="fa fa-times"></i> Reset This Form
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body"></div>
                            </div>
                        </div>
                        <div class="dropzone-wrapper">
                            <div class="dropzone-desc">
                                <!-- <i class="glyphicon glyphicon-download-alt"></i> -->
                                <i class="bi bi-arrow-down" style="font-size: 2rem; "></i>
                                <p>
                                    <strong> Choose a file</strong> or drag it here.
                                </p>
                            </div>
                            <input type="file" name="filename" class="dropzone">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <!-- <button type="submit" class="btn btn-primary pull-right">Upload</button> -->
                    <button class="btn btn-primary mt-5" type="submit" name="submit">Submit Assignment</button>

                </div>
            </div>
        </div>
    </form>

    <script>
        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    var htmlPreview =
                        '<img width="200" src="' + e.target.result + '" />' +
                        '<p>' + input.files[0].name + '</p>';
                    var htmlPrevPdf =
                        '<i class="bi bi-file-earmark-pdf-fill"></i>' +
                        '<p>' + input.files[0].name + '</p>';
                    var htmlPrevZipRar =
                        '<i class="bi bi-file-earmark-zip-fill"></i>' +
                        '<p>' + input.files[0].name + '</p>';
                    var htmlPrevDoc =
                        '<i class="bi bi-file-earmark-word-fill"></i>' +
                        '<p>' + input.files[0].name + '</p>';
                    const ext = input.files[0].name.split('.').pop();
                    console.log(ext)
                    var wrapperZone = $(input).parent();
                    var previewZone = $(input).parent().parent().find('.preview-zone');
                    var boxZone = $(input).parent().parent().find('.preview-zone').find('.box').find('.box-body');

                    wrapperZone.removeClass('dragover');
                    previewZone.removeClass('hidden');
                    boxZone.empty();
                    if (ext == 'pdf') {
                        boxZone.append(htmlPrevPdf);
                    } else if (ext == 'png' || ext == 'jpg') {
                        boxZone.append(htmlPreview);
                    } else if (ext == 'zip' || ext == 'rar') {
                        boxZone.append(htmlPrevZipRar);
                    } else if (ext == 'doc' || ext == 'docx') {
                        boxZone.append(htmlPrevDoc);
                    } else {
                        boxZone.append(htmlPreview);
                    }
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function reset(e) {
            e.wrap('<form>').closest('form').get(0).reset();
            e.unwrap();
        }
        $(".dropzone").change(function() {
            readFile(this);
        });
        $('.dropzone-wrapper').on('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('dragover');
        });
        $('.dropzone-wrapper').on('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('dragover');
        });
        $('.remove-preview').on('click', function() {
            var boxZone = $(this).parents('.preview-zone').find('.box-body');
            var previewZone = $(this).parents('.preview-zone');
            var dropzone = $(this).parents('.form-group').find('.dropzone');
            boxZone.empty();
            previewZone.addClass('hidden');
            reset(dropzone);
        });
    </script>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>