<?php   $pathStyle_inner = 'style/'; $pathStyle_global = '../globalStyle/';
        $pathScript_inner = 'script/'; $pathScript_global ='../globalScript/';
        $pathContent_global = '../global-content/';
?>


<!DOCTYPE html>
<html lang="he" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="אתר מידע והנחיות לצוות בניין שאפ.">
    <meta name="keywords" content="צוות בית שאפת,שאפ,עובדים">
    <meta name="author" content="Tatyana Shaferov">
    <!-- add icon link -->
    <link rel="icon" href="<?php echo $pathStyle_global?>media/SHAP.png" type="image/x-icon">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- fontAwesome -->
    <script src="https://kit.fontawesome.com/b2fc89dd52.js" crossorigin="anonymous"></script>
    <title>צוות בית שאפ</title>
    <!-- styles -->

    <!-- global styles for both sites -->
    <link rel="stylesheet" href="<?php echo $pathStyle_global?>header&footer.css">
    <link rel="stylesheet" href="<?php echo $pathStyle_global?>root.css">

    <!-- local styles -->
    <link rel="stylesheet" href="<?php echo $pathStyle_inner?>root.css" type="text/css">

    <link rel="stylesheet" href="<?php echo $pathStyle_inner?>general_&main.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $pathStyle_inner?>pages.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $pathStyle_inner?>messages.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $pathStyle_inner?>article.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $pathStyle_inner?>secondary-nav.css" type="text/css">




</head>

<body>

    <nav id="nav">
        <div id="main-nav">
            <span class="logo">
                שאפ
            </span>
            <div id="nav-btns">
                <button class="nav-btn" value="shomrim">שומרים</button>
                <button class="nav-btn" value="nikayon">נקיון</button>
                <button class="nav-btn" value="ahzaka">אחזקה</button>
            </div>
        </div>

        <div id="secondary-nav">
            <div class="big upper-nav">
                <a href="#messages">הודעות</a>

                <a href="#nehalim">נהלים</a>
                <a href="#anhayot">הנחיות</a>

                <a href="#schedule">מערכת שעות</a>
            </div>
            <div class='small'>


            </div>
        </div>
    </nav>

    <!-- ////////////////////////// -->

    <button class="main-side-navigation-arrow" id="up"><img
            src="<?php echo $pathStyle_inner?>media/circle-arrow-up-solid.svg" alt="up"></button>
    <button class="main-side-navigation-arrow" id="down"><img
            src="<?php echo $pathStyle_inner?>media/circle-arrow-down-solid.svg" alt="down"></button>


    <!-- //////////////////////////////////////// -->

    <main>

    </main>
    <?php require $pathContent_global . 'footer.php' ?>
    <script>

    </script>
    <!-- scripts -->
    <script src="<?php echo $pathScript_inner;?>navigation.js"></script>

    <script src="<?php echo $pathScript_inner;?>scroll.js"></script>
    <script src="<?php echo $pathScript_inner;?>article-navigation.js
"></script>


    <script>
    </script>


</body>

</html>