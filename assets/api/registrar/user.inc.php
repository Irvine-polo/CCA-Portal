<?php

$baseUrl = "../../../";

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "registrar");

if (isset($_GET["selectUsers"])) {
	$request = $_REQUEST;

	$sql = "SELECT * FROM users WHERE role = 'student' ";

	if (!empty($request["search"]["value"])) {
		$sql .= "AND (username LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR email_address LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR CONCAT(lastname, ', ', firstname, ' ', middlename) LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR CONCAT(is_active, ' ', 'status') LIKE '%" . $request["search"]["value"] . "%') ";
	}

	$result = mysqli_query($conn, $sql);

	$totalData = mysqli_num_rows($result);
	$totalFilter = $totalData;

	$sql .= "ORDER BY lastname ASC, firstname ASC, middlename ASC ";
	$sql .= "LIMIT " . $request["start"] . ", " . $request["length"];

	$result = mysqli_query($conn, $sql);

	$data = [];
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$subdata = array();

			$subdata[] =	"<a data-fancybox='' data-src='../assets/uploads/avatars/" . $row["avatar"] . "'>
								<button class='btn btn-secondary btn-sm'>View</button>
							</a>";
			$subdata[] = $row["username"];
			$subdata[] = $row["lastname"] . ", " . $row["firstname"] . " " . $row["middlename"];
			$subdata[] = $row["role"];

			if ($row["is_active"] == 1) {
			    $subdata[] = "<span class='badge bg-success'>enabled</span>";
			} else if ($row["is_active"] == 0) {
				$subdata[] = "<span class='badge bg-danger'>disabled</span>";
			}

			if ($row["is_active"] == 1) {
				$subdata[] = "<div class='btn-group'>
					<button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#recoverModal' data-bs-name='" . $row["username"] . "' data-bs-href='../assets/includes/registrar/user.inc.php?recoverUser&id=" . $row["id"] . "' title='recover'>
						<i class='fa-solid fa-heart-pulse'></i>
					</button>
					<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#disableModal' data-bs-name='" . $row["username"] . "' data-bs-href='../assets/includes/registrar/user.inc.php?disableUser&id=" . $row["id"] . "' title='disable'>
						<i class='fa-solid fa-toggle-off'></i>
					</button>
					<a class='btn btn-info btn-sm' href='../../../registrar/edit/user?userId=" . $row["id"] . "' title='edit'>
					    <i class='fa-solid fa-pen-to-square'></i>
					</a>
				</div>";
			} else if ($row["is_active"] == 0) {
				$subdata[] = "<div class='btn-group'>
					<button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#recoverModal' data-bs-name='" . $row["username"] . "' data-bs-href='../assets/includes/registrar/user.inc.php?recoverUser&id=" . $row["id"] . "' title='recover'>
						<i class='fa-solid fa-heart-pulse'></i>
					</button>
					<button type='button' class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#enableModal' data-bs-name='" . $row["username"] . "' data-bs-href='../assets/includes/registrar/user.inc.php?enableUser&id=" . $row["id"] . "' title='enable'>
						<i class='fa-solid fa-toggle-on'></i>
					</button>
					<a class='btn btn-info btn-sm' href='../../../registrar/edit/user?userId=" . $row["id"] . "' title='edit'>
					    <i class='fa-solid fa-pen-to-square'></i>
					</a>
				</div>";
			}

			$data[] = $subdata;
		}
	}

	$jsonData = array(
		"draw"				=> intval($request['draw']),
		"recordsTotal"		=> intval($totalData),
		"recordsFiltered"	=> intval($totalFilter),
		"data"				=> $data
	);

	echo json_encode($jsonData);
}