<?php
            include 'views/header.php';
            if (!isset($_SESSION['user_id'])) {
                header('Location: create_account.php');
}
?>

<div class="container bd-content">

    <form id="send" action="send.php" method="post">
        <div class="col-md-5">
            <h2>Send Bitcoins</h2>
            
            <br>
            <p><b>Wallet Balance:</b>


                <?php
                require_once("include/block_io.php");
                include 'key.php';

             //Querying the API in order to get balance for the user's address. This will display the balance
                $balance   = $block_io->get_address_balance(array('addresses' => $_SESSION['address']));
                $amount    = $balance->data;
                $a_balance = $amount->available_balance;
                echo $a_balance;
                ?>


            </p>
            <br />

            <div id="result"  class="alert alert-info col-md-12" style="display:none"></div>
            <div class="form-group">
                <label for="exampleInputEmail1">Receiving Bitcoin address</label><br />
                <input type="text" class="form-control" id="exampleInputEmail1" name="address" placeholder="Receiving Bitcoin address">
            </div>
            <br />
            <div class="form-group">
                <label for="exampleInputEmail1">Amount in Bitcoins</label><br />
                <input type="text" class="form-control" id="exampleInputEmail1" name="amount" placeholder="Amount in Bitcoins">
            </div>
        </div>
        <div class="col-md-5 col-md-offset-2 text-center">
            <h2 class="lead">Receive Bitcoins</h2>

            <p>Give out the Bitcoin address below to receive Bitcoin</p>

            //The code below displays the QR code where user can scan in order to transfer fund to the account
            <p class="lead">
            <html>

                <img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=<?php echo $_SESSION["address"]; ?>">
                <br><?php echo $_SESSION["address"]; ?></br>

            </html></p>
        </div>
        <br />
        <div class="col-md-8">
            <button type="submit" id="rcv_btn" class="btn btn-default btn-lg">SEND</button>
        </div>

    </form>
</div>
<?php include 'views/footer.php'; ?>

<script type="text/javascript">
    $(document).ready(function (e) {
        $("#send").on('submit', (function (e) {



            e.preventDefault();

            $.ajax({
                url: "send.php",
                type: "POST",
                data: new FormData(this),
                mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {

                    if (data == 1) {
                        $('#result').show();

                        $('#result').text("Bitcoin Successfully sent!.");



                        $("#rcv_btn").button('reset');


                    } 
                    if (data == '2') {
                        $('#result').show();
                        $('#result').text("You dont have enough balance");
                        $('#rcv_btn').trigger("reset");
                    }
                    if (data == '0') {
                        $('#result').show();
                        $('#result').text("Failed to add");
                        $('#rcv_btn').trigger("reset");
                    }
                    if (data == '') {
                        $('#result').show();
                        $('#result').text("Something went wrong");
                        $('#rcv_btn').trigger("reset");
                    }




                },
                error: function ()
                {
                    $('#result').text("Something went wrong");

                }
            });
            $('#rcv_btn').trigger("reset");
        }));
    });</script>