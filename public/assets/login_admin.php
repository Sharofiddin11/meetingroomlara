<html>
    <head>
        <meta charset="UTF-8">
        <title>Meeting Room Booking</title>

    	<link type="text/css" rel="stylesheet" href="media/layout.css" />


	    <script src="js/jquery/jquery-1.9.1.min.js" type="text/javascript"></script>


        <script src="js/daypilot/daypilot-all.min.js" type="text/javascript"></script>

        <link type="text/css" rel="stylesheet" href="icons/style.css" />

        <style type="text/css">
            body, input, button, select {
                font-size: 14px;
            }
            
            select {
                padding: 5px;
            }
            
            .toolbar {
                margin: 10px 0px;
            }
            
            .toolbar button {
                padding: 5px 15px;
            }
            
            .icon {
                font-size: 14px;
                text-align: center;
                line-height: 14px;
                vertical-align: middle;

                cursor: pointer;
            }
            
            .toolbar-separator {
                width: 1px;
                height: 28px;
                /*content: '&nbsp;';*/
                display: inline-block;
                box-sizing: border-box;
                background-color: #ccc;
                margin-bottom: -8px;
                margin-left: 15px;
                margin-right: 15px;
            }

			.scheduler_default_corner div:nth-of-type(4) {
				display: none !important;
			}
            .scheduler_default_rowheader_inner
            {
                border-right: 1px solid #ccc;
            }
            .scheduler_default_rowheadercol2
            {
                background: White;
            }
            .scheduler_default_rowheadercol2 .scheduler_default_rowheader_inner
            {
                top: 2px;
                bottom: 2px;
                left: 2px;
                background-color: transparent;
                border-left: 5px solid #38761d; /* green */
                border-right: 0px none;
            }
            .status_dirty.scheduler_default_rowheadercol2 .scheduler_default_rowheader_inner
            {
                border-left: 5px solid #cc0000; /* red */
            }
            .status_cleanup.scheduler_default_rowheadercol2 .scheduler_default_rowheader_inner
            {
                border-left: 5px solid #e69138; /* orange */
            }

        </style>

    </head>
    <body>
	
			<div id="header">
                <div class="bg-help">
                    <div class="inBox">
                        <h1 id="logo">Проект бронирование митинг рум (JavaScript/PHP)</h1>
                        <hr class="hidden" />
                    </div>
                </div>
            </div>
					
					
            <div class="shadow"></div>
            <div class="hideSkipLink">
            </div>
            <div class="main">

                <div style="display: none;">
                    <div id="nav"></div>
                </div>

                <div style="margin-left: 20px;">

                    <div class="toolbar">
                        <button id="add-room">Добавить комнат</button>
                        
                    </div>
                     <div style = "position: absolute; left: 190vh; top: 80px;" >

				
					</div>
                    <div id="dp"></div>

                </div>
                <script type="text/javascript">

                    var nav = new DayPilot.Navigator("nav");
                    nav.selectMode = "month";
                    nav.showMonths = 3;
                    nav.skipMonths = 3;
                    nav.onTimeRangeSelected = function(args) {
                        loadTimeline(args.start);
                        loadEvents();
                    };
                    nav.init();
//

                    $("#autocellwidth").click(function() {
                        dp.cellWidth = 60;
                        dp.cellWidthSpec = $(this).is(":checked") ? "Auto" : "Fixed";
                        dp.update();
                    });

                    $("#add-room").click(function(ev) {
                        ev.preventDefault();
                        var modal = new DayPilot.Modal();
                        modal.onClosed = function(args) {
                            loadResources();
                        };
                        modal.showUrl("room_new.php");
                    });
//					

                </script>

                <script>
                    var dp = new DayPilot.Scheduler("dp");

                    dp.allowEventOverlap = false;

                    dp.days = dp.startDate.daysInMonth();
                    loadTimeline(DayPilot.Date.today().firstDayOfMonth());

                    dp.eventDeleteHandling = "Update";

                    dp.timeHeaders = [
                        { groupBy: "Month", format: "MMMM yyyy" },
                        { groupBy: "Day", format: "d" }
                    ];

                    dp.eventHeight = 80;
                    dp.cellWidth = 60;

                    dp.rowHeaderColumns = [
                        {title: "Название комнат", width: 120},
                        {title: "Количества мест", width: 120}
                    ];

                    dp.separators = [
                        { location: new DayPilot.Date(), color: "red" }
                    ];
                    dp.onBeforeResHeaderRender = function(args) {
                        var beds = function(count) {
                            return count + " мест";
                        };

                        args.resource.columns[0].html = beds(args.resource.capacity);
                    };
                    var php_var = "admin";
					if(php_var == "admin") {
                        dp.onBeforeResHeaderRender = function(args) {
                            var beds = function(count) {
                                return count + " мест";
                            };

                            args.resource.columns[0].html = beds(args.resource.capacity);
                            args.resource.areas = [{
                                        top:3,
                                        right:4,
                                        height:14,
                                        width:14,
                                        action:"JavaScript",
                                        js: function(r) {
                                            var modal = new DayPilot.Modal();
                                            modal.onClosed = function(args) {
                                                loadResources();
                                            };
                                            modal.showUrl("/assets/room_edit.php?id=" + r.id);
                                        },
                                        v:"Hover",
                                        css:"icon icon-edit",
                                }];
    					};
						  
						dp.onEventMoved = function (args) {
							$.post("backend_move.php",
							{
								id: args.e.id(),
								newStart: args.newStart.toString(),
								newEnd: args.newEnd.toString(),
								newResource: args.newResource
							},
							function(data) {
								dp.message(data.message);
							});
						};

						dp.onEventResized = function (args) {
							$.post("backend_resize.php",
							{
								id: args.e.id(),
								newStart: args.newStart.toString(),
								newEnd: args.newEnd.toString()
							},
							function() {
								dp.message("Resized.");
							});
						}; 

						dp.onEventDeleted = function(args) {
							$.post("backend_delete.php",
							{
								id: args.e.id()
							},
							function() {
								dp.message("Deleted.");
							});
						};

					}
                    dp.onTimeRangeSelected = function (args) {

                        var modal = new DayPilot.Modal();
                        modal.closed = function() {
                            dp.clearSelection();

                            var data = this.result;
                            if (data && data.result === "OK") {
                                loadEvents();
                            }
                        };
                        modal.showUrl("reservation_new.php?start=" + args.start + "&end=" + args.end + "&resource=" + args.resource);

                    };

                    dp.onEventClick = function(args) {
                        var modal = new DayPilot.Modal();
                        modal.closed = function() {
                            var data = this.result;
                            if (data && data.result === "OK") {
                                loadEvents();
                            }
                        };
                        modal.showUrl("reservation_edit.php?id=" + args.e.id());
                    };

                    dp.onBeforeEventRender = function(args) {
                        var start = new DayPilot.Date(args.e.start);
                        var end = new DayPilot.Date(args.e.end);

                        var today = DayPilot.Date.today();
                        var now = new DayPilot.Date();

                        args.e.html = args.e.text + " (" + start.toString("M/d/yyyy") + " - " + end.toString("M/d/yyyy") + ")";

                        var in2days = today.addDays(1);
                     ///   alert(start.getTimePart() / 3600 / 1000);
                     ///   alert(now.getTimePart() / 3600 / 1000);
                     ///   alert(now.getDatePart());
                        if(end < now) {
                            args.e.barColor = "green";
                            args.e.toolTip = "законченно";
                        } else {
                            if (start.getTimePart() - now.getTimePart() <= 1 * 3600 * 1000 && now.getDatePart() == start.getDatePart() && start.getTimePart() - now.getTimePart() > 0) { 
                            ///    alert(start.getTimePart() / 3600 / 1000);
                            ///    alert(((now.getTimePart() / 1000) % 3600) / 60);
                                args.e.barColor = 'orange';
                                args.e.toolTip = 'будет зан¤то через  ' + Math.trunc((((start.getTimePart() - now.getTimePart()) / 1000) % 3600) / 60) + ' минут';
                            }
                            else {
                                if(start < now) {
                                    args.e.barColor = 'red';
                                    args.e.toolTip = 'сейчас зан¤то';
                                } else {
                                    args.e.barColor = "yellow";
                                    args.e.toolTip = "бронированно";
                                }
                            }
                        }
                        args.e.html = "<div>" + args.e.html + "<br /><span style='color:black'>" + args.e.toolTip + "</span></div>";
                    };

                    dp.init();

                    loadResources();
                    loadEvents();

                    function loadTimeline(date) {
                        dp.scale = "Manual";
                        dp.timeline = [];
                        var start = date.getDatePart().addHours(12);

                        for (var i = 0; i < dp.days; i++) {
                            dp.timeline.push({start: start.addDays(i), end: start.addDays(i+1)});
                        }
                        dp.update();
                    }

                    function loadEvents() {
                        var start = dp.visibleStart();
                        var end = dp.visibleEnd();

                        $.post("backend_events.php",
                            {
                                start: start.toString(),
                                end: end.toString()
                            },
                            function(data) {
                                dp.events.list = data;
                                dp.update();
                            }
                        );
                    }
                       
                    function loadResources() {
                       
					   $.post("backend_rooms.php",
                        { capacity: $("#filter").val() },
                        function(data) {
                            dp.resources = data;
                            dp.update();
                        });
                    }

                    $(document).ready(function() {
                        $("#filter").change(function() {
                            loadResources();
                        });
                    });

                </script>


            </div>
            <div class="clear">
            </div>
    </body>
</html>
