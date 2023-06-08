<style>
    .bordergaris {
        border: 1px solid black;
        padding: 5px;
    }
</style>

<?php 
session_start();
include 'connection.php';
if (isset($_POST['orderid'])) {
    $orderid = $_POST['orderid'];
    $tablename = $_POST['tablename'];
    $_SESSION['order_id'] = $orderid;    
    $_SESSION['table_name2'] = $tablename;   
    $column_name = $_SESSION['table_name2'] . '_ID'; 
    $sql = "SELECT P.PRODUCT_ID AS 'PRODUCT ID', P.PRODUCT_NAME AS 'PRODUCT NAME', P.PRODUCT_PRICE AS'PRODUCT PRICE', ROUND((O.GRAND_TOTAL - O.TOTAL_POTONGAN) + ((O.GRAND_TOTAL - O.TOTAL_POTONGAN) * 5/100)) AS 'GRAND TOTAL', D.DELIVERY_COST AS 'DELIVERY COST' FROM  PRODUCT_ORDER PO INNER JOIN PRODUCT P ON PO.PRODUCT_ID = P.PRODUCT_ID INNER JOIN `ORDER` O ON PO.ORDER_ID = O.ORDER_ID INNER JOIN DELIVERY D ON O.DELIVERY_ID = D.DELIVERY_ID WHERE  PO.order_id = '" . $_SESSION['order_id'] . "'; ";

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


<div class="modal-content popupdetails">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Product Details</h5>
        <button type="button" class="btn-close" style="background-color: black;" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form method="POST" class="formEdit">
            <?php $index = 0; ?>
            <?php foreach ($data[0] as $columnName => $value): ?>
                <div class="form-group">
                    <label for="<?php echo $columnName; ?>"><?php echo $columnName; ?>:</label>
                    <p id="<?php echo $columnName; ?>"><?php echo $value; ?></p>
                </div>
                <?php $index++; ?>
            <?php endforeach; ?>

            <?php $columnNames = array_keys($data[0]); // Mengambil nama kolom dari $data ?>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary popupresi" name="form<?php echo $columnNames[0]; ?>">View Receipt</button>
            </div>
        </form>

       
    </div>
</div>
<div class="modal-content resi">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">RECEIPT</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: black;"></button>

    </div>
    <div class="modal-body">
        <?php
        if (isset($_POST['orderid'])) {
            $orderid = $_POST['orderid'];
            $tablename = $_POST['tablename'];
            $_SESSION['order_id'] = $orderid;    
            $_SESSION['table_name'] = $tablename;   
            $column_name = $_SESSION['table_name'] . '_ID'; 
            $sql = "SELECT C.CUSTOMER_NAME, O.ORDER_ID, O.ORDER_DATE, P.PRODUCT_NAME, O.TOTAL_QTY, D.DELIVERY_NAME, CONCAT(D.DELIVERY_WEIGHT, 'gr') AS DELIVERY_WEIGHT, D.DELIVERY_COST, IF(A.PHONE IS NULL, '-',A.PHONE) AS PHONE, IF(A.ADDRESS IS NULL,'-',A.ADDRESS) AS ADDRESS FROM `ORDER` O LEFT JOIN CUSTOMER C ON O.CUSTOMER_ID = C.CUSTOMER_ID LEFT JOIN DELIVERY D ON O.DELIVERY_ID = D.DELIVERY_ID LEFT JOIN ADDRESS A ON C.CUSTOMER_ID = A.CUSTOMER_ID LEFT JOIN PRODUCT_ORDER PO ON O.ORDER_ID = PO.ORDER_ID LEFT JOIN PRODUCT P ON PO.PRODUCT_ID = P.PRODUCT_ID WHERE O.ORDER_ID ='" . $_SESSION['order_id'] . "';";
            
            
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
    }        
        ?>
    <div class="label">RECEIVER:</div>
    <div  class="label"><?php echo $data[0]["CUSTOMER_NAME"]; ?></div>
            <div><?php echo $data[0]["ORDER_ID"]; ?></div>

            <div><?php echo $data[0]["ADDRESS"]; ?></div>

            <div>Phone: <?php echo $data[0]["PHONE"]; ?></div>

            <BR></BR>

            <div class="section-heading">SHIPPER:</div>
        <div class="section-content">
            <div>Ever After Essentials</div>
        </div>


            <br><br>

            <div class="bordergaris">
                <div class="label">Order Date:</div>
                <div><?php echo $data[0]["ORDER_DATE"]; ?></div>

                <div class="label">Delivery Name:</div>
                <div><?php echo $data[0]["DELIVERY_NAME"]; ?></div>

                <div class="label">Delivery Weight:</div>
                <div><?php echo $data[0]["DELIVERY_WEIGHT"]; ?></div>

                <div class="label">Delivery Cost:</div>
                <div><?php echo $data[0]["DELIVERY_COST"]; ?></div>
            </div>

<br><br>

<div class="bordergaris row">
    <div class="col-9">
            <div class="label">Product Name:</div>
            <div><?php echo $data[0]["PRODUCT_NAME"]; ?></div>
            </div>
            <div class="col-3">
            <div class="label">Quantity</div>
            <div><?php echo $data[0]["TOTAL_QTY"]; ?></div>
            </div>

</div>

            </div>   
       
    </div>
</div>

<script>
    const resi = document.querySelector('.resi');
    const popupresi = document.querySelector('.popupresi');
    const popupdetails = document.querySelector('.popupdetails');
    resi.style.display = 'none';
    popupdetails.style.display = 'block';
    popupresi.addEventListener('click', function(event) {
      event.preventDefault();
      resi.style.display = 'block';
      popupdetails.style.display = 'none';
      });
</script>

<?php } session_destroy()?>
          