<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>New Reservation</title>
    	<link type="text/css" rel="stylesheet" href="media/layout.css" />    
        <script src="js/jquery/jquery-1.9.1.min.js" type="text/javascript"></script>
    </head>
    <body>
        <?php
            
            require_once '_db.php';
            
            $rooms = $db->query('SELECT * FROM rooms');
            
            $start = $_GET['start'];
            $end = $_GET['end'];
        ?>
        <form id="f" action="backend_create.php" style="padding:20px;">
            
            
            <h1>Бронировать</h1>
            
            <div class="space">
                <div>Имя: </div>
                <div><input type="text" id="name" name="name" value="" /></div>
            </div>
            
            <div class="space">
                <div>Начало:</div>
                <div><input type="text" id="start" name="start" value="<?php echo $start ?>" /></div>
            </div>
            
            <div class="space">
                <div>Конец:</div>
                <div><input type="text" id="end" name="end" value="<?php echo $end ?>" /></div>
            </div>
            
            <div class="space">
                <div>Комната:</div>
                <div>
                    <select id="room" name="room">
                        <?php 
                            foreach ($rooms as $room) {
                                $selected = $_GET['resource'] == $room['id'] ? ' selected="selected"' : '';
                                $id = $room['id'];
                                $name = $room['name'];
								if($name != '') {
                                print "<option value='$id' $selected>$name</option>";
								}
                            }
                        ?>
                    </select>

                </div>
            </div>
            
            <div class="space"><input type="submit" value="Save" /> <a href="javascript:close();">Cancel</a></div>
        </form>
        
        <script type="text/javascript">
        function close(result) {
            if (parent && parent.DayPilot && parent.DayPilot.ModalStatic) {
                parent.DayPilot.ModalStatic.close(result);
            }
        }

        $("#f").submit(function () {
            var f = $("#f");
            $.post(f.attr("action"), f.serialize(), function (result) {
                close(eval(result));
            });
            return false;
        });

        $(document).ready(function () {
            $("#name").focus();
        });
    
        </script>
    </body>
</html>
