<div class="row">
    <div class="col-lg-12">
        <h2>Razorpay Payment Gateway Integration In Codeigniter using cURL</h2>                 
    </div>
</div><!-- /.row -->
<div class="row">
        <div class="col-lg-6 col-md-6 mb-6">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="#"><?php print "tewst";?></a>
                    </h4>
                    <h5>₹<?php print $element['price'];?></h5>
                    <p class="card-text"><?php print "tewst"; ?></p>
                </div>
                <div class="card-footer text-right">                    
                    <a href="<?php base_url()?>Razorpay/checkout/100" class="add-to-cart btn-success btn btn-sm" title="Add to Cart"><i class="fa fa-shopping-cart fa-fw"></i> Buy Now</a>                    
                </div>
            </div>
        </div>
             
</div>
<?php
$this->load->view('templates/footer');
?>