(function($) {

    initiateAfterScript();

})(jQuery);

function initiateAfterScript() {

    $(".contentBodycustomscroll").mCustomScrollbar({

        scrollInertia: 100

    });

    $(".customscrollnormal").mCustomScrollbar({

        scrollInertia: 100

    });

    $(".customscrollmedium").mCustomScrollbar({

        scrollInertia: 100

    });

    customfileinit();

}

$(document).ready(function() {

    $('.navbar-topmenu li a').click(function() {

        $('.selectmenuinfo').hide();

    });

    $('.tab-pane li a').click(function() {

        $('.selectmenuinfo').hide();

    })

    $('#createmenutop').click(function() {

        $('#create-bodycontent').addClass('active');

        if (!($('#create-leftmenu li').hasClass('active'))) {

            $('#create-leftmenu [data-target="#fontstab"]').trigger('click');

        }

    });

    $('#create-leftmenu li > a').click(function() {

        $('#create-bodycontent').addClass('active');


    });

});




function customfileinit() {

    //Reference: 

    //http://www.onextrapixel.com/2012/12/10/how-to-create-a-custom-file-input-with-jquery-css3-and-php/

    ;
    (function($) {



        // Browser supports HTML5 multiple file?

        var multipleSupport = typeof $('<input/>')[0].multiple !== 'undefined',

            isIE = /msie/i.test(navigator.userAgent);



        $.fn.customFile = function() {



            return this.each(function() {



                var $file = $(this).addClass('custom-file-upload-hidden'), // the original file input

                    $wrap = $('<div class="file-upload-wrapper">'),

                    $input = $('<input type="text" class="file-upload-input" placeholder="No file chosen" required />'),

                    $btnlabel = $(this).data('btnlabel'),

                    // Button that will be used in non-IE browsers

                    $button = $('<button type="button" class="file-upload-button">' + $btnlabel + '</button>'),

                    // Hack for IE

                    $label = $('<label class="file-upload-button" for="' + $file[0].id + '">' + $btnlabel + '</label>');



                // Hide by shifting to the left so we

                // can still trigger events

                $file.css({

                    position: 'absolute',

                    left: '-9999px'

                });



                $wrap.insertAfter($file)

                    .append($file, (isIE ? $label : $button), $input);



                // Prevent focus

                $file.attr('tabIndex', -1);

                $button.attr('tabIndex', -1);



                $button.click(function() {

                    $file.focus().click(); // Open dialog

                });



                $file.change(function() {



                    var files = [],
                        fileArr, filename;



                    // If multiple is supported then extract

                    // all filenames from the file array

                    if (multipleSupport) {

                        fileArr = $file[0].files;

                        for (var i = 0, len = fileArr.length; i < len; i++) {

                            files.push(fileArr[i].name);

                        }

                        filename = files.join(', ');



                        // If not supported then just take the value

                        // and remove the path to just show the filename

                    } else {

                        filename = $file.val().split('\\').pop();

                    }



                    $input.val(filename) // Set the value

                        .attr('title', filename) // Show filename in title tootlip

                        .focus(); // Regain focus



                });



                $input.on({

                    blur: function() {
                        $file.trigger('blur');
                    },

                    keydown: function(e) {

                        if (e.which === 13) { // Enter

                            if (!isIE) {
                                $file.trigger('click');
                            }

                        } else if (e.which === 8 || e.which === 46) { // Backspace & Del

                            // On some browsers the value is read-only

                            // with this trick we remove the old input and add

                            // a clean clone with all the original events attached

                            $file.replaceWith($file = $file.clone(true));

                            $file.trigger('change');

                            $input.val('');

                        } else if (e.which === 9) { // TAB

                            return;

                        } else { // All other keys

                            return false;

                        }

                    }

                });



            });



        };



        // Old browser fallback

        if (!multipleSupport) {

            $(document).on('change', 'input.customfile', function() {



                var $this = $(this),

                    // Create a unique ID so we

                    // can attach the label to the input

                    uniqId = 'customfile_' + (new Date()).getTime(),

                    $wrap = $this.parent(),



                    // Filter empty input

                    $inputs = $wrap.siblings().find('.file-upload-input')

                    .filter(function() {
                        return !this.value
                    }),



                    $file = $('<input type="file" id="' + uniqId + '" name="' + $this.attr('name') + '"/>');



                // 1ms timeout so it runs after all other events

                // that modify the value have triggered

                setTimeout(function() {

                    // Add a new input

                    if ($this.val()) {

                        // Check for empty fields to prevent

                        // creating new inputs when changing files

                        if (!$inputs.length) {

                            $wrap.after($file);

                            $file.customFile();

                        }

                        // Remove and reorganize inputs

                    } else {

                        $inputs.parent().remove();

                        // Move the input so it's always last on the list

                        $wrap.appendTo($wrap.parent());

                        $wrap.find('input').focus();

                    }

                }, 1);



            });

        }



    }(jQuery));



    $('input[type=file]').customFile();

}

function deleteresource(id, url, redirecturl) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
    $.ajax({
        type: "DELETE",
        url: url + '/' + id, //resource
        success: function(affectedRows) {
            if (affectedRows > 0) {
                if(redirecturl)
                window.location = redirecturl;
                else
                window.location = url;
            }
        }
    });
}

function searchresource(type) {

    var searchinput = document.getElementById("searchinput").value;

    if (searchinput.trim() == "")
        return false;

    window.location.href = 'search' + type + '/' + searchinput;
}

function updateElements(id, url) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })

    var keywords = document.getElementById('keywords').value;

    var price = 0;
    if (document.getElementById('pricecheckbox').checked)
        price = 1;

    var formData = {
        price: price,
        keywords: keywords
    }

    var type = "PUT"; //for creating new resource
    var myurl = url + "/" + id;

    $.ajax({
        type: type,
        url: myurl,
        data: formData,
        dataType: 'json',
        success: function(affectedRows) {
            window.location = url;
        },
        error: function(data) {
            alert(data)
            console.log('Error:', data);
        }
    });
}

$(document).ready(function() {
    generateKeywordsHTML()
});

function generateKeywordsHTML() {

    if (!document.getElementById('keywords'))
        return false;

    var keywords_section = document.getElementById('keywords_section');
    var keywords = document.getElementById('keywords').value
    keywords = keywords.split(",");;
    keywords_section.innerHTML = "";
    keywords.forEach(function(keyword) {
        if (keyword.trim() != "")
            keywords_section.innerHTML = keywords_section.innerHTML + '<div class="tagsinner"><div class="tags">' + keyword + '<a href="javascript:deleteKeyword(\'' + keyword + '\');" class="tagclose"><span class="icon-close"></span></a></div></div>';
    });
}

$("#newkeyword").keyup(function(event) {
    var keywords = document.getElementById('keywords').value;
    var newkeyword = document.getElementById('newkeyword').value;

    if (event.keyCode == 13 && newkeyword.trim() !== "") {
        keywords += "," + newkeyword;
        document.getElementById('keywords').value = keywords;
        generateKeywordsHTML();
        document.getElementById('newkeyword').value = "";
    }
});

function deleteKeyword(keyword) {
    var keywords = document.getElementById('keywords').value;
    keywords = keywords.replace("," + keyword, "");
    keywords = keywords.replace(keyword + ",", "");
    document.getElementById('keywords').value = keywords;
    generateKeywordsHTML();
}

$(document).ready(function() {
    var tags = [];
    $(".file-upload-wrapper:has(#videos)").css('display', 'block')

    $('#file-input').change(function() {
        $('#previewImage').attr('href')
        readURL(this)
        $('#previewImage').css({
            'display': 'block'
        });
    })

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImage').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
});