var groupselobject;
var SCALE_FACTOR = 1.2;
var savestateaction = true;
var currentcanvasid = 0;
var canvasindex = 0;
var canvasarray = [];
var isdownloadpdf = false;
var issaveaslayout = false;
var isadminlayout = false;
var totalsvgs = 0;
var convertedsvgs = 0;
var activeObjectCopy, activeGroupCopy;
var keystring = "";
var remstring = "";
var isReplaceImage = false;
var issavelayout = false;
var gfcanvas;

function addheadingText(options) {
    var txtBox = new fabric.Textbox("Heading Text", {
        fontFamily: selectedFont,
        fontSize: 36 * 1.3,
        textAlign: "center",
        fill: fillColor,
        scaleX: canvas.canvasScale,
        scaleY: canvas.canvasScale,
        lineHeight: 1,
        width: 400,
    });
    canvas.add(txtBox);
    //setControlsVisibility(txtBox);
    canvas.setActiveObject(txtBox);

    if (options) {
        txtBox.left = options.left - txtBox.width / 2;
        txtBox.top = options.top - txtBox.height / 2;
    } else
        txtBox.center();

    txtBox.globalCompositeOperation = 'source-atop';
    txtBox.setCoords();
    canvas.calcOffset();
    saveState();
    canvas.renderAll();
}

function addsubheadingText(options) {
    var txtBox = new fabric.Textbox("Subheading text", {
        fontFamily: selectedFont,
        fontSize: 24 * 1.3,
        textAlign: "center",
        fill: fillColor,
        scaleX: canvas.canvasScale,
        scaleY: canvas.canvasScale,
        lineHeight: 1,
        width: 350
    });
    txtBox.globalCompositeOperation = 'source-atop';
    canvas.add(txtBox);
    //setControlsVisibility(txtBox);
    canvas.setActiveObject(txtBox);

    if (options) {
        txtBox.left = options.left - txtBox.width / 2;
        txtBox.top = options.top - txtBox.height / 2;
    } else
        txtBox.center();

    txtBox.setCoords();
    canvas.calcOffset();
    saveState();
    canvas.renderAll();
}

function addText(options) {
    var txtBox = new fabric.Textbox("Text element", {
        fontFamily: selectedFont,
        fontSize: 12 * 1.3,
        textAlign: "center",
        fill: fillColor,
        scaleX: canvas.canvasScale,
        scaleY: canvas.canvasScale,
        lineHeight: 1,
        width: 150,
        fontWeight: "normal"
    });
    txtBox.globalCompositeOperation = 'source-atop';
    canvas.add(txtBox);
    //setControlsVisibility(txtBox);
    canvas.setActiveObject(txtBox);

    if (options) {
        txtBox.left = options.left - txtBox.width / 2;
        txtBox.top = options.top - txtBox.height / 2;
    } else
        txtBox.center();

    txtBox.setCoords();
    canvas.calcOffset();
    saveState();
    canvas.renderAll();
}

function addSVGToCanvas(logosvgimg, svgoptions) {
    fabric.loadSVGFromURL(logosvgimg, function(objects, options) {
        var loadedObject = fabric.util.groupSVGElements(objects, options);
        loadedObject.set({
            scaleX: canvas.canvasScale,
            scaleY: canvas.canvasScale
        });
        var objects = loadedObject.getObjects();

        if (svgoptions && svgoptions.grid) {

            var index = 1;
            objects.forEach(function(o) {
                o.index = index++;
            });
            var newgridobj = new fabric.Group(objects, {
                scaleX: loadedObject.scaleX,
                scaleY: loadedObject.scaleY
            });
            newgridobj.globalCompositeOperation = 'source-atop';
            canvas.add(newgridobj);
            newgridobj.scaleToWidth(300);
            newgridobj.grid = svgoptions.grid;
            newgridobj.src = logosvgimg;
            newgridobj.center();
            if (svgoptions) {
                if (svgoptions.left)
                    newgridobj.left = svgoptions.left - (newgridobj.width * newgridobj.scaleX) / 2;
                if (svgoptions.top)
                    newgridobj.top = svgoptions.top - (newgridobj.height * newgridobj.scaleY) / 2;
            }
            newgridobj.setCoords();
            setElementProps(newgridobj)
        } else {

            canvas.add(loadedObject);
            loadedObject.src = logosvgimg;
            loadedObject.globalCompositeOperation = 'source-atop';

            loadedObject.scaleToWidth(300);
            canvas.setActiveObject(loadedObject);
            loadedObject.center();
            if (svgoptions) {
                if (svgoptions.left)
                    loadedObject.left = svgoptions.left - (loadedObject.width * loadedObject.scaleX) / 2;
                if (svgoptions.top)
                    loadedObject.top = svgoptions.top - (loadedObject.height * loadedObject.scaleY) / 2;
            }
            loadedObject.setCoords();
            loadedObject.hasRotatingPoint = true;
            setElementProps(loadedObject)
        }

        saveState();
        canvas.renderAll();

        dragdatasrc = "";
    });
}

function addUploadedSVGToCanvas(svgimg) {
    var svgImgPath = "./uploads/" + svgimg;
    fabric.loadSVGFromURL(svgImgPath, function(objects, options) {
        var loadedObject = fabric.util.groupSVGElements(objects, options);
        loadedObject.set({
            left: 200,
            top: 200,
            scaleX: canvas.canvasScale,
            scaleY: canvas.canvasScale
            //perPixelTargetFind: true,
            //targetFindTolerance: 4 
        });
        loadedObject.src = svgImgPath;
        loadedObject.globalCompositeOperation = 'source-atop';
        canvas.add(loadedObject);
        canvas.setActiveObject(loadedObject);
        loadedObject.center();
        loadedObject.setCoords();
        saveState();
        loadedObject.hasRotatingPoint = true;
        canvas.renderAll();
    });
}

function setControlsVisibility(object) {
    object.setControlsVisibility({
        tl: true, // top left
        tr: true, // top right
        bl: true, // bottom left
        br: true, // bottom right
        mt: true, // middle top disable
        mb: true, // midle bottom disable
        ml: true, // middle left disable
        mr: true, // middle right disable
    });
    object.hasControls = true;
}

function addCanvasToPage(dupflag, pageid, jsonarray) {
    var rows = 1,
        cols = 1;
    $('.deletecanvas').css('display', 'block');
    var rc = parseInt(rows) * parseInt(cols) * parseInt(pageid);
    var dupcount = 0;
    var jsonarrcount = 1;
    for (var i = 1; i <= rows; i++) {
        $("#panelpage" + pageindex).append("<table><tr>");
        for (var j = 1; j <= cols; j++) {
            addNewCanvas();
            if (dupflag) {
                var currentcanvasjson = canvasarray[rc + dupcount].toDatalessJSON();
                canvas.loadFromDatalessJSON(currentcanvasjson);
                canvas.renderAll();
                dupcount++;
            }
        }
        $("#panelpage" + pageindex).append("</tr></table>");
    }
    var dupcanvicon = $("#duplicatecanvas").clone(true).prop('id', 'duplicatecanvas' + pageindex);
    var delcanvicon = $("#deletecanvas").clone(true).prop('id', 'deletecanvas' + pageindex);
    dupcanvicon.appendTo("#panelpage" + pageindex);
    delcanvicon.appendTo("#panelpage" + pageindex);
    adjustIconPos(pageindex);
    $("#addnewpagebutton").show();
}

function resizeDownCanvas(lcanvas) {
    if (Math.round(lcanvas.width) > (window.innerWidth - $(".tabs-left").width() - 200)) {
        zoomOut(lcanvas);
        resizeDownCanvas(lcanvas);
    }
}

function resizeUpCanvas(lcanvas) {
    if (lcanvas.width < (window.innerWidth - $(".tabs-left").width() - 200)) {
        zoomIn(lcanvas);
        resizeUpCanvas(lcanvas);
    }
}

function setCanvasSize() {
    return;
}

function addFileToCanvas(imagefile) {

    var actObj = canvas.getActiveObject();
    if (isReplaceImage && actObj && actObj.type == 'image') {
        //replace image
        var img = new Image();
        img.onload = function() {
            var w = actObj.width;
            var h = actObj.height;
            actObj.setElement(img);
            actObj.setWidth(w);
            actObj.setHeight(h);

            $("#spinnerModal").modal('hide');
            $("#AdduploadimageModal").modal('hide');
        }
        img.src = "./uploads/" + imagefile;
        isReplaceImage = false;
    } else {
        fabric.util.loadImage("./uploads/" + imagefile, function(img) {
            var object = new fabric.Image(img, {
                left: canvas.getWidth() / 2,
                top: canvas.getHeight() / 2,
                scaleX: canvas.canvasScale / 2,
                scaleY: canvas.canvasScale / 2
            });
            object.src = "uploads/" + imagefile;
            object.globalCompositeOperation = 'source-atop';
            canvas.add(object);
            canvas.setActiveObject(object);
            object.center();
            object.setCoords();
            setControlsVisibility(object);
            canvas.setActiveObject(object);

            $("#spinnerModal").modal('hide');
            $("#AdduploadimageModal").modal('hide');

            canvas.renderAll();
            saveState();
        }, {
            crossOrigin: ''
        });
    }
}

function setCanvasSVGBg(bgsrc) {

    //deleteCanvasBg(canvas);

    savestateaction = false;

    if (bgsrc) {

        (function(lcanvas) {

            fabric.loadSVGFromURL(bgsrc, function(objects, options) {
                var loadedObject = fabric.util.groupSVGElements(objects, options);
                loadedObject.src = bgsrc;
                loadedObject.bg = true;
                loadedObject.selectable = false;
                loadedObject.hasRotatingPoint = false;
                lcanvas.add(loadedObject);

                setCanvasWidthHeight(loadedObject.width * 2, loadedObject.height * 2, lcanvas);

                resizeUpCanvas(lcanvas);
                resizeDownCanvas(lcanvas);

                loadedObject.scaleToWidth(lcanvas.width);

                loadedObject.center();
                loadedObject.setCoords();

                lcanvas.renderAll();

                var totalpanels = $("#layoutsrc-container").find('li').length;
                if (totalpanels == canvasarray.length) {
                    $("#spinnerModal").modal('hide');
                }

                savestateaction = true;
                saveState();
            });

        })(canvas);
    }
}

function setCanvasBg(lcanvas, bgsrc, bgcolor, scalex) {

    deleteCanvasBg(lcanvas);

    if (bgcolor) {
        var bg = new fabric.Rect({
            originX: "center",
            originY: "center",
            strokeWidth: 1,
            fill: bgcolor,
            opacity: 1,
            selectable: false,  
            hasBorders: false,
            hasControls: false,
            hasCorners: false,
            lockMovementX: true,
            lockMovementY: true,
            width: lcanvas.getWidth(),
            height: lcanvas.getHeight()
        });
        lcanvas.add(bg);
        bg.globalCompositeOperation = 'source-atop';
        bg.center();
        bg.bg = true;
        bg.selectable = false;
        bringToFront();
        saveState();
    }
    if (bgsrc) {
        var img = new Image();
        img.onload = function() {
            var imgwidth = canvas.width;
            var imgheight = canvas.height;
            for (var left = imgwidth / 2; left < (lcanvas.width + (imgwidth / 2)); left += imgwidth) {
                for (var top = imgheight / 2; top < (lcanvas.height + (imgheight / 2)); top += imgheight) {
                    (function(leftpos, toppos) {
                        fabric.util.loadImage(bgsrc, function(img) {
                            var bg = new fabric.Image(img);
                            bg.set({
                                originX: 'center',
                                originY: 'center',
                                opacity: 1,
                                selectable: false,
                                hasBorders: false,
                                hasControls: false,
                                hasCorners: false,
                                width: imgwidth,
                                height: imgheight,
                                left: leftpos,
                                top: toppos
                            });
                            lcanvas.add(bg);
                            bg.globalCompositeOperation = 'source-atop';
                            bg.bg = true;
                            setElementProps(bg);
                            bringToFront();
                            saveState();
                        });
                    })(left, top);
                }
            }

        };
        img.src = bgsrc;
    }
}

function bringToFront() {

    var objects = canvas.getObjects().filter(function(o) {
        return !o.bg;
    });

    objects.forEach(function(o) {
        canvas.bringToFront(o);
    });
    canvas.renderAll();
}

function deleteCanvasBg(lcanvas) {

    var objects = canvas.getObjects().filter(function(o) {
        return o.bg == true && o.globalCompositeOperation == 'source-atop';
    });

    for (var i = 0; i < objects.length; i++) {
        canvas.remove(objects[i]);
    }
}

function setStyle(object, styleName, value) {
    if (!object) return;
    if (object.styles) {
        var styles = object.styles;
        for (var row in styles) {
            for (var char in styles[row]) {
                if (styleName in styles[row][char]) {
                    delete styles[row][char][styleName];
                }
            }
        }
    }

    object.set(styleName, value).setCoords();
    canvas.renderAll();
    saveState();
}

var fontBoldValue = "normal";
var fontBoldSwitch = document.getElementById('fontbold');
if (fontBoldSwitch) {
    fontBoldSwitch.onclick = function() {
        fontBoldValue = (fontBoldValue == "normal") ? "bold" : "normal";
        var activeObject = canvas.getActiveObject();
        if (activeObject && /text/.test(activeObject.type)) {
            setStyle(activeObject, 'fontWeight', fontBoldValue);
            canvas.renderAll();
        }
    };
}
var fontItalicValue = "normal";
var fontItalicSwitch = document.getElementById('fontitalic');
if (fontItalicSwitch) {
    fontItalicSwitch.onclick = function() {
        fontItalicValue = (fontItalicValue == "normal") ? "italic" : "normal";
        var activeObject = canvas.getActiveObject();
        if (activeObject && /text/.test(activeObject.type)) {
            setStyle(activeObject, 'fontStyle', fontItalicValue);
            canvas.renderAll();
        }
    };
}
var fontUnderlineValue = "normal";
var fontUnderlineSwitch = document.getElementById('fontunderline');
if (fontUnderlineSwitch) {
    fontUnderlineSwitch.onclick = function() {
        fontUnderlineValue = (fontUnderlineValue == "normal") ? "underline" : "normal";
        var activeObject = canvas.getActiveObject();
        if (activeObject && /text/.test(activeObject.type)) {
            setStyle(activeObject, 'textDecoration', fontUnderlineValue);
            canvas.renderAll();
        }
    };
}
var fontSizeSwitch = document.getElementById('fontsize');
if (fontSizeSwitch) {
    fontSizeSwitch.onchange = function() {
        // Fontsize min/max is 6pt/200pt
        if (this.value > 200) this.value = 200;
        if (this.value < 6) this.value = 6;
        var fontsize = Math.round(this.value.toLowerCase() * 1.3);
        var activeObject = canvas.getActiveObject();
        if (activeObject && /text/.test(activeObject.type)) {
            setStyle(activeObject, 'fontSize', fontsize);
            activeobject.setCoords();
            canvas.renderAll();
        }
    };
}

$('.deleteitem').click(function() {
    deleteItem();
});

function deleteItem() {
    var activeObject = canvas.getActiveObject();
    if (!activeObject) activeObject = canvas.getActiveGroup();
    if (!activeObject) return;
    canvas.remove(activeObject);
    canvas.deactivateAllWithDispatch().renderAll();
    saveState();
}
var objectalignleftSwitch = document.getElementById('objectalignleft');
if (objectalignleftSwitch) {
    objectalignleftSwitch.onclick = function() {
        activeObject = canvas.getActiveObject();
        if (activeObject) {
            if (activeObject && /textbox/.test(activeObject.type)) {
                setStyle(activeObject, 'textAlign', "left");
                canvas.renderAll();
            }
        }
    };
}
var objectaligncenterSwitch = document.getElementById('objectaligncenter');
if (objectaligncenterSwitch) {
    objectaligncenterSwitch.onclick = function() {
        activeObject = canvas.getActiveObject();
        if (activeObject) {
            if (activeObject && /textbox/.test(activeObject.type)) {
                setStyle(activeObject, 'textAlign', "center");
                canvas.renderAll();
            }
        }
    };
}
var objectalignrightSwitch = document.getElementById('objectalignright');
if (objectalignrightSwitch) {
    objectalignrightSwitch.onclick = function() {
        activeObject = canvas.getActiveObject();
        if (activeObject) {
            if (activeObject && /textbox/.test(activeObject.type)) {
                setStyle(activeObject, 'textAlign', "right");
                canvas.renderAll();
            }
        }
    };
}

var objectalignjustifySwitch = document.getElementById('objectalignjustify');
if (objectalignjustifySwitch) {
    objectalignjustifySwitch.onclick = function() {
        activeObject = canvas.getActiveObject();
        if (activeObject) {
            if (activeObject && /textbox/.test(activeObject.type)) {
                setStyle(activeObject, 'textAlign', "justify");
                canvas.renderAll();
            }
        }
    };
}

var horizcenterIndentSwitch = document.getElementById('horizcenterindent');
if (horizcenterIndentSwitch) {
    horizcenterIndentSwitch.onclick = function() {
        var activeObject = canvas.getActiveObject();
        var activeGroup = canvas.getActiveGroup();
        if (activeGroup) {
            var objs = activeGroup.getObjects();
            var group = new fabric.Group(objs, {
                originX: 'center',
                originY: 'center',
                top: activeGroup.top
            });
            canvas._activeObject = null;
            canvas.setActiveGroup(group.setCoords()).renderAll();
            var activeGroup = canvas.getActiveGroup();
            canvas.centerObjectH(activeGroup);
            activeGroup.setCoords();
            canvas.renderAll();
            saveState();
        } else if (activeObject) {
            activeObject.centerH();
            activeObject.setCoords();
            canvas.renderAll();
            saveState();
        }
    };
}
var verticenterIndentSwitch = document.getElementById('verticenterindent');
if (verticenterIndentSwitch) {
    verticenterIndentSwitch.onclick = function() {
        var activeObject = canvas.getActiveObject();
        var activeGroup = canvas.getActiveGroup();
        if (activeGroup) {
            var objs = activeGroup.getObjects();
            var group = new fabric.Group(objs, {
                originX: 'center',
                originY: 'center',
                left: activeGroup.left
            });
            canvas._activeObject = null;
            canvas.setActiveGroup(group.setCoords()).renderAll();
            var activeGroup = canvas.getActiveGroup();
            canvas.centerObjectV(activeGroup);
            activeGroup.setCoords();
            canvas.renderAll();
            saveState();
        } else if (activeObject) {
            activeObject.centerV();
            activeObject.setCoords();
            canvas.renderAll();
            saveState();
        }
    };
}
var leftIndentSwitch = document.getElementById('leftindent');
if (leftIndentSwitch) {
    leftIndentSwitch.onclick = function() {
        var activeObject = canvas.getActiveObject();
        var activeGroup = canvas.getActiveGroup();
        if (activeGroup) {
            var objs = activeGroup.getObjects();
            var group = new fabric.Group(objs, {
                originX: 'center',
                originY: 'center',
                top: activeGroup.top
            });
            canvas._activeObject = null;
            canvas.setActiveGroup(group.setCoords()).renderAll();
            var activeGroup = canvas.getActiveGroup();
            canvas.centerObjectH(activeGroup);
            activeGroup.left = activeGroup.width / 2 * activeGroup.scaleX + (12 * canvas.canvasScale);
            activeGroup.setCoords();
            canvas.renderAll();
            saveState();
        } else if (activeObject) {
            activeObject.centerH();
            activeObject.setCoords();
            activeObject.originX = 'left';
            // left/right object align should leave 1mm space to the outer edges of the label
            // 1mm = 6px approx;
            activeObject.left = (12 * canvas.canvasScale);
            activeObject.setCoords();
            canvas.renderAll();
            saveState();
        }
    };
}
var rightIndentSwitch = document.getElementById('rightindent');
if (rightIndentSwitch) {
    rightIndentSwitch.onclick = function() {
        var activeObject = canvas.getActiveObject();
        var activeGroup = canvas.getActiveGroup();
        if (activeGroup) {
            var objs = activeGroup.getObjects();
            var group = new fabric.Group(objs, {
                originX: 'center',
                originY: 'center',
                top: activeGroup.top
            });
            canvas._activeObject = null;
            canvas.setActiveGroup(group.setCoords()).renderAll();
            var activeGroup = canvas.getActiveGroup();
            canvas.centerObjectH(activeGroup);
            activeGroup.left = canvas.width - (activeGroup.width / 2 * activeGroup.scaleX) - (12 * canvas.canvasScale);
            activeGroup.setCoords();
            canvas.renderAll();
            saveState();
        } else if (activeObject) {
            activeObject.centerH();
            activeObject.setCoords();
            activeObject.originX = 'left';
            activeObject.left = canvas.width - (activeObject.width * activeObject.scaleX) - (12 * canvas.canvasScale);
            activeObject.setCoords();
            canvas.renderAll();
            saveState();
        }
    };
}

function resetState() {
    canvas.state = [];
    canvas.index = 0;
}

function saveState() {
    if (savestateaction && canvas.state) {
        var state = canvas.state;
        myjson = JSON.stringify(canvas);
        //console.log("savestate" + state.length + " " + arguments.callee.caller.name);
        state.push(myjson);
        if (state.length >= 60)
            state = state.splice(-5, 5);
        canvas.state = state;
    }
}

var undoSwitch = document.getElementById('undo');
if (undoSwitch) {
    undoSwitch.onclick = function() {
        undo();
        return false;
    };
}

function undo() {

    savestateaction = false;
    var index = canvas.index;
    var state = canvas.state;

    if (index < state.length && state.length - 1 - index + 1 > 1) {

        canvas.clear().renderAll();
        canvas.loadFromJSON(state[state.length - 1 - index - 1], function() {
            canvas.renderAll();
            restorePattern(canvas);
        });
        //console.log("geladen " + (state.length-1-index+1));
        index += 1;
        //console.log("state " + state.length);
        //console.log("index " + index);
        canvas.index = index;
    }

    savestateaction = true;
}

var redoSwitch = document.getElementById('redo');
if (redoSwitch) {
    redoSwitch.onclick = function() {
        redo();
        return false;
    };
}

function redo() {

    var index = canvas.index;
    var state = canvas.state;
    savestateaction = false;
    if (index > 0) {

        canvas.clear().renderAll();
        canvas.loadFromJSON(state[state.length - 1 - index + 1], function() {
            canvas.renderAll();
            restorePattern(canvas);
        });
        index -= 1;
        canvas.index = index;
    }
    savestateaction = true;
    canvas.renderAll();
}

function changeObjectColor(hex) {
    var obj = canvas.getActiveObject();
    if (obj) {
        if (groupselobject) groupselobject.setFill(hex);
        else if (obj.paths) {
            for (var i = 0; i < obj.paths.length; i++) {
                obj.paths[i].setFill(hex);
            }
        } else if (obj.type == "rect" || obj.type == "circle" || obj.type == "triangle" || obj.type == "square") {
            obj.setFill(hex);
            obj.setStroke(hex);
        } else obj.setFill(hex);
    }
    var grpobjs = canvas.getActiveGroup();
    if (grpobjs) {
        grpobjs.forEachObject(function(object) {
            if (object.paths) {
                for (var i = 0; i < object.paths.length; i++) {
                    object.paths[i].setFill(hex);
                }
            } else object.setFill(hex);
        });
    }
    canvas.renderAll();
    saveState();
}

function changeStrokeColor(hex) {
    var obj = canvas.getActiveObject();
    if (obj) {
        if (groupselobject) groupselobject.setStroke(hex);
        else if (obj.paths) {
            for (var i = 0; i < obj.paths.length; i++) {
                obj.paths[i].setStroke(hex);
            }
        } else obj.setStroke(hex);
    }
    var grpobjs = canvas.getActiveGroup();
    if (grpobjs) {
        grpobjs.forEachObject(function(object) {

            if (object.paths) {
                for (var i = 0; i < object.paths.length; i++) {
                    object.paths[i].setStroke(hex);
                }
            } else object.setStroke(hex);
        });
    }
    canvas.renderAll();
    saveState();
}

function setCanvasWidthHeight(width, height, lcanvas) {

    if(!lcanvas) lcanvas = canvas;

    lcanvas.setDimensions({
        width: width,
        height: height
    });
    lcanvas.calcOffset();
    lcanvas.renderAll();
    $("#canvaswidth").val(Math.round(lcanvas.getWidth()));
    $("#canvasheight").val(Math.round(lcanvas.getHeight()));
}

// button Zoom In
$("#btnZoomIn").click(function() {
    zoomIn();
    resetState();
    for (var i = 0; i <= pageindex; i++) {
        adjustIconPos(i);
    }
    initCenteringGuidelines(canvas);
});
// button Zoom Out
$("#btnZoomOut").click(function() {
    zoomOut();
    resetState();
    for (var i = 0; i <= pageindex; i++) {
        adjustIconPos(i);
    }
    initCenteringGuidelines(canvas);
});
// Zoom In
function zoomIn(lcanvas) {

    if(!lcanvas) lcanvas = canvas;

    // Set max zoom at 500%
    if (lcanvas.canvasScale * SCALE_FACTOR > 5) {
        $("#zoomperc").html(Math.round(5 * 100) + '%');
        return;
    }
    lcanvas.deactivateAllWithDispatch().renderAll();
    lcanvas.canvasScale = lcanvas.canvasScale * SCALE_FACTOR;

    setCanvasWidthHeight(lcanvas.getWidth() * SCALE_FACTOR, lcanvas.getHeight() * SCALE_FACTOR, lcanvas);

    var objects = lcanvas.getObjects();
    for (var i in objects) {
        var scaleX = objects[i].scaleX;
        var scaleY = objects[i].scaleY;
        var left = objects[i].left;
        var top = objects[i].top;
        var tempScaleX = scaleX * SCALE_FACTOR;
        var tempScaleY = scaleY * SCALE_FACTOR;
        var tempLeft = left * SCALE_FACTOR;
        var tempTop = top * SCALE_FACTOR;
        objects[i].scaleX = tempScaleX;
        objects[i].scaleY = tempScaleY;
        objects[i].left = tempLeft;
        objects[i].top = tempTop;
        objects[i].setCoords();
    }
    lcanvas.renderAll();

    $("#zoomperc").html(Math.round(lcanvas.canvasScale * 100) + '%');
}
// Zoom Out
function zoomOut(lcanvas) {

    if(!lcanvas) lcanvas = canvas;

    lcanvas.deactivateAllWithDispatch().renderAll();
    lcanvas.canvasScale = lcanvas.canvasScale / SCALE_FACTOR;
    setCanvasWidthHeight(lcanvas.getWidth() * (1 / SCALE_FACTOR), lcanvas.getHeight() * (1 / SCALE_FACTOR), lcanvas);

    var objects = lcanvas.getObjects();
    for (var i in objects) {
        var scaleX = objects[i].scaleX;
        var scaleY = objects[i].scaleY;
        var left = objects[i].left;
        var top = objects[i].top;
        var tempScaleX = scaleX * (1 / SCALE_FACTOR);
        var tempScaleY = scaleY * (1 / SCALE_FACTOR);
        var tempLeft = left * (1 / SCALE_FACTOR);
        var tempTop = top * (1 / SCALE_FACTOR);
        objects[i].scaleX = tempScaleX;
        objects[i].scaleY = tempScaleY;
        objects[i].left = tempLeft;
        objects[i].top = tempTop;
        objects[i].setCoords();
    }
    lcanvas.renderAll();

    $("#zoomperc").html(Math.round(lcanvas.canvasScale * 100) + '%');
}
// Reset Zoom
function resetZoom() {
    resetState();

    setCanvasWidthHeight(canvas.getWidth() * (1 / canvas.canvasScale), canvas.getHeight() * (1 / canvas.canvasScale));

    var objects = canvas.getObjects();
    for (var i in objects) {
        var scaleX = objects[i].scaleX;
        var scaleY = objects[i].scaleY;
        var left = objects[i].left;
        var top = objects[i].top;
        var tempScaleX = scaleX * (1 / canvas.canvasScale);
        var tempScaleY = scaleY * (1 / canvas.canvasScale);
        var tempLeft = left * (1 / canvas.canvasScale);
        var tempTop = top * (1 / canvas.canvasScale);
        objects[i].scaleX = tempScaleX;
        objects[i].scaleY = tempScaleY;
        objects[i].left = tempLeft;
        objects[i].top = tempTop;
        objects[i].setCoords();
    }
    canvas.renderAll();

    canvas.canvasScale = 1;
    $("#zoomperc").html(Math.round(canvas.canvasScale * 100) + '%');
    initCenteringGuidelines(canvas);
}

$("#savelayout").click(function() {
    issaveaslayout = true;
    if (loadeddesignid == 0)
        $('#savelayout_modal').modal('show');
    else {
        //resetZoom();
        canvas.deactivateAllWithDispatch().renderAll();
        $("#spinnerModal").modal('show');
        saveLayout();
    }
});

<!-- Save as Template  form validate -->
$(document).ready(function() {
    $('#savelayoutform').validate({
        rules: {
            layoutname: {
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        submitHandler: function(form) {

            $('#savelayout_modal').modal('hide');
            $("#spinnerModal").modal('show');
            
            proceed_savelayout();
        }
    });
});

function downloadAsJPEG() {
    downloadImage();
}

function downloadAsPDF() {
    $("#spinnerModal").modal('show');
    isdownloadpdf = true;
    //resetZoom();
    downloadPdf();
}

function savetextfromselection() {
    var actobj = canvas.getActiveObject();
    var actgroupobjs = canvas.getActiveGroup();
    if (actobj && actobj.type == 'textbox') {
        var clone = actobj.clone();
        var jsonData = JSON.stringify(clone.toJSON());
        var pngdataURL = clone.toDataURL("image/png");
        //window.open(pngdataURL);
        //console.log(jsonData);
        var path = "uploads/savetext/";
        var filename = $('#textname').val();
        var categoryId = $('#text_category option:selected').val();
        $.ajax({
            type: 'POST',
            url: 'savetext.php',
            data: {
                path: path,
                pngimageData: pngdataURL,
                filename: filename,
                category: categoryId,
                jsonData: jsonData
            },
            success: function(msg) {
                getTexts('');
            }
        })
    } else if (actgroupobjs) {
        var jsonData = "";
        var objects = actgroupobjs.getObjects();
        jsonData += JSON.stringify(actgroupobjs.toJSON());
        var pngdataURL = actgroupobjs.toDataURL("image/png");
        //window.open(pngdataURL);
        //console.log(jsonData);
        var path = "uploads/savetext/";
        var filename = $('#textname').val();
        var categoryId = $('#text_category option:selected').val();
        $.ajax({
            type: 'POST',
            url: 'savetext.php',
            data: {
                path: path,
                pngimageData: pngdataURL,
                filename: filename,
                category: categoryId,
                jsonData: jsonData
            },
            success: function(msg) {
                getTexts('');
            }
        })
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Text object, you wish to save.');
    }
}

function saveelementsfromselection() {
    var actobj = canvas.getActiveObject();
    var actgroupobjs = canvas.getActiveGroup();
    tempcanvas.clear();
    if (actobj) {
        if (fabric.util.getKlass(actobj.type).async) {
            actobj.clone(function(clone) {
                tempcanvas.width = clone.width * clone.scaleX;
                tempcanvas.height = clone.height * clone.scaleY;
                clone.originX = 'center';
                clone.originY = 'center';
                tempcanvas.add(clone);
                clone.center();
                var svgData = tempcanvas.toSVG();
                var jsonData = JSON.stringify(clone.toJSON());
                saveassvg(svgData, jsonData);
            });
        } else {
            var clone = actobj.clone();
            tempcanvas.width = clone.width * clone.scaleX;
            tempcanvas.height = clone.height * clone.scaleY;
            clone.originX = 'center';
            clone.originY = 'center';
            tempcanvas.add(clone);
            clone.center();
            var svgData = tempcanvas.toSVG();
            var jsonData = JSON.stringify(clone.toJSON());
            saveassvg(svgData, jsonData);
        }
    } else if (actgroupobjs) {
        tempcanvas.width = actgroupobjs.width * actgroupobjs.scaleX;
        tempcanvas.height = actgroupobjs.height * actgroupobjs.scaleY;
        var totalobjs = actgroupobjs.getObjects().length;
        var loadedobjs = 0;
        var jsonData = "";
        actgroupobjs.forEachObject(function(object) {
            if (fabric.util.getKlass(object.type).async) {
                object.clone(function(clone) {
                    tempcanvas.add(clone);
                    clone.setLeft(clone.left + tempcanvas.width / 2);
                    clone.setTop(clone.top + tempcanvas.height / 2);
                    loadedobjs++;
                    if (loadedobjs >= totalobjs) {
                        var svgData = tempcanvas.toSVG();
                        var objects = actgroupobjs.getObjects();
                        jsonData += JSON.stringify(actgroupobjs.toJSON());
                        saveassvg(svgData, jsonData);
                    }
                });
            } else {
                var clone = object.clone();
                tempcanvas.add(clone);
                clone.setLeft(clone.left + tempcanvas.width / 2);
                clone.setTop(clone.top + tempcanvas.height / 2);
                loadedobjs++;
                if (loadedobjs >= totalobjs) {
                    var svgData = tempcanvas.toSVG();
                    var objects = actgroupobjs.getObjects();
                    jsonData += JSON.stringify(actgroupobjs.toJSON());
                    saveassvg(svgData, jsonData);
                }
            }
        });
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the object, you wish to save.');
    }
}

function saveassvg(svgData, jsonData) {
    //console.log(jsonData)
    var filename = $('#elmtname').val();
    var categoryId = $('#elmt_category option:selected').val();
    var path = "uploads/";
    //lsvgobj.visible = path + filename + '.svg';
    $.ajax({
        type: 'POST',
        url: 'saveassvg.php',
        data: {
            path: path,
            filename: filename,
            svgData: svgData,
            jsonData: jsonData,
            category: categoryId,
        },
        success: function(msg) {
            getcatimages('');
        }
    })
}

function proceed_savelayout() {
    //resetZoom();
    canvas.deactivateAllWithDispatch().renderAll();
    if (issaveaslayout) saveAsLayout();
    if (issavelayout) saveLayout();
}

function downloadImage() {
    //resetZoom();
    $('#publishModal').modal('hide');
    $("#spinnerModal").modal('show');
    var cols = 1;
    var rows = 1;

    //inch to pixel
    var cwidth = cwidth * 96;
    var cheight = cheight * 96;

    var buffer = document.getElementById("outputcanvas");
    var buffer_context = buffer.getContext("2d");
    buffer.width = parseInt(cwidth) * parseInt(cols);
    var hiddencanvascount = parseInt(cols) * parseInt(rows) * (pageindex + 1) - $(".divcanvas:visible").length;
    buffer.height = parseInt(cheight) * ((parseInt(rows) * (pageindex + 1)) - hiddencanvascount / parseInt(cols));

    var h = 0;
    var writtenpages = 0;
    var processpages = 0;
    var rowcount = 0;
    var colcount = 0;
    for (var i = 0; i < canvasindex; i++) {
        if (!canvasarray[i]) continue;

        hideshowobjects(canvasarray[i], false);

        canvasarray[i].deactivateAll().renderAll();
        if ($("#divcanvas" + i).is(":visible")) {
            processpages++;
            if (colcount >= cols) {
                colcount = 0;
                rowcount++;
            }
            w = cwidth * colcount;
            h = cheight * rowcount;
            colcount++;
            (function(li, c, r) {
                var img = new Image();
                img.onload = function() {
                    buffer_context.drawImage(this, c, r);
                    writtenpages++;
                    if (writtenpages == processpages) {

                        var canvasele = document.getElementById("outputcanvas");
                        var currentTime = new Date();
                        var month = currentTime.getMonth() + 1;
                        var day = currentTime.getDate();
                        var year = currentTime.getFullYear();
                        var hours = currentTime.getHours();
                        var minutes = currentTime.getMinutes();
                        var seconds = currentTime.getSeconds();
                        var filename = month + '' + day + '' + year + '' + hours + '' + minutes + '' + seconds + ".png";

                        // draw to canvas...
                        canvasele.toBlob(function(blob) {
                            saveAs(blob, filename);
                            $('#spinnerModal').modal('hide');
                            hideshowobjects(canvasarray[li], true);
                        });
                    }
                };
                img.src = canvasarray[li].toDataURL("image/png");
            })(i, w, h);
        }
    }
}

function hideshowobjects(lcanvas, showflag) {

    var objs = lcanvas.getObjects().map(function(o) {
        if (!o.selectable && !o.bg && o.type != 'text') {
            o.opacity = showflag;
        }
        return o;
    });

    canvas.renderAll();
}

var savecrop = false;

function downloadPdf() {
    if (totalsvgs == convertedsvgs) {
        isdownloadpdf = false;
        if ($('input#savecrop').is(':checked')) {
            savecrop = true;
        }
        var currentTime = new Date();
        var month = currentTime.getMonth() + 1;
        var day = currentTime.getDate();
        var year = currentTime.getFullYear();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();
        var filename = month + '' + day + '' + year + '' + hours + '' + minutes + '' + seconds;
        filename = filename + ".pdf";
        var jsonCanvasArray = [];
        for (var i = 0; i < canvasindex; i++) {
            if ($("#divcanvas" + i).is(":visible")) {
                hideshowobjects(canvasarray[i], false);
                //jsonCanvasArray.push(canvasarray[i].toDatalessJSON());
                jsonCanvasArray.push(canvasarray[i].toSVG());
            }
        }
        var jsonData = JSON.stringify(jsonCanvasArray);
        //console.log(jsonData);
        var rows = 1;
        var cols = 1;

        //inch to pixel
        var cwidth = cwidth * 96;
        var cheight = cheight * 96;
        var path = "uploads/savelayout/";
        $.ajax({
            type: 'POST',
            url: 'pdf.php',
            data: {
                filename: filename,
                jsonData: jsonData,
                cwidth: cwidth,
                cheight: cheight,
                rows: rows,
                cols: cols,
                savecrop: savecrop
            },
            success: function(msg) {

                //console.log(msg);

                window.location.href = "downloadfile.php?file=" + msg;
                savecrop = false;
                setTimeout(function() {
                    deleteImage(msg);
                }, 8000);
                for (var i = 0; i < canvasindex; i++) {
                    if ($("#divcanvas" + i).is(":visible")) {
                        hideshowobjects(canvasarray[i], true);
                    }
                }
                $("#spinnerModal").modal('hide');
            },
            error: function(err) {
                console.log(err);
            }
        })
    }
}

function deleteImage(file_name) {
    $.ajax({
        type: 'POST',
        url: 'deleteimage.php',
        data: {
            filename: file_name,
        },
        success: function(msg) {}
    });
}
// JavaScript Document
$("#addCategory").click(function() {
    $("#Addcategoryodal").modal('show');
});
$("#addLayoutCategory").click(function() {
    $("#AddLayoutcategoryModal").modal('show');
});
$("#addBGCategory").click(function() {
    $("#AddBGcategoryodal").modal('show');
});
$("#addTextCategory").click(function() {
    $("#AddTextcategoryModal").modal('show');
});
$("#saveText").click(function() {
    $('#savetext_modal').modal('show');
});
$("#saveElement").click(function() {
    $('#saveelement_modal').modal('show');
});
$("#addElement").click(function() {
    $("#AddelementModal").modal('show');
});
$("#addBackground").click(function() {
    $("#AddbackgroundModal").modal('show');
});
$("#upload_image").click(function() {
    $("#AdduploadimageModal").modal('show');
});

$("#replace_image").click(function() {
    isReplaceImage = true;
    $("#AdduploadimageModal").modal('show');
});
$("#cropimage").click(function() {

    var actobj = canvas.getActiveObject();

    if (actobj.type == "image") {
        $("#imagetocrop").attr('src', actobj.orgSrc);
        $('#crop_imagepopup').modal('show');
    }
});

$("#deletetempcat").click(function() {
    var sel_tempcatid = $('#tempcat-select').val();
    if (sel_tempcatid != '') {
        $("#Del_layoutcatmodal").modal('show');
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Category, you wish to delete.');
    }
});
$("#deleteCategory").click(function() {
    var sel_catid = $('#cat-select').val();
    if (sel_catid != '') {
        $("#Del_catmodal").modal('show');
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Category, you wish to delete.');
    }
});
$("#deleteBGCategory").click(function() {
    var sel_bgcatid = $('#bgcat-select').val();
    if (sel_bgcatid != '') {
        $("#Del_bgcatmodal").modal('show');
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Category, you wish to delete.');
    }
});
$("#deletetextcat").click(function() {
    var sel_textcatid = $('#textcat-select').val();
    if (sel_textcatid != '') {
        $("#Del_textcatmodal").modal('show');
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Category, you wish to delete.');
    }
});
$('#deleteEle').click(function() {
    $('#spinnerModal').modal('hide');
    var selectedImg = [];
    $('.catimg-checkbox:checked').each(function() {
        selectedImg.push($(this).val());
    });
    if (selectedImg != '') {
        selectedImg = selectedImg.join(',');
        $.post("actions/deleteElement.php", {
            "elementid": selectedImg
        }, function(data) {
            $('#spinnerModal').modal('hide');
            $('#catimage_container1').empty();
            getcategory();
            getcatimages('');
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
        });
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Element(s), you wish to delete.');
    }
});
$('#deleteText').click(function() {
    $('#spinnerModal').modal('hide');
    var selectedTxt = [];
    $('.textimg-checkbox:checked').each(function() {
        selectedTxt.push($(this).val());
    });
    if (selectedTxt != '') {
        selectedTxt = selectedTxt.join(',');
        $.post("actions/deleteText.php", {
            "textid": selectedTxt
        }, function(data) {
            $('#spinnerModal').modal('hide');
            $('#text_container').empty();
            getTexts();
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
        });
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Text(s), you wish to delete.');
    }
});
$('#deleteBackground').click(function() {
    $('#spinnerModal').modal('hide');
    var selectedImg = [];
    $('.bgimg-checkbox:checked').each(function() {
        selectedImg.push($(this).val());
    });
    if (selectedImg != '') {
        selectedImg = selectedImg.join(',');
        $.post("actions/deleteBackground.php", {
            "bgid": selectedImg
        }, function(data) {
            $('#spinnerModal').modal('hide');
            $('#background_container').empty();
            //IsBgselected = true;
            getBgcategory();
            getbgimages('');
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
        });
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Background(s), you wish to delete.');
    }
});

function proceed_tempDelete() {
    $('#Del_tempModal').modal('hide');
    $('#spinnerModal').modal('show');
    var selectedTemp = tempIdToDel;

    if (selectedTemp != '') {
        $.post("actions/deletelayout.php", {
            "layoutid": selectedTemp
        }, function(data) {
            $('#spinnerModal').modal('hide');
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
            $('#layout_container').empty();
            getLayouts();
        });
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Flyer(s), you wish to delete.');
    }
}
<!-- File Upload --->
function readIMG(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#previewImage').show();
            $('#previewImage').attr('src', e.target.result).width(150).height(150);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
var files;
$('#element_img').on('change', prepareUpload);

function prepareUpload(event) {
    files = event.target.files;
}

function uploadimage() {
    var data = new FormData();
    //adding file content to data
    $.each(files, function(key, value) {
        data.append("element_img", value);
    });
    $.ajax({
        url: 'upload.php?files',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function(data) {
            alert(data)
        }
    });
}
<!-- File Upload --->
function readBGIMG(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#previewBGImage').show();
            $('#previewBGImage').attr('src', e.target.result).width(150).height(150);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
var bgfiles;
$('#bg_img').on('change', prepareBGUpload);

function prepareBGUpload(event) {
    bgfiles = event.target.files;
}

function uploadBgimage() {
    var data = new FormData();
    //adding file content to data
    $.each(bgfiles, function(key, value) {
        data.append("bg_img", value);
    });
    $.ajax({
        url: 'upload.php?files',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function(data) {
            alert(data)
        }
    });
}

function addNewCanvasPage(dupflag, pageid) {
    $("#canvaspages").append("<div class='page' id='panelpage" + pageindex + "'></div>");
    addCanvasToPage(dupflag, pageid);
}

function addNewCanvas() {
    canvas.deactivateAllWithDispatch().renderAll();
    $("#panelpage" + pageindex).append("<td align='center' id='divcanvas" + canvasindex + "' onmousedown='javascript:selectCanvas(this.id);' onClick='javascript:selectCanvas(this.id);' oncontextmenu='javascript:selectCanvas(this.id);' class='divcanvas'><div class='canvascontent' ><canvas id='canvas" + canvasindex + "' class='canvas'></canvas></div></td>");
    canvas = new fabric.Canvas(document.getElementById('canvas' + canvasindex));
    canvas.preserveObjectStacking = true;
    canvas.index = 0;
    canvas.state = [];
    canvas.canvasScale = 1;
    canvas.rotationCursor = 'url("img/rotatecursor2.png") 10 10, crosshair';
    //canvas.backgroundColor = '#ffffff';
    canvas.selectionColor = 'rgba(255,255,255,0.3)';
    canvas.selectionBorderColor = 'rgba(0,0,0,0.1)';
    canvas.hoverCursor = 'pointer';
    canvasarray.push(canvas);

    initCanvasEvents(canvas);
    initAligningGuidelines(canvas);
    initCenteringGuidelines(canvas);
    initKeyboardEvents();

    $("#canvas" + canvasindex).droppable({
        accept: ".catImage, .bgImage, .textImage, .catSVGImage, .gridImage",
        drop: function(event, ui) {

            var dropPositionX = event.pageX - $(this).offset().left;
            var dropPositionY = event.pageY - $(this).offset().top;

            dropDragObject(dropPositionX, dropPositionY);
            dragdatasrc = "";
        }
    });

    if (bgpanel) {

        setCanvasSVGBg(bgpanel);

        /*var center = canvas.getCenter();
        canvas.setOverlayImage('./img/watermark.png', canvas.renderAll.bind(canvas), {
            scaleX: 1,
            scaleY: 1,
            top: center.top,
            left: center.left,
            originX: 'center',
            originY: 'center'
        });     */
    }

    canvas.isTarget = panelisTarget;
    canvas.panelname = panelname;

    canvas.calcOffset();
    canvas.renderAll();
    currentcanvasid = canvasindex;
    canvasindex++;
}

function showPanel(panelid, panelimage, isTarget, lpanelname) {

    $('.panelimg').css({
        'background': ''
    });
    $('#panel' + panelid).css({
        'background': 'lightblue'
    });

    hidePanels();

    //check if panel exists or create new page for the panel

    if ($('#panelpage' + panelid).length) {

        $('#panelpage' + panelid).show("slow");
        $('#panelpage' + panelid).find('.divcanvas').click();
    } else {

        pageindex = panelid;
        bgpanel = panelimage;
        panelisTarget = isTarget;
        panelname = lpanelname
        addNewCanvasPage();
    }
}

function hidePanels() {
    $("div[id^='panelpage']").hide();
}

function dropDragObject(left, top) {
    var options = {};
    options.left = left;
    options.top = top;
    if (dragdataclass.indexOf("textImage") != -1) {
        if (dragdatatexttype == "H1")
            addheadingText(options)
        else if (dragdatatexttype == "H2")
            addsubheadingText(options)
        else if (dragdatatexttype == "H3")
            addText(options);
    } else if (dragdataclass.indexOf("bgImage") != -1) {

        var fileExt = dragdatasrc.split('.').pop();
        if (fileExt == "svg" || fileExt == "SVG") {
            //setCanvasSVGBg(dragdatasrc);
        } else {
            setCanvasBg(canvas, dragdatasrc);
        }
    } else if (dragdataclass.indexOf("catSVGImage") != -1) {

        addSVGToCanvas(dragdatasrc, options);
    } else if (dragdataclass.indexOf("gridImage") != -1) {

        options.grid = true;
        addSVGToCanvas(dragdatasrc, options);
    } else {

        var fileExt = dragdatasrc.split('.').pop();
        if (fileExt == "svg" || fileExt == "SVG") {
            addSVGToCanvas(dragdatasrc, options);
        } else {
            addImage(dragdatasrc, options);
        }
    }
}

function selectCanvas(id) {
    id = id.replace("divcanvas", "");
    if (currentcanvasid == parseInt(id)) return;
    savestateaction = true;
    canvas.deactivateAllWithDispatch().renderAll();
    if (currentcanvasid == parseInt(id)) return;

    currentcanvasid = parseInt(id);
    var tempcanvas = canvasarray[parseInt(id)];
    if (tempcanvas) canvas = tempcanvas;

    var obj = canvas.getActiveObject();
    if (obj)
        canvas.setActiveObject(obj);

    //resetZoom();
    //zommToScale(canvas.canvasScale);

    $("#zoomperc").html(Math.round(canvas.canvasScale * 100) + '%');

    canvas.renderAll();
}

function adjustIconPos(id) {

    return;

    //set duplicate / delete icons left top positions.
    var p = $("#panelpage" + id);
    var position = p.position();
    // .outerWidth() takes into account border and padding.
    var width = p.outerWidth();
    var height = p.outerHeight();
}

$(".deletecanvas").click(function() {
    var id = this.id;
    id = id.replace("deletecanvas", "");
    var pageid = id;
    id = "#panelpage" + id;
    //$(id).detach();
    $(id).hide();
    $("#canvaspages").find(".page").each(function() {
        var nextid = this.id;
        nextid = nextid.replace("page", "");
        adjustIconPos(nextid);
    });
    if ($(".page:visible").length == 1) {
        $('.deletecanvas').css('display', 'none');
    }
});

function openLayout(jsons, isSave, filename) {
    var jsonCanvasArray = JSON.parse(jsons);
    if (!jsonCanvasArray || jsonCanvasArray.length <= 0) return;
    var wh = jsonCanvasArray[0];
    wh = JSON.parse(wh);

    for (var i = 0; i < (jsonCanvasArray.length - 1); i++) {
        $("#canvaspages").append("<div class='page' id='panelpage" + pageindex + "'></div>");
        addCanvasToPage(false, i, jsonCanvasArray);
        setCanvasWidthHeight(wh.width, wh.height);
        canvas.canvasScale = wh.scale;
        $("#zoomperc").html(Math.round(canvas.canvasScale * 100) + '%');
    }
    //setCanvasSize();

    (function(lcanvas, json) {

        lcanvas.clear();

        lcanvas.loadFromJSON(json, function() {

            //first render
            lcanvas.renderAll.bind(lcanvas);

            initCanvasEvents(lcanvas);
            initAligningGuidelines(lcanvas);
            initCenteringGuidelines(lcanvas);

            saveState();

            $("#spinnerModal").modal('hide');
            initKeyboardEvents();
            //setCanvasSize();

            var center = lcanvas.getCenter();

            lcanvas.renderAll();

            restorePattern(lcanvas);
        });

    })(canvas, jsonCanvasArray[1]);

    var js = jsonCanvasArray[1];
    var ffs = getValues(js, 'fontFamily');
    ffs = remove_duplicates(ffs);

    if (ffs && ffs.length == 0) ffs.push('Droid Sans');

    WebFont.load({
        google: {
            families: ffs
        },
        custom: {
            families: ffs
        },
        active: function() {},
        classes: false
    });
}

function saveAsLayout() {

    issaveaslayout = false;

    $("#spinnerModal").modal('show');

    //inch to pixel
    width = canvas.width;
    height = canvas.height;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })

    var formData = "";
    if (isAdmin) {
        formData = {
            name: $('#layoutname').val(),
            product_id: product_id
        }
    } else {
        formData = {
            name: $('#layoutname').val(),
            user_id: user_id,
            product_id: product_id
        }
    }

    var type = "POST"; //for creating new resource
    var my_url = app_base_url + "/createdesign";

    //console.log(formData);

    $.ajax({
        type: type,
        url: my_url,
        data: formData,
        dataType: 'json',
        success: function(data) {

            //console.log(data);
            designid = data.id;
            loadeddesignid = designid;

            for (var i = 0; i < canvasindex; i++) {

                if (!canvasarray[i]) continue;

                (function(index) {

                    canvasarray[index].deactivateAll().renderAll();

                    var type = "POST"; //for creating new resource
                    var my_url = app_base_url + "/layouts";

                    var formData = "";
                    if (isAdmin) {
                        formData = {
                            adminDesign_id: designid
                        }
                    } else {
                        formData = {
                            design_id: designid
                        }
                    }

                    $.ajax({
                        type: type,
                        url: my_url,
                        data: formData,
                        dataType: 'json',
                        success: function(data) {

                            canvasarray[index].layoutid = data.id;

                            updatelayoutjsonimage(canvasarray[index], index);

                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                })(i);
            }

        },
        error: function(data) {
            console.log('Error:', data);
        }
    });
}

function saveLayout() {
    issavelayout = false;

    for (var i = 0; i < canvasindex; i++) {

        if (!canvasarray[i]) continue;

        (function(index) {

            canvasarray[index].deactivateAll().renderAll();

            if (!canvasarray[index].layoutid) {

                var type = "POST"; //for creating new resource
                var my_url = app_base_url + "/layouts";

                var formData = "";
                if (isAdmin) {
                    formData = {
                        adminDesign_id: loadeddesignid
                    }
                } else {
                    formData = {
                        design_id: loadeddesignid
                    }
                }

                $.ajax({
                    type: type,
                    url: my_url,
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        canvasarray[index].layoutid = data.id;

                        updatelayoutjsonimage(canvasarray[index], index);
                    }
                });

            } else
                updatelayoutjsonimage(canvasarray[index], index);

        })(i);
    }
}

function updatelayoutjsonimage(lcanvas, index) {

    $('#spinnerModal').modal('show');
    var jsonCanvasArray = [];
    var wh = '{\"width\": ' + lcanvas.width + ', \"height\": ' + lcanvas.height +  ', \"scale\": ' + lcanvas.canvasScale + '}';
    jsonCanvasArray.push(wh);

    var jpegdataURL = lcanvas.toDataURL({
        format: 'jpeg',
        quality: 1
    });
    var pngdataURL = lcanvas.toDataURL({
        format: 'png',
        quality: 1
    });

    var objs = lcanvas.getObjects().filter(function(o) {
        return o.grid == true;
        to
    });

    objs.forEach(function(o) {

        var inObjs = o.getObjects();
        inObjs.forEach(function(io) {
            if (io.fill.fillsrc) {
                io.origfill = {
                    "fillsrc": io.fill.fillsrc,
                    "imgleft": io.fill.imgleft,
                    "imgtop": io.fill.imgtop,
                    "imgscalex": io.fill.imgscalex,
                    "imgscaley": io.fill.imgscaley
                };
            }
        })
    });

    jsonCanvasArray.push(lcanvas.toDatalessJSON());
    var jsonData = JSON.stringify(jsonCanvasArray);

    var formData = {
        jpegimageData: jpegdataURL,
        pngimageData: pngdataURL,
        jsonData: jsonData,
        isTarget: lcanvas.isTarget,
        name: lcanvas.panelname
    }

    var type = "PUT"; //for creating new resource
    var my_url = app_base_url + "/savelayouts/" + lcanvas.layoutid;

    $.ajax({
        type: type,
        url: my_url,
        data: formData,
        dataType: 'json',
        success: function(data) {

            if (index == canvasarray.length - 1) {
                if (data.design_id)
                    window.location.href = app_base_url + '/editlayouts/products/' + product_id + '/designs/' + data.design_id;
                else
                    window.location.href = app_base_url + '/admineditor/products/' + product_id + '/admindesigns/' + data.adminDesign_id;
            }
        },
        error: function(data) {
            console.log('Error:', data);
        }
    });
}

$(".duplicatecanvas").click(function() {
    var id = this.id;
    id = id.replace("duplicatecanvas", "");
    addNewCanvasPage(true, id);
});

function initKeyboardEvents() {

    $(document).keyup(function(e) {

        switch (e.keyCode) {
            case 17:
                remstring = 'ctrl ';
                break;

            case 67:
                remstring = ' c';
                break;

            case 88:
                remstring = ' x';
                break;

            case 86:
                remstring = ' v';
                break;

            default:
                break;
        }

        if (keystring.indexOf(remstring) != -1)
            keystring = keystring.replace(remstring, '');
    });

    $(document).keydown(function(e) {

        e.stopImmediatePropagation();

        //if (e.target && e.target.nodeName == 'INPUT') return false;

        //console.log(keystring)

        if (e.metaKey === true || e.ctrlKey === true) {
            switch (e.keyCode) {

                case 90: // ctrl + z

                    if (e.shiftKey === true) { //for mac
                        //fire your custom redo logic
                        redo();
                    } else {
                        //fire your custom undo logic
                        undo();
                    }
                    e.preventDefault();
                    break;

                case 89: // ctrl + y
                    redo();
                    e.preventDefault();
                    break;

                default:
                    break;
            }
        }

        var activeobject = canvas.getActiveObject();
        if (!activeobject) activeobject = canvas.getActiveGroup();
        if (!activeobject && !activeObjectCopy && !activeGroupCopy) return;
        if (activeobject && activeobject.isEditing) return;

        switch (e.keyCode) {
            case 8:
                e.preventDefault();
                deleteItem();
                break;
            case 17: //ctrl
                e.preventDefault();
                keystring = 'ctrl';
                break;
            case 91: //cmd
                e.preventDefault();
                keystring = 'cmd';
                break;
            case 173:
            case 109: // -
                e.preventDefault();
                if (e.ctrlKey || e.metaKey) {
                    return objManip('zoomBy-z', -10);
                }
                return true;
            case 61:
            case 107: // +
                if (e.ctrlKey || e.metaKey) {
                    return demo.objManip('zoomBy-z', 10);
                }
                return true;
            case 37: // left
                if (e.shiftKey) {
                    return objManip('zoomBy-x', -1);
                    return false;
                }
                if (e.ctrlKey || e.metaKey) {
                    return objManip('angle', -1);
                }
                return objManip('left', -1);
            case 39: // right
                if (e.shiftKey) {
                    return objManip('zoomBy-x', 1);
                    return false;
                }
                if (e.ctrlKey || e.metaKey) {
                    return objManip('angle', 1);
                }
                return objManip('left', 1);
            case 38: // up
                if (e.shiftKey) {
                    return objManip('zoomBy-y', -1);
                }
                if (!e.ctrlKey && !e.metaKey) {
                    return objManip('top', -1);
                }
                return true;
            case 40: // down
                if (e.shiftKey) {
                    return objManip('zoomBy-y', 1);
                }
                if (!e.ctrlKey && !e.metaKey) {
                    return objManip('top', 1);
                }
                return true;

            case 67: // ctrl + c

                e.preventDefault();
                keystring += ' c';
                if (keystring == "ctrl c" || keystring == "cmd c") {
                    copyobjs();
                }
                break;

            case 88: // ctrl + x
                e.preventDefault();
                keystring += ' x';
                if (keystring == "ctrl x" || keystring == "cmd x") {
                    cutobjs();
                }
                break;

            case 86: // ctrl + v
                e.preventDefault();
                keystring += ' v';
                if (keystring == "ctrl v" || keystring == "cmd v") {
                    pasteobjs();
                }
                break;

            case 83: // ctrl + s
                e.preventDefault();
                keystring += ' s';
                if (keystring == "ctrl s" || keystring == "cmd s") {
                    $("#savelayout").click();
                }
                break;

            case 46:
                e.preventDefault();
                deleteItem();

                break;
            default:
                break;
        }
        canvas.renderAll();
        return true;
    });
}

$("#font-size-dropdown li a").click(function() {
    var selSize = $(this).text();
    var activeObject = canvas.getActiveObject();
    if (activeObject && /textbox/.test(activeObject.type)) {
        selectedFontSize = selSize;
        setStyle(activeObject, 'fontSize', selectedFontSize * 1.3);
        activeObject.setCoords();
        canvas.renderAll();
    }
    $("#fontsizeval").html(selectedFontSize);
});

<!-- Element form validate -->
$(document).ready(function() {
    sortUnorderedList("fonts-dropdown");
    $("#fonts-dropdown li a").click(function() {
        var selText = $(this).text();
        var activeObject = canvas.getActiveObject();
        if (activeObject && /textbox/.test(activeObject.type)) {
            selectedFont = selText;
            setStyle(activeObject, 'fontFamily', selectedFont);
            cutobjs();
            pasteobjs();
            canvas.setActiveObject(activeObject);
            canvas.renderAll();
        }
        $(this).parents('.btn-group').find('.dropdown-toggle').html('<span style="overflow:hidden">' + selText + '&nbsp;&nbsp;<span class="caret"></span></span>');
    });
});

function sortUnorderedList(ul, sortDescending) {
    if (typeof ul == "string") ul = document.getElementById(ul);
    // Idiot-proof, remove if you want
    if (!ul) {
        alert("The UL object is null!");
        return;
    }
    // Get the list items and setup an array for sorting
    var lis = ul.getElementsByTagName("LI");
    var vals = [];
    // Populate the array
    for (var i = 0, l = lis.length; i < l; i++) vals.push(lis[i].innerHTML);
    // Sort it
    vals.sort();
    // Sometimes you gotta DESC
    if (sortDescending) vals.reverse();
    // Change the list on the page
    for (var i = 0, l = lis.length; i < l; i++) lis[i].innerHTML = vals[i];
}

function loadDesign(designid) {

    loadeddesignid = designid;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })

    $("#spinnerModal").modal('show');

    $.ajax({
        url: app_base_url + "/designlayouts/" + designid,
        type: "GET",
        data: {
            designid: designid
        },
        success: function(layouts) {

            pageindex = 0;
            canvasindex = 0;
            canvasarray = [];
            bgpanel = '';

            $("#canvaspages").html('');

            var layoutsindex = 0;
            loadLayout(layouts[layoutsindex].id, layouts[layoutsindex].canvas_json, layouts, layouts[layoutsindex].isTarget, layouts[layoutsindex].name, ++layoutsindex);
        }
    });
}

function loadAdminDesign(designid) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })

    $("#spinnerModal").modal('show');

    $.ajax({
        url: app_base_url + "/admindesignlayouts/" + designid,
        type: "GET",
        data: {
            designid: designid
        },
        success: function(layouts) {

            pageindex = 0;
            canvasindex = 0;
            canvasarray = [];
            bgpanel = '';
            loadeddesignid = 0;

            $("#canvaspages").html('');

            var layoutsindex = 0;
            loadLayout(layouts[layoutsindex].id, layouts[layoutsindex].canvas_json, layouts, layouts[layoutsindex].isTarget, layouts[layoutsindex].name, ++layoutsindex);
        }
    });
}

function loadLayout(layoutid, layoutjsonurl, layouts, isTarget, name, layoutsindex) {

    var layoutloaded = false;

    if (!layoutjsonurl)
        for (var i = 0; i < canvasindex; i++) {
            //console.log(canvasarray[i].layoutid)
            if (canvasarray[i].layoutid == layoutid) {
                hidePanels();
                showPanel(canvasarray[i].pageindex);
                layoutloaded = true;

                canvas.calcOffset();
                canvas.renderAll();
            }
        }

    if (layoutloaded) return;

    $("#spinnerModal").modal('show');

    var jsonFile = new XMLHttpRequest();

    jsonFile.onreadystatechange = function() {

        if (jsonFile.readyState == 4 && jsonFile.status == 200) {
            savestateaction = false;

            openLayout(jsonFile.responseText);

            canvas.layoutid = layoutid;

            canvas.pageindex = pageindex;

            if (isTarget)
                canvas.isTarget = isTarget;
            else
                canvas.isTarget = panelisTarget;

            if (name)
                canvas.panelname = name;
            else
                canvas.panelname = panelname;

            canvas.calcOffset();
            canvas.renderAll();

            savestateaction = true;

            if (layouts && layoutsindex < layouts.length) {
                pageindex++;
                hidePanels();
                loadLayout(layouts[layoutsindex].id, layouts[layoutsindex].canvas_json, layouts, layouts[layoutsindex].isTarget, layouts[layoutsindex].name, ++layoutsindex);
            }

            $("#spinnerModal").modal('hide');
        }
    }
    jsonFile.open("GET", layoutjsonurl + "?v=" + Math.random(), true);
    jsonFile.send();
}

function loadText(textid) {
    $("#spinnerModal").modal('show');
    $.ajax({
        url: "loadtext.php",
        type: "get",
        data: {
            id: parseInt(textid)
        },
        success: function(data) {
            //console.log(data)
            if (data != "empty") {
                var json = JSON.parse(data);
                var objects = json.objects;
                //console.log(objects.length);
                for (var i = 0; i < objects.length; i++) {
                    var object = objects[i];
                    //console.log(object)
                    if (object.type == 'textbox') {
                        var txtBox = new fabric.Textbox(object.text, object);
                        canvas.add(txtBox);
                        setControlsVisibility(txtBox);
                        canvas.setActiveObject(txtBox);
                        txtBox.center();
                        txtBox.setCoords();
                        saveState();
                        canvas.calcOffset();
                        canvas.renderAll();
                    }
                    if (object.type == 'group') {
                        var group = object;
                        var groupleft = group.left;
                        var grouptop = group.top;
                        var grpobjects = group.objects;
                        for (var j = 0; j < grpobjects.length; j++) {
                            var object = grpobjects[j];
                            if (object.type == 'textbox') {
                                var txtBox = new fabric.Textbox(object.text, object);
                                canvas.add(txtBox);
                                txtBox.setLeft(txtBox.left + canvas.width / 2);
                                txtBox.setTop(txtBox.top + canvas.height / 2);
                                txtBox.setCoords();
                            }
                        }
                        canvas.calcOffset();
                        saveState();
                        canvas.renderAll();
                    }
                }
                $("#spinnerModal").modal('hide');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            switch (jqXHR.status) {
                case 400:
                    var excp = $.parseJSON(jqXHR.responseText).error;
                    console.log("UnableToComplyException:" + excp.message, 'warning');
                    break;
                case 500:
                    var excp = $.parseJSON(jqXHR.responseText).error;
                    console.log("PanicException:" + excp.message, 'panic');
                    break;
                default:
                    console.log("HTTP status=" + jqXHR.status + "," + textStatus + "," + errorThrown + "," + jqXHR.responseText);
            }
        }
    });
}

function loadElement(elementid) {
    $("#spinnerModal").modal('show');
    $.ajax({
        url: "loadelement.php",
        type: "get",
        data: {
            id: parseInt(elementid)
        },
        success: function(data) {
            var json = JSON.parse(data);
            fabric.util.enlivenObjects([json], function(objects) {
                var origRenderOnAddRemove = canvas.renderOnAddRemove;
                canvas.renderOnAddRemove = false;
                objects.forEach(function(o) {
                    canvas.add(o);
                    o.setCoords();
                    o.center();
                    var items = o._objects;
                    o._restoreObjectsState();
                    canvas.remove(o);
                    for (var i = 0; i < items.length; i++) {
                        canvas.add(items[i]);
                    }
                });
                canvas.renderOnAddRemove = origRenderOnAddRemove;
                canvas.renderAll();
            });
            $("#spinnerModal").modal('hide');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            switch (jqXHR.status) {
                case 400:
                    var excp = $.parseJSON(jqXHR.responseText).error;
                    console.log("UnableToComplyException:" + excp.message, 'warning');
                    break;
                case 500:
                    var excp = $.parseJSON(jqXHR.responseText).error;
                    console.log("PanicException:" + excp.message, 'panic');
                    break;
                default:
                    console.log("HTTP status=" + jqXHR.status + "," + textStatus + "," + errorThrown + "," + jqXHR.responseText);
            }
        }
    });
}

$('.objectfliphorizontal').click(function() {
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        if (activeObject.flipX) activeObject.flipX = false;
        else activeObject.flipX = true;
        canvas.renderAll();
        saveState();
    }
});

$('.objectflipvertical').click(function() {
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        if (activeObject.flipY) activeObject.flipY = false;
        else activeObject.flipY = true;
        canvas.renderAll();
        saveState();
    }
});

$('.objectlock').click(function() {
    var activeObject = canvas.getActiveObject();
    if (!activeObject) activeObject = canvas.getActiveGroup();
    if (!activeObject) return;
    canvas.deactivateAllWithDispatch().renderAll();
    if (activeObject.type == "group") {
        activeObject.forEachObject(function(object) {
            lockSelObject(object);
        });
    } else {
        lockSelObject(activeObject);
    }
});

function lockSelObject(selObj) {

    if (selObj) {
        if (selObj.lockMovementY) {
            selObj.lockMovementY = selObj.lockMovementX = selObj.lockScalingY = selObj.lockScalingX = false;
            selObj.hasControls = true;
            selObj.hoverCursor = 'pointer';
            selObj.locked = false;
        } else {
            selObj.lockMovementY = selObj.lockMovementX = selObj.lockScalingY = selObj.lockScalingX = true;
            selObj.hasControls = false;
            selObj.hoverCursor = 'url(""http://www.zipoly.com/editor/img/lockcursor.png"") 10 10, pointer';
            selObj.setCoords();
            selObj.locked = true;
            selObj.lockedleft = selObj.left;
            selObj.lockedtop = selObj.top;

            selObj.left = selObj.lockedleft;
            selObj.top = selObj.lockedtop;
            selObj.setCoords();
        }
        canvas.renderAll();
        saveState();
    }
}

//Changes opacity of active object
var ChangeOpacitytx = function() {
    var activeObject = canvas.getActiveObject();
    savestateaction = false;
    $("#txtopacityval").html(changeopacitytxslider.getValue());
    activeObject.setOpacity(changeopacitytxslider.getValue());
    savestateaction = true;
    canvas.renderAll();
};
var ChangeOpacityimg = function() {
    var activeObject = canvas.getActiveObject();
    savestateaction = false;
    $("#imgopacityval").html(changeopacityimgslider.getValue());
    activeObject.setOpacity(changeopacityimgslider.getValue());
    savestateaction = true;
    canvas.renderAll();
};
var ChangeOpacitysvg = function() {
    var activeObject = canvas.getActiveObject();
    savestateaction = false;
    $("#svgopacityval").html(changeopacitysvgslider.getValue());
    activeObject.setOpacity(changeopacitysvgslider.getValue());
    savestateaction = true;
    canvas.renderAll();
};

//Font line height
var ChangeLineHeight = function() {
    var activeObject = canvas.getActiveObject();
    savestateaction = false;    
    $("#lineheightval").html(changelineheightslider.getValue());
    setStyle(activeObject, 'lineHeight', changelineheightslider.getValue());
    savestateaction = true;
    canvas.renderAll();
};

//Font line height
var ChangeCharSacing = function() {
    var activeObject = canvas.getActiveObject();
    savestateaction = false;    
    $("#letterspaceval").html(changecharspacingslider.getValue());
    setStyle(activeObject, 'charSpacing', changecharspacingslider.getValue());
    savestateaction = true;
    canvas.renderAll();
};

var changeopacitytxslider;
var changeopacityimgslider;
var changeopacitysvgslider;
var changelineheightslider;
var bgscaleslider;
var changecharspacingslider;
$(document).ready(function() {

    changeopacitytxslider = new Slider('#changeopacitytx', {
        formatter: function(value) {
            return parseInt(value * 100) + '%'
        }
    });

    changeopacityimgslider = new Slider('#changeopacityimg', {
        formatter: function(value) {
            return parseInt(value * 100) + '%'
        }
    });

    changeopacitysvgslider = new Slider('#changeopacitysvg', {
        formatter: function(value) {
            return parseInt(value * 100) + '%'
        }
    });

    changelineheightslider = new Slider('#changelineheight', {
        formatter: function(value) {
            return parseInt(value * 100) + '%'
        }
    });

    changecharspacingslider = new Slider('#changecharspacing', {
        formatter: function(value) {
            return parseInt(value) + '%'
        }
    });

    changelineheightslider.on('slide', ChangeLineHeight);
    changeopacitytxslider.on('slide', ChangeOpacitytx);
    changeopacityimgslider.on('slide', ChangeOpacityimg);
    changeopacitysvgslider.on('slide', ChangeOpacitysvg);
    changecharspacingslider.on('slide', ChangeCharSacing);

    changecharspacingslider.on('slideStop', saveState);

});

$('.clone').click(function() {
    var activeObject = canvas.getActiveObject();
    if (!activeObject) activeObject = canvas.getActiveGroup();
    if (!activeObject) return;
    cloneSelObject(activeObject);
});

function cloneSelObject(actobj) {
    if (fabric.util.getKlass(actobj.type).async) {
        actobj.clone(function(clone) {
            clone.set({
                left: actobj.getLeft() + 20,
                top: actobj.getTop() + 20
            });
            canvas.add(clone);
        });
    } else {
        canvas.add(actobj.clone().set({
            left: actobj.getLeft() + 20,
            top: actobj.getTop() + 20
        }));
    }
}

$('.sendbackward').click(function() {
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        canvas.sendBackwards(activeObject);
        canvas.renderAll();
        saveState();
        bringToFront();
    }
});

$('.bringforward').click(function() {
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        canvas.bringForward(activeObject);
        canvas.renderAll();
        saveState();
    }
});

function onlyUnique(value, index, self) {
    return self.indexOf(value) === index;
}

function cutobjs() {
    activeObjectCopy = canvas.getActiveObject();
    activeGroupCopy = canvas.getActiveGroup();
    if (activeObjectCopy || activeGroupCopy) {
        var jsonData;
        if (activeGroupCopy) {
            var jsonCanvas = activeGroupCopy.toJSON();
            jsonData = JSON.stringify(jsonCanvas);
        } else if (activeObjectCopy) {
            var jsonCanvas = activeObjectCopy.toJSON();
            jsonData = JSON.stringify(jsonCanvas);
        }
    }
    if (activeGroupCopy) {
        var objectsInGroup = activeGroupCopy.getObjects();
        canvas.discardActiveGroup();
        objectsInGroup.forEach(function(object) {
            canvas.remove(object);
        });
    } else if (activeObjectCopy) {
        canvas.remove(activeObjectCopy);
    }
}

function selectallobjs() {
    var objs = canvas.getObjects().map(function(o) {
        return o.set('active', true);
    });

    var objs = canvas.getObjects().filter(function(o) {
        return o.bg != true;
    });

    var group = new fabric.Group(objs, {
        originX: 'center',
        originY: 'center'
    });
    canvas._activeObject = null;
    canvas.setActiveGroup(group.setCoords()).renderAll();
}

function copyobjs() {
    activeObjectCopy = canvas.getActiveObject();
    activeGroupCopy = canvas.getActiveGroup();
    if (activeObjectCopy || activeGroupCopy) {
        var jsonData;
        if (activeGroupCopy) {
            var jsonCanvas = activeGroupCopy.toJSON();
            jsonData = JSON.stringify(jsonCanvas);
        } else if (activeObjectCopy) {
            var jsonCanvas = activeObjectCopy.toJSON();
            jsonData = JSON.stringify(jsonCanvas);
        }
    }
}

function pasteobjs() {
    if (activeGroupCopy) {
        var objectsInGroup = activeGroupCopy.getObjects();
        canvas.discardActiveGroup();
        objectsInGroup.forEach(function(object) {
            if (fabric.util.getKlass(object.type).async) {
                object.clone(function(clone) {
                    canvas.add(clone);
                });
            } else {
                canvas.add(object.clone());
            }
        });
    } else if (activeObjectCopy) {
        if (fabric.util.getKlass(activeObjectCopy.type).async) {
            activeObjectCopy.clone(function(clone) {
                canvas.add(clone);
            });
        } else {
            canvas.add(activeObjectCopy.clone());
        }
    }
    canvas.renderAll();
}

function toSVG() {
    window.open(
        'data:image/svg+xml;utf8,' +
        encodeURIComponent(canvas.toSVG()));
}

$('#nofill').click(function() {
    var isShapeNoFill = $('#nofill').is(":checked");
    var obj = canvas.getActiveObject();
    if (obj && obj.type == "rect" || obj.type == "circle" || obj.type == "triangle") {
        if (obj && isShapeNoFill == true) {
            obj.prevfill = obj.fill;
            obj.fill = 'Transparent';
            obj.set('onfill', true);
        } else if (obj && isShapeNoFill == false) {
            if (obj.prevfill) {
                obj.setFill(obj.prevfill);
            } else
                obj.set('onfill', false);
        }
        saveState();
    }
    canvas.renderAll();
});
$('#storkewidth').change(function() {
    var strokeWidth = $(this).val();
    var obj = canvas.getActiveObject();
    if (obj) {
        obj.strokeWidth = parseInt(strokeWidth);
        obj.setCoords();
    }
    canvas.calcOffset();
    canvas.renderAll();
});

function addShape(shape) {
    var stroke = $('#strokeline i').css('color');
    var fill = $('#fillshape i').css('color');
    var strokewidth = parseInt($('#storkewidth').val());

    var isShapeNoFill = $('#nofill').is(":checked");

    $('#shapeselectdropdown').val("");

    if (isShapeNoFill)
        fill = 'Transparent';

    if (!fill) fill = 'black';

    if (shape == 'circle') {

        var circle = new fabric.Circle({
            radius: 40,
            originX: "center",
            originY: "center",
            strokeWidth: strokewidth,
            fill: fill,
            stroke: stroke,
            onfill: false
            //opacity: 0.5
        });

        savestateaction = false;
        canvas.add(circle);
        savestateaction = true;
        circle.center();
        circle.setCoords();
        canvas.setActiveObject(circle);
        canvas.renderAll();
    } else if (shape == 'rectangle') {
        var rectangle = new fabric.Rect({

            width: 100,
            height: 60,
            originX: 'left',
            originY: 'top',
            strokeWidth: strokewidth,
            fill: fill,
            stroke: stroke,
            onfill: false
            //opacity: 0.5

        });

        savestateaction = false;
        canvas.add(rectangle);
        savestateaction = true;
        rectangle.center();
        rectangle.setCoords();
        canvas.renderAll();
        canvas.setActiveObject(rectangle);

    } else if (shape == 'square') {
        var square = new fabric.Rect({
            width: 60,
            height: 60,
            originX: 'left',
            originY: 'top',
            strokeWidth: strokewidth,
            fill: fill,
            stroke: stroke,
            onfill: false
            //opacity: 0.5
        });

        savestateaction = false;
        canvas.add(square);
        savestateaction = true;
        square.center();
        square.setCoords();
        canvas.renderAll();
        canvas.setActiveObject(square);

    } else if (shape == 'triangle') {
        var triangle = new fabric.Triangle({
            top: 250,
            left: 300,
            width: 100,
            height: 100,
            strokeWidth: strokewidth,
            fill: fill,
            stroke: stroke,
            onfill: false
            //opacity: 0.5
        });
        savestateaction = false;
        canvas.add(triangle);
        savestateaction = true;
        triangle.center();
        triangle.setCoords();
        canvas.renderAll();
        canvas.setActiveObject(triangle);
    }
}

function changeStorkColor(hex) {
    var obj = canvas.getActiveObject();
    if (obj) {
        obj.setStroke(hex);
        saveState();
    }
    canvas.renderAll();
}

function changefillColor(hex) {
    var obj = canvas.getActiveObject();
    if (!obj) return;
    if (obj.onfill == false) {
        obj.setFill(hex);
    } else if (obj.onfill == true) {
        obj.fill = 'Transparent';
    }
    saveState();
    canvas.renderAll();
}

// function to remove duplicates from the array
function remove_duplicates(arr) {
    var obj = {};
    for (var i = 0; i < arr.length; i++) {
        obj[arr[i]] = true;
    }
    arr = [];
    for (var key in obj) {
        arr.push(key);
    }
    return arr;
}

//return an array of objects according to key, value, or key and value matching
function getObjects(obj, key, val) {
    var objects = [];
    for (var i in obj) {
        if (!obj.hasOwnProperty(i)) continue;
        if (typeof obj[i] == 'object') {
            objects = objects.concat(getObjects(obj[i], key, val));
        } else
            //if key matches and value matches or if key matches and value is not passed (eliminating the case where key matches but passed value does not)
            if (i == key && obj[i] == val || i == key && val == '') { //
                objects.push(obj);
            } else if (obj[i] == val && key == '') {
            //only add if the object is not already in the array
            if (objects.lastIndexOf(obj) == -1) {
                objects.push(obj);
            }
        }
    }
    return objects;
}

//return an array of values that match on a certain key
function getValues(obj, key) {
    var objects = [];
    for (var i in obj) {
        if (!obj.hasOwnProperty(i)) continue;
        if (typeof obj[i] == 'object') {
            objects = objects.concat(getValues(obj[i], key));
        } else if (i == key) {
            objects.push(obj[i]);
        }
    }
    return objects;
}

//return an array of keys that match on a certain value
function getKeys(obj, val) {
    var objects = [];
    for (var i in obj) {
        if (!obj.hasOwnProperty(i)) continue;
        if (typeof obj[i] == 'object') {
            objects = objects.concat(getKeys(obj[i], val));
        } else if (obj[i] == val) {
            objects.push(i);
        }
    }
    return objects;
}

function filepickerimageToCanvas(imgurl) {

    $("#loadingpage").fadeOut("slow");
    fabric.util.loadImage(imgurl, function(img) {
        var object = new fabric.Image(img, {
            left: canvas.getWidth() / 2,
            top: canvas.getHeight() / 2,
            scaleX: canvas.canvasScale / 2,
            scaleY: canvas.canvasScale / 2
        });
        object.src = imgurl;
        canvas.add(object);

        object.scaleToWidth(200);

        object.globalCompositeOperation = 'source-atop';
        canvas.setActiveObject(object);
        object.center();
        object.setCoords();
        setControlsVisibility(object);

        $("#spinnerModal").modal('hide');

        canvas.renderAll();
        saveState();
    }, null, {
        crossOrigin: 'Anonymous'
    });
}

var f = fabric.Image.filters;

function applyFilter(index, filter) {
    var obj = canvas.getActiveObject();
    if (!obj) return;
    obj.filters[index] = filter;
    obj.applyFilters(canvas.renderAll.bind(canvas));
}

function applyFilterValue(index, prop, value) {
    var obj = canvas.getActiveObject();
    if (obj.filters[index]) {
        obj.filters[index][prop] = value;
        obj.applyFilters(canvas.renderAll.bind(canvas));
    }
}

function getFilterValue(prop) {
    var value = 0;
    var obj = canvas.getActiveObject();
    if (obj.type === 'image' && obj.filters.length) {
        for (var j = 0; j < obj.filters.length; j++) {
            var key;

            if (obj.filters[j])
                key = Object.keys(obj.filters[j])[0];

            if (key == prop)
                value = obj.filters[j][key];
        }
    }
    return value;
}

$(document).ready(function() {
    $('#imgbrightness').on("change", function() {
        applyFilterValue(5, 'brightness', parseInt(this.value, 10));
    });
    $('#imgbrightness').on("mousemove", function() {
        $("#imgbrightness-value").html(parseInt(this.value, 10));
    });
    $('#imgcontrast').on("change", function() {
        applyFilterValue(6, 'contrast', parseInt(this.value, 10));
    });
    $('#imgcontrast').on("mousemove", function() {
        $("#imgcontrast-value").html(parseInt(this.value, 10));
    });
    $('#imgsaturate').on("change", function() {
        applyFilterValue(7, 'saturate', parseInt(this.value, 10));
    });
    $('#imgsaturate').on("mousemove", function() {
        $("#imgsaturate-value").html(parseInt(this.value, 10));
    });
});

function initImageFilters() {

    var brightness = getFilterValue("brightness");
    var contrast = getFilterValue("contrast");
    var saturate = getFilterValue("saturate");

    //console.log("brightness: " + brightness);

    $('#imgbrightness').val(brightness);
    $("#imgbrightness-value").html(brightness);

    $('#imgcontrast').val(contrast);
    $("#imgcontrast-value").html(contrast);

    $('#imgsaturate').val(saturate);
    $("#imgsaturate-value").html(saturate);

    var obj = canvas.getActiveObject();
    if (!obj.filterinit) {
        applyFilter(5, new f.Brightness({
            brightness: parseInt($('#imgbrightness').val(), 10)
        }));
        applyFilter(6, new f.Contrast({
            contrast: parseInt($('#imgcontrast').val(), 10)
        }));
        applyFilter(7, new f.Saturate({
            saturate: parseInt($('#imgsaturate').val(), 10)
        }));
        obj.filterinit = true;
    }
}

var gfSelectedObject;
function initgridframecanvas() {

    //grid frame canvas
    gfcanvas = new fabric.Canvas('gridframecanvas', {
        isDrawingMode: false
    });
    gfcanvas.clear();
    gfcanvas.calcOffset();
    gfcanvas.renderAll();
    fabric.Object.prototype.transparentCorners = false;

    gfcanvas.observe('object:modified', function(e) {

        e.target.setCoords();

        if (e.target.mapobject) {

            e.target.mapobject.fill = 'black';

            if (e.target.top >= e.target.mapobject.top)
                e.target.top = e.target.mapobject.top;

            if (e.target.top + e.target.height * e.target.scaleY < e.target.mapobject.top + e.target.mapobject.height * e.target.mapobject.scaleY)
                e.target.top = e.target.mapobject.top - (e.target.height * e.target.scaleY - e.target.mapobject.height * e.target.mapobject.scaleY);

            if (e.target.left >= e.target.mapobject.left)
                e.target.left = e.target.mapobject.left;

            if (e.target.left + e.target.width * e.target.scaleX < e.target.mapobject.left + e.target.mapobject.width * e.target.mapobject.scaleX)
                e.target.left = e.target.mapobject.left - (e.target.width * e.target.scaleX - e.target.mapobject.width * e.target.mapobject.scaleX);
        }

    });

    gfcanvas.observe('object:moving', function(e) {

        e.target.setCoords();

        if (e.target.mapobject) {

            e.target.mapobject.fill = 'black';

            if (e.target.top >= e.target.mapobject.top)
                e.target.top = e.target.mapobject.top;

            if (e.target.top + e.target.height * e.target.scaleY < e.target.mapobject.top + e.target.mapobject.height * e.target.mapobject.scaleY)
                e.target.top = e.target.mapobject.top - (e.target.height * e.target.scaleY - e.target.mapobject.height * e.target.mapobject.scaleY);

            if (e.target.left >= e.target.mapobject.left)
                e.target.left = e.target.mapobject.left;

            if (e.target.left + e.target.width * e.target.scaleX < e.target.mapobject.left + e.target.mapobject.width * e.target.mapobject.scaleX)
                e.target.left = e.target.mapobject.left - (e.target.width * e.target.scaleX - e.target.mapobject.width * e.target.mapobject.scaleX);

        }

    });

    gfcanvas.observe('object:scaling', function(e) {

        e.target.setCoords();

        if (e.target.mapobject) {

            e.target.mapobject.fill = '';

            if (!e.target.oldscaleX)
                e.target.oldscaleX = e.target.scaleX;
            if (!e.target.oldscaleY)
                e.target.oldscaleY = e.target.scaleY;

            if (e.target.getWidth() <= e.target.mapobject.getWidth())
                e.target.scaleX = e.target.oldscaleX;
            else
                e.target.oldscaleX = e.target.scaleX;

            if (e.target.getHeight() <= e.target.mapobject.getHeight())
                e.target.scaleY = e.target.oldscaleY;
            else
                e.target.oldscaleY = e.target.scaleY;

            if (e.target.top >= e.target.mapobject.top)
                e.target.top = e.target.mapobject.top;

            if (e.target.top + e.target.height * e.target.scaleY < e.target.mapobject.top + e.target.mapobject.height * e.target.mapobject.scaleY)
                e.target.top = e.target.mapobject.top - (e.target.height * e.target.scaleY - e.target.mapobject.height * e.target.mapobject.scaleY);

            if (e.target.left >= e.target.mapobject.left)
                e.target.left = e.target.mapobject.left;

            if (e.target.left + e.target.width * e.target.scaleX < e.target.mapobject.left + e.target.mapobject.width * e.target.mapobject.scaleX)
                e.target.left = e.target.mapobject.left - (e.target.width * e.target.scaleX - e.target.mapobject.width * e.target.mapobject.scaleX);

        }
    });

    gfcanvas.observe('mouse:down', function(e) {
        if(e.target) {
            gfSelectedObject = e.target;            
        }
    });

    fabric.util.addListener(gfcanvas.upperCanvasEl, 'dblclick', function(e) {

        var target = gfcanvas.findTarget(e);
        displayGridImage(target);
    });
}

function displayGridImage(target) {
        
    var objects = gfcanvas.getObjects().filter(function(o) {
        return o.mapobject;
    });

    if (objects[0] && objects[0].mapobject) {
        
        var actobj = objects[0];

        var frameobj = actobj.mapobject;

        if (fabric.util.getKlass(actobj.type).async) {

            actobj.clone(function(clone) {

                clone.opacity = 1;

                var patternSourceCanvas = new fabric.StaticCanvas();

                patternSourceCanvas.setDimensions({
                    width: frameobj.getWidth() * 2,
                    height: frameobj.getHeight() * 2
                });

                patternSourceCanvas.add(clone);

                clone.left = actobj.left - frameobj.left;
                clone.top = actobj.top - frameobj.top;

                clone.setCoords();

                var img = new Image();
                img.onload = function() {

                    var pattern = new fabric.Pattern({
                        source: img,
                        repeat: 'no-repeat'
                    });
                    pattern.fillsrc = frameobj.origfill.fillsrc;
                    pattern.imgleft = clone.left;
                    pattern.imgtop = clone.top;
                    pattern.imgscalex = clone.scaleX;
                    pattern.imgscaley = clone.scaleY;

                    frameobj.fill = pattern;
                    frameobj.origfill = pattern;

                    gfcanvas.remove(actobj);

                    gfcanvas.renderAll();

                    saveState();
                }
                img.src = patternSourceCanvas.toDataURL({
                    format: 'jpeg',
                    multiplier: 2,
                    quality: 1
                });
            });
        }
    }

    if (target && target.origfill && target.origfill.fillsrc) {

        var objects = gfcanvas.getObjects().filter(function(o) {
            return o;
        });

        objects.forEach(function(o) {
            //console.log(o.index)
            if (o.origfill && o.origfill.fillsrc !== target.origfill.fillsrc || o.index !== target.index) {
                o.opacity = 0.2;
            } else {
                o.opacity = 1;
                //add image

                var option = {};
                option['fill'] = "black";
                o.set(option);

                fabric.util.loadImage(target.origfill.fillsrc, function(img) {
                    var object = new fabric.Image(img, {
                        left: target.origfill.imgleft + o.left,
                        top: target.origfill.imgtop + o.top,

                        hasRotatingPoint: false,
                        opacity: 0.8
                    });

                    if (!target.origfill.imgscalex) {
                        if (img.width <= img.height)
                            object.scaleToWidth(o.width * o.scaleX);
                        else
                            object.scaleToHeight(o.height * o.scaleY);
                        target.origfill.imgscalex = object.scaleX;
                        target.origfill.imgscaley = object.scaleY;
                    } else {
                        object.scaleX = target.origfill.imgscalex;
                        object.scaleY = target.origfill.imgscaley;
                    }

                    gfcanvas.add(object);
                    object.setCoords();
                    gfcanvas.setActiveObject(object);
                    o.setCoords();
                    object.mapobject = o;

                    gfcanvas.renderAll();
                });
            }
            o.selectable = false;
        });
    }
}

function showPatternToolbar() {

    $(".toolbar-svg").css("visibility", "hidden");
    $(".toolbar-text").css("visibility", "hidden");
    $(".toolbar-image").css("visibility", "hidden");

    $('.toolbar-pattern').css("visibility", "visible");
}

initgridframecanvas();

function addGridToCanvas() {

    var gridobj = canvas.getActiveObject();
    if (gridobj && !gridobj.grid) return;

    gridobj.origopacity = parseFloat(gridobj.opacity);
    gridobj.opacity = 0;
    gridobj.origangle = gridobj.angle;
    gridobj.setAngle(0);
    gridobj.setCoords();

    canvas.renderAll();

    gfcanvas.clear();

    $("#gridsframesdiv").css({
        left: $("#rightsection").offset().left + 2,
        top: $("#rightsection").offset().top + 15
    });
    gfcanvas.calcOffset();
    gfcanvas.renderAll();

    var canvasElement = document.getElementById("gridframecanvas");
    canvasElement.bb = canvasElement.getBoundingClientRect();

    var offsetleft = $("#canvasbox-tab").offset().left - $("#rightsection").offset().left;
    var offsettop = $("#canvasbox-tab").offset().top - $("#rightsection").offset().top;

    fabric.loadSVGFromURL(gridobj.src, function(objects, options) {
        var loadedObject = fabric.util.groupSVGElements(objects, options);
        var objects = loadedObject.getObjects();

        var index = 1;
        var gridobjs = gridobj.getObjects();

        var ooffsetx, ooffsety;
        objects.forEach(function(o) {

            o.perPixelTargetFind = true;
            o.targetFindTolerance = 5;
            o.lockMovementX = true;
            o.lockMovementY = true;

            if (gridobjs[index - 1].origfill)
                o.fill = gridobjs[index - 1].origfill;
            else
                o.fill = gridobjs[index - 1].fill;

            o.origfill = o.fill;

            o.selectable = false;

            console.log(o.bb);

            o.index = index;
            index++;
        });

        var newgridobj = new fabric.Group(objects, {
            scaleX: gridobj.scaleX,
            scaleY: gridobj.scaleY,
            selectable: false
        });
        gfcanvas.add(newgridobj);
        newgridobj.grid = true;
        newgridobj.src = gridobj.src;
        newgridobj.left = gridobj.left + offsetleft;
        newgridobj.top = gridobj.top + offsettop;
        newgridobj.setCoords();

        var items = newgridobj.getObjects();
        newgridobj._restoreObjectsState();
        for(var i = 0; i < items.length; i++) {
          gfcanvas.add(items[i]);
          items[i].setCoords();
          items[i].bb = items[i].getBoundingRect();
        }
        gfcanvas.remove(newgridobj);

        gfcanvas.renderAll();
    });
}

$("#gridframecanvas").droppable({
    accept: ".catImage",
    drop: function(e, ui) {

        var objects = gfcanvas.getObjects().filter(function(o) {
            return o.bb !== "";
        });

        var ispatterapplied = false;
        objects.forEach(function(o) {

            if (objsColliding(mousx, mousy, o.bb) && !ispatterapplied) {
                o.origfill = o.fill;
                setElementProps(o);
            }
        });
        dragdatasrc = "";
    }
});

function objsColliding(x, y, bb) {
    if (bb && x > bb.left && x < (bb.left + bb.width) && y > bb.top && y < (bb.top + bb.height))
        return true;
    else
        return false;
}

var mousx;
var mousy;
var fillpattern;
var framobjs;

function checkcollision(e) {

    if (!dragdatasrc || !gfcanvas) return;

    var canvasElement = document.getElementById("gridframecanvas");
    canvasElement.bb = canvasElement.getBoundingClientRect();

    mousx = e.clientX - canvasElement.bb.left;
    mousy = e.clientY - canvasElement.bb.top;

    var objects = gfcanvas.getObjects().filter(function(o) {
        return o.overlay == true;
    });

    objects.forEach(function(o) {
        gfcanvas.remove(o);
    });

    var objects = gfcanvas.getObjects().filter(function(o) {
        return o.bb !== "";
    });

    var ispatterapplied = false;

    objects.forEach(function(o) {

        if (o.bb && objsColliding(mousx, mousy, o.bb) && !ispatterapplied) {

            if (fillpattern) {
                fillpattern.imgleft = 0;
                fillpattern.imgtop = 0;
                fillpattern.fillsrc = dragdatasrc;
                            
                var option = {};
                option['fill'] = fillpattern;
                o.set(option);

                o.opacity = 1;
                o.setCoords();
            } else {
                fabric.Image.fromURL(dragdatasrc, function(img) {

                    ispatterapplied = true;

                    var patternSourceCanvas = new fabric.StaticCanvas();

                    if (img.width <= img.height)
                    img.scaleToWidth(o.width*o.scaleX);
                    else
                    img.scaleToHeight(o.height*o.scaleY);

                    patternSourceCanvas.setDimensions({
                        width: img.getWidth(),
                        height: img.getHeight()
                    });

                    patternSourceCanvas.add(img);

                    var img = new Image();
                    img.onload = function() {
                        
                        fillpattern = new fabric.Pattern({
                            source: img,
                            repeat: 'no-repeat'
                        });

                        fillpattern.imgleft = 0;
                        fillpattern.imgtop = 0;

                        fillpattern.fillsrc = dragdatasrc;

                        var option = {};
                        option['fill'] = fillpattern;
                        o.set(option);

                        o.opacity = 1;
                    }
                    img.src = patternSourceCanvas.toDataURL({
                        format: 'jpeg',
                        multiplier: 2,
                        quality: 1
                    });
                });
            }
        } else {
                        
            var option = {};
            option['fill'] = o.origfill;
            o.set(option);

            o.opacity = 0.4;
        }
    });
    gfcanvas.renderAll();
}

function restorePattern(lcanvas) {

    var objs = lcanvas.getObjects().filter(function(o) {
        return o.grid == true;
    });

    objs.forEach(function(o) {

        var inObjs = o.getObjects();
        var index = 1;
        inObjs.forEach(function(io) {
            io.index = index++;
            if (io.origfill && io.origfill.fillsrc) {

                $("#spinnerModal").modal('show');

                fabric.Image.fromURL(io.origfill.fillsrc, function(img) {

                    var patternSourceCanvas = new fabric.StaticCanvas();

                    patternSourceCanvas.setDimensions({
                        width: io.getWidth(),
                        height: io.getHeight()
                    });

                    patternSourceCanvas.add(img);

                    img.left = io.origfill.imgleft;
                    img.top = io.origfill.imgtop;
                    img.scaleX = io.origfill.imgscalex;
                    img.scaleY = io.origfill.imgscaley;

                    img.setCoords();

                    var img = new Image();
                    img.onload = function() {

                        var pattern = new fabric.Pattern({
                            source: img,
                            repeat: 'no-repeat'
                        });
                        pattern.fillsrc = io.origfill.fillsrc;
                        pattern.imgleft = io.origfill.imgleft;
                        pattern.imgtop = io.origfill.imgtop;
                        pattern.imgscalex = io.origfill.imgscalex;
                        pattern.imgscaley = io.origfill.imgscaley;

                        io.fill = pattern;
                        io.origfill = pattern;

                        var tscaleX = o.scaleX;
                        o.scaleX = tscaleX - 0.1;
                        o.setCoords();

                        lcanvas.renderAll();

                        o.scaleX = tscaleX;
                        o.setCoords();

                        lcanvas.renderAll();

                        $("#spinnerModal").modal('hide');
                    }
                    img.src = patternSourceCanvas.toDataURL({
                        format: 'jpeg',
                        multiplier: 2,
                        quality: 1
                    });
                });
            }
        });
    });
}

function cropPattern() {
    if(gfSelectedObject) { 
        displayGridImage(gfSelectedObject);
        gfSelectedObject = "";
    }
}

function okPattern() {

    gridobj = canvas.getActiveObject();

    var objs = gridobj.getObjects();

    for (var i = 0; i < objs.length; i++) {

        var gfobjects = gfcanvas.getObjects().filter(function(o) {
            return o.index == i + 1;
        });

        if(gfobjects[0]) {
            objs[i].fill = gfobjects[0].fill;
            objs[i].origfill = gfobjects[0].fill;
            copyElementProps(gfobjects[0], objs[i]);
        }
    }

    var tscaleX = gridobj.scaleX;
    gridobj.scaleX = tscaleX - 0.1;
    gridobj.setCoords();

    canvas.renderAll();

    gridobj.scaleX = tscaleX;
    gridobj.setCoords();

    gridobj.setAngle(gridobj.origangle);
    if(gridobj.origopacity == 0) gridobj.origopacity = 1;
    gridobj.setOpacity(gridobj.origopacity);

    canvas.renderAll();

    var actobj = gfcanvas.getActiveObject();
    if (actobj && actobj.mapobject) {

        var frameobj = actobj.mapobject;

        if (fabric.util.getKlass(actobj.type).async) {

            actobj.clone(function(clone) {

                clone.opacity = 1;

                var patternSourceCanvas = new fabric.StaticCanvas();

                patternSourceCanvas.setDimensions({
                    width: frameobj.getWidth() * 2,
                    height: frameobj.getHeight() * 2
                });

                patternSourceCanvas.add(clone);

                clone.left = actobj.left - frameobj.left;
                clone.top = actobj.top - frameobj.top;

                clone.setCoords();

                var img = new Image();
                img.onload = function() {

                    var pattern = new fabric.Pattern({
                        source: img,
                        repeat: 'no-repeat'
                    });
                    pattern.fillsrc = frameobj.origfill.fillsrc;
                    pattern.imgleft = clone.left;
                    pattern.imgtop = clone.top;
                    pattern.imgscalex = clone.scaleX;
                    pattern.imgscaley = clone.scaleY;

                    for (var i = 0; i < objs.length; i++) {
                        if (objs[i].index == frameobj.index) {
                            objs[i].fill = pattern;
                            objs[i].origfill = pattern;
                            
                            copyElementProps(frameobj, objs[i]);

                            objs[i].setCoords();
                        }
                    }

                    var tscaleX = gridobj.scaleX;
                    gridobj.scaleX = tscaleX - 0.1;
                    gridobj.setCoords();

                    canvas.renderAll();

                    gridobj.scaleX = tscaleX;
                    gridobj.setCoords();

                    canvas.renderAll();

                    gfcanvas.clear();

                    gfcanvas.renderAll();

                    saveState();
                }
                img.src = patternSourceCanvas.toDataURL({
                    format: 'jpeg',
                    multiplier: 2,
                    quality: 1
                });
            });
        }
    } else {
        saveState();
    }
    $("#canvaspages").css("opacity", "1");
    $("#gridsframesdiv").hide();
    $('.toolbar-pattern').css("visibility", "hidden");
    $('.toolbar-svg').css("visibility", "visible");
}

function cancelPattern() {
    var actobj = gfcanvas.getActiveObject();
    $('.toolbar-pattern').css("visibility", "hidden");
    $("#gridsframesdiv").hide();

    if (actobj && actobj.mapobject) {
        actobj.mapobject.fill = actobj.mapobject.origfill;
        gfcanvas.clear();
    }

    $("#canvaspages").css("opacity", "1");

    var actobj = canvas.getActiveObject();
    actobj.setAngle(actobj.origangle);
    if(actobj.origopacity == 0) actobj.origopacity = 1;
    actobj.setOpacity(actobj.origopacity);
    canvas.renderAll();
    $('.toolbar-svg').css("visibility", "visible");
}

function showGridFrameCanvas() {

    var actObj = canvas.getActiveObject();
    if(actObj && actObj.grid) {
        dragdatasrc = "";
        gfSelectedObject = "";
        addGridToCanvas();
        $("#canvaspages").css("opacity", "0.3");
        $("#gridsframesdiv").show();
        showPatternToolbar();
    }
}

function rgbToCmyk(r, g, b) {

    var result = new CMYK(0, 0, 0, 0);

    r = r / 255;
    g = g / 255;
    b = b / 255;

    result.k = Math.min(1 - r, 1 - g, 1 - b);
    result.c = (1 - r - result.k) / (1 - result.k);
    result.m = (1 - g - result.k) / (1 - result.k);
    result.y = (1 - b - result.k) / (1 - result.k);

    result.c = Math.round(result.c * 100);
    result.m = Math.round(result.m * 100);
    result.y = Math.round(result.y * 100);
    result.k = Math.round(result.k * 100);

    return result;
}

//source: https://gist.github.com/felipesabino/5066336
function CMYK(c, m, y, k) {
    if (c <= 0) {
        c = 0;
    }
    if (m <= 0) {
        m = 0;
    }
    if (y <= 0) {
        y = 0;
    }
    if (k <= 0) {
        k = 0;
    }

    if (c > 100) {
        c = 100;
    }
    if (m > 100) {
        m = 100;
    }
    if (y > 100) {
        y = 100;
    }
    if (k > 100) {
        k = 100;
    }

    this.c = c;
    this.m = m;
    this.y = y;
    this.k = k;
}

function rgbToHex(r, g, b) {
    return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
}

function hexToRgb(hex){
    hex = hex.replace('#','');
    r = parseInt(hex.substring(0,2), 16);
    g = parseInt(hex.substring(2,4), 16);
    b = parseInt(hex.substring(4,6), 16);
    result = 'rgb('+r+','+g+','+b+')';
    return result;
}

function showElementDetails(id, type, single, multiple, rights, keywordsJSON) {

    $("#elementdetails").show();

    $("#iddet").html(id);

    $("#typedet").html(type);

    elementPrice = 0;
    elementLicense = "Free";

    if(elementPrice < single) {
      elementPrice = single;
      elementLicense = "Single";
    }
    if(elementPrice < multiple) {
      elementPrice = multiple;
      elementLicense = "Multiple";
    }
    if(elementPrice < rights) {
      elementPrice = rights;
      elementLicense = "Rights";
    }

    if(elementPrice == 0)
        $("#freepricedet").html('Free');
    else {

        $("#singlepricedet").html("Single : $" + single + " USD");
        $("#multiplepricedet").html("Multiple : $" + multiple + " USD");
        $("#rightspricedet").html("Rights : $" + rights + " USD");
    }

    var keywordsarr = JSON.parse(keywordsJSON);
    var keywords = "";
    $.each(keywordsarr, function(k, v) {
        if(keywords != "") {
            keywords += " ,"
        }
        keywords += v.name;
    });
    $("#keywordsdet").html(keywords);
}

function hideElementDetails() {
    $("#elementdetails").hide();
}

function showBGElementDetails(id, type, single, multiple, rights, keywordsJSON) {

    $("#bgelementdetails").show();

    $("#bgiddet").html(id);

    $("#bgtypedet").html(type);

    elementPrice = 0;
    elementLicense = "Free";

    if(elementPrice < single) {
      elementPrice = single;
      elementLicense = "Single";
    }
    if(elementPrice < multiple) {
      elementPrice = multiple;
      elementLicense = "Multiple";
    }
    if(elementPrice < rights) {
      elementPrice = rights;
      elementLicense = "Rights";
    }

    if(elementPrice == 0)
        $("#bgsinglepricedet").html('Free');
    else {

        $("#bgsinglepricedet").html("Single : $" + single + " USD");
        $("#bgmultiplepricedet").html("Multiple : $" + multiple + " USD");
        $("#bgrightspricedet").html("Rights : $" + rights + " USD");
    }

    var keywordsarr = JSON.parse(keywordsJSON);
    var keywords = "";
    $.each(keywordsarr, function(k, v) {
        if(keywords != "") {
            keywords += " ,"
        }
        keywords += v.name;
    });
    $("#bgkeywordsdet").html(keywords);
}

function hideBGElementDetails() {

    $("#bgelementdetails").hide();    
}