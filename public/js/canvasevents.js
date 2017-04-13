function initCanvasEvents(lcanvas) {

    if (lcanvas.initated) return;
    lcanvas.initated = true;

    var selectedObject;
    lcanvas.observe('object:selected', function(e) {

        selectedObject = e.target;

        $(".toolbar-svg").css("visibility", "hidden");
        $(".toolbar-text").css("visibility", "hidden");
        $(".toolbar-image").css("visibility", "hidden");

        var objectopacity = selectedObject.getOpacity();

        if (selectedObject.type == "textbox" || selectedObject.type == "text") {
            $(".toolbar-text").css("visibility", "visible");
            $('#textbgcolor i').css('backgroundColor', selectedObject.fill);
            $("#fontsizeval").html((e.target.fontSize / 1.3).toFixed(0));

            changeopacitytxslider.setValue(objectopacity);
            var lineheight = selectedObject.getLineHeight();
            changelineheightslider.setValue(lineheight);
            var charspacing = selectedObject.charSpacing;
            changecharspacingslider.setValue(charspacing);

            $("#txtopacityval").html(changeopacitytxslider.getValue());
            $("#lineheightval").html(changelineheightslider.getValue());
            $("#letterspaceval").html(changecharspacingslider.getValue());
        }

        if (selectedObject.type == "path-group" || selectedObject.type == "group") {
            $(".toolbar-svg").css("visibility", "visible");
            changeopacitysvgslider.setValue(objectopacity);
            $("#svgopacityval").html(changeopacitysvgslider.getValue());
        }

        if (selectedObject.type == 'image') {
            $(".toolbar-image").css("visibility", "visible");
            changeopacityimgslider.setValue(objectopacity);
            $("#imgopacityval").html(changeopacityimgslider.getValue());
        }

        $("#editgridframeicon").show();

        $("#dynamiccolorpickers").html('');
        if (selectedObject.type == 'path-group') {
            var colorarray = [];
            var objects = selectedObject.getObjects();
            for (var i = 0; i < objects.length; i++) {
                var colorString = objects[i].fill;
                if (colorString && (typeof colorString === 'string')) {
                    var rgb = colorString.substring(colorString.indexOf('(') + 1, colorString.lastIndexOf(')')).split(/,\s*/);
                    if (rgb && rgb != "") {
                        var red = parseInt(rgb[0]);
                        var green = parseInt(rgb[1]);
                        var blue = parseInt(rgb[2]);
                        hexCode = rgbToHex(red, green, blue);
                        objects[i].fill = hexCode;
                        colorarray.push(hexCode);
                    } else
                        colorarray.push(objects[i].fill);
                }
            }
            colorarray = colorarray.filter(onlyUnique); // returns ['a', 1, 2, '1']
            //console.log(colorarray);
            $("#colorSelector").hide();
            $("#editgridframeicon").hide();
            
            var colorpickerhtml = "";
            for (var i = 0; i < colorarray.length; i++) {
                //console.log(colorarray[i]);
                colorpickerhtml += '<button class="btn dynamiccolorpicker" value="' + colorarray[i] + '" title="SVG Color" class="btn" style="padding: 0;background-color: transparent;"><i class="fa fa-circle-up" style="border: 1px solid rgb(204, 204, 204); height: 1.5em; border-radius: 3px; width: 1.5em;background-color: ' + colorarray[i] + ';"></i></button>';
            }
            colorpickerhtml += '<input type="hidden" id="dynamiccolorpicker-input" value="#abc123"/>';
            $("#dynamiccolorpickers").html(colorpickerhtml + '<span class="single-brd"></span>');
            var objinitcolor = "";
            var selectedclrbutton;
            var svgColorDiaHidden =  $('#dynamiccolorpicker-input').colorpicker({
                parts: ['cmyk', 'swatches'],
                alpha: true,
                inline: false,
                layout: {
                    preview: [0, 0, 0, 1]
                },
                position: {
                    my: 'top+6%',
                    at: 'left+100',
                    of: '#dynamiccolorpickers'
                },        
                open: function(event, color) {
                    
                    isSvgClPickrOpen = true;

                    var v = $(selectedclrbutton).find('i').css("background-color");

                    var rgb = v.replace(/^rgba?\(|\s+|\)$/g,'').split(',');

                    var cmyk = rgbToCmyk(rgb[0],rgb[1],rgb[2])

                    color.colorPicker.color.setCMYK(cmyk.c / 100.0, cmyk.m / 100.0, cmyk.y / 100.0, cmyk.k / 100.0);

                    var i = 0;
                    $('.ui-colorpicker-swatch').each(function(){   
                        if($(this).css('background-color') == v) {         
                            //console.log($(this).css('background-color'), v, i)          
                            if(i == 1) {
                              $('.ui-colorpicker-swatches:eq(1)').animate({scrollTop: $(this).offset().top -  $('.ui-colorpicker-swatches:eq(1)').offset().top },'slow');
                            }
                            i++;
                        }
                    });
                },        
                close: function() {                    
                    isSvgClPickrOpen = false;
                },
                select: function(event, color) {
                    var newcolorVal = ('#' + color.formatted);
                    var objects = selectedObject.getObjects();
                    for (var i = 0; i < objects.length; i++) {
                        if (objects[i].fill && objinitcolor.toLowerCase() == objects[i].fill.toString().toLowerCase()) {

                            var option = {};
                            option['fill'] = newcolorVal;
                            option['stroke'] = newcolorVal;
                            objects[i].set(option);
                        }
                    }

                    var option = {};
                    option['fill'] = newcolorVal;
                    option['stroke'] = newcolorVal;
                    selectedObject.set(option);
                    objinitcolor = newcolorVal;

                    $(selectedclrbutton).find('i').css("background-color", newcolorVal);
                    $(selectedclrbutton).val(objinitcolor);

                    lcanvas.renderAll();
                    saveState();
                    svgColorDiaHidden.colorpicker('close');
                }
            });
            $('.dynamiccolorpicker').click(function(event) {
                svgColorDiaHidden.colorpicker('close');
                objinitcolor = $(this).val();
                selectedclrbutton = this;

                setTimeout(function() {
                    svgColorDiaHidden.colorpicker('open');
                }, 300);
            });

            var isSvgClPickrOpen = false;
            $( window ).scroll(function() {

                if(isSvgClPickrOpen)
                svgColorDiaHidden.colorpicker('close');

                if(isSvgClPickrOpen) {
                    setTimeout(function() {
                        svgColorDiaHidden.colorpicker('open');
                    }, 300);
                }
            });
        }
    });

    lcanvas.observe('selection:cleared', function(e) {

        $(".toolbar-svg").css("visibility", "hidden");
        $(".toolbar-text").css("visibility", "hidden");
        $(".toolbar-image").css("visibility", "hidden");

        groupselobject = '';
        $(".custom-menu").hide();
    });

    lcanvas.observe('object:moving', function(e) {

        if (e.target && e.target.locked) {
            e.target.left = e.target.lockedleft;
            e.target.top = e.target.lockedtop;
        }

        e.target.setCoords();

        e.target.modified = true;
    });

    lcanvas.observe('object:rotating', function(e) {
        e.target.setCoords();
        e.target.modified = true;
    });

    lcanvas.observe('object:scaling', function(e) {
        if (selectedObject.type == "textbox" || selectedObject.type == "text") {
            if (e.target) {
                $("#fontsizeval").html(((e.target.fontSize * e.target.scaleX) / 2).toFixed(0));
            }
        }
        e.target.setCoords();
        e.target.modified = true;
    });

    lcanvas.observe('object:modified', function(e) {

        console.log(e.target.type);

        if (e.target && e.target.locked) {
            e.target.left = e.target.lockedleft;
            e.target.top = e.target.lockedtop;
        }

        e.target.setCoords();

        if (e.target.modified) {
            saveState();
            e.target.modified = false;
        }
    });

    lcanvas.observe('text:editing:exited', function(e) {
        if (e.target.modified) {
            saveState();
            e.target.modified = false;
        }
    });

    lcanvas.observe('text:changed', function(e) {
        e.target.modified = true;
    });

    fabric.util.addListener(lcanvas.upperCanvasEl, 'dblclick', function(e) {
        var target = lcanvas.findTarget(e);

        console.log(target.grid)

        if (target.grid) {
            showGridFrameCanvas();
        }
    });
}