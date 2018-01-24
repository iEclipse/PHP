//Header Information
<html>
<head>
<title>Bank PHP Demo - New Account</title>
<link rel="stylesheet" type="text/css" href="Stylesheet.css">
</head>
<center>
<body>

//Collect Form Information From User
<div class="CreateAccount">
<b>New Account</b><p>
<form action="<?php
echo htmlspecialchars($_SERVER["PHP_SELF"]);
?>" method="post">
Username<br> <input type="text" name="username" size="35" maxlength="15"><p>
Password<br> <input type="password" name="password" size="35" maxlength="15"><p>
Re-Enter Password<br> <input type="password" name="password2" size="35" maxlength="15"><p>
Name<br> <input type="text" name="firstname" placeholder="First" size="15" maxlength="15"> <input type="text" name="lastname" placeholder="Last" size="15" maxlength="15"><p>
Account Type [Withdrawl Limit]<br>
<select name="type" style="width: 280px;">
  <option value="Gold">Gold ($20,000)</option>
  <option value="Platinum">Platinum ($50,000)</option>
  <option value="Unlimited">Unlimited</option>
</select><p>
<input type="submit" value="Create Account" name="CreateAccount"> <input type="submit" value="Login"></form>
</div>
<br>

</body>
</center>
</html>

//Creates Account and Does Requirement Checking
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username  = test_input($_POST["username"]);
        $password  = $_POST["password"];
        $password2 = $_POST["password2"];
        $name  = test_input($_POST["firstname"]) . " " . test_input($_POST["lastname"]);
        $type  = test_input($_POST["type"]);
    if (isset($_POST['CreateAccount'])) {
        if ($username == "" or $password == "" or $password2 == "" or $name == "")
            echo "<b><font color=\"red\"><center>MISSING INFORMATION.</font></b></center>";
        elseif (!ctype_alnum($username))
            echo "<b><font color=\"red\"><center>INVALID USERNAME.</font></b></center>";
        elseif (file_exists($username))
            echo "<b><font color=\"red\"><center>USERNAME ALREADY TAKEN.</font></b></center>";
        elseif (!ctype_alpha(test_input($_POST["firstname"])) or !ctype_alpha(test_input($_POST["lastname"])))
            echo "<b><font color=\"red\"><center>INVALID NAME.</font></b></center>";
        else if (strlen($password) < 6 || strpos($password, ' ') !== false)
            echo "<b><font color=\"red\"><center>PASSWORD MUST BE AT LEAST SIX CHARACTERS LONG AND CANNOT CONTAIN SPACES.</font></b></center>";
        elseif ($password !== $password2)
            echo "<b><font color=\"red\"><center>PASSWORDS DO NOT MATCH.</font></b></center>";
        else {
            $file = fopen($username, "x+");
            fwrite($file, $password . "\n" . $name . "\n" . $type . "\n0");
            fclose($file);
            echo "<b><font color=\"lightgreen\"><center>ACCOUNT SUCCESSFULLY CREATED.</font></b></center>";
        }
    } else
        header('Location: Home.php');
}

//Removes Whitespace
function test_input($data)
{
    $data = trim($data);
    return $data;
}
?>