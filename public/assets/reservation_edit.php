<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Edit Event</title>
    	<link type="text/css" rel="stylesheet" href="media/layout.css" />    
        <script src="js/jquery/jquery-1.9.1.min.js" type="text/javascript"></script>
    </head>
    <body>
        <?php
            is_numeric($_GET['id']) or die("invalid URL");
            
            require_once '_db.php';
            
            $stmt = $db->prepare('SELECT * FROM reservations WHERE id = :id');
            $stmt->bindParam(':id', $_GET['id']);
            $stmt->execute();
            $reservation = $stmt->fetch();
            
            $rooms = $db->query('SELECT * FROM rooms');
        ?>
        <form id="f" action="backend_update.php" style="padding:20px;">
            <input type="hidden" name="id" value="<?php print $_GET['id'] ?>" />
            <h1>Редактирование комнат</h1>
            
            <div class="space">
                <div>Начало:</div>
                <div><input type="text" id="start" name="start" value="<?php print $reservation['start'] ?>" /></div>
            </div>
            
            <div class="space">
                <div>Конец:</div>
                <div><input type="text" id="end" name="end" value="<?php print $reservation['end'] ?>" /></div>
            </div>
            
            <div class="space">
                <div>Комната:</div>
                <div>
                    <select id="room" name="room">
                        <?php 
                            foreach ($rooms as $room) {
                                $selected = $reservation['room_id'] == $room['id'] ? ' selected="selected"' : '';
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
            
            <div class="space">
                <div>Имя: </div>
                <div><input type="text" id="name" name="name" value="<?php print $reservation['name'] ?>" /></div>
            </div>
          
            
            <div class="space">
                <input type="submit" value="Save" /> <a href="javascript:close();">Cancel</a>
            </div>
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
