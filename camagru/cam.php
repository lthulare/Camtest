<!doctype html>
<html>
    <head>
        <title>Snap</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <link href="css/style.css" rel="stylesheet" type="text/css">
    </head>
<body>
    <header style="padding-bottom: 70px;">
    <div class="nav">
      <ul>
        <li class="home"><a class = "active"  href="index.php">Home</a></li>
        <li class="tutorials"><a href="modify.php">Profile</a></li>
        <li class="about"><a href= "gallery.php">Gallery</a></li>
        <li class="contact"><a href="logout.php">Logout</a></li>      
      </ul>
    </div>
    </header>
    
    <div class="" style="position: relative; float:center; text-align:center;">
        <h1>Selfie Booth</h1>
        <video id="video">Streaming is unavailable</video>
        <img src="" alt="" id="overlay" style="position:fixed; float: left;width: 100px;height: 100px;">
        
        <form method='post' action='upload.php' onsubmit='prepare()'>
           <button id="photo-button" class="btn btn-primary" onclick="Prepare.js">Snap</button> 
           <input type='text'  id='img' name='img' value=''>
            <input type='submit' class='btn btn-primary' value='Upload last image'>
        <select id="photo-filter" name= "stick">
            <option value="none">Normal</option>
            <option value="styleimg/cool.png">Cool guy</option>
            <option value="styleimg/download.png">Emo</option>
            <option value="styleimg/whatsapp.png">Whatsapp</option>
            <option value="styleimg/minging.png">Minging</option>
        </select>
        <button id="clear-button">Clear</button>
        <canvas id="canvas" style="display:none;"></canvas>
    </div>
    <div class="bottom-container">
        <div id="photos"></div>
    </div>
    <script src="gallery.js" ></script>
    <script src= "prepare.js"></script>
    <br>
    <br>
    <footer>
                
                <div class="nav">
      <ul>
        <li class="home"><a href="cam.php">Refresh</a></li>
        <li class="about"><a href= "logout.php">Log out</a></li>   
      </ul>

                </ul>
        </footer>
</body>
</html>
