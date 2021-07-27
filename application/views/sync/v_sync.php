<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sync Simak</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Sync</a></li>
                        <li class="breadcrumb-item active">Sync</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="flash-data-gagal" data-flashdatagagal="<?= $this->session->flashdata('gagal'); ?>"></div>

    <section class="container-fluid">
        <form class="form-horizontal" action="<?= base_url()?>Sync/formcsv" method="post" name="uploadCSV"
            enctype="multipart/form-data">
            <div class="input-row">
                <label class="col-md-4 control-label">Choose CSV File</label> <input
                    type="file" name="file" id="file" accept=".csv">
                <button type="submit" id="submit" name="import"
                    class="btn-submit">Import</button>
                <br />

            </div>
            <div id="labelError"></div>
        </form>
    </section>
    <section class="container-fluid">
        <?php
        $sqlSelect = "SELECT * FROM users";
        $result = mysqli_query($conn, $sqlSelect);
                    
        if (mysqli_num_rows($result) > 0) {
        ?>
        <table id='userTable'>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>User Name</th>
                    <th>First Name</th>
                    <th>Last Name</th>

                </tr>
            </thead>
            <?php
            while ($row = mysqli_fetch_array($result)) {
            ?>

            <tbody>
                <tr>
                    <td><?php  echo $row['userId']; ?></td>
                    <td><?php  echo $row['userName']; ?></td>
                    <td><?php  echo $row['firstName']; ?></td>
                    <td><?php  echo $row['lastName']; ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        <?php } ?>
    </section>

</div>

<script type="text/javascript">
	$(document).ready(
	function() {
		$("#frmCSVImport").on(
		"submit",
		function() {

			$("#response").attr("class", "");
			$("#response").html("");
			var fileType = ".csv";
			var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+("
					+ fileType + ")$");
			if (!regex.test($("#file").val().toLowerCase())) {
				$("#response").addClass("error");
				$("#response").addClass("display-block");
				$("#response").html(
						"Invalid File. Upload : <b>" + fileType
								+ "</b> Files.");
				return false;
			}
			return true;
		});
	});
</script>