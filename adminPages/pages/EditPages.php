<?php require 'header.php'?>


<!-- //set session end -->
<?php if( isset($_GET['fileError'])) {?>
<div class='alert-container'>
    <div class='alert'>
        <p>
            <?=$_GET['fileError']?>
        </p>
        <button>ok</button>
    </div>
</div>
<?php } ?>

<?php if(isset($_GET['selectError'])) {?>
<div class='alert-container'>
    <div class='alert'>
        <p>
            <?=$_GET['selectError']?>
        </p>
        <button>ok</button>
    </div>
</div>
<?php } ?>




<h2>עורך תוכן</h2>
<?php require 'success_GET.php'; ?>

<form action="../back_process/page_update/pageUpdate.php" method="POST" id="edit-form">

    <input type="text" style='display:none' name='url' id='url' value='<?=$_SERVER['REQUEST_URI']?>'>

    <section>
        <?php require 'error_GET.php'; ?>

        <p>בחר עמוד ואזור לעריכה:</p>
        <div class='checkers'>


            <input type="radio" name="page-select" value="shomrim-cont_edit" id="shomrim-cont">
            <span class="radio-btn radio-btn-main">

                <legend for="shomrim-cont">שומרים</legend>
            </span>
            <input type="radio" name="page-select" value="nikayon-cont_edit" id="nikayon-cont">
            <span class="radio-btn radio-btn-main">

                <legend for="nikayon-cont">נקיון</legend>
            </span>
            <input type="radio" name="page-select" value="ahzaka-cont_edit" id="ahzaka-cont">
            <span class="radio-btn radio-btn-main">

                <legend for="ahzaka-cont">אחזקה</legend>
            </span>
            <input type="radio" name="page-select" value="home-cont_edit" id="home-cont" checked="checked">

            <span class="radio-btn radio-btn-main">
                <legend for="home-cont">עמוד הבית</legend>
            </span>
        </div>
        <!-- //NOTE://FIXME: make dinamic
 -->
        <div id="show-all-div" class='checkers'>
            <input type="radio" name="section-select" value="nehalim-edit" checked="checked" id="nehalim-edit">
            <span class="radio-btn-sub radio-btn">

                <legend for="nehalim-edit">נהלים</legend>
            </span>
            <input type="radio" name="section-select" value="anhayot-edit" id="anhayot-edit">
            <span class="radio-btn-sub radio-btn">

                <legend for="anhayot-edit">הנחיות</legend>
            </span>
            <input type="radio" name="section-select" value="schedule-edit" id="schedule-edit">
            <span class="radio-btn-sub radio-btn">

                <legend for="schedule-edit">לו"ז</legend>
            </span>
            <input type="radio" name="section-select" value="main-edit" id="main-edit">
            <span class="radio-btn-sub radio-btn" id="main-subNav-btn">

                <legend for="main-edit">ראשי</legend>
            </span>



        </div>
        <button id="load-page-to-editor" class="load-btn">טען עמוד</button>
        <div id="radio-addHow">
            <div>
                <input type="radio" name="create_or_add" value="add-toEnd" id="add-toEnd" checked="checked">
                <legend for="add-toEnd">הוסף תוכן זה בסוף האזור הנבחר</legend>
            </div>
            <div>
                <input type="radio" name="create_or_add" value="add-New" id="add-New">
                <legend for="add-New">צור תוכן חדש</legend>
            </div>
        </div>
        <div id="create-backup-div">
            <input type="checkbox" name="backup-content" value="backup" id="backup-check">
            <legend for="backup-check"> ליצור עותק לתוכן הקיים באתר</legend>
            <input type="text" name="backup-name" id="backup-name-input" disabled
                placeholder="הוסף שם או שמור כ-תאריך+עמוד+אזור בלבד">
        </div>

    </section>

    <div class="relative"><button id="save">
            <img src="../style/media/box-archive-solid.svg" alt="save"> שמור לאחר כך:</button>
        <input type="text" name='save_name' id='save_name' placeholder='שם'>
        <div class='msg-to-user' id='save_user_msg' style="display:none;">
        </div>
    </div>

    <textarea name="richText" id="richText"></textarea>


    <input type="submit" value="עדכן עמוד">
</form>
<aside>
    <span id='slider'>
        <span>

        </span>
    </span>
    <!-- FIXME: make dinamic -->

    <h3>קבצים שמורים</h3>
    <div id='side-page-select'>
        <button class='active' value='home'>בית</button>
        <button value='shomrim'>שומרים</button>
        <button value='ahzaka'>אחזקה</button>
        <button value='nikayon'>ניקיון</button>
    </div>
    <div id="side-section-filter">
        <button value=''>הכל</button>

        <button value='anhayot'>הנחיות</button>
        <button value='nehalim'>נהלים</button>
        <button value='schedule'>לו"ז</button>

        <button value='main'>ראשי</button>
    </div>
    <form class='radio-load-btns'>
        אין קבצים שמורים </form>
    <span class='error'>
        * בחר קובץ
    </span>
    <button class="load-btn" id='select-backup-load-btn'>טען</button>
</aside>

<?php include 'include_updates/admin_setters.php';?>



<?php require $pathContent_global . 'footer.php' ?>

<?php require '../include-inFoo/page-scripts.html';?>
<script src="<?php echo $pathScript_inner?>slider.js">
< script src = "<?php echo $pathScript_inner?>close_alerts.js" >
</script>
<script src="<?php echo $pathScript_inner?>EDIT_handle_selected_values.js"></script>

<script src="../script/dir-backup.php"></script>



<script src="../script/dir.php"></script>

<script //FIXME src="../script/load_sectionBtns.js">

</script> -->
<!-- //////////////////////////////////
///////////////////////////////////
/////////////////////////////////// -->
<script>
$(document).ready(function() {

    //NOTE: textarea options

    $('#richText').richText({
        // text formatting
        bold: true,
        italic: true,
        underline: true,

        // text alignment
        leftAlign: true,
        centerAlign: true,
        rightAlign: true,
        justify: true,

        // lists
        ol: true,
        ul: true,

        // title
        heading: true,

        // fonts
        //NOTE:changed to false
        fonts: false,
        fontList: [
            "Arial",
            "Arial Black",
            "Comic Sans MS",
            "Courier New",
            "Geneva",
            "Georgia",
            "Helvetica",
            "Impact",
            "Lucida Console",
            "Tahoma",
            "Times New Roman",
            "Verdana"
        ],
        fontColor: true,
        fontSize: true,

        // uploads
        imageUpload: true,
        fileUpload: true,

        // media
        videoEmbed: true,

        // link
        urls: true,

        // tables
        table: true,

        // code
        removeStyles: true,
        code: true,

        // colors
        colors: [],

        // dropdowns
        fileHTML: '',
        imageHTML: '',

        // translations
        translations: {
            'title': 'Title',
            'white': 'White',
            'black': 'Black',
            'brown': 'Brown',
            'beige': 'Beige',
            'darkBlue': 'Dark Blue',
            'blue': 'Blue',
            'lightBlue': 'Light Blue',
            'darkRed': 'Dark Red',
            'red': 'Red',
            'darkGreen': 'Dark Green',
            'green': 'Green',
            'purple': 'Purple',
            'darkTurquois': 'Dark Turquois',
            'turquois': 'Turquois',
            'darkOrange': 'Dark Orange',
            'orange': 'Orange',
            'yellow': 'Yellow',
            'imageURL': 'Image URL',
            'fileURL': 'File URL',
            'linkText': 'Link text',
            'url': 'URL',
            'size': 'Size',
            'responsive': 'Responsive',
            'text': 'Text',
            'openIn': 'Open in',
            'sameTab': 'Same tab',
            'newTab': 'New tab',
            'align': 'Align',
            'left': 'Left',
            'center': 'Center',
            'right': 'Right',
            'rows': 'Rows',
            'columns': 'Columns',
            'add': 'Add',
            'pleaseEnterURL': 'Please enter an URL',
            'videoURLnotSupported': 'Video URL not supported',
            'pleaseSelectImage': 'Please select an image',
            'pleaseSelectFile': 'Please select a file',
            'bold': 'Bold',
            'italic': 'Italic',
            'underline': 'Underline',
            'alignLeft': 'Align left',
            'alignCenter': 'Align centered',
            'alignRight': 'Align right',
            'addOrderedList': 'Add ordered list',
            'addUnorderedList': 'Add unordered list',
            'addHeading': 'Add Heading/title',
            'addFont': 'Add font',
            'addFontColor': 'Add font color',
            'addFontSize': 'Add font size',
            'addImage': 'Add image',
            'addVideo': 'Add video',
            'addFile': 'Add file',
            'addURL': 'Add URL',
            'addTable': 'Add table',
            'removeStyles': 'Remove styles',
            'code': 'Show HTML code',
            'undo': 'Undo',
            'redo': 'Redo',
            'close': 'Close'
        },

        // privacy
        youtubeCookies: false,

        // preview
        preview: false,

        // placeholder
        placeholder: '',

        // developer settings
        useSingleQuotes: false,
        height: 0,
        heightPercentage: 0,
        adaptiveHeight: false,
        id: "",
        class: "",
        useParagraph: true,
        maxlength: 0,
        callback: undefined,
        useTabForNext: false
    });
    ///////////////////////////////
    //[ ]here


    function showSaveMsg(type, cont) {
        let $msgContainer = $('#save_user_msg');

        $msgContainer.text(type).append("<span>" + cont + "</span>");
        $msgContainer.show();

        if (type == 'ERROR: ') {
            $msgContainer.css('color', 'red');
        } else {
            $msgContainer.css('color', 'white');

            setTimeout(() => {
                $msgContainer.fadeOut('slow');

            }, 5000);
        }


    }
    //////////////////////////////
    $("#save").click((e) => {
        e.preventDefault();
        let fileName = $('#save_name').val();
        let section = $('input[name=section-select]:checked').val();
        let page = $('input[name=page-select]:checked').val();
        let textData = $('#richText').val();


        let $msgContainer = $('#save_user_msg');

        //console.log(textData);
        $.ajax({
            url: "../back_process/page_update/save.php",
            type: "POST",
            data: {

                fileName: fileName,
                page: page,
                section: section,
                textData: textData
            },
            success: function(result) {
                console.log(result);
                if (result.includes('backup/') && result.includes('.html')) {
                    console.log('good');
                    showSaveMsg('נשמר כ: ', result);
                } else {
                    result = JSON.parse(result);
                    console.log(result);
                    showSaveMsg('ERROR: ', result[1]);
                }
            },
            error: function() {
                showSaveMsg('ERROR: ', 'could not make request');
            },
        });
    });


    //////////////////////////////////////
    //#region load pages to the editor

    $('#load-page-to-editor').click((e) => {
        e.preventDefault();

        //switch to replace content instead od add at the and [radio]
        $('#add-New').prop("checked", true);


        let page = $('input[name=page-select]:checked').val();
        page = page.split('-'),
            page = page[0];
        console.log(page);


        let section;
        if (page == 'home') {
            section = '/main.html';
        } else {

            section = $('input[name=section-select]:checked').val();

            section = section.split('-'),
                section = "/" + section[0] + ".html";
            console.log(section);
        }


        $.get("../../mainWebsite/pages/" + page + section, function(data) {
            $('#richText').val(data).trigger('change');

        });
    })
    //#endregion
    /////////////////////////////////////////////

    let load = document.getElementById("select-backup-load-btn");
    let err = document.getElementsByTagName('aside')[0];
    err = err.getElementsByClassName('error')[0];

    load.addEventListener("click", function() {
        if (document.querySelector('input[name="select-load"]:checked')) {
            let fileName =
                document.querySelector('input[name="select-load"]:checked').value +
                ".html";

            let page = document
                .getElementById("side-page-select")
                .getElementsByClassName("active");
            page = page[0].value;

            $.get(
                "../back_process/page_update/backup/" + page + "/" + fileName,
                function(data) {
                    $("#richText").val(data).trigger("change");
                }
            );
            err.style.display = 'none';

        } else {

            err.style.display = 'block';

        }
    });


})
</script>
</body>

</html>