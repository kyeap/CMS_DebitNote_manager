
<div class="login_form">
    <form action="" method="post">

        <label class="formLabel" for="username"><b>Username</b></label>
        <input class="login_input" type="text" name="username" placeholder="Enter username">
        <label class="formLabel" for="password"><b>Username</b></label>
        <input class="login_input" type="password" name="password" placeholder="Enter password">
        <input class="login_submit" type="submit" name="login" value="login">

    </form>
</div>

 <?php

    //if login then store variable in session
    if(isset($_POST['login'])){

        include 'config.php';
        $username = $_POST['username'];
        $password = $_POST['password'];

        // $uname = mysqli_real_escape_string($_POST['username']);
        // $password = mysqli_real_escape_string($_POST['password']);

        $sql = "SELECT * FROM uname_pass WHERE username='$username' and password='$password'";

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
            //set the resulting array to associative
            $search_result_array =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            }
        
        if(count($search_result_array) > 0){
            $_SESSION['uname'] = $username;
            $_SESSION['auth'] = 1;

            echo "<script>window.location.href='/index.php?page=private/loginHome';</script>";
            exit();
        }else{
            echo "Invalid username and password";
        }
        
    }

?>