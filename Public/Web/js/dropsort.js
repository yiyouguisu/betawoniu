function getObjectIndex(a, b) {
    for (var i in b) {
        if (b[i] == a) {
            return i;
        }
    }
    return -1;
}

var dot = function (x, y) {
    var x = x;
    var y = y;
}
var edge = function (w, h) {
    var w = w;
    var h = h;
}
var visualrect = function (point, rect) {
    var point = point;//new dot();
    var rect = rect;//new edge();
}

function checkpoint(dot, visualrect) {

    if (dot.x > visualrect.point.x && dot.y > visualrect.point.y) {
        //通过左上点检测
        if (dot.x < visualrect.point.x + visualrect.rect.w && dot.y < visualrect.point.y + visualrect.rect.h) {
            //通过范围检测
            return true;
        }
    }
    return false;
}


function SwapPosition($a, $b) {

    var dragMovetop = parseInt($a.css("top"));
    var dragOldtop = $a.offset().top - dragMovetop;
    var positionY = dragMovetop - ($b.offset().top - dragOldtop);

    var $dragClone = $a.clone();
    $dragClone.css("display", "none");
    $a.after($dragClone);

    $b.after($a);
    $a.css("top", positionY)
    $a.resetanimate();

    $dragClone.after($b);
    $b.css("top", dragMovetop)
    $b.resetanimate();

    $dragClone.remove();
}

function drag(element) {
    var $element = $(element);
    var hammer = new Hammer(element);//hammer

    hammer.on('panstart', function (event) {
        //$element.css("position", "relative");
    });
    hammer.on('panmove', function (event) {
        $element.css("top", event.deltaY);
        $element.css("left", event.deltaX);
    });
    hammer.on('panend', function (event) {
        var $siblings = $element.siblings();
        $siblings.each(function (index) {
            var $sib = $($siblings[index]);
            var top = $sib.offset().top;
            var left = $sib.offset().left;
            var height = $sib[0].clientHeight;
            var width = $sib[0].clientWidth;

            var isHover = checkpoint(
                {
                    x: event.center.x,
                    y: event.center.y
                },
                {
                    point: { x: left, y: top },
                    rect: { w: width, h: height }
                }
            );

            if (isHover) {
                SwapPosition($element, $sib);
            } else {
                $element.resetanimate();
            }
        });
    });
}

~function ($) {

    $.fn.hammerdrag = function () {
        for (var i in this) {
            try {
                drag(this[i]);
            } catch (e) {
                break;
            }
        }
    }
    

    //放置换位
    $.fn.dropsort = function () {
        //1
        
        this.draggable({
            opacity: 0.1,
            revert: "invalid",
        });
        

        //2
        this.droppable({//接收
            tolerance: "pointer",//接收对象如何感应鼠标
            accept: this,
            drop: function (event, ui) {
                //var e = event || window.event;
                //var mouseY = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;//鼠标当前的Y轴位置

                if ($(this).parent()[0] != ui.draggable.parent()[0]) {

                    ui.draggable.resetanimate();

                } else {

                    SwapPosition(ui.draggable, $(this));

                }
                
            }
        });

        
    }

    $.fn.resetanimate = function () {
        this.animate({//还原位置动画
            "left": 0,
            "top": 0
        });
    }



    //未使用
    $.fn.drag = function () {

        return;//拖动排序，存在bug

        var visualObject;
        var firstTimeDirectionIsDown;
        var thisTimeDirectionIsDown;
        var firstTimeIndex;
        var lastTimeIndex;
        var overCount;

        this.draggable({
            opacity: 0.1,
            revert: "invalid",
            appendTo: "body",
            helper: function () {
                return visualObject = $(this).clone().css({
                    height: $(this).height(),
                    width: $(this).width()
                });
            },
            start: function (event, ui) {
                var $this = $(this);
                $this.css("opacity", 0.1);
                var $family = $this.parent().children();
                firstTimeIndex = getObjectIndex($this[0], $family);
                overCount = 0;
            },
            stop: function (event, ui) {
                $(this).animate({ opacity: 1 });
            }
        });//可以拖动

        this.droppable({//接收
            tolerance: "pointer",//接收对象如何感应鼠标
            accept: this,
            over: function (event, ui) {
                overCount++;

                var $this = $(this);
                var $drag = ui.draggable;

                if ($this.parent()[0] == $drag.parent()[0]) {
                    var $family = $this.parent().children();


                    var thisIndex = getObjectIndex($this[0], $family);
                    var dragIndex = getObjectIndex($drag[0], $family);

                    if (overCount == 1) {
                        firstTimeDirectionIsDown = thisIndex > firstTimeIndex;
                    } else {
                        thisTimeDirectionIsDown = thisIndex > lastTimeIndex;

                        if (firstTimeDirectionIsDown) {
                            if (!thisTimeDirectionIsDown) {//该次向上
                                thisIndex++;
                                $this = $this.next();
                            }
                        }
                    }


                    if (thisIndex > dragIndex) {
                        $this.after($drag);
                    } else if (thisIndex < dragIndex) {
                        $this.before($drag);
                    }
                    //$this.find("> .trip_h2")[0].innerText += ",1"
                    lastTimeIndex = thisIndex;
                }
            }
        });
    };
}($)


