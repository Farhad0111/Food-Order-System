<?php
    include('../config/constants.php');
    //echo "Delete Page";
    //Check whether the id and image_name value is set or not
    if(isset($_GET['id']) AND isset( $_GET['image_name']))

    {
        //Get the value and delete
        //echo"Get value and delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove the physical image file is available
        if($image_name != "")
        {
            $path = "../images/category/".$image_name;
            $remove = unlink($path);

            if($remove == false)
            {
                //Set the Session message
                $_SESSION['remove'] = "<div class='error'>Failed to remove image</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
                die();
            }
        }


        //Delete data from database

        $sql = "DELETE FROM tbl_category WHERE id = $id";

        $res = mysqli_query($conn, $sql);

        if($res == true)
        {
            //Success
            $_SESSION['delete'] = "<div class = 'success'>Category Deleted Successfully</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            //Failed
            $_SESSION['delete'] = "<div class = 'error'>Failed to Delete Category</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }


        //Redirect to manage category
    }
    else
    {
        //redirect to Manage Category page
        header('location:'.SITEURL.'admin/manage-category.php');

    }


?>