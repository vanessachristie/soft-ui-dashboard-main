<?php 
session_start();
include 'connection.php';
if (isset($_POST['productid'])) {
    $productid = $_POST['productid'];
    $tablename = $_POST['tablename'];
    $_SESSION['product_id'] = $productid;    
    $_SESSION['table_name'] = $tablename;   
    $column_name = $_SESSION['table_name'] . '_ID'; 
    $sql = "SELECT * FROM " . $_SESSION['table_name'] . " WHERE $column_name = '" . $_SESSION['product_id'] . "'";
    echo $sql;
} 


$result=$conn->query($sql);

if($result->num_rows > 0){
$response=array();
while ($row=$result->fetch_assoc()){
    $dt = $row;
    array_push($response,$dt);
}

$hasil_json=json_encode($response);
$data = json_decode($hasil_json,true);

?>


<!-- Modal -->


    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
    <form method="POST" class="formEdit" action="tables.php">
        <?php $index = 0; ?>
        <?php foreach ($data[0] as $columnName => $value): ?>
            <div class="form-group">
                <input type="text" class="form-control" value="<?php echo $value; ?>" name="<?php echo $columnName; ?>" <?php echo ($index === 0) ? 'readonly' : ''; ?>>
            </div>
            <?php $index++; ?>
        <?php endforeach; ?>

        <?php $columnNames = array_keys($data[0]); // Mengambil nama kolom dari $data ?>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="form<?php echo $columnNames[0]; ?>">Save changes</button>
        </div>

    </form>
    <form method="POST" class="formDel" action="tables.php"> 
        <?php
            $firstColumn = array_keys($data[0])[0]; // Mendapatkan nama kolom pertama
            $firstValue = $data[0][$firstColumn]; // Mendapatkan nilai dari kolom pertama
        ?>
        <input type="hidden" class="form-control" value="<?php echo $firstValue; ?>" name="<?php echo $firstColumn; ?>">
        <p>Are you sure want to delete this data?</p>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger" name="delForm">Delete</button>
        </div>
    </form>

    </div>
    </div>

<?php } session_destroy()?>
          