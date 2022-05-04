<?php require 'header.php' ; ?>


<h2>צור הודעה חדשה</h2>
<form action="../back_process/messages_page/handle_new_msg.php" method="POST" id="edit-form">

    <input type="text" style='display:none' name='url' id='url' value='<?=$_SERVER['REQUEST_URI']?>'>
    <section>
        <?php $error = 'error';require 'error_GET.php'; ?>
        <p>סמן לאיזה עמודים להעלות את ההודעה:</p>
        <div class='checkers'>


            <input type="checkbox" name="shomrim-msg" value="shomrim-msg" id="shomrim-msg">
            <span class="radio-btn check-btn-msg">

                <legend for="shomrim-msg">שומרים</legend>
            </span>
            <input type="checkbox" name="nikayon-msg" value="nikayon-msg" id="nikayon-msg">
            <span class="radio-btn check-btn-msg">

                <legend for="nikayon-msg">נקיון</legend>
            </span>
            <input type="checkbox" name="ahzaka-msg" value="ahzaka-msg" id='ahzaka-msg'>
            <span class="radio-btn check-btn-msg">

                <legend for="ahzaka-msg">אחזקה</legend>
            </span>

            <!-- <span class="radio-btn check-btn-msg">
                <input type="checkbox" name="general-msg" value="general-msg" checked="checked">
                <legend for="general-msg">הודעה כללית</legend>
            </span> -->
        </div>
        <!-- <div id="show-all-div">
            <input type="checkbox" name="show-all" value="show-all">
            <legend for="show-all">הראה הודעה זו בכל העמודים</legend>
        </div> -->
        <div>
            <legend for="expire">* תאריך אחרון להופעת ההודעה:</legend>
            <input type="date" name="expire" id="expire-msg">
        </div>
        <!-- <button id="load-page-to-editor">ערוך הודעה נוכחית</button> -->

    </section>
    <textarea name="richText" id="richText"></textarea>
    <input type="submit" value="צור הודעה">
</form>
<hr>
<main>
    <section>
        <h3>טען הודעות</h3>
        <div id="load-msg" class="checkers">
            <!-- <button class="load-btn">טען הודעות קיימות</button> -->
            <input type="checkbox" name="empty-msg-load" value="1" id="empty-msg-load">
            <span class="radio-btn radio-btn-sub">
                <legend for="empty-msg">ללא </legend>
            </span>
            <input type="checkbox" name="shomrim-msg-load" value="1" id="shomrim-msg-load">
            <span class="radio-btn radio-btn-sub">
                <legend for="shomrim-msg">שומרים</legend>
            </span>
            <input type="checkbox" name="nikayon-msg-load" value="1" id="nikayon-msg-load">
            <span class="radio-btn radio-btn-sub">
                <legend for="nikayon-msg">נקיון</legend>
            </span>
            <input type="checkbox" name="ahzaka-msg-load" value="1" id='ahzaka-msg-load'>
            <span class="radio-btn radio-btn-sub">
                <legend for="ahzaka-msg">אחזקה</legend>
            </span>
        </div>
    </section>

    <section id="active-messages">
        <div>
            <div class="box-header pad">


                <button class='save-change-btn' type="submit"></button>



                <div>
                    <input type="checkbox" name="" id="">
                    <span class='in-messages' data-setType='shomrim'>
                        שומרים
                    </span>
                    <input type="checkbox" name="" id="">
                    <span class='in-messages' data-setType='ahzaka'>
                        אחזקה
                    </span>
                    <input type="checkbox" name="" id="">
                    <span class='in-messages' data-setType='nikayon'>
                        ניקיון
                    </span>
                </div>


            </div>
            <div class="message-cont">
                <h4>examle</h4>
                <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Et repudiandae laudantium, velit, debitis
                    totam
                    distinctio quia ab nam consequuntur similique repellat nulla modi repellendus iure officia veniam
                    tempora
                    aliquid quaerat?
                </p>
            </div>
            <div class="box-footer">
                <button>delete</button>
                <button class='exp-date'>

                    exp:
                    <span>
                        11.11.1999
                    </span>
                </button>
                <button>freeze</button>

            </div>
            <div class="status">
                <p>
                    Status:
                </p>
                <p>active</p>
                <p>
                    <input type="checkbox" name="set-new-msg-date" onchange='(function(obj){
                        if(obj.checked==true){
                            obj.nextElementSibling.style.display = "initial";
                        }else{
                            obj.nextElementSibling.style.display = "none";

                        }
                    })(this)'>
                    New exp:
                    <input type="date" name="new-msg-date" id="">
                </p>
            </div>
        </div>

    </section>
</main>
<?php include 'include_updates/msg_setters.php';?>


<?php require $pathContent_global . 'footer.php' ?>

<?php require '../include-inFoo/page-scripts.html'; ?>
<script src="<?php echo $pathScript_inner?>min-date.js"></script>
<script src="<?php echo $pathScript_inner?>MSG_handle_selected_values.js"></script>
<script src="<?php echo $pathScript_inner?>load-msges-ajax.js"></script>

<script src="<?php echo $pathScript_inner?>scroll-arrow.js"></script>

<script>
$(function() {



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

})
//#region load messages to editor

$('#load-page-to-editor').click((e) => {
    e.preventDefault();
    let page = $('input[name=show-to]:checked').val();
    page = page.split('-'), page = page[0] + '-cont';

    console.log(page);

    let msg = '/messages.html';





    $.get("../../mainWebsite/pages/" + page + msg, function(data) {
        $('#richText').val(data).trigger('change');

    });
})
//#endregion
</script>
</body>

</html>