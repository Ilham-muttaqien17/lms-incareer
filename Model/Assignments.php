<?php
class Assignments
{
    private $assignmentId;
    private $assignmentName;
    private $assignmentStartDate;
    private $assignmentEndDate;
    private $assignmentDesc;
    private $subjectId;
    private $dbConn;

    public function __construct()
    {
        require_once("DbConnect.php");
        $db = new DbConnect;
        $this->dbConn = $db->connect();
    }
    public function setAssignmentId($id)
    {
        $this->assignmentId = $id;
    }
    public function getAssignmentId()
    {
        return $this->assignmentId;
    }
    public function setAssignmentName($name)
    {
        $this->assignmentName = $name;
    }
    public function getAssignmentName()
    {
        return $this->assignmentName;
    }
    public function setAssignmentStartDate($date)
    {
        $this->assignmentStartDate = $date;
    }
    public function getAssignmentStartDate()
    {
        return $this->assignmentStartDate;
    }
    public function setAssignmentEndDate($date)
    {
        $this->assignmentEndDate = $date;
    }
    public function getAssignmentEndDate()
    {
        return $this->assignmentEndDate;
    }
    public function setAssignmentDesc($desc)
    {
        $this->assignmentDesc = $desc;
    }
    public function getAssignmentDesc()
    {
        return $this->assignmentDesc;
    }
    public function setSubjectId($id)
    {
        $this->subjectId = $id;
    }
    public function getSubjectId()
    {
        return $this->subjectId;
    }

    public function saveAssignment() {
        $stmt = $this->dbConn->prepare("INSERT INTO assignments VALUES(null, :name, :start_date, :end_date, :desc, null)");
        
        $stmt->bindParam(":name", $this->assignmentName);
        $stmt->bindParam(":start_date", $this->assignmentStartDate);
        $stmt->bindParam(":end_date", $this->assignmentEndDate);
        $stmt->bindParam(":desc", $this->assignmentDesc);

        try {
            if($stmt->execute()) {
                return true;
            } else {
                return false;
            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function createAssignment($data, $file) {
        $is_ok = false;
        $msg = "";

        if(!is_string($data['title'])) {
            $msg = "Judul tidak valid!";
            goto out;
        }

        if(!is_string($data['desc'])) {
            $msg = "Deskripsi tidak valid!";
            goto out;
        }

        if(empty($data['start-date'])) {
            $msg = "Tanggal mulai tidak boleh kosong!";
            goto out;
        }

        if(empty($data['end-date'])) {
            $msg = "Tanggal selesai tidak boleh kosong!";
            goto out;
        }

        $this->setAssignmentName($data['title']);
        $this->setAssignmentStartDate($data['start-date']);
        $this->setAssignmentEndDate($data['end-date']);
        $this->setAssignmentDesc($data['desc']);

        require_once("AssignmentQuestion.php");
        $objQuest = new AssignmentQuestion;

        $validExtention = ['pdf', 'doc', 'docx', 'xlsx', 'txt', 'png', 'jpg', 'jpeg', 'ppt'];
        $fileExtention = explode(".", $file['filename']['name']);
        $fileExtention = strtolower(end($fileExtention));

        if(!in_array($fileExtention, $validExtention)) {
            $msg = "Format file tidak didukung!";
            goto out;
        }

        $objQuest->setQuestionFileName($file['filename']['name']);
        date_default_timezone_set('Asia/Jakarta');
        $objQuest->setQuestionUploadDate(date("Y-m-d H:i:s"));

        $path = "./Upload/Assignment/Questions/";
        move_uploaded_file($file['filename']['tmp_name'], $path . $file['filename']['name']);

        $save = $this->saveAssignment();
        $upload = $objQuest->uploadFile();

        if($save && $upload) {
            $msg = "Berhasil membuat tugas!";
            $is_ok = true;
            goto out;
        } else {
            $msg = "Gagal membuat tugas!";
            goto out;
        }

        out: {
            return [
                "is_ok" => $is_ok,
                "msg" => $msg,
            ];
        }
    }
}