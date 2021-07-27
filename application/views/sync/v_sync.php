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

 <!-- Main content -->
 <section class="content">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Sinkornisasi Data dengan SIMAK
            </h3>

            <div class="card-tools">
                <button class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <?php echo form_open_multipart('sync/syncSimak'); ?>
            <div class="card-body">
                <h2>Import Data SIMAK</h2>
                <br>
                <input type="file" class="form-control-file" name="csvsimak" accept="csv">
            </div>
            <!-- card footer -->
            <div class="card-footer">
                <button type="submit" class="btn btn-success" name="import">Import Data</button> 
            </div>
        <?php echo form_close(); ?>
    </div>

 </section>

</div>