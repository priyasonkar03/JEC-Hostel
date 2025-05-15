<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

$hostelType = isset($_GET['classId']) ? $_GET['classId'] : ''; // 'Girl' or 'Boy'
$filename = "Merit_List_" . $hostelType . "_" . date("Y-m-d");

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=" . $filename . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

// Step 1: Get teacher classId and classArmId using their email
$teacherEmail = $_SESSION['emailAddress'];
$classQuery = mysqli_query($conn, "SELECT classId, classArmId FROM tblclassteacher WHERE emailAddress = '$teacherEmail'");
$classData = mysqli_fetch_assoc($classQuery);

$classId = $classData['classId'];
$classArmId = $classData['classArmId'];
?>

<table border="1">
<thead>
    <tr>
        <th>#</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Gender</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Category</th>
        <th>JEE Percentage</th>
        <th>Hostel Type</th>
        <th>Session</th>
        <th>Degree</th>
        <th>Branch</th>
        <th>Reg Date</th>
    </tr>
</thead>
<tbody>

<?php
// Step 2: Filter students based on classId, classArmId, hostelType, and gender
$query = "
    SELECT *, 
    CASE 
        WHEN category = 'ST' THEN 1
        WHEN category = 'SC' THEN 2
        WHEN category = 'OBC' THEN 3
        WHEN category = 'General' THEN 4
        ELSE 5
    END AS category_rank
    FROM tblregstudents
    WHERE 
        classId = '$classId' AND 
        classArmId = '$classArmId' AND 
        (
            (category = 'ST' AND jeePercentage >= 35) OR
            (category = 'SC' AND jeePercentage >= 45) OR
            (category = 'OBC' AND jeePercentage >= 60) OR
            (category = 'General' AND jeePercentage >= 75)
        ) AND
        hostelType = '$hostelType'
    ORDER BY category_rank ASC, jeePercentage DESC
";

$result = mysqli_query($conn, $query);
$cnt = 1;

while ($row = mysqli_fetch_assoc($result)) {
    $gender = $row['gender'];

    if (
        ($hostelType == 'Girl' && $gender == 'Female') ||
        ($hostelType == 'Boy' && $gender == 'Male')
    ) {
        echo "<tr>
            <td>{$cnt}</td>
            <td>{$row['firstName']}</td>
            <td>{$row['lastName']}</td>
            <td>{$row['gender']}</td>
            <td>{$row['email']}</td>
            <td>{$row['phone']}</td>
            <td>{$row['category']}</td>
            <td>{$row['jeePercentage']}</td>
            <td>{$row['hostelType']}</td>
            <td>{$row['session']}</td>
            <td>{$row['degree']}</td>
            <td>{$row['branch']}</td>
            <td>{$row['regDate']}</td>
        </tr>";
        $cnt++;
    }
}
?>

</tbody>
</table>



























<!--<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

$filename = "Merit_List_" . date("Y-m-d");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=" . $filename . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table border="1">
<thead>
    <tr>
        <th>#</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Gender</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Category</th>
        <th>JEE Percentage</th>
        <th>Hostel Type</th>
        <th>Session</th>
        <th>Degree</th>
        <th>Branch</th>
        <th>Reg Date</th>
    </tr>
</thead>
<tbody>

<?php
/*$query = "
SELECT * FROM tblregstudents
WHERE 
    (category = 'ST' AND jeePercentage >= 35) OR
    (category = 'SC' AND jeePercentage >= 45) OR
    (category = 'OBC' AND jeePercentage >= 60) OR
    (category = 'General' AND jeePercentage >= 75)
ORDER BY jeePercentage DESC
";*/

$query = "
    SELECT *, 
    CASE 
        WHEN category = 'ST' THEN 1
        WHEN category = 'SC' THEN 2
        WHEN category = 'OBC' THEN 3
        WHEN category = 'General' THEN 4
        ELSE 5
    END AS category_rank
    FROM tblregstudents
    WHERE 
        (category = 'ST' AND jeePercentage >= 35) OR
        (category = 'SC' AND jeePercentage >= 45) OR
        (category = 'OBC' AND jeePercentage >= 60) OR
        (category = 'General' AND jeePercentage >= 75)
    ORDER BY category_rank ASC, jeePercentage DESC
";



$result = mysqli_query($conn, $query);
$cnt = 1;

while ($row = mysqli_fetch_assoc($result)) {
    $gender = $row['gender'];
    $hostelType = $row['hostelType'];

    // Match gender to hostelType
    if (
        ($gender == 'Male' && $hostelType == 'Boy') ||
        ($gender == 'Female' && $hostelType == 'Girl')
    ) {
        echo "<tr>
            <td>{$cnt}</td>
            <td>{$row['firstName']}</td>
            <td>{$row['lastName']}</td>
            <td>{$row['gender']}</td>
            <td>{$row['email']}</td>
            <td>{$row['phone']}</td>
            <td>{$row['category']}</td>
            <td>{$row['jeePercentage']}</td>
            <td>{$row['hostelType']}</td>
            <td>{$row['session']}</td>
            <td>{$row['degree']}</td>
            <td>{$row['branch']}</td>
            <td>{$row['regDate']}</td>
        </tr>";
        $cnt++;
    }
}
?>

</tbody>
</table> -->



<!--///==========update version

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../vendor/mpdf/mpdf/mpdf.php';
include '../Includes/dbcon.php';

// use Mpdf\Mpdf;
use mpdf\mpdf;

$mpdf = new mpdf();

$html = '
<h2 style="text-align:center;">Merit List</h2>
<table border="1" style="width:100%; border-collapse: collapse;">
<thead>
    <tr>
        <th>Rank</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Gender</th>
        <th>Category</th>
        <th>JEE %</th>
        <th>Hostel Type</th>
    </tr>
</thead>
<tbody>
';

$query = "
    SELECT * FROM tblregstudents
    WHERE 
        (category = 'ST' AND jeePercentage >= 35) OR
        (category = 'SC' AND jeePercentage >= 45) OR
        (category = 'OBC' AND jeePercentage >= 60) OR
        (category = 'General' AND jeePercentage >= 75)
    ORDER BY jeePercentage DESC
";

$result = mysqli_query($conn, $query);
$rank = 1;

while ($row = mysqli_fetch_assoc($result)) {
    $gender = $row['gender'];
    $hostelType = $row['hostelType'];

    if (
        ($gender == 'Male' && $hostelType == 'Boy') ||
        ($gender == 'Female' && $hostelType == 'Girl')
    ) {
        $html .= "<tr>
            <td>{$rank}</td>
            <td>{$row['firstName']}</td>
            <td>{$row['lastName']}</td>
            <td>{$gender}</td>
            <td>{$row['category']}</td>
            <td>{$row['jeePercentage']}%</td>
            <td>{$hostelType}</td>
        </tr>";
        $rank++;
    }
}

$html .= '</tbody></table>';

$mpdf->WriteHTML($html);
$mpdf->Output('Merit_List.pdf', 'D'); // D = force download
-->