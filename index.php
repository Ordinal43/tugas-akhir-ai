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
    </style>
</head>
<body>

    <div class="jumbotron-fluid bg-light p-4">
        <div class="container">
            <h1 class="h1">Tic Tac Toe</h1>
        </div>
    </div>
    <div class="container text-center mt-4">
        <table class="box text-center">
            <tr>
                <td><label for="b1"></label></td>
                <td><label for="b2"></label></td>
                <td><label for="b3"></label></td>
            </tr>
            <tr>
                <td><label for="b4"></label></td>
                <td><label for="b5"></label></td>
                <td><label for="b6"></label></td>
            </tr>
            <tr>
                <td><label for="b7"></label></td>
                <td><label for="b8"></label></td>
                <td><label for="b9"></label></td>
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
            <button type="button" class="btn btn-outline-primary" name="turn" id="turn">Finish turn</button>
        </form>
    </div>
</body>
<script>
$(document).ready(function () {
    $(".input").hide();
    $(".input").on("click", function () {
        $(this).val("1");
        $(this).siblings().val("0").removeClass("selected");
    });

    $("label").on("click", function (){
        $(this).addClass("selected").siblings().removeClass("selected");
    });
    
    $("#turn").on("click", function (e) {
        e.preventDefault();
        var string = { "1":$("#b1").val(), "2":$("#b2").val(), "3":$("#b3").val(), "4":$("#b4").val(), "5":$("#b5").val(), "6":$("#b6").val(), "7":$("#b7").val(), "8":$("#b8").val(), "9":$("#b9").val()};
        $.ajax({
            type: "post",
            url: "index.php",
            data: string,
            success: function (response) {
                alert("success");
            }
        });
    });
});
</script>
</html>