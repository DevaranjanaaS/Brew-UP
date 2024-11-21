<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $con = mysqli_connect('localhost', 'root', '', 'beverage');

    if (!$con) {
        die('Database connection error: ' . mysqli_connect_error());
    }

    $t = $_POST['TEMPRATURE'];
    $suga = $_POST['sugar'];
    $f = $_POST['FLAVOUR'];
    $i = $_POST['INSTANTFILTER'];
    $b = $_POST['BEAN'];

    // Ensure to properly escape the user input to prevent SQL injection
    $t = mysqli_real_escape_string($con, $t);
    $suga = mysqli_real_escape_string($con, $suga);
    $f = mysqli_real_escape_string($con, $f);
    $i = mysqli_real_escape_string($con, $i);
    $b = mysqli_real_escape_string($con, $b);

    $query = "SELECT * FROM about WHERE sugarquantity='$suga' AND hotcold='$t' AND flavour='$f' AND filterinstant='$i' AND typeofbean='$b'";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die('Query error: ' . mysqli_error($con));
    }

    $rows = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    $_SESSION['result'] = $rows;

    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Results</title>
    <style>
            @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}
html {
  scroll-behavior: smooth;
}
nav {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  height: 70px;
  background: #0e0f13;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
  z-index: 99;
}
nav .navbar {
  height: 100%;
  max-width: 1250px;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin: auto;
  /* background: red; */
  padding: 0 50px;
}
.navbar .logo a {
  font-size: 28px;
  color: #027373;
  text-decoration: none;
  font-weight: 600;
  font-family: "Merienda", sans-serif;
  margin: 1rem auto;
  background: -webkit-gradient(
      linear,
      left top,
      right top,
      from(#e6e6e6),
      to(#1d1c1c),
      color-stop(0.8, #ffffff)
    )
    no-repeat;
  background: gradient(
      linear,
      left top,
      right top,
      from(#222),
      to(#222),
      color-stop(0.8, #fff)
    )
    no-repeat;
  background-size: 110px 100%;
  -webkit-background-clip: text;
  background-clip: text;
  animation: flick 1.5s infinite;
  user-select: none;
}
@keyframes flick {
  0% {
    background-position: top left;
  }
  100% {
    background-position: top right;
  }
}
nav .navbar .nav-links {
  line-height: 70px;
  height: 100%;
}
nav .navbar .links {
  display: flex;
}
nav .navbar .links li {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: space-between;
  list-style: none;
  padding: 0 14px;
}
nav .navbar .links li a {
  height: 100%;
  text-decoration: none;
  white-space: nowrap;
  color: #e46313fa;
  font-size: 15px;
  font-weight: 500;
}
.links li:hover .htmlcss-arrow,
.links li:hover .js-arrow {
  transform: rotate(180deg);
}

nav .navbar .links li .arrow {
  /* background: red; */
  height: 100%;
  width: 22px;
  line-height: 70px;
  text-align: center;
  display: inline-block;
  color: #e46313fa;
  transition: all 0.3s ease;
}
nav .navbar .links li .sub-menu {
  position: absolute;
  top: 70px;
  left: 0;
  line-height: 40px;
  background: #0e0f13;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
  border-radius: 0 0 4px 4px;
  display: none;
  z-index: 2;
}
nav .navbar .links li:hover .htmlCss-sub-menu,
nav .navbar .links li:hover .js-sub-menu {
  display: block;
}
.navbar .links li .sub-menu li {
  padding: 0 22px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}
.navbar .links li .sub-menu a {
  color: #04bfad;
  font-size: 15px;
  font-weight: 500;
}
.navbar .links li .sub-menu .more-arrow {
  line-height: 40px;
}
.navbar .links li .htmlCss-more-sub-menu {
  /* line-height: 40px; */
}
.navbar .links li .sub-menu .more-sub-menu {
  position: absolute;
  top: 0;
  left: 100%;
  border-radius: 0 4px 4px 4px;
  z-index: 1;
  display: none;
}
.links li .sub-menu .more:hover .more-sub-menu {
  display: block;
}
.navbar .search-box {
  position: relative;
  height: 40px;
  width: 40px;
}
.navbar .search-box i {
  position: absolute;
  height: 100%;
  width: 100%;
  line-height: 40px;
  text-align: center;
  font-size: 22px;
  color: #e46313fa;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}
.navbar .search-box .input-box {
  position: absolute;
  right: calc(100% - 40px);
  top: 80px;
  height: 60px;
  width: 300px;
  background: #0e0f13;
  border-radius: 6px;
  opacity: 0;
  pointer-events: none;
  transition: all 0.4s ease;
}
.navbar.showInput .search-box .input-box {
  top: 65px;
  opacity: 1;
  pointer-events: auto;
  background: #0e0f13;
}
.search-box .input-box::before {
  content: "";
  position: absolute;
  height: 20px;
  width: 20px;
  background: #0e0f13;
  right: 10px;
  top: -6px;
  transform: rotate(45deg);
}
.search-box .input-box input {
  position: absolute;
  top: 50%;
  left: 50%;
  border-radius: 4px;
  transform: translate(-50%, -50%);
  height: 35px;
  width: 280px;
  outline: none;
  padding: 0 15px;
  font-size: 16px;
  border: none;
}
.navbar .nav-links .sidebar-logo {
  display: none;
}
.navbar .bx-menu {
  display: none;
}
@media (max-width: 920px) {
  nav .navbar {
    max-width: 100%;
    padding: 0 25px;
  }

  nav .navbar .logo a {
    font-size: 27px;
  }
  nav .navbar .links li {
    padding: 0 10px;
    white-space: nowrap;
  }
  nav .navbar .links li a {
    font-size: 15px;
  }
}
@media (max-width: 800px) {
  nav {
    /* position: relative; */
  }
  .navbar .bx-menu {
    display: block;
  }
  nav .navbar .nav-links {
    position: fixed;
    top: 0;
    left: -100%;
    display: block;
    max-width: 270px;
    width: 100%;
    background: #0e0f13;
    line-height: 40px;
    padding: 20px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    transition: all 0.5s ease;
    z-index: 1000;
  }
  .navbar .nav-links .sidebar-logo {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .sidebar-logo .logo-name {
    font-size: 25px;
    color: #fff;
  }
  .sidebar-logo i,
  .navbar .bx-menu {
    font-size: 25px;
    color: #e46313fa;
  }
  nav .navbar .links {
    display: block;
    margin-top: 20px;
  }
  nav .navbar .links li .arrow {
    line-height: 40px;
  }
  nav .navbar .links li {
    display: block;
  }
  nav .navbar .links li .sub-menu {
    position: relative;
    top: 0;
    box-shadow: none;
    display: none;
  }
  nav .navbar .links li .sub-menu li {
    border-bottom: none;
  }
  .navbar .links li .sub-menu .more-sub-menu {
    display: none;
    position: relative;
    left: 0;
  }
  .navbar .links li .sub-menu .more-sub-menu li {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .links li:hover .htmlcss-arrow,
  .links li:hover .js-arrow {
    transform: rotate(0deg);
  }
  .navbar .links li .sub-menu .more-sub-menu {
    display: none;
  }
  .navbar .links li .sub-menu .more span {
    /* background: red; */
    display: flex;
    align-items: center;
    /* justify-content: space-between; */
  }

  .links li .sub-menu .more:hover .more-sub-menu {
    display: none;
  }
  nav .navbar .links li:hover .htmlCss-sub-menu,
  nav .navbar .links li:hover .js-sub-menu {
    display: none;
  }
  .navbar .nav-links.show1 .links .htmlCss-sub-menu,
  .navbar .nav-links.show3 .links .js-sub-menu,
  .navbar .nav-links.show2 .links .more .more-sub-menu {
    display: block;
  }
  .navbar .nav-links.show1 .links .htmlcss-arrow,
  .navbar .nav-links.show3 .links .js-arrow {
    transform: rotate(180deg);
  }
  .navbar .nav-links.show2 .links .more-arrow {
    transform: rotate(90deg);
  }
}
body {
  min-height: 100vh;
  overflow-x: hidden;
  background-color: #979da6;
}
.heading {
  font-size: 38px;
  text-align: center;
}
.filter-box {
  text-align: center;
  align-items: center;
  justify-content: center;

  color: #e46313fa;
  height: 55px;
  border-color: rgb(128, 64, 0);
  border-width: 5px;
  margin-top: 4%;
  padding-top: 0.5%;
}
.text {
  margin-top: 5px;
  margin-left: 40%;
  text-align: center;
  align-items: center;
  justify-content: center;
}
.image {
  width: 35%;
  height: 55%;
  margin-left: 30%;
  margin-top: 75px;
}

.box {
  padding: 6px 12px;
  background: #0e0f13;
  border: 1px solid rgb(60, 63, 68);
  border-radius: 4px;
  font-size: 13px;
  color: #e46313fa;
  height: 46px;
  appearance: none;
  transition: border 0.15s ease 0s;
  font-size: 15px;
}

.box:focus {
  outline: none;
  box-shadow: none;
  border-color: rgb(100, 153, 255);
}
.submit {
  background-color:  rgb(128, 64, 0);
  border-radius: 100px;
  box-shadow: rgba(200, 204, 206, 0.2) 0 -25px 18px -14px inset,
    rgba(200, 204, 206, 0.15) 0 1px 2px, rgba(200, 204, 206, 0.15) 0 2px 4px,
    rgba(200, 204, 206, 0.15) 0 4px 8px, rgba(200, 204, 206, 0.15) 0 8px 16px,
    rgba(200, 204, 206, 0.15) 0 16px 32px;
  color: #ffffff;
  cursor: pointer;
  display: inline-block;
  font-family: CerebriSans-Regular, -apple-system, system-ui, Roboto, sans-serif;
  padding: 7px 20px;
  text-align: center;
  text-decoration: none;
  transition: all 250ms;
  border: 0;
  font-size: 16px;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  margin-top: -1px;
}

.submit:hover {
  box-shadow: rgba(216, 174, 129, 0.2) 0 -25px 18px -14px inset,
    rgba(129, 216, 208, 0.2) 0 1px 2px, rgba(129, 216, 208, 0.2) 0 2px 4px,
    rgba(129, 216, 208, 0.2) 0 4px 8px, rgba(129, 216, 208, 0.2) 0 8px 16px,
    rgba(129, 216, 208, 0.2) 0 16px 32px;
  transform: scale(1.05) rotate(0deg);
}
        table {
            margin-top:10%;
            border-collapse: collapse;
            width: 100%;
        }
        
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <?php
    if (isset($_SESSION['result'])) {
        $result = $_SESSION['result'];
        unset($_SESSION['result']);
    ?>
    <h1>Query Results</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Sugar Quantity</th>
                <th>Hot/Cold</th>
                <th>Flavour</th>
                <th>Filter/Instant</th>
                <th>Type of Bean</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo $row['coffeename']; ?></td>
                <td><?php echo $row['sugarquantity']; ?></td>
                <td><?php echo $row['hotcold']; ?></td>
                <td><?php echo $row['flavour']; ?></td>
                <td><?php echo $row['filterinstant']; ?></td>
                <td><?php echo $row['typeofbean']; ?></td>
                <td><?php echo $row['price'];?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php } ?>
    <nav>
        <div class="navbar">
          <i class="bx bx-menu"></i>
          <img src="" alt="" srcset="" />
          <div class="logo"><a href="#"><img src="images/logo.png"></a></div>
          <div class="nav-links">
            <div class="sidebar-logo">
              <span class="logo-name">BREW UP</span>
              <i class="bx bx-x"></i>
            </div>
            <ul class="links">
              <li><a href="org.html" id="home">HOME</a></li>
              
              
          
          </div>
        </div>
      </nav>
    
      <div class="filter-box">
        <form class="box" action="" method="post">
          <label for="TEMPRATURE">PICK YOUR TEMPRATURE:</label>
          <select id="TEMPRATURE" name="TEMPRATURE">
            <option value="HOT">HOT</option>
            <option value="COLD">COLD</option>
          </select>
          <label for="sugar">PICK YOUR SUGAR PREFERENCE:</label>
          <select id="sugar" name="sugar">
            <option value="HIGH">HIGH</option>
            <option value="MEDIUM">MEDIUM</option>
            <option value="LOW">LOW</option>
          </select>
          <label for="FLAVOUR">PICK YOUR FLAVOUR:</label>
          <select id="FLAVOUR" name="FLAVOUR">
            <option value="CARMEL">CARMEL</option>
            <option value="VANILLA">VANILLA</option>
            <option value="CHOCOLATE">CHOCOLATE</option>
            <option value="HAZEL NUT">HAZEL NUT</option>
          </select>
          <label for="INSTANTFILTER">INSTANT OR FILTER:</label>
          <select id="INSTANTFILTER" name="INSTANTFILTER">
            <option value="INSTANT">INSTANT</option>
            <option value="FILTER">FILTER</option>
          </select> 
          <label for="BEAN">PICK YOUR BEAN:</label>
          <select id="BEAN" name="BEAN">
            <option value="ARABICA">ARABICA</option>
            <option value="DARK ROAST">DARK ROAST</option>
            <option value="LIBERICA">LIBERICA</option>
          </select> 
          <button type="submit">Submit</button>
        </form>
      </div>
    </div>
  </body>
</body>
</html>
