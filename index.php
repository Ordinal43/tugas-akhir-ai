<?php
    if(isset($_POST["1"])){
        echo $_POST["1"];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tic Tac Toe</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="./js/jquery.min.js"></script>
    <style>
        td {
            border: 1px solid grey;
            width: 8em;
            height: 8em;
        }

        label {
            width: 100%;
            height: 100%;
            margin: 0;
        }

        label:hover {
            cursor: pointer;
        }

        .selected {
            background: url("./cross.png");
            background-size: 90%;
            background-repeat: no-repeat;
            background-position: center;
        }

        .selected-enemy {
            background: url("./circle.png");
            background-size: 90%;
            background-repeat: no-repeat;
            background-position: center;
        }

        #debug{
            overflow-y: scroll;
            overflow-x: hidden;
            height: 24em;
        }
    </style>
</head>
<body>

    <div class="jumbotron-fluid bg-light p-4">
        <div class="container">
            <h1 class="h1">Impossible Tic Tac Toe</h1>
            <button id="reset" class="btn btn-primary">Reset</button>
            <button id="second" class="btn btn-primary">Second Play</button>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <table class="box text-center">
                    <tr>
                        <td><label for="b1" id="a1"></label></td>
                        <td><label for="b2" id="a2"></label></td>
                        <td><label for="b3" id="a3"></label></td>
                    </tr>
                    <tr>
                        <td><label for="b4" id="a4"></label></td>
                        <td><label for="b5" id="a5"></label></td>
                        <td><label for="b6" id="a6"></label></td>
                    </tr>
                    <tr>
                        <td><label for="b7" id="a7"></label></td>
                        <td><label for="b8" id="a8"></label></td>
                        <td><label for="b9" id="a9"></label></td>
                    </tr>
                </table>

                <form action="index.php" method="post">
                    <input class="input" type="text" value="0" name="b1" id="b1">
                    <input class="input" type="text" value="0" name="b2" id="b2">
                    <input class="input" type="text" value="0" name="b3" id="b3">
                    <input class="input" type="text" value="0" name="b4" id="b4">
                    <input class="input" type="text" value="0" name="b5" id="b5">
                    <input class="input" type="text" value="0" name="b6" id="b6">
                    <input class="input" type="text" value="0" name="b7" id="b7">
                    <input class="input" type="text" value="0" name="b8" id="b8">
                    <input class="input" type="text" value="0" name="b9" id="b9">
                </form>
            </div>
            <div class="col-12 col-md-6">
                <p id="debug">

                </p>
            </div>
        </div>
    </div>
</body>
<script>
$(document).ready(function () {
    $(".input").hide();
    $(".input").on("click", function(){
        if ($(this).val() == 0){
            $(this).val(1)
            $(this).siblings().removeClass("selected");
            $.ajax({
                type: "post",
                url: "JURUS.php",
                data: {
                    "b1":$("#b1").val(),
                    "b2":$("#b2").val(),
                    "b3":$("#b3").val(),
                    "b4":$("#b4").val(),
                    "b5":$("#b5").val(),
                    "b6":$("#b6").val(),
                    "b7":$("#b7").val(),
                    "b8":$("#b8").val(),
                    "b9":$("#b9").val()
                },
                dataType: "json",
                success: function (response) {
                    // alert(response.choice)
                    $count=0;
                    // check if there's still an empty box
                    for($i=1;$i<=9;$i++){
                        if($("#b"+$i).val()=="0"){
                            $count++;
                        }
                    }
                    // if there's still an empty box left return result
                    if($count!=0){
                        switch (response.choice) {    
                            case "b1":
                                $("#b1").val("2");
                                $("#a1").addClass("selected-enemy");
                                break;
                            case "b2":
                                $("#b2").val("2");
                                $("#a2").addClass("selected-enemy");
                                break;
                            case "b3":
                                $("#b3").val("2");
                                $("#a3").addClass("selected-enemy");
                                break;
                            case "b4":
                                $("#b4").val("2");
                                $("#a4").addClass("selected-enemy");
                                break;
                            case "b5":
                                $("#b5").val("2");
                                $("#a5").addClass("selected-enemy");
                                break;
                            case "b6":
                                $("#b6").val("2");
                                $("#a6").addClass("selected-enemy");
                                break;
                            case "b7":
                                $("#b7").val("2");
                                $("#a7").addClass("selected-enemy");                            
                                break;
                            case "b8":
                                $("#b8").val("2");
                                $("#a8").addClass("selected-enemy");
                                break;
                            case "b9":
                                $("#b9").val("2");
                                $("#a9").addClass("selected-enemy");
                                break;
                        default:
                            break;
                        }  
                    }
                    $("#debug").html(response.debug);
                }
            });
        }
    })
    $("label").on("click", function (){
        $(this).addClass("selected").siblings().removeClass("selected");
    });
    $("#reset").on("click", function(){
        $(".input").val('0');
        $("label").removeClass();
        $("#debug").html("");
    })
    $("#second").on("click", function(){
        $.ajax({
            type: "post",
            url: "JURUS.php",
            data: {
                "b1":$("#b1").val(),
                "b2":$("#b2").val(),
                "b3":$("#b3").val(),
                "b4":$("#b4").val(),
                "b5":$("#b5").val(),
                "b6":$("#b6").val(),
                "b7":$("#b7").val(),
                "b8":$("#b8").val(),
                "b9":$("#b9").val()
            },
            dataType: "json",
            success: function (response) {
                // alert(response.choice)
                $count=0;
                // check if there's still an empty box
                for($i=1;$i<=9;$i++){
                    if($("#b"+$i).val()=="0"){
                        $count++;
                    }
                }
                // if there's still an empty box left return result
                if($count != 0){
                    switch (response.choice) {    
                        case "b1":
                            $("#b1").val("2");
                            $("#a1").addClass("selected-enemy");
                            break;
                        case "b2":
                            $("#b2").val("2");
                            $("#a2").addClass("selected-enemy");
                            break;
                        case "b3":
                            $("#b3").val("2");
                            $("#a3").addClass("selected-enemy");
                            break;
                        case "b4":
                            $("#b4").val("2");
                            $("#a4").addClass("selected-enemy");
                            break;
                        case "b5":
                            $("#b5").val("2");
                            $("#a5").addClass("selected-enemy");
                            break;
                        case "b6":
                            $("#b6").val("2");
                            $("#a6").addClass("selected-enemy");
                            break;
                        case "b7":
                            $("#b7").val("2");
                            $("#a7").addClass("selected-enemy");                            
                            break;
                        case "b8":
                            $("#b8").val("2");
                            $("#a8").addClass("selected-enemy");
                            break;
                        case "b9":
                            $("#b9").val("2");
                            $("#a9").addClass("selected-enemy");
                            break;
                        default:
                            break;
                    }
                }
                $("#debug").html(response.debug);
            }
        });
    });
});
</script>
</html>