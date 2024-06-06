<?php include 'partials/menu.php'; ?>

<style>
    .tbl-full {
        width: 100%;
        border-collapse: collapse;
    }

    .tbl-full th, .tbl-full td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    .tbl-full th {
        padding-top: 12px;
        padding-bottom: 12px;
        background-color: #f2f2f2;
        color: black;
    }

    .tbl-full tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .tbl-full tr:hover {
        background-color: #ddd;
    }

    .btn-secondary, .btn-danger {
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        display: inline-block;
        margin: 5px 2px;
    }

    .btn-secondary {
        background-color: #5cb85c;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #4cae4c;
    }

    .btn-danger {
        background-color: #d9534f;
        color: white;
    }

    .btn-danger:hover {
        background-color: #c9302c;
    }

    .wrapper {
        width: 95%;
        margin: 0 auto;
    }

    .main-content h1 {
        margin-bottom: 20px;
        color: #333;
    }

    .success {
        color: #4cae4c;
        font-weight: bold;
    }

    .error {
        color: #e74c3c;
        font-weight: bold;
    }
</style>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>

        <?php 
            if(isset($_SESSION['delete'])) {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            if(isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

            if(isset($_SESSION['unauthorize'])) {
                echo $_SESSION['unauthorize'];
                unset($_SESSION['unauthorize']);
            }
        ?>

        <br><br>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty.</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>

            <?php
            // SQL query to get all orders
            $sql = "SELECT * FROM tbl_order ORDER BY id DESC";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if ($count > 0) {
                $sn = 1; // Create a serial number variable and set its initial value as 1
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $total = $row['total'];
                    $order_date = $row['order_date'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];
                    ?>
                    <tr>
                        <td><?php echo $sn++; ?>. </td>
                        <td><?php echo $food; ?></td>
                        <td><?php echo $price; ?></td>
                        <td><?php echo $qty; ?></td>
                        <td><?php echo $total; ?></td>
                        <td><?php echo $order_date; ?></td>
                        <td>
                            <?php 
                                if ($status == 'Ordered') {
                                    echo "<label>$status</label>";
                                } elseif ($status == 'On Delivery') {
                                    echo "<label style='color: orange;'>$status</label>";
                                } elseif ($status == 'Delivered') {
                                    echo "<label style='color: green;'>$status</label>";
                                } elseif ($status == 'Cancelled') {
                                    echo "<label style='color: red;'>$status</label>";
                                }
                            ?>
                        </td>
                        <td><?php echo $customer_name; ?></td>
                        <td><?php echo $customer_contact; ?></td>
                        <td><?php echo $customer_email; ?></td>
                        <td><?php echo $customer_address; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update Order</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-order.php?id=<?php echo $id; ?>" class="btn-danger">Delete Order</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='12' class='error'>Orders not Available.</td></tr>";
            }
            ?>
        </table>
    </div>
</div>

<?php include 'partials/footer.php'; ?>
