
<div class="row">
    <div class="col-lg-12">
        <h2>Razorpay Payment</h2>                 
    </div>
</div><!-- /.row -->
<?php
$txnid = time();
$surl = $surl;
$furl = $furl;        
$key_id = "rzp_test_nO46lDkNW6unOYhbhhbjbhbhbh";
$currency_code = $currency_code;            
$total = 100; 
$amount = 1;
$merchant_order_id = "q".time();
$card_holder_name = 'TechArise Team';
$email = 'shubham@mailinator.com';
$phone = '9907677712';
$name = "LMC";
$return_url = site_url().'razorpay/callback';
?>
<div class="row">
    <div class="col-lg-12">
        <?php if(!empty($this->session->flashdata('msg'))){ ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('msg'); ?>
            </div>        
        <?php } ?>
        
    </div>
</div>
 <form name="razorpay-form" id="razorpay-form" action="<?php echo $return_url; ?>" method="POST">
  <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" />
  <input type="hidden" name="merchant_order_id" id="merchant_order_id" value="<?php echo $merchant_order_id; ?>"/>
  <input type="hidden" name="merchant_trans_id" id="merchant_trans_id" value="<?php echo $txnid; ?>"/>
  <input type="hidden" name="merchant_product_info_id" id="merchant_product_info_id" value="<?php echo 11; ?>"/>
  <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo $surl; ?>"/>
  <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo $furl; ?>"/>
  <input type="hidden" name="card_holder_name_id" id="card_holder_name_id" value="<?php echo $card_holder_name; ?>"/>
  <input type="hidden" name="merchant_total" id="merchant_total" value="<?php echo $total; ?>"/>
  <input type="hidden" name="merchant_amount" id="merchant_amount" value="<?php echo $amount; ?>"/>
</form>
    <div class="row">   
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                        
            <table class="table table-bordered table-hover table-striped print-table order-table" style="font-size:11px;">
                <thead class="bg-primary">
                    <tr>
                        <th width="15%" class="text-left" style="vertical-align: inherit">Image</th>
                        <th width="30%" class="text-left" style="vertical-align: inherit">Name</th>
                        <th width="15%" class="text-left" style="vertical-align: inherit">Price</th>
                        <th width="15%" class="text-right" style="vertical-align: inherit">Qty</th>
                        <th width="15%" class="text-right" style="vertical-align: inherit">Sub Total</th>                        
                    </tr>
                </thead>                        

            </table>
        </div>
    </div>

   


<?php
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
  /*var razorpay_options = {
    key: "<?php echo $key_id; ?>",
    amount: "<?php echo $total; ?>",
    name: "<?php echo $name; ?>",
    description: "Order # <?php echo $merchant_order_id; ?>",
    order_id: "order_NN078CEzUA8Pdh",
    currency: "<?php echo $currency_code; ?>",
    prefill: {
      name:"<?php echo $card_holder_name; ?>",
      email: "<?php echo $email; ?>", 
      contact: "<?php echo $phone; ?>"
    },
    
    handler: function (transaction) {
        document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;
        document.getElementById('razorpay-form').submit();
    },
    "modal": {
        "ondismiss": function(){
            location.reload()
        }
    }
  };*/
  
  $(document).ready(function() {
    console.log( "ready!" );
    razorpaySubmit();
});

  
  var options = {
    "key": "rzp_live_nqAy0qyhdRxvsQ", 
    "amount": "50000", 
    "currency": "INR",
    "name": "Acme Corp", 
    "description": "Test Transaction",
    "image": "https://example.com/your_logo",
    "order_id": "order_NN0GuG52i7N8WQ", 
    "callback_url": "https://eneqd3r9zrjok.x.pipedream.net/",
    "prefill": { 
        "name": "Gaurav Kumar", 
        "email": "gaurav.kumar@example.com",
        "contact": "9000090000"
    },
    "notes": {
        "address": "Razorpay Corporate Office"
    },
    "theme": {
        "color": "#3399cc"
    }
};

  
  function razorpaySubmit(){
        var razorpay_instance = new Razorpay(options);
       razorpay_instance.open();
  }  
</script>
