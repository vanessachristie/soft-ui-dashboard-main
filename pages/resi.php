<?php 
session_start();
include 'connection.php';
if (isset($_POST['orderid'])) {
    $orderid = $_POST['orderid'];
    $tablename = $_POST['tablename'];
    $_SESSION['order_id'] = $orderid;    
    $_SESSION['table_name'] = $tablename;   
    $column_name = $_SESSION['table_name'] . '_ID'; 
    $sql = "SELECT C.CUSTOMER_NAME , O.ORDER_ID, O.ORDER_DATE, P.PRODUCT_NAME, O.TOTAL_QTY, D.DELIVERY_NAME, CONCAT(D.DELIVERY_WEIGHT, 'gr') AS DELIVERY_WEIGHT, D.DELIVERY_COST, A.PHONE, A.ADDRESS FROM CUSTOMER C INNER JOIN `ORDER` O ON C.CUSTOMER_ID = O.CUSTOMER_ID INNER JOIN DELIVERY D ON O.DELIVERY_ID = D.DELIVERY_ID INNER JOIN ADDRESS A ON C.CUSTOMER_ID = A.CUSTOMER_ID INNER JOIN PRODUCT_ORDER PO ON O.ORDER_ID = PO.ORDER_ID INNER JOIN PRODUCT P ON PO.PRODUCT_ID = P.PRODUCT_ID WHERE O.ORDER_ID ='" . $_SESSION['order_id'] . "' ;";
    
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
<!DOCTYPE html>
<html>
<head>
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .section-heading {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .section-content {
            margin-bottom: 20px;
        }

        .label {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">RECEIVER:</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
    <div class="label">Receiver:</div>
            <div><?php echo $data[0]["CUSTOMER_NAME"]; ?></div>

            <div class="label">Order ID:</div>
            <div><?php echo $data[0]["ORDER_ID"]; ?></div>

            <div class="label">Order Date:</div>
            <div><?php echo $data[0]["ORDER_DATE"]; ?></div>

            <div class="label">Product Name:</div>
            <div><?php echo $data[0]["PRODUCT_NAME"]; ?></div>

            <div class="label">Total Quantity:</div>
            <div><?php echo $data[0]["TOTAL_QTY"]; ?></div>

            <div class="label">Delivery Name:</div>
            <div><?php echo $data[0]["DELIVERY_NAME"]; ?></div>

            <div class="label">Delivery Weight:</div>
            <div><?php echo $data[0]["DELIVERY_WEIGHT"]; ?></div>

            <div class="label">Delivery Cost:</div>
            <div><?php echo $data[0]["DELIVERY_COST"]; ?></div>

            <div class="label">Phone:</div>
            <div><?php echo $data[0]["PHONE"]; ?></div>

            <div class="label">Address:</div>
            <div><?php echo $data[0]["ADDRESS"]; ?></div>

            <div class="section-heading">SHIPPER:</div>
        <div class="section-content">
            <div>Ever After Essentials</div>
        </div>
    </div>

</body>
</html>
<?php } session_destroy()?>