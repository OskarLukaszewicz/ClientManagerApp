<?php $packageTypes = $params['items'];

    if (!$packageTypes[0]) { die; }

    $basicPackage = $packageTypes[0];
    $premiumPackage = $packageTypes[1];
    $superPremiumPackage = $packageTypes[2];

?>
<div class="row text-center"><h1 class="w-100"><b>Pakiety</b></h1></div>
<div class="row p-5 text-center">
    <div class="col-4 px-1">
        <div class="packageContainer h-100 ">
            <h3> <?php echo $basicPackage['package_name'] ?> </h3>
            <s>800$</s>
            <?php echo $basicPackage['price'] . "$!" ?> <br>
            <span class="fa fa-star"></span>
            <p><?php echo $basicPackage['features'] ?></p>
            <button class="buyButton btn btn-success">Oferta</button>
        </div>
    </div>
    <div class="col-4 px-1">
        <div class="packageContainer h-100 ">
            <h3> <?php echo $premiumPackage['package_name'] ?> </h3>
            <s>1000$</s>
            <?php echo $premiumPackage['price'] . "$!" ?><br>
            <span class="fa fa-star"></span><span class="fa fa-star"></span>
            <p><?php echo $premiumPackage['features'] ?></p>
            <button class="buyButton btn btn-success">Oferta</button>
        </div>
    </div>
    <div class="col-4 px-1">
        <div class="packageContainer h-100 ">
            <h3> <?php echo $superPremiumPackage['package_name'] ?> </h3>
            <s>1500$</s>
            <?php echo $superPremiumPackage['price'] . "$!" ?><br>
            <span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>
            <p><?php echo $superPremiumPackage['features'] ?></p>
            <button class="buyButton btn btn-success">Oferta</button>
        </div>
    </div>
</div>
